<?php
require_once 'includes/db.php';

$category_slug = $_GET['category'] ?? null;

if ($category_slug) {
    $stmt = $pdo->prepare("
        SELECT g.*, c.name AS category_name 
        FROM gallery_items g 
        JOIN categories c ON g.category_id = c.id 
        WHERE c.slug = ? 
        ORDER BY g.id DESC
    ");
    $stmt->execute([$category_slug]);
    $items = $stmt->fetchAll();
} else {
    $stmt = $pdo->query("SELECT g.*, c.name AS category_name FROM gallery_items g JOIN categories c ON g.category_id = c.id ORDER BY g.id DESC");
    $items = $stmt->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Gallery - PhotoFolio</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>
<body class="gallery-page">
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
          <li class="dropdown"><a href="gallery.php" class="active"><span>Gallery</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
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
        <div class="container text-center">
          <h1>Gallery <?= $category_slug ? ' - ' . ucfirst(htmlspecialchars($category_slug)) : '' ?></h1>
          <p class="mb-0">Explore selected captures across various themes and styles.</p>
        </div>
      </div>
    </div>

    <section id="gallery" class="gallery section">
      <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-center">
          <?php if (empty($items)): ?>
            <p class="text-center py-5 text-muted">No portfolio items found in this section.</p>
          <?php else: ?>
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
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
