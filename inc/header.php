<?php
// ===== Шапка: <head>, верхняя панель, переключатель языков, меню тем =====
// Перед подключением страница может задать $title (без названия сайта).
$menu = [
	'index.php'      => 'nav_home',
	'news.php'       => 'nav_news',
	'archive.php'    => 'nav_archive',
	'news/index.php' => 'nav_news_archive',
	'about.php'      => 'nav_about',
	'contact.php'    => 'nav_contact',
];
$topicNow = PAGE === 'news.php' && isset($_GET['topic']) ? $_GET['topic'] : '';
?>
<!doctype html>
<html lang="<?= LANGS[LANG] ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= isset($title) ? e($title) . ' - ' : '' ?><?= SITE ?></title>
<?php foreach (LANGS as $code => $iso): ?>
<link rel="alternate" hreflang="<?= $iso ?>" href="<?= e(lang_url($code)) ?>">
<?php endforeach; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&family=Noto+Sans+Georgian:wght@400;700&display=swap">
<link rel="stylesheet" href="<?= url('css/style.css') ?>">
</head>

<body>
	<!-- Верхняя панель -->
	<div class="topbar">
		<div class="topbar-inner">
			<span><?= e(today_text()) ?></span>
			<a class="logo" href="<?= lurl() ?>"><img src="<?= url('img/logos/cybernetwork.png') ?>" alt="<?= SITE ?>"><span class="slogan">CYBERNETWORK</span></a>
			<span>
<?php foreach ($menu as $mp => $key): ?>
				<a href="<?= lurl($mp === 'index.php' ? '' : ($mp === 'news/index.php' ? 'news/' : $mp)) ?>"<?= PAGE === $mp ? ' class="active"' : '' ?>><?= e(t($key)) ?></a>
<?php endforeach; ?>
			</span>
			<!-- Переключатель языков -->
			<span class="lang-switch">
<?php foreach (LANGS as $code => $iso): ?>
				<a href="<?= e(lang_url($code)) ?>" hreflang="<?= $iso ?>"<?= $code === LANG ? ' class="active"' : '' ?>><?= $code ?></a>
<?php endforeach; ?>
			</span>
		</div>
		<!-- Темы -->
		<nav class="topic-nav">
<?php foreach (TOPICS as $tp): ?>
			<a href="<?= lurl('news.php?topic=' . $tp) ?>" data-topic="<?= $tp ?>"<?= $topicNow === $tp ? ' class="active"' : '' ?>><?= topic_icon($tp) ?><?= e(t('topics')[$tp]) ?></a>
<?php endforeach; ?>
		</nav>
	</div>

