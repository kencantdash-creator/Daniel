<?php
require 'config.php';
$upcoming = $pdo->query('SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date, event_time')->fetchAll();
$past = $pdo->query('SELECT * FROM events WHERE event_date < CURDATE() ORDER BY event_date DESC LIMIT 10')->fetchAll();
$pageTitle = 'Events and Activities';
include 'includes/header.php';
echo page_head('calendar', 'Events and Activities', 'Programs and gatherings in the community.');

function event_card($ev, $muted = false) {
    $ts = strtotime($ev['event_date']);
    ob_start(); ?>
    <article id="event-<?= (int)$ev['id'] ?>" class="flex gap-4 bg-white border border-neutral-300 rounded-lg p-4 scroll-mt-4 <?= $muted ? 'opacity-75' : '' ?>">
      <div class="w-16 shrink-0 text-center rounded-md py-2 h-fit <?= $muted ? 'bg-neutral-300 text-neutral-800' : 'bg-green-800 text-white' ?>">
        <div class="text-xs"><?= e(date('M', $ts)) ?></div>
        <div class="text-2xl font-bold leading-none"><?= e(date('j', $ts)) ?></div>
        <div class="text-xs mt-0.5"><?= e(date('Y', $ts)) ?></div>
      </div>
      <div class="min-w-0">
        <h3 class="font-bold text-lg leading-snug"><?= e($ev['title']) ?></h3>
        <p class="text-sm text-neutral-600 mt-1"><?= e($ev['description']) ?></p>
        <div class="mt-2 flex flex-wrap gap-x-5 gap-y-1 text-sm text-neutral-700">
          <?php if ($ev['event_time']): ?><span class="flex items-center gap-1"><?= icon('clock', 'w-4 h-4') ?><?= e(fmt_time($ev['event_time'])) ?></span><?php endif; ?>
          <span class="flex items-center gap-1"><?= icon('map-pin', 'w-4 h-4') ?><?= e($ev['location']) ?></span>
        </div>
      </div>
    </article>
    <?php return ob_get_clean();
}
?>
<h2 class="text-xl font-bold mb-3">Upcoming</h2>
<?php if (!$upcoming): ?>
  <p class="bg-white border border-dashed border-neutral-300 rounded-lg p-6 text-neutral-600">No upcoming events right now. Check back soon.</p>
<?php else: ?>
  <div class="grid gap-4 lg:grid-cols-2"><?php foreach ($upcoming as $ev) echo event_card($ev); ?></div>
<?php endif; ?>

<?php if ($past): ?>
  <h2 class="text-xl font-bold mt-10 mb-3">Past events</h2>
  <div class="grid gap-4 lg:grid-cols-2"><?php foreach ($past as $ev) echo event_card($ev, true); ?></div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
