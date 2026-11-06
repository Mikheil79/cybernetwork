<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/init.php';
$article = article('virus');
include ROOT . '/templates/article-start.php';
?>
			<p>Cybersecurity companies are warning users about the rapid spread of a new piece of malware that mostly hides in email attachments and spreads disguised as fake software updates.</p>

			<p>Once a device is infected, the program may collect personal data, encrypt files and demand a ransom, or use the infected device for further attacks on other systems.</p>

			<p>To stay protected, do not click suspicious links or attachments, keep your antivirus software up to date and make regular backups of important data.</p>
<?php include ROOT . '/templates/article-end.php'; ?>
