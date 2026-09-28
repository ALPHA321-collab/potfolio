<?php
require_once 'includes/db.php';
$testimonials = $pdo->query("SELECT * FROM testimonials")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>About - PhotoFolio</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>
<body class="about-page">
  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <i class="bi bi-camera"></i>
        <h1 class="sitename">PhotoFolio</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php" class="active">About</a></li>
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
    </div>
  </header>

  <main class="main">
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1>About</h1>
              <p class="mb-0">Professional photographer capturing unforgettable moments and perspectives.</p>
              <a href="contact.php" class="cta-btn">Available for Hire<br></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section id="about" class="about section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-center">
          <div class="col-lg-4">
            <img src="assets/img/profile-img.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-5 content">
            <h2>Professional Photographer from Faisalabad</h2>
            <p class="fst-italic py-3">Specializing in commercial, event, and portrait photography.</p>
            <div class="row">
              <div class="col-lg-6">
                <ul>
                  <li><i class="bi bi-chevron-right"></i> <strong>Birthday:</strong> <span>1 May 1995</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong> <span>www.example.com</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong> <span>+92 315 4367867</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>City:</strong> <span>Faisalabad, Pakistan</span></li>
                </ul>
              </div>
              <div class="col-lg-6">
                <ul>
                  <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong> <span>30</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong> <span>Master</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong> <span>info@example.com</span></li>
                  <li><i class="bi bi-chevron-right"></i> <strong>Freelance:</strong> <span>Available</span></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>What they are saying</p>
      </div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": { "delay": 5000 },
              "slidesPerView": "auto",
              "pagination": { "el": ".swiper-pagination", "type": "bullets", "clickable": true },
              "breakpoints": { "320": { "slidesPerView": 1, "spaceBetween": 40 }, "1200": { "slidesPerView": 3, "spaceBetween": 1 } }
            }
          </script>
          <div class="swiper-wrapper">
            <?php foreach ($testimonials as $t): ?>
            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <?php for ($i = 0; $i < $t['rating']; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                </div>
                <p><?= htmlspecialchars($t['quote']) ?></p>
                <div class="profile mt-auto">
                  <img src="<?= htmlspecialchars($t['image_url']) ?>" class="testimonial-img" alt="">
                  <h3><?= htmlspecialchars($t['name']) ?></h3>
                  <h4><?= htmlspecialchars($t['designation']) ?></h4>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
          <div class="swiper-pagination"></div>
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
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
