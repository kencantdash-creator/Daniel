<?php
require 'config.php';

$errors = [];
$old = ['name' => '', 'contact' => '', 'category' => '', 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();
    foreach ($old as $k => $_) $old[$k] = trim($_POST[$k] ?? '');

    if (mb_strlen($old['name']) > 100) $errors[] = 'Name must be 100 characters or fewer.';
    if (mb_strlen($old['contact']) > 100) $errors[] = 'Contact must be 100 characters or fewer.';
    if (!in_array($old['category'], FEEDBACK_CATEGORIES, true)) $errors[] = 'Choose a feedback type.';
    $len = mb_strlen($old['message']);
    if ($len < 10) $errors[] = 'Write at least 10 characters in your message.';
    if ($len > 1000) $errors[] = 'Message must be 1000 characters or fewer.';

    if (!$errors) {
        $st = $pdo->prepare('INSERT INTO feedback (name, contact, category, message) VALUES (?,?,?,?)');
        $st->execute([$old['name'] ?: null, $old['contact'] ?: null, $old['category'], $old['message']]);
        flash('Thank you. Your feedback was sent to the barangay.');
        redirect('feedback.php');
    }
}

$pageTitle = 'Submit Feedback';
include 'includes/header.php';
echo page_head('message-square', 'Submit Feedback', 'Share a suggestion, concern, complaint or compliment.');
$inputCls = 'w-full rounded-md border border-neutral-300 bg-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-700';
?>
<div class="max-w-2xl bg-white border border-neutral-300 rounded-lg p-5 sm:p-7">
  <?php if ($errors): ?>
    <ul class="mb-5 rounded-md bg-red-50 border border-red-300 text-red-800 text-sm p-3 list-disc list-inside">
      <?php foreach ($errors as $er): ?><li><?= e($er) ?></li><?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="post" class="space-y-4">
    <?= csrf_field() ?>
    <div class="grid gap-4 sm:grid-cols-2">
      <div>
        <label for="name" class="block text-sm font-medium mb-1">Name <span class="text-neutral-500 font-normal">(optional)</span></label>
        <input id="name" name="name" maxlength="100" value="<?= e($old['name']) ?>" class="<?= $inputCls ?>">
      </div>
      <div>
        <label for="contact" class="block text-sm font-medium mb-1">Contact <span class="text-neutral-500 font-normal">(optional)</span></label>
        <input id="contact" name="contact" maxlength="100" value="<?= e($old['contact']) ?>" placeholder="Phone or email" class="<?= $inputCls ?>">
      </div>
    </div>
    <div>
      <label for="category" class="block text-sm font-medium mb-1">Feedback type</label>
      <select id="category" name="category" required class="<?= $inputCls ?>">
        <option value="">Select type</option>
        <?php foreach (FEEDBACK_CATEGORIES as $c): ?><option value="<?= e($c) ?>" <?= $c === $old['category'] ? 'selected' : '' ?>><?= e($c) ?></option><?php endforeach; ?>
      </select>
    </div>
    <div>
      <label for="message" class="block text-sm font-medium mb-1">Message</label>
      <textarea id="message" name="message" rows="5" required minlength="10" maxlength="1000" placeholder="Tell us what happened or what we can improve" class="<?= $inputCls ?>"><?= e($old['message']) ?></textarea>
    </div>
    <button class="w-full sm:w-auto bg-green-800 hover:bg-green-900 text-white font-semibold rounded-md px-6 py-2.5 flex items-center justify-center gap-2"><?= icon('send', 'w-4 h-4') ?>Send feedback</button>
  </form>
  <p class="text-xs text-neutral-500 mt-4">For emergencies, do not use this form. Call 911 or see the <a href="emergency.php" class="underline text-green-800">emergency contacts</a>.</p>
</div>
<?php include 'includes/footer.php'; ?>
