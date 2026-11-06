<?php
// ===== Архив новостей: список месяцев; news/?m=2026-10 — новости одного месяца =====
$months = news_months();
$month = isset($_GET['m']) && isset($months[$_GET['m']]) ? $_GET['m'] : '';

$title = $month ? sprintf(t('news_month_title'), month_text($month)) : t('news_archive_title');
include ROOT . '/inc/header.php';
?>

<?php if ($month): ?>
	<div class="news">
		<br>
		<h1><?= e($title) ?></h1>
		<span class="card-line"></span>

<?php foreach (news_items() as $item) if (!empty($item['path']) && substr($item['date'], 0, 7) === $month) include ROOT . '/templates/news-card.php'; ?>
		<div class="text-center"><a class="card-btn back-btn" href="<?= lurl('news/') ?>">&larr; <?= e(t('news_archive_title')) ?></a></div>
	</div>
<?php else: ?>
	<div class="page archive">
		<br>
		<h1><?= e($title) ?></h1>
		<span class="card-line"></span>

<?php if (!$months): ?>
		<p class="text-center"><?= e(t('news_archive_empty')) ?></p>
<?php endif; ?>
<?php foreach ($months as $m => $count): ?>
		<section class="archive-month">
			<h2><a href="<?= lurl('news/?m=' . $m) ?>"><?= e(month_text($m)) ?></a></h2>
			<p><?= e(plural($count, t('news_count'))) ?></p>
		</section>
<?php endforeach; ?>
	</div>
<?php endif; ?>
	<br>

<?php include ROOT . '/inc/footer.php'; ?>
