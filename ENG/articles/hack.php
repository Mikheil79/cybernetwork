<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/init.php';
$article = article('hack');
include ROOT . '/templates/article-start.php';
?>
			<p>Cybersecurity specialists have recently recorded a growing number of data breaches. Attackers increasingly rely on phishing and social engineering to gain access to companies' internal systems.</p>

			<p>According to experts, security weaknesses most often show up in poor password management and in failing to update software on time. A single successful attack can be enough for the personal data of thousands of users to end up on the internet.</p>

			<p>Specialists advise users to choose complex, unique passwords, enable two-factor authentication and change their credentials immediately if anything looks suspicious.</p>
<?php include ROOT . '/templates/article-end.php'; ?>
