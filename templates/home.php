<?php
// ===== Главная: карточки статей из data/articles.json =====
include ROOT . '/inc/header.php';
?>

	<div class="cards">
<?php $n = 0; foreach (articles() as $id => $a): $n++; $name = tr($a['title']); $link = lurl('articles/' . $id . '.php'); ?>
		<div class="card">
			<a class="card-img" href="<?= $link ?>"><img src="<?= url('img/' . $a['img']) ?>" alt="<?= e($name) ?>"><span class="card-num"><?= sprintf('%02d', $n) ?></span></a>
			<h2 class="card-title"><?= e($name) ?></h2>
			<span class="card-line"></span>
			<a class="card-btn" href="<?= $link ?>"><?= e(t('more')) ?></a>
		</div>
<?php endforeach; ?>
	</div>

<?php include ROOT . '/inc/footer.php'; ?>
