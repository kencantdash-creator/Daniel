<?php
require 'config.php';
$latest = $pdo->query("SELECT * FROM posts WHERE type = 'Announcement' ORDER BY posted_at DESC, id DESC LIMIT 3")->fetchAll();
$events = $pdo->query("SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date, event_time LIMIT 3")->fetchAll();
$status = office_status($pdo);

$tiles = [
    ['announcements.php', 'Announcements', 'megaphone', 'Official notices'],
    ['updates.php', 'Community Updates', 'newspaper', 'News from the barangay'],
    ['officials.php', 'Officials', 'users', 'Barangay leaders'],
    ['services.php', 'Services', 'briefcase', 'Requirements and fees'],
    ['hours.php', 'Office Hours', 'clock', 'When we are open'],
    ['events.php', 'Events', 'calendar', 'Activities near you'],
    ['schedules.php', 'Schedules', 'calendar-check', 'Collections and clinics'],
    ['feedback.php', 'Feedback', 'message-square', 'Share your thoughts'],
];

$pageTitle = 'Home';
include 'includes/header.php';
?>
<section class="bg-white border border-neutral-300 rounded-lg p-5 sm:p-8">
  <h1 class="text-2xl sm:text-4xl font-extrabold text-neutral-900 leading-tight">Barangay information and services in one place</h1>
  <p class="text-neutral-600 mt-3 max-w-2xl">Check announcements, office hours, schedules and emergency contacts for <?= e(BARANGAY_NAME) ?> without going to the Barangay Hall.</p>
  <form action="search.php" method="get" class="mt-5 flex flex-col sm:flex-row gap-3 max-w-2xl" role="search">
    <div class="relative flex-1">
      <span class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-400"><?= icon('search', 'w-5 h-5') ?></span>
      <input type="search" name="q" required minlength="2" placeholder="Search clearance, garbage collection, officials..." aria-label="Search information" class="w-full rounded-md border border-neutral-300 pl-10 pr-3 py-3 focus:outline-none focus:ring-2 focus:ring-green-700">
    </div>
    <button class="bg-green-800 hover:bg-green-900 text-white font-semibold rounded-md px-6 py-3 flex items-center justify-center gap-2"><?= icon('search', 'w-4 h-4') ?>Search</button>
  </form>
</section>

<section class="mt-6 grid gap-4 md:grid-cols-3">
  <div class="md:col-span-2 bg-white border border-neutral-300 rounded-lg p-5 flex items-center gap-4">
    <span class="rounded-full p-3 shrink-0 <?= $status['open'] ? 'bg-green-100 text-green-800' : 'bg-neutral-200 text-neutral-700' ?>"><?= icon('clock', 'w-6 h-6') ?></span>
    <div class="flex-1 min-w-0">
      <p class="font-bold text-lg"><?= $status['open'] ? 'Barangay Hall is open' : 'Barangay Hall is closed' ?></p>
      <p class="text-sm text-neutral-600"><?= e($status['text']) ?></p>
    </div>
    <a href="hours.php" class="text-sm font-semibold text-green-800 underline shrink-0">Full hours</a>
  </div>
  <a href="emergency.php" class="bg-red-600 hover:bg-red-700 text-white rounded-lg p-5 flex items-center gap-4">
    <span class="bg-white text-red-600 rounded-full p-3 shrink-0"><?= icon('siren', 'w-6 h-6') ?></span>
    <span><span class="block font-bold text-lg">Emergency contacts</span><span class="block text-sm text-red-100">Call 911 or the barangay hotline</span></span>
  </a>
</section>

<section class="mt-8">
  <h2 class="text-xl font-bold mb-3">Quick access</h2>
  <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
    <?php foreach ($tiles as [$href, $label, $ic, $desc]): ?>
      <a href="<?= e($href) ?>" class="bg-white border border-neutral-300 rounded-lg p-4 hover:border-green-800 focus:outline-none focus:ring-2 focus:ring-green-700">
        <span class="inline-flex bg-green-100 text-green-800 rounded-md p-2"><?= icon($ic, 'w-5 h-5') ?></span>
        <span class="block font-semibold mt-3"><?= e($label) ?></span>
        <span class="block text-xs text-neutral-500 mt-0.5"><?= e($desc) ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<div class="mt-8 grid gap-8 lg:grid-cols-2">
  <section>
    <div class="flex items-center justify-between mb-3">
      <h2 class="text-xl font-bold">Latest announcements</h2>
      <a href="announcements.php" class="text-sm font-semibold text-green-800 underline">View all</a>
    </div>
    <div class="space-y-3">
      <?php foreach ($latest as $p): ?>
        <a href="announcements.php#post-<?= (int)$p['id'] ?>" class="block bg-white border border-neutral-300 rounded-lg p-4 hover:border-green-800">
          <p class="text-xs text-neutral-500"><?= e(fmt_date($p['posted_at'])) ?></p>
          <h3 class="font-semibold mt-1"><?= e($p['title']) ?></h3>
          <p class="text-sm text-neutral-600 mt-1"><?= e(excerpt($p['body'])) ?></p>
        </a>
      <?php endforeach; ?>
      <?php if (!$latest): ?><p class="text-sm text-neutral-600 bg-white border border-dashed border-neutral-300 rounded-lg p-4">No announcements yet.</p><?php endif; ?>
    </div>
  </section>

  <section>
    <div class="flex items-center justify-between mb-3">
      <h2 class="text-xl font-bold">Upcoming events</h2>
      <a href="events.php" class="text-sm font-semibold text-green-800 underline">View all</a>
    </div>
    <div class="space-y-3">
      <?php foreach ($events as $ev): $ts = strtotime($ev['event_date']); ?>
        <a href="events.php" class="flex gap-4 bg-white border border-neutral-300 rounded-lg p-4 hover:border-green-800">
          <div class="w-14 shrink-0 text-center bg-green-800 text-white rounded-md py-1.5">
            <div class="text-xs"><?= e(date('M', $ts)) ?></div>
            <div class="text-xl font-bold leading-none"><?= e(date('j', $ts)) ?></div>
          </div>
          <div class="min-w-0">
            <h3 class="font-semibold"><?= e($ev['title']) ?></h3>
            <p class="text-sm text-neutral-600 flex items-center gap-1 mt-1"><?= icon('map-pin', 'w-4 h-4 shrink-0') ?><span class="truncate"><?= e($ev['location']) ?></span></p>
          </div>
        </a>
      <?php endforeach; ?>
      <?php if (!$events): ?><p class="text-sm text-neutral-600 bg-white border border-dashed border-neutral-300 rounded-lg p-4">No upcoming events.</p><?php endif; ?>
    </div>
  </section>
</div>
<?php include 'includes/footer.php'; ?>
