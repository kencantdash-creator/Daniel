<?php
require 'config.php';
$rows = $pdo->query('SELECT * FROM emergency_contacts ORDER BY sort_order, id')->fetchAll();
$pageTitle = 'Emergency Contacts';
include 'includes/header.php';
echo page_head('siren', 'Emergency Contacts', 'Tap a number to call from your phone.');
?>
<?php if (!$rows): ?>
  <p class="bg-white border border-dashed border-neutral-300 rounded-lg p-8 text-center text-neutral-600">No emergency contacts have been listed yet. In an emergency, call 911.</p>
<?php else: ?>
  <div class="grid gap-4 md:grid-cols-2">
    <?php foreach ($rows as $i => $c): $first = $i === 0; ?>
      <article id="contact-<?= (int)$c['id'] ?>" class="rounded-lg border p-4 flex items-center gap-4 scroll-mt-4 <?= $first ? 'bg-red-600 text-white border-red-700 md:col-span-2' : 'bg-white border-neutral-300' ?>">
        <span class="rounded-full p-3 shrink-0 <?= $first ? 'bg-white text-red-600' : 'bg-red-100 text-red-600' ?>"><?= icon('phone', 'w-6 h-6') ?></span>
        <div class="flex-1 min-w-0">
          <h2 class="font-bold <?= $first ? 'text-lg' : '' ?>"><?= e($c['name']) ?></h2>
          <?php if ($c['note']): ?><p class="text-sm <?= $first ? 'text-red-100' : 'text-neutral-600' ?>"><?= e($c['note']) ?></p><?php endif; ?>
          <p class="font-extrabold mt-1 <?= $first ? 'text-3xl' : 'text-xl' ?>"><?= e($c['number']) ?></p>
        </div>
        <a href="tel:<?= e(tel($c['number'])) ?>" class="shrink-0 rounded-md px-4 py-2 text-sm font-semibold flex items-center gap-2 <?= $first ? 'bg-white text-red-700 hover:bg-red-50' : 'bg-red-600 text-white hover:bg-red-700' ?>"><?= icon('phone', 'w-4 h-4') ?>Call</a>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
