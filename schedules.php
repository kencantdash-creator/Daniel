<?php
require 'config.php';
$rows = $pdo->query('SELECT * FROM schedules ORDER BY category, id')->fetchAll();
$groups = [];
foreach ($rows as $r) $groups[$r['category']][] = $r;
$pageTitle = 'Important Schedules';
include 'includes/header.php';
echo page_head('calendar-check', 'Important Schedules', 'Regular collections, clinics, sessions and patrols.');
?>
<?php if (!$groups): ?>
  <p class="bg-white border border-dashed border-neutral-300 rounded-lg p-8 text-center text-neutral-600">No schedules have been posted yet.</p>
<?php else: ?>
  <div class="space-y-8">
    <?php foreach ($groups as $cat => $items): ?>
      <section>
        <h2 class="text-xl font-bold mb-3"><?= e($cat) ?></h2>
        <div class="grid gap-4 md:grid-cols-2">
          <?php foreach ($items as $s): ?>
            <article id="schedule-<?= (int)$s['id'] ?>" class="bg-white border border-neutral-300 rounded-lg p-4 scroll-mt-4">
              <h3 class="font-semibold"><?= e($s['title']) ?></h3>
              <p class="text-sm font-medium text-green-800 mt-1 flex items-center gap-1.5"><?= icon('clock', 'w-4 h-4 shrink-0') ?><?= e($s['when_text']) ?></p>
              <?php if ($s['details']): ?><p class="text-sm text-neutral-600 mt-2"><?= e($s['details']) ?></p><?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
