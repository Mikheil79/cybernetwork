<?php
require $_SERVER['DOCUMENT_ROOT'] . '/inc/init.php';
$article = article('neiro');
include ROOT . '/templates/article-start.php';
?>
			<p>In recent years, artificial neural networks have become one of the main driving forces of technological progress. They are inspired by the way the human brain works and consist of layers of interconnected “neurons” that learn from large amounts of data.</p>

			<p>Today neural networks are used in image recognition, natural language processing, translation, medical diagnostics and self-driving cars. Their capabilities are growing rapidly as computing power and the availability of data increase.</p>

			<p>However, the technology also poses challenges for society: a lack of transparency, biased data and ethical questions are actively debated in the scientific community.</p>
<?php include ROOT . '/templates/article-end.php'; ?>
