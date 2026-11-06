<?php
// ===== Архив: статьи и новости по месяцам, поиск и фильтр по рубрикам (js/script.js) =====
$entries = [];
foreach (articles() as $id => $a) {
	$entries[] = ['date' => $a['date'], 'cat' => $a['cat'], 'title' => tr($a['title']), 'link' => lurl('articles/' . $id . '.php'), 'type' => t('type_article')];
}
foreach (news_items() as $n) {
	$entries[] = ['date' => $n['date'], 'cat' => $n['cat'], 'title' => tr($n['title']), 'link' => news_link($n), 'type' => t('type_news')];
}
usort($entries, function ($a, $b) { return strcmp($b['date'], $a['date']); });

$byMonth = [];
foreach ($entries as $entry) $byMonth[substr($entry['date'], 0, 7)][] = $entry;

// Кнопки фильтра — только рубрики, которые есть в архиве, в порядке из файла переводов
$used = array_unique(array_column($entries, 'cat'));
$cats = array_filter(array_keys(t('cats')), function ($c) use ($used) { return in_array($c, $used, true); });

$title = t('archive_title');
include ROOT . '/inc/header.php';
?>

	<div class="page archive">
		<br>
		<h1><?= e($title) ?></h1>
		<span class="card-line"></span>

		<!-- Поиск и фильтр -->
		<input class="archive-search" id="archive-search" type="search" placeholder="<?= e(t('archive_search')) ?>">
		<div class="archive-filters" id="archive-filters">
			<button class="filter-btn active" type="button" data-cat="all"><?= e(t('archive_all')) ?></button>
<?php foreach ($cats as $cat): ?>
			<button class="filter-btn" type="button" data-cat="<?= $cat ?>"><?= e(cat_name($cat)) ?></button>
<?php endforeach; ?>
		</div>

<?php include ROOT . '/templates/news-months.php'; ?>

		<!-- Материалы по месяцам -->
<?php foreach ($byMonth as $m => $list): ?>
		<section class="archive-month">
			<h2><?= e(month_text($m)) ?></h2>
			<ul>
<?php foreach ($list as $entry): ?>
				<li class="archive-item" data-cat="<?= $entry['cat'] ?>">
					<span class="archive-day"><?= substr($entry['date'], 8, 2) ?></span>
					<div>
						<div class="news-meta"><span class="news-tag"><?= e(cat_name($entry['cat'])) ?></span><span class="news-date"><?= e($entry['type']) ?></span></div>
						<a href="<?= $entry['link'] ?>"><?= e($entry['title']) ?></a>
					</div>
				</li>
<?php endforeach; ?>
			</ul>
		</section>
<?php endforeach; ?>

		<p class="archive-empty" id="archive-empty" hidden><?= e(t('archive_empty')) ?></p>
		<br>
	</div>

<?php include ROOT . '/inc/footer.php'; ?>
