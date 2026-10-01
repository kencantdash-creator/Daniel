</main>
<footer class="bg-white border-t border-neutral-300 text-sm text-neutral-600">
  <div class="max-w-6xl mx-auto px-4 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
    <p class="flex items-center gap-2"><?= icon('map-pin', 'w-4 h-4') ?><?= e(BARANGAY_NAME) ?> &middot; <?= e(BARANGAY_ADDRESS) ?></p>
    <p>Smart Barangay &copy; <?= date('Y') ?> &middot; <a href="admin.php" class="underline hover:text-green-800">Staff login</a></p>
  </div>
</footer>
<script>
  const btn = document.getElementById('menuBtn');
  const wrap = document.getElementById('navWrap');
  btn.addEventListener('click', () => {
    const open = wrap.classList.toggle('hidden') === false;
    btn.setAttribute('aria-expanded', open ? 'true' : 'false');
  });
</script>
</body>
</html>
