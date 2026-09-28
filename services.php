<?php
require_once 'includes/db.php';
$services = $pdo->query("SELECT * FROM services")->fetchAll();
$pricing = $pdo->query("SELECT * FROM pricing")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Services - PhotoFolio</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>
<body class="services-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <i class="bi bi-camera"></i>
        <h1 class="sitename">PhotoFolio</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="gallery.php">Gallery</a></li>
          <li><a href="services.php" class="active">Services</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main">
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container text-center">
          <h1>Services & Pricing</h1>
        </div>
      </div>
    </div>

    <section id="services" class="services section">
      <div class="container">
        <div class="row gy-4">
          <?php foreach ($services as $s): ?>
          <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi <?= htmlspecialchars($s['icon']) ?> icon"></i></div>
              <h4><a href="" class="stretched-link"><?= htmlspecialchars($s['title']) ?></a></h4>
              <p><?= htmlspecialchars($s['description']) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="pricing" class="pricing section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Pricing</h2>
        <p>Transparent rates for quality shoots</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 gx-lg-5">
          <?php foreach ($pricing as $p): ?>
          <div class="col-lg-6">
            <div class="pricing-item d-flex justify-content-between">
              <h3><?= htmlspecialchars($p['title']) ?></h3>
              <h4>$<?= number_format($p['price'], 2) ?></h4>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  </main>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
</body>
</html>
