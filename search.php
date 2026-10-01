<?php
require 'config.php';

$q = trim($_GET['q'] ?? '');
$groups = [];
$tooShort = $q !== '' && mb_strlen($q) < 2;

function find(PDO $pdo, $sql, $n, $like) {
    $st = $pdo->prepare($sql);
    $st->execute(array_fill(0, $n, $like));
    return $st->fetchAll();
}

if (mb_strlen($q) >= 2) {
    $like = '%' . addcslashes($q, '%_\\') . '%';
    $add = function ($label, $ic, $rows) use (&$groups) { if ($rows) $groups[] = ['label' => $label, 'icon' => $ic, 'rows' => $rows]; };

    $rows = [];
    foreach (find($pdo, 'SELECT id, type, title, body FROM posts WHERE title LIKE ? OR body LIKE ? ORDER BY posted_at DESC', 2, $like) as $r)
        $rows[] = [$r['title'], excerpt($r['body']), ($r['type'] === 'Update' ? 'updates.php' : 'announcements.php') . '#post-' . $r['id']];
    $add('Announcements and updates', 'megaphone', $rows);

    $rows = [];
    foreach (find($pdo, 'SELECT * FROM officials WHERE name LIKE ? OR position LIKE ? OR committee LIKE ? ORDER BY sort_order', 3, $like) as $r)
        $rows[] = [$r['name'], $r['position'] . ($r['committee'] ? ', ' . $r['committee'] : ''), 'officials.php'];
    $add('Officials', 'users', $rows);

    $rows = [];
    foreach (find($pdo, 'SELECT * FROM services WHERE name LIKE ? OR description LIKE ? OR requirements LIKE ?', 3, $like) as $r)
        $rows[] = [$r['name'], excerpt($r['description']), 'services.php#service-' . $r['id']];
    $add('Services', 'briefcase', $rows);

    $rows = [];
    foreach (find($pdo, 'SELECT * FROM events WHERE title LIKE ? OR description LIKE ? OR location LIKE ? ORDER BY event_date DESC', 3, $like) as $r)
        $rows[] = [$r['title'], fmt_date($r['event_date']) . ' at ' . $r['location'], 'events.php#event-' . $r['id']];
    $add('Events', 'calendar', $rows);

    $rows = [];
    foreach (find($pdo, 'SELECT * FROM schedules WHERE title LIKE ? OR when_text LIKE ? OR details LIKE ? OR category LIKE ?', 4, $like) as $r)
        $rows[] = [$r['title'], $r['when_text'], 'schedules.php#schedule-' . $r['id']];
    $add('Schedules', 'calendar-check', $rows);

    $rows = [];
    foreach (find($pdo, 'SELECT * FROM emergency_contacts WHERE name LIKE ? OR note LIKE ? OR number LIKE ? ORDER BY sort_order', 3, $like) as $r)
        $rows[] = [$r['name'], $r['number'] . ($r['note'] ? ', ' . $r['note'] : ''), 'emergency.php#contact-' . $r['id']];
    $add('Emergency contacts', 'siren', $rows);
}
$total = 0;
foreach ($groups as $g) $total += count($g['rows']);

$pageTitle = 'Search';
include 'includes/header.php';
echo page_head('search', 'Search information', 'Find announcements, services, schedules, contacts and more.');
?>
<form action="search.php" method="get" class="max-w-2xl flex flex-col sm:flex-row gap-3 mb-6" role="search">
  <input type="search" name="q" value="<?= e($q) ?>" required minlength="2" placeholder="Type a keyword" aria-label="Search information" class="flex-1 rounded-md border border-neutral-300 bg-white px-3 py-3 focus:outline-none focus:ring-2 focus:ring-green-700">
  <button class="bg-green-800 hover:bg-green-900 text-white font-semibold rounded-md px-6 py-3 flex items-center justify-center gap-2"><?= icon('search', 'w-4 h-4') ?>Search</button>
</form>

<?php if ($q === ''): ?>
  <p class="text-neutral-600">Type at least 2 characters to search all barangay information.</p>
<?php elseif ($tooShort): ?>
  <p class="text-neutral-600">Type at least 2 characters to search.</p>
<?php elseif (!$groups): ?>
  <div class="bg-white border border-dashed border-neutral-300 rounded-lg p-8 text-center max-w-2xl">
    <h2 class="font-bold text-lg">No results for "<?= e($q) ?>"</h2>
    <p class="text-sm text-neutral-600 mt-1">Check the spelling or try a shorter keyword such as "clearance" or "garbage".</p>
  </div>
<?php else: ?>
  <p class="text-sm text-neutral-600 mb-4"><?= $total ?> result<?= $total === 1 ? '' : 's' ?> for "<?= e($q) ?>"</p>
  <div class="space-y-8 max-w-3xl">
    <?php foreach ($groups as $g): ?>
      <section>
        <h2 class="font-bold text-lg flex items-center gap-2 mb-2"><?= icon($g['icon'], 'w-5 h-5 text-green-800') ?><?= e($g['label']) ?> <span class="text-sm font-normal text-neutral-500">(<?= count($g['rows']) ?>)</span></h2>
        <div class="bg-white border border-neutral-300 rounded-lg divide-y divide-neutral-200">
          <?php foreach ($g['rows'] as [$title, $text, $url]): ?>
            <a href="<?= e($url) ?>" class="flex items-center gap-3 p-4 hover:bg-neutral-50">
              <div class="flex-1 min-w-0"><p class="font-semibold"><?= e($title) ?></p><p class="text-sm text-neutral-600 break-words"><?= e($text) ?></p></div>
              <span class="text-neutral-400 shrink-0"><?= icon('chevron-right', 'w-5 h-5') ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
