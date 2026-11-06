<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/init.php';
$article = article('chrome');
include ROOT . '/templates/article-start.php';
?>
			<p>Since the latest update, many users have been complaining that Google Chrome is unstable: the browser often freezes, individual tabs lock up, and in some cases the program hangs completely.</p>

			<p>One possible cause is a large number of pages open in tabs at once, together with heavy extensions, which significantly increase memory usage. Old or corrupted profile data can also play a role.</p>

			<p>As a temporary workaround, it is recommended to update the browser to the latest version, disable unnecessary extensions, clear the cache and cookies, or create a new user profile to isolate the problem.</p>
<?php include ROOT . '/templates/article-end.php'; ?>
