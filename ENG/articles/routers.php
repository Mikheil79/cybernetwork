<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/init.php';
$article = article('routers');
include ROOT . '/templates/article-start.php';
?>
			<p>Home and office routers often remain outside the focus of cybersecurity, even though they are the gateway to the entire internal network. Many devices still run with factory passwords and outdated software.</p>

			<p>Attackers actively look for devices with known unpatched vulnerabilities in order to recruit them into botnets or use them to eavesdrop on and redirect traffic - often without the user noticing.</p>

			<p>To reduce the risk, it is recommended to change the factory password immediately, update the software regularly and disable remote management if it is not needed.</p>
<?php include ROOT . '/templates/article-end.php'; ?>
