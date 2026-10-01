<?php

$st = $pdo->prepare('SELECT * FROM posts WHERE type = ? ORDER BY posted_at DESC, id DESC');
$st->execute([$postType]);
$posts = $st->fetchAll();
include __DIR__ . '/header.php';
echo page_head($pageIcon, $pageTitle, $pageSub);
?>
<?php if (!$posts): ?>
  <p class="bg-white border border-dashed border-neutral-300 rounded-lg p-8 text-center text-neutral-600">Nothing has been posted yet. Please check back soon.</p>
<?php else: ?>
  <div class="space-y-4 max-w-3xl">
    <?php foreach ($posts as $p): ?>
      <article id="post-<?= (int)$p['id'] ?>" class="bg-white border border-neutral-300 rounded-lg p-5 scroll-mt-4">
        <p class="text-xs text-neutral-500 flex items-center gap-1"><?= icon('calendar', 'w-3.5 h-3.5') ?><?= e(fmt_date($p['posted_at'])) ?></p>
        <h2 class="text-lg font-bold mt-1"><?= e($p['title']) ?></h2>
        <p class="text-neutral-700 mt-2 whitespace-pre-line break-words"><?= e($p['body']) ?></p>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php include __DIR__ . '/footer.php'; ?>
