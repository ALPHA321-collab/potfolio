<?php
require_once 'includes/db.php';

// Fetch gallery preview items
$stmt = $pdo->query("SELECT * FROM gallery_items ORDER BY id DESC LIMIT 8");
$items = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>PhotoFolio - Home</title>
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&family=Inter:wght@300;400;600;700&family=Cardo:wght@400;700&display=swap" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <i class="bi bi-camera"></i>
        <h1 class="sitename">PhotoFolio</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li class="dropdown"><a href="gallery.php"><span>Gallery</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="gallery.php?category=nature">Nature</a></li>
              <li><a href="gallery.php?category=people">People</a></li>
              <li><a href="gallery.php?category=architecture">Architecture</a></li>
              <li><a href="gallery.php?category=animals">Animals</a></li>
              <li><a href="gallery.php?category=sports">Sports</a></li>
              <li><a href="gallery.php?category=travel">Travel</a></li>
            </ul>
          </li>
          <li><a href="services.php">Services</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class="header-social-links">
        <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
      </div>
    </div>
  </header>

  <main class="main">
    <section id="hero" class="hero section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center" data-aos="fade-up" data-aos-delay="100">
            <h2><span>I'm </span><span class="underlight">Saad farooq</span> a Professional<span> Photographer from Faisalabad</span></h2>
            <p>Capturing the genuine essence of life, nature, and modern architecture with timeless photography.</p>
            <a href="contact.php" class="btn-get-started">Available for Hire<br></a>
          </div>
        </div>
      </div>
    </section>

    <section id="gallery" class="gallery section">
      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-center">
          <?php foreach ($items as $item): ?>
          <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="gallery-item h-100">
              <img src="<?= htmlspecialchars($item['image_url']) ?>" class="img-fluid" alt="<?= htmlspecialchars($item['title']) ?>">
              <div class="gallery-links d-flex align-items-center justify-content-center">
                <a href="<?= htmlspecialchars($item['image_url']) ?>" title="<?= htmlspecialchars($item['title']) ?>" class="glightbox preview-link"><i class="bi bi-arrows-angle-expand"></i></a>
                <a href="gallery-single.php?id=<?= $item['id'] ?>" class="details-link"><i class="bi bi-link-45deg"></i></a>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright text-center">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">PhotoFolio</strong> <span>All Rights Reserved</span></p>
      </div>
    </div>
  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
