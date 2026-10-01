<?php
require 'config.php';
$services = $pdo->query('SELECT * FROM services ORDER BY id')->fetchAll();
$pageTitle = 'Barangay Services';
include 'includes/header.php';
echo page_head('briefcase', 'Barangay Services', 'What we offer, what to bring, and how much it costs.');
?>
<?php if (!$services): ?>
  <p class="bg-white border border-dashed border-neutral-300 rounded-lg p-8 text-center text-neutral-600">No services are listed yet.</p>
<?php else: ?>
  <div class="grid gap-4 md:grid-cols-2">
    <?php foreach ($services as $s): ?>
      <article id="service-<?= (int)$s['id'] ?>" class="bg-white border border-neutral-300 rounded-lg p-5 flex flex-col scroll-mt-4">
        <div class="flex items-start gap-3">
          <span class="bg-green-100 text-green-800 rounded-md p-2.5 shrink-0"><?= icon($s['icon'], 'w-6 h-6') ?></span>
          <div class="min-w-0 flex-1">
            <h2 class="font-bold text-lg leading-snug"><?= e($s['name']) ?></h2>
            <p class="text-sm text-neutral-600 mt-1"><?= e($s['description']) ?></p>
          </div>
        </div>
        <?php if (trim((string)$s['requirements']) !== ''): ?>
          <h3 class="font-semibold text-sm mt-4">Requirements</h3>
          <ul class="mt-1 space-y-1 text-sm text-neutral-700">
            <?php foreach (preg_split('/\R/', $s['requirements']) as $r): if (trim($r) === '') continue; ?>
              <li class="flex items-start gap-2"><span class="text-green-800 mt-0.5"><?= icon('check', 'w-4 h-4') ?></span><?= e($r) ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
        <p class="mt-auto pt-4 text-sm"><span class="text-neutral-500">Fee:</span> <span class="font-semibold"><?= e($s['fee']) ?></span></p>
      </article>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
