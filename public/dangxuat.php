<?php

if (session_status() === PHP_SESSION_NONE) { // neu trang thai chua duoc bat 
  session_start(); //if(session_status() !== PHP_SESSION_ACTIVE) session_start();
}

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_SESSION['user_formdb'])) {
    unset($_SESSION['id']);
    unset($_SESSION['full_name']);
    unset($_SESSION['email']);
    unset($_SESSION['pass_word']);
    unset($_SESSION['user_formdb']);
    session_destroy();
    
  }
  if (isset($_SESSION['admin_formdb'])) {
    unset($_SESSION['id']);
    unset($_SESSION['email']);
    unset($_SESSION['full_name']);
    unset($_SESSION['pass_word']);
    unset($_SESSION['user_formdb']);
    session_destroy();
    
  }
}

include_once __DIR__ . '/../partials/header.php'; //header
?>
<main>
  <section>
    <?php if (!isset($_SESSION['user'])) : ?>
      <div style="height: 200px; margin-top:200px" class="text-center">
        <h1 style="color: #F2B686;">
          <p> Bạn đã đăng xuất thành công</p>
        </h1>
        <a href="index.php"> <button class="btn btn-warning">Đi đến trang chủ</button></a>
        <a href="menu.php"> <button class="btn btn-warning">Đi đến trang menu</button></a>

      </div>

    <?php endif ?>

  </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- footer -->
<?php include __DIR__ . '/../partials/footer.php' ?> 