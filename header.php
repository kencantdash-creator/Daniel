<?php
$flash = get_flash();
$active = basename($_SERVER['PHP_SELF']);
$nav = [
    'index.php' => ['Home', 'home'],
    'announcements.php' => ['Announcements', 'megaphone'],
    'updates.php' => ['Community Updates', 'newspaper'],
    'officials.php' => ['Officials', 'users'],
    'services.php' => ['Services', 'briefcase'],
    'hours.php' => ['Office Hours', 'clock'],
    'events.php' => ['Events', 'calendar'],
    'schedules.php' => ['Schedules', 'calendar-check'],
    'emergency.php' => ['Emergency', 'siren'],
    'feedback.php' => ['Feedback', 'message-square'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle ?? 'Home') ?> | Smart Barangay</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = { theme: { extend: { fontFamily: { sans: ['Manrope', 'ui-sans-serif', 'system-ui', 'sans-serif'] } } } };
</script>
</head>
<body class="bg-neutral-100 text-neutral-800 font-sans min-h-screen flex flex-col">

<header class="bg-green-800 text-white">
  <div class="max-w-6xl mx-auto px-4 py-3 flex items-center gap-3">
    <a href="index.php" class="flex items-center gap-3 min-w-0">
      <span class="bg-white text-green-800 rounded-md p-2 shrink-0"><?= icon('landmark', 'w-6 h-6') ?></span>
      <span class="leading-tight min-w-0">
        <span class="block font-extrabold text-lg">Smart Barangay</span>
        <span class="block text-xs text-green-100 truncate"><?= e(BARANGAY_NAME) ?></span>
      </span>
    </a>
    <form action="search.php" method="get" class="hidden md:flex ml-auto w-72 relative" role="search">
      <input type="search" name="q" required minlength="2" placeholder="Search information" aria-label="Search information" class="w-full rounded-md pl-3 pr-10 py-2 text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-amber-400">
      <button class="absolute right-0 top-0 h-full px-3 text-green-800" aria-label="Search"><?= icon('search', 'w-4 h-4') ?></button>
    </form>
    <button id="menuBtn" class="md:hidden ml-auto p-2 rounded-md hover:bg-green-700" aria-label="Open menu" aria-expanded="false"><?= icon('menu', 'w-6 h-6') ?></button>
  </div>

  <nav id="navWrap" class="hidden md:block bg-green-900" aria-label="Main">
    <div class="max-w-6xl mx-auto px-4">
      <form action="search.php" method="get" class="md:hidden py-3 relative" role="search">
        <input type="search" name="q" required minlength="2" placeholder="Search information" aria-label="Search information" class="w-full rounded-md pl-3 pr-10 py-2 text-sm text-neutral-900">
        <button class="absolute right-0 top-3 h-[calc(100%-1.5rem)] px-3 text-green-800" aria-label="Search"><?= icon('search', 'w-4 h-4') ?></button>
      </form>
      <ul class="flex flex-col md:flex-row md:flex-wrap text-sm pb-2 md:py-1">
        <?php foreach ($nav as $file => [$label, $ic]):
            $isEmergency = $file === 'emergency.php';
            $cls = $isEmergency ? 'bg-red-600 hover:bg-red-700' : ($active === $file ? 'bg-green-700' : 'hover:bg-green-800'); ?>
          <li class="md:mr-1 my-0.5">
            <a href="<?= e($file) ?>" <?= $active === $file ? 'aria-current="page"' : '' ?> class="flex items-center gap-2 px-3 py-2.5 rounded-md <?= $cls ?>"><?= icon($ic, 'w-4 h-4') ?><?= e($label) ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </nav>
</header>

<main class="flex-1 max-w-6xl w-full mx-auto px-4 py-6 sm:py-8">
<?php if ($flash): ?>
  <div class="mb-6 rounded-md border px-4 py-3 text-sm flex items-start gap-2 <?= $flash['type'] === 'error' ? 'bg-red-50 border-red-300 text-red-800' : 'bg-green-50 border-green-300 text-green-800' ?>" role="alert">
    <?= icon($flash['type'] === 'error' ? 'x' : 'check', 'w-5 h-5 shrink-0') ?>
    <span><?= e($flash['msg']) ?></span>
  </div>
<?php endif; ?>
