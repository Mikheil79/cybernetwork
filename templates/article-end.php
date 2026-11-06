<?php
// ===== Конец статьи: навигация, «Читайте также», возврат на главную =====
$prev = $article['prev'] ? article($article['prev']) : null;
$next = $article['next'] ? article($article['next']) : null;
?>
		</div>

		<!-- Предыдущая / следующая статья -->
		<nav class="article-nav">
<?php if ($prev): ?>
			<a class="nav-prev" href="<?= lurl('articles/' . $prev['id'] . '.php') ?>"><small>&larr; <?= e(t('prev_article')) ?></small><?= e(tr($prev['title'])) ?></a>
<?php else: ?>
			<span class="nav-prev disabled"></span>
<?php endif; ?>
<?php if ($next): ?>
			<a class="nav-next" href="<?= lurl('articles/' . $next['id'] . '.php') ?>"><small><?= e(t('next_article')) ?> &rarr;</small><?= e(tr($next['title'])) ?></a>
<?php else: ?>
			<span class="nav-next disabled"></span>
<?php endif; ?>
		</nav>

		<!-- Читайте также -->
		<h2 class="section-title"><?= e(t('related')) ?></h2>
		<span class="card-line"></span>
		<div class="related">
<?php foreach ($article['related'] as $rid): $r = article($rid); if (!$r) continue; ?>
			<a class="related-card" href="<?= lurl('articles/' . $rid . '.php') ?>">
				<img src="<?= url('img/' . $r['img']) ?>" alt="<?= e(tr($r['title'])) ?>">
				<span class="news-tag"><?= e(cat_name($r['cat'])) ?></span>
				<strong><?= e(tr($r['title'])) ?></strong>
			</a>
<?php endforeach; ?>
		</div>

		<div class="text-center"><a class="card-btn back-btn" href="<?= lurl() ?>">&larr; <?= e(t('back_home')) ?></a></div>
	</div>
	<br>

<?php include ROOT . '/inc/footer.php'; ?>
