<?php
require_once 'includes/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header("Location: gallery.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT g.*, c.name AS category_name 
    FROM gallery_items g 
    JOIN categories c ON g.category_id = c.id 
    WHERE g.id = ?
");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    header("Location: gallery.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?= htmlspecialchars($project['title']) ?> - PhotoFolio</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>
<body class="gallery-single-page">
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
          <li><a href="services.php">Services</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="main">
    <div class="page-title" data-aos="fade">
      <div class="heading">
        <div class="container text-center">
          <h1><?= htmlspecialchars($project['title']) ?></h1>
        </div>
      </div>
    </div>

    <section id="gallery-details" class="gallery-details section">
      <div class="container" data-aos="fade-up">
        <div class="text-center mb-4">
          <img src="<?= htmlspecialchars($project['image_url']) ?>" class="img-fluid rounded" alt="<?= htmlspecialchars($project['title']) ?>">
        </div>

        <div class="row justify-content-between gy-4 mt-4">
          <div class="col-lg-8" data-aos="fade-up">
            <div class="portfolio-description">
              <h2>Project Overview</h2>
              <p><?= nl2br(htmlspecialchars($project['description'] ?? 'No description provided.')) ?></p>
            </div>
          </div>
          <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
            <div class="portfolio-info">
              <h3>Project Information</h3>
              <ul>
                <li><strong>Category:</strong> <?= htmlspecialchars($project['category_name']) ?></li>
                <li><strong>Client:</strong> <?= htmlspecialchars($project['client'] ?? 'Private Client') ?></li>
                <li><strong>Date:</strong> <?= htmlspecialchars($project['project_date'] ?? 'N/A') ?></li>
                <?php if (!empty($project['project_url'])): ?>
                  <li><strong>Project URL:</strong> <a href="<?= htmlspecialchars($project['project_url']) ?>" target="_blank">Visit Site</a></li>
                <?php endif; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
</body>
</html>
