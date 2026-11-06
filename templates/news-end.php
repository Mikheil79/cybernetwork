<?php
// ===== Конец новости: ссылка на источник и возврат к новостям месяца =====
?>
<?php if (!empty($article['source'])): ?>

			<p class="source"><?= e(t('source')) ?>: <a href="<?= e($article['source']) ?>" target="_blank" rel="noopener"><?= e(parse_url($article['source'], PHP_URL_HOST)) ?></a></p>
<?php endif; ?>
		</div>

		<div class="text-center"><a class="card-btn back-btn" href="<?= lurl('news/?m=' . substr($article['date'], 0, 7)) ?>">&larr; <?= e(t('all_news')) ?></a></div>
	</div>
	<br>

<?php include ROOT . '/inc/footer.php'; ?>
