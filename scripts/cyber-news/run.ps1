param([switch]$FetchOnly, [string]$Since, [int]$Max)
# Запуск агента cyber-news: скачивает RSS xakep.ru и передаёт новые материалы агенту,
# который публикует их на трёх языках (GEO, ENG, RUS).
# Планировщик Windows вызывает его по вторникам и пятницам.
# Разовый запуск за период: run.ps1 -Since 2026-10-01 -Max 15 (по умолчанию — последние 5 дней, до 8 статей).

$ErrorActionPreference = 'Stop'
$Root = 'D:\OSPanel\home\cybernetwork'
Set-Location $Root

$DataDir = Join-Path $Root 'data'
$LogDir  = Join-Path $Root 'logs\cyber-news'
New-Item -ItemType Directory -Force $DataDir, $LogDir | Out-Null

$now = Get-Date
$Log = Join-Path $LogDir ("{0:yyyy-MM-dd_HHmm}.log" -f $now)
Start-Transcript -Path $Log | Out-Null

try {
    # Уже обработанные ссылки
    $ProcessedFile = Join-Path $DataDir 'processed.json'
    $processed = @()
    if (Test-Path $ProcessedFile) {
        # ForEach-Object разворачивает массив: в PowerShell 5.1 ConvertFrom-Json отдаёт его одним объектом
        $processed = @(Get-Content $ProcessedFile -Raw -Encoding UTF8 | ConvertFrom-Json | ForEach-Object { $_ })
    }

    # Темы сайта: тег xakep.ru -> название темы
    $Topics = [ordered]@{
        'windows'                 = 'Windows'
        'linux'                   = 'Linux'
        'android'                 = 'Android'
        'zhelezo'                 = 'Железо'
        'iskusstvennyj-intellekt' = 'Нейросеть (AI)'
    }

    # Лента тега отдаёт по 10 записей; листаем страницы, пока не дойдём до материалов старше 5 дней.
    # Материал с несколькими тегами попадает в список один раз, с перечнем тем.
    $since = if ($Since) { [DateTime]::ParseExact($Since, 'yyyy-MM-dd', $null) } else { $now.AddDays(-5) }
    $byLink = [ordered]@{}
    foreach ($tag in $Topics.Keys) {
        foreach ($page in 1..6) {
            $url = "https://xakep.ru/tag/$tag/feed/"
            if ($page -gt 1) { $url += "?paged=$page" }
            try { $r = Invoke-WebRequest -Uri $url -UseBasicParsing -TimeoutSec 30 } catch { break }
            [xml]$xml = [Text.Encoding]::UTF8.GetString($r.RawContentStream.ToArray())
            $pageItems = @($xml.rss.channel.item)
            if ($pageItems.Count -eq 0) { break }
            $oldest = $now
            foreach ($i in $pageItems) {
                $date = [DateTime]::Parse($i.pubDate, [Globalization.CultureInfo]::InvariantCulture)
                if ($date -lt $oldest) { $oldest = $date }
                if ($date -lt $since -or $processed -contains $i.link) { continue }
                if ($byLink.Contains($i.link)) {
                    if ($byLink[$i.link].topics -notcontains $Topics[$tag]) { $byLink[$i.link].topics += $Topics[$tag] }
                    continue
                }
                $byLink[$i.link] = [pscustomobject]@{
                    title       = $i.title
                    link        = $i.link
                    pubDate     = $date.ToString('yyyy-MM-dd HH:mm')
                    topics      = @($Topics[$tag])
                    categories  = @($i.category | ForEach-Object { $_.'#cdata-section' })
                    description = ($i.description.'#cdata-section' -replace '<[^>]+>', '').Trim()
                }
            }
            if ($oldest -lt $since) { break }
        }
    }
    $items = @($byLink.Values | Sort-Object pubDate -Descending)

    $FeedFile = Join-Path $DataDir 'feed.json'
    ConvertTo-Json -InputObject @($items) -Depth 4 | Out-File $FeedFile -Encoding utf8
    Write-Output "Новых материалов: $($items.Count)"

    if ($items.Count -eq 0 -or $FetchOnly) { return }

    $prompt = "Новые материалы xakep.ru лежат в data/feed.json ($($items.Count) шт.). Сегодня $($now.ToString('yyyy-MM-dd')). Опубликуй каждую выбранную новость на трёх языках (GEO, ENG, RUS) и добавь её в data/news.json. Выполни свою задачу."
    if ($Max -gt 0) { $prompt += " В этот раз выбери до $Max материалов." }
    & claude -p $prompt `
        --agent cyber-news `
        --permission-mode acceptEdits `
        --allowedTools 'Read' 'Write' 'Edit' 'Glob' 'Grep' 'WebFetch(domain:xakep.ru)'
}
finally {
    Stop-Transcript | Out-Null
}
