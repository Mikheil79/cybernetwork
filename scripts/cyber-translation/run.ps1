param([switch]$ListOnly)
# Запуск агента cyber-translation: ищет новые/изменённые файлы в translation/GEO, ENG, RUS
# (по дате изменения) и передаёт их агенту для перевода на два других языка.
# Планировщик Windows вызывает его по средам и субботам в 00:05.

$ErrorActionPreference = 'Stop'
$Root = 'D:\OSPanel\home\cybernetwork'
Set-Location $Root

$Langs     = 'GEO', 'ENG', 'RUS'
$TransDir  = Join-Path $Root 'translation'
$LogDir    = Join-Path $Root 'logs\cyber-translation'
$StateFile = Join-Path $TransDir '.state\cyber-translation.json'
New-Item -ItemType Directory -Force (@($Langs | ForEach-Object { Join-Path $TransDir $_ }) + $LogDir + (Split-Path $StateFile)) | Out-Null

$now = Get-Date
$Log = Join-Path $LogDir ("{0:yyyy-MM-dd_HHmm}.log" -f $now)
Start-Transcript -Path $Log | Out-Null

try {
    # Известные файлы: "LANG\относительный путь" -> дата изменения на момент последнего перевода.
    # Сюда попадают и исходники, и готовые переводы, чтобы переводы не считались новыми исходниками.
    $state = @{}
    if (Test-Path $StateFile) {
        (Get-Content $StateFile -Raw -Encoding UTF8 | ConvertFrom-Json).PSObject.Properties |
            ForEach-Object { $state[$_.Name] = $_.Value }
    }

    # Новый файл — которого нет в state или который изменён после последнего перевода
    $Extensions = '.txt', '.md', '.html', '.htm'
    $changed = @(foreach ($lang in $Langs) {
        $dir = Join-Path $TransDir $lang
        Get-ChildItem $dir -File -Recurse |
            Where-Object { $Extensions -contains $_.Extension.ToLower() } |
            ForEach-Object {
                $rel   = $_.FullName.Substring($dir.Length + 1)
                $stamp = $_.LastWriteTimeUtc.ToString('o')
                if ($state["$lang\$rel"] -ne $stamp) {
                    [pscustomobject]@{ Lang = $lang; Rel = $rel; Stamp = $stamp; Time = $_.LastWriteTime }
                }
            }
    })

    # Если один и тот же файл изменён сразу в нескольких языках — исходником считается самый свежий
    $jobs = @($changed | Group-Object Rel | ForEach-Object {
        $src = $_.Group | Sort-Object Time -Descending | Select-Object -First 1
        $_.Group | Where-Object { $_ -ne $src } | ForEach-Object { Write-Host "Пропущен (есть более свежая версия в $($src.Lang)): $($_.Lang)\$($_.Rel)" }
        $src | Add-Member -PassThru Targets @($Langs | Where-Object { $_ -ne $src.Lang })
    } | Sort-Object Time)

    Write-Output "Новых файлов для перевода: $($jobs.Count)"
    $jobs | ForEach-Object { Write-Output ("  {0:yyyy-MM-dd HH:mm}  {1}\{2} -> {3}" -f $_.Time, $_.Lang, $_.Rel, ($_.Targets -join ', ')) }

    if ($jobs.Count -eq 0 -or $ListOnly) { return }

    $list = ($jobs | ForEach-Object { "- translation/$($_.Lang)/$($_.Rel -replace '\\', '/') → $($_.Targets -join ', ')" }) -join "`n"
    $prompt = "Сегодня $($now.ToString('yyyy-MM-dd')). Переведи эти файлы на указанные языки и сохрани переводы под теми же именами в translation/<ЯЗЫК>/ (существующие переводы перезаписывай):`n$list`nВыполни свою задачу."
    & claude -p $prompt `
        --agent cyber-translation `
        --permission-mode acceptEdits `
        --allowedTools 'Read' 'Write' 'Edit' 'Glob' 'Grep'

    # Отмечаем переведёнными только задания, для которых появились все свежие переводы
    foreach ($job in $jobs) {
        $outs = @($job.Targets | ForEach-Object { Join-Path (Join-Path $TransDir $_) $job.Rel })
        $done = @($outs | Where-Object { (Test-Path $_) -and (Get-Item $_).LastWriteTime -ge $now })
        if ($done.Count -eq $outs.Count) {
            $state["$($job.Lang)\$($job.Rel)"] = $job.Stamp
            foreach ($t in $job.Targets) {
                $state["$t\$($job.Rel)"] = (Get-Item (Join-Path (Join-Path $TransDir $t) $job.Rel)).LastWriteTimeUtc.ToString('o')
            }
        } else {
            Write-Output "Не переведён: $($job.Lang)\$($job.Rel)"
        }
    }
    $state | ConvertTo-Json | Out-File $StateFile -Encoding utf8
}
finally {
    Stop-Transcript | Out-Null
}
