<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 4.0.0
    </div>
    <p>&copy; <span id="year"></span> Pongkhun. All rights reserved.</p>
<script>
  document.getElementById("year").innerHTML = new Date().getFullYear();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (isset($_SESSION['flash'])): ?>
<script>
  Swal.fire(<?php echo json_encode($_SESSION['flash'], JSON_UNESCAPED_UNICODE); ?>);
</script>
<?php unset($_SESSION['flash']); endif; ?>
</footer>