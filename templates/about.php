<?php
// ===== О нас: тексты в lang/<LANG>.php =====
$title = t('about_title');
include ROOT . '/inc/header.php';
?>

	<div class="page">
		<br>
		<h1><?= e($title) ?></h1>
<?php foreach (t('about_intro') as $p): ?>
		<p><?= $p ?></p>
<?php endforeach; ?>
		<!-- О чём мы пишем -->
		<h2 class="section-title"><?= e(t('about_cover')) ?></h2>
		<span class="card-line"></span>
		<div class="topics">
<?php foreach (t('about_topics') as $topic): ?>
			<div class="topic">
				<span class="topic-icon"><?= icon($topic[0]) ?></span>
				<h3 class="topic-title"><?= e($topic[1]) ?></h3>
				<span class="card-line"></span>
				<p><?= e($topic[2]) ?></p>
			</div>
<?php endforeach; ?>
		</div>
		<br>
	</div>

<?php include ROOT . '/inc/footer.php'; ?>
