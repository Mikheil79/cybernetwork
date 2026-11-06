<?php
// ===== Лента новостей; news.php?topic=ai — только одна тема =====
define('NEWS_LIMIT', 20);

$topic = isset($_GET['topic']) && in_array($_GET['topic'], TOPICS, true) ? $_GET['topic'] : '';
$items = news_items();
if ($topic) {
	$items = array_values(array_filter($items, function ($n) use ($topic) { return $n['cat'] === $topic; }));
}
$items = array_slice($items, 0, NEWS_LIMIT);

$title = $topic ? t('topics')[$topic] : t('news_title');
include ROOT . '/inc/header.php';
?>

	<div class="news">
		<br>
		<h1><?= e($title) ?></h1>
		<span class="card-line"></span>

<?php if (!$items): ?>
		<p class="text-center"><?= e(t('news_empty_topic')) ?></p>
<?php endif; ?>
<?php foreach ($items as $item) include ROOT . '/templates/news-card.php'; ?>
<?php include ROOT . '/templates/news-months.php'; ?>
	</div>
	<br>

<?php include ROOT . '/inc/footer.php'; ?>
