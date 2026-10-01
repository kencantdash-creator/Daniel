<?php
require 'config.php';
$officials = $pdo->query('SELECT * FROM officials ORDER BY sort_order, id')->fetchAll();
$pageTitle = 'Barangay Officials';
include 'includes/header.php';
echo page_head('users', 'Barangay Officials', 'Your elected and appointed barangay leaders.');
?>
<?php if (!$officials): ?>
  <p class="bg-white border border-dashed border-neutral-300 rounded-lg p-8 text-center text-neutral-600">The list of officials is not available yet.</p>
<?php else: ?>
  <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
    <?php foreach ($officials as $o): $lead = $o['position'] === 'Punong Barangay'; ?>
      <div class="bg-white border rounded-lg p-4 flex items-center gap-4 <?= $lead ? 'border-green-800 sm:col-span-2 lg:col-span-3' : 'border-neutral-300' ?>">
        <div class="shrink-0 rounded-full flex items-center justify-center font-bold <?= $lead ? 'w-20 h-20 text-2xl bg-green-800 text-white' : 'w-14 h-14 text-lg bg-green-100 text-green-800' ?>"><?= e(initials($o['name'])) ?></div>
        <div class="min-w-0">
          <h2 class="font-bold <?= $lead ? 'text-xl' : '' ?>"><?= e($o['name']) ?></h2>
          <p class="text-sm font-medium text-green-800"><?= e($o['position']) ?></p>
          <?php if ($o['committee']): ?><p class="text-sm text-neutral-600"><?= e($o['committee']) ?></p><?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
