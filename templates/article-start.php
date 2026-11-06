<?php
// ===== Начало страницы статьи или новости; ожидает $article =====
// $article — запись из data/articles.json (article('id')) или data/news.json (news_item('id')).
// После этого шаблона идут абзацы текста, затем article-end.php или news-end.php.
if (!$article) {
	http_response_code(404);
	exit;
}
$title = tr($article['title']);
include ROOT . '/inc/header.php';
?>

	<div class="article">
		<div class="news-meta article-meta"><span class="news-tag"><?= e(cat_name($article['cat'])) ?></span><span class="news-date"><?= date_text($article['date']) ?></span><span class="news-date"><?= sprintf(t('read_min'), $article['read']) ?></span></div>
		<h1><?= e($title) ?></h1>
		<span class="card-line"></span>
<?php if (!empty($article['img'])): ?>

		<div class="article-hero">
			<img class="hero-bg" src="<?= url('img/' . $article['img']) ?>" alt="" aria-hidden="true">
			<img class="hero-img" src="<?= url('img/' . $article['img']) ?>" alt="<?= e($title) ?>">
		</div>
<?php endif; ?>

		<div class="article-text">
