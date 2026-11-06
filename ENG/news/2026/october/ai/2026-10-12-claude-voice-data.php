<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/init.php';
$article = news_item('2026-10-12-claude-voice-data');
include ROOT . '/templates/article-start.php';
?>
			<p>Anthropic has invited Claude users to voluntarily share recordings of their voice conversations to train and improve its AI models. The notification appears when people use Claude's voice features.</p>

			<p>The notification offers two options: “Allow” or “Not now”. According to Anthropic, this will help the models better understand human speech and respond to it more effectively.</p>

			<p>Permission to use voice data is a separate setting under Settings &rarr; Privacy. It is not tied to sharing regular chats and Claude Code sessions for model training: for example, a user can allow voice while disallowing text chats, or vice versa. According to the source, the setting is off by default.</p>

			<p>Users can change their decision later: the feature can be turned off, and already stored voice data can be deleted in the settings at any time. The article does not say how long the data is kept.</p>
<?php include ROOT . '/templates/news-end.php'; ?>
