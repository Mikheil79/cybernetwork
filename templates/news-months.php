<?php
// ===== Строка со ссылками на страницы месяцев (лента и архив) =====
$monthList = news_months();
if ($monthList):
?>
		<p class="news-months"><?= e(t('news_months')) ?><?php foreach ($monthList as $m => $count): ?> <a href="<?= lurl('news/?m=' . $m) ?>"><?= e(month_text($m)) ?></a><?php endforeach; ?></p>
<?php endif; ?>
