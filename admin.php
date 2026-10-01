<?php
require 'config.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    $action = $_POST['action'] ?? '';
    if ($action === 'login') {
        if (hash_equals(ADMIN_PASSWORD, (string)($_POST['password'] ?? ''))) {
            session_regenerate_id(true);
            $_SESSION['is_admin'] = true;
            redirect('admin.php');
        }
        $error = 'Incorrect password.';
    } elseif (!empty($_SESSION['is_admin'])) {
        if ($action === 'logout') {
            unset($_SESSION['is_admin']);
            flash('You have been logged out.');
            redirect('admin.php');
        }
        if ($action === 'delete') {
            $pdo->prepare('DELETE FROM feedback WHERE id = ?')->execute([(int)($_POST['id'] ?? 0)]);
            flash('Feedback deleted.');
            redirect('admin.php');
        }
    }
}

$isAdmin = !empty($_SESSION['is_admin']);
$rows = $isAdmin ? $pdo->query('SELECT * FROM feedback ORDER BY created_at DESC, id DESC')->fetchAll() : [];

$pageTitle = 'Staff';
include 'includes/header.php';
?>
<?php if (!$isAdmin): ?>
  <div class="max-w-sm mx-auto bg-white border border-neutral-300 rounded-lg p-6">
    <h1 class="text-xl font-bold flex items-center gap-2"><?= icon('lock', 'w-5 h-5') ?>Staff login</h1>
    <p class="text-sm text-neutral-600 mt-1">Barangay staff can read submitted feedback here.</p>
    <?php if ($error): ?><p class="mt-4 rounded-md bg-red-50 border border-red-300 text-red-800 text-sm p-3"><?= e($error) ?></p><?php endif; ?>
    <form method="post" class="mt-4 space-y-4">
      <?= csrf_field() ?><input type="hidden" name="action" value="login">
      <div>
        <label for="password" class="block text-sm font-medium mb-1">Password</label>
        <input id="password" type="password" name="password" required class="w-full rounded-md border border-neutral-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-700">
      </div>
      <button class="w-full bg-green-800 hover:bg-green-900 text-white font-semibold rounded-md py-2.5">Log in</button>
    </form>
  </div>
<?php else: ?>
  <div class="flex items-center justify-between gap-3 mb-6">
    <?= page_head('message-square', 'Submitted feedback', count($rows) . ' message' . (count($rows) === 1 ? '' : 's')) ?>
    <form method="post" class="-mt-6">
      <?= csrf_field() ?><input type="hidden" name="action" value="logout">
      <button class="border border-neutral-300 bg-white hover:bg-neutral-50 rounded-md px-4 py-2 text-sm font-semibold flex items-center gap-2"><?= icon('log-out', 'w-4 h-4') ?>Log out</button>
    </form>
  </div>
  <?php if (!$rows): ?>
    <p class="bg-white border border-dashed border-neutral-300 rounded-lg p-8 text-center text-neutral-600">No feedback has been submitted yet.</p>
  <?php else: ?>
    <div class="space-y-3 max-w-3xl">
      <?php foreach ($rows as $f): ?>
        <article class="bg-white border border-neutral-300 rounded-lg p-4">
          <div class="flex flex-wrap items-center justify-between gap-2">
            <p class="font-semibold flex items-center gap-2"><?= icon('user', 'w-4 h-4 text-neutral-500') ?><?= e($f['name'] ?: 'Anonymous') ?>
              <span class="text-xs font-semibold bg-green-100 text-green-800 rounded-full px-2 py-0.5"><?= e($f['category']) ?></span></p>
            <p class="text-xs text-neutral-500"><?= e(date('M j, Y g:i A', strtotime($f['created_at']))) ?></p>
          </div>
          <p class="mt-2 text-neutral-700 whitespace-pre-line break-words"><?= e($f['message']) ?></p>
          <?php if ($f['contact']): ?><p class="mt-2 text-sm text-neutral-600 flex items-center gap-1"><?= icon('phone', 'w-4 h-4') ?><?= e($f['contact']) ?></p><?php endif; ?>
          <form method="post" class="mt-3" onsubmit="return confirm('Delete this feedback?');">
            <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$f['id'] ?>">
            <button class="text-sm text-red-700 hover:underline flex items-center gap-1"><?= icon('trash', 'w-4 h-4') ?>Delete</button>
          </form>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
