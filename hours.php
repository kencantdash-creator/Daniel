<?php
require 'config.php';
$rows = $pdo->query('SELECT * FROM office_hours ORDER BY sort_order')->fetchAll();
$status = office_status($pdo);
$today = date('l');
$pageTitle = 'Office Hours';
include 'includes/header.php';
echo page_head('clock', 'Office Hours', BARANGAY_NAME . ' Barangay Hall');
?>
<div class="max-w-xl">
  <div class="mb-4 rounded-lg border px-4 py-3 flex items-center gap-3 <?= $status['open'] ? 'bg-green-50 border-green-300 text-green-800' : 'bg-neutral-200 border-neutral-300 text-neutral-800' ?>">
    <?= icon($status['open'] ? 'check' : 'clock', 'w-5 h-5 shrink-0') ?>
    <span class="font-semibold"><?= e($status['text']) ?></span>
  </div>

  <div class="bg-white border border-neutral-300 rounded-lg divide-y divide-neutral-200">
    <?php foreach ($rows as $r): $isToday = $r['day_label'] === $today; ?>
      <div class="flex items-center justify-between px-4 py-3 <?= $isToday ? 'bg-green-50' : '' ?>">
        <span class="font-medium flex items-center gap-2"><?= e($r['day_label']) ?><?php if ($isToday): ?><span class="text-xs font-semibold bg-green-800 text-white rounded-full px-2 py-0.5">Today</span><?php endif; ?></span>
        <span class="text-sm <?= $r['open_time'] ? '' : 'text-neutral-500' ?>"><?= $r['open_time'] ? e(fmt_time($r['open_time']) . ' to ' . fmt_time($r['close_time'])) : 'Closed' ?></span>
      </div>
    <?php endforeach; ?>
  </div>

  <p class="mt-4 text-sm text-neutral-600 flex items-start gap-2"><?= icon('siren', 'w-5 h-5 shrink-0 text-red-600') ?>Outside office hours, emergencies are handled by the barangay tanods. See the <a href="emergency.php" class="text-green-800 underline font-semibold">emergency contacts</a>.</p>
</div>
<?php include 'includes/footer.php'; ?>
