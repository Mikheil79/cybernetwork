<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/init.php';
$article = news_item('2026-10-06-openai-distillation');
include ROOT . '/templates/article-start.php';
?>
			<p>OpenAI representatives say they have blocked a large-scale distillation campaign whose participants tried to extract the protected reasoning of AI models. According to the company's assessment, the main cluster of activity is linked to people associated with Moonshot AI, the Chinese developer of Kimi.</p>

			<p>OpenAI explains that this is “adversarial distillation”: the mass collection of answers and reasoning from strong models in order to train competing LLMs. The attackers did not break encryption or gain access to databases or chat histories: using specially crafted prompts, they forced the model to reveal its internal reasoning in a form visible to the user.</p>

			<p>The campaign began on 1 July 2026. It peaked on 24–25 July, when more than 16,000 requests from over 4,000 users were recorded. In total, about 15,000 accounts were identified, and the activity stopped on 28 July.</p>

			<p>In response, OpenAI banned the accounts involved, tightened registration checks, strengthened monitoring and removed the ability to re-send encrypted reasoning blocks between sessions - a gap described in research published in August. According to the source, in September Moonshot AI's Kimi was also accused of secretly redirecting user requests to Claude and passing off the answers as its own.</p>
<?php include ROOT . '/templates/news-end.php'; ?>
