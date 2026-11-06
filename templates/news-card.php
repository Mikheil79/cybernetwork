<?php
// ===== Карточка новости; ожидает $item из data/news.json =====
$name = tr($item['title']);
?>
		<article class="news-item" id="news-<?= e($item['id']) ?>">
			<span class="news-thumb"><?= icon(isset($item['icon']) ? $item['icon'] : $item['cat']) ?></span>
			<div class="news-body">
				<div class="news-meta"><span class="news-tag"><?= e(cat_name($item['cat'])) ?></span><span class="news-date"><?= date_text($item['date']) ?></span></div>
				<h2><?php if (!empty($item['path'])): ?><a href="<?= lurl($item['path']) ?>"><?= e($name) ?></a><?php else: ?><?= e($name) ?><?php endif; ?></h2>
				<p><?= e(tr($item['summary'])) ?></p>
			</div>
		</article>

