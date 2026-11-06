<?php
// ===== Контакты (TODO: заменить реальными данными) =====
define('CONTACT_EMAIL', 'info@example.com');
define('CONTACT_PHONE', '+995 000 00 00 00');

$title = t('contact_title');
include ROOT . '/inc/header.php';
?>

	<div class="page">
		<br>
		<h1><?= e($title) ?></h1>
		<p class="text-center"><?= e(t('contact_intro')) ?></p>

		<div class="topics topics-3">
			<div class="topic">
				<span class="topic-icon"><?= icon('mail') ?></span>
				<h3 class="topic-title"><?= e(t('contact_email')) ?></h3>
				<span class="card-line"></span>
				<p><a href="mailto:<?= CONTACT_EMAIL ?>"><?= CONTACT_EMAIL ?></a></p>
			</div>

			<div class="topic">
				<span class="topic-icon"><?= icon('call') ?></span>
				<h3 class="topic-title"><?= e(t('contact_phone')) ?></h3>
				<span class="card-line"></span>
				<p><a href="tel:<?= str_replace(' ', '', CONTACT_PHONE) ?>"><?= CONTACT_PHONE ?></a></p>
			</div>

			<div class="topic">
				<span class="topic-icon"><?= icon('pin') ?></span>
				<h3 class="topic-title"><?= e(t('contact_address')) ?></h3>
				<span class="card-line"></span>
				<p><?= e(t('address')) ?></p>
			</div>
		</div>

		<br>
	</div>

<?php include ROOT . '/inc/footer.php'; ?>
