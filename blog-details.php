    <?php
    require_once 'db.php';
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $detail = null;
    if($id > 0) {
        $result = $conn->query("SELECT * FROM kegiatan_ormas WHERE id=$id");
        $detail = $result->fetch_assoc();
    }
    ?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
      <meta charset="utf-8">
      <meta content="width=device-width, initial-scale=1.0" name="viewport">
      <title>Sistem Informasi Organisasi Masyarakat</title>
      <meta name="description" content="Detail kegiatan organisasi masyarakat di Kabupaten Natuna">
      <meta name="keywords" content="Ormas, Natuna, Kegiatan, Kabupaten Natuna">
      <link href="assets/img/logo.png" rel="icon">
      <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
      <link href="https://fonts.googleapis.com" rel="preconnect">
      <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
      <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
      <link href="assets/vendor/aos/aos.css" rel="stylesheet">
      <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
      <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
      <link href="assets/css/main.css" rel="stylesheet">
      <style>
        /* Pastikan logo dan header tetap besar dan proporsional */
        .logo img { height: 48px; }
        .blog-author-widget .rounded-circle { width: 80px; height: 80px; object-fit: cover; }
        .post-img img { width: 100%; height: 320px; object-fit: cover; }
        .recent-posts-widget .post-item img { width: 40px; height: 40px; object-fit: cover; }
      </style>
    </head>

    <body class="blog-details-page">

      <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">
          <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="assets/img/logo.png" alt="">
            <h1 class="sitename">SI-ORMAS</h1>
          </a>
          <nav id="navmenu" class="navmenu">
            <ul>
              <li><a href="index.php#hero">Beranda</a></li>
              <li><a href="index.php#about">Seputar Ormas</a></li>
              <li><a href="index.php#services">Layanan</a></li>
              <li><a href="index.php#portfolio">Data Ormas</a></li>
              <li><a href="blog.php" class="active">Kegiatan Ormas</a></li>
              <li><a href="index.php#kontak">Kontak</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
          </nav>
        </div>
      </header>

      <main class="main">

        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.jpeg);">
          <div class="container position-relative">
            <h1>Detail Kegiatan Ormas</h1>
            <p>Baca detail kegiatan dan program terbaru organisasi masyarakat</p>
            <nav class="breadcrumbs">
              <ol>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="blog.php">Kegiatan Ormas</a></li>
                <li class="current">Detail Kegiatan</li>
              </ol>
            </nav>
          </div>
        </div><!-- End Page Title -->

        <div class="container">
          <div class="row">

            <div class="col-lg-8">

              <!-- Blog Details Section -->
              <section id="blog-details" class="blog-details section">
                <div class="container">
                  <?php if ($detail): ?>
                  <article class="article">
                    <div class="post-img">
                      <img src="<?php echo htmlspecialchars($detail['foto_kegiatan']); ?>" alt="" class="img-fluid">
                    </div>
                    <h2 class="title"><?php echo htmlspecialchars($detail['nama_kegiatan']); ?></h2>
                    <div class="meta-top">
                      <ul>
                        <li class="d-flex align-items-center">
                          <i class="bi bi-person"></i> <?php echo htmlspecialchars($detail['ormas_penyelenggara']); ?>
                        </li>
                        <li class="d-flex align-items-center">
                          <i class="bi bi-clock"></i>
                          <time datetime="<?php echo $detail['tanggal_kegiatan']; ?>">
                            <?php echo date('d F Y', strtotime($detail['tanggal_kegiatan'])); ?>
                          </time>
                        </li>
                      </ul>
                    </div>
                    <div class="content">
                      <p><?php echo htmlspecialchars($detail['deskripsi_singkat']); ?></p>
                      <p><?php echo nl2br(htmlspecialchars($detail['deskripsi_lengkap'])); ?></p>
                    </div>
                  </article>
                  <?php else: ?>
                    <div class="alert alert-warning">Kegiatan tidak ditemukan.</div>
                  <?php endif; ?>
                </div>
              </section><!-- /Blog Details Section -->

            </div>

            <div class="col-lg-4 sidebar">

              <div class="widgets-container">

                <!-- Blog Author Widget -->
                <div class="blog-author-widget widget-item">
                  <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center w-100">
                      <img src="assets/img/blog/blog-author.jpeg" class="rounded-circle flex-shrink-0" alt="">
                      <div>
                        <h4>Badan Kesatuan Bangsa dan Politik Kabupaten Natuna</h4>
                      </div>
                    </div>
                    <p>
                      Badan Kesatuan Bangsa dan Politik Kabupaten Natuna sebagai lembaga pemerintah berperan dalam menjaga persatuan dan kesatuan bangsa
                    </p>
                  </div>
                </div><!--/Blog Author Widget -->

                <!-- Recent Posts Widget -->
                <div class="recent-posts-widget widget-item">
                  <h3 class="widget-title">Kegiatan Terbaru</h3>
                  <?php
                  $res = $conn->query("SELECT id, nama_kegiatan, foto_kegiatan, tanggal_kegiatan FROM kegiatan_ormas ORDER BY tanggal_kegiatan DESC LIMIT 3");
                  while ($rec = $res->fetch_assoc()):
                  ?>
                    <div class="post-item d-flex align-items-center mb-2">
                      <img src="<?php echo htmlspecialchars($rec['foto_kegiatan']); ?>" alt="" class="flex-shrink-0">
                      <div class="ms-2">
                        <h4 style="font-size:1rem;"><a href="blog-details.php?id=<?php echo $rec['id']; ?>"><?php echo htmlspecialchars($rec['nama_kegiatan']); ?></a></h4>
                        <time datetime="<?php echo $rec['tanggal_kegiatan']; ?>"><?php echo date('d F Y', strtotime($rec['tanggal_kegiatan'])); ?></time>
                      </div>
                    </div>
                  <?php endwhile; ?>
                </div><!--/Recent Posts Widget -->

              </div>
            </div>
          </div>
        </div>

    <!-- kontak Section -->
    <section id="kontak" class="kontak section dark-background" style="position:relative;overflow:hidden;">
      <img src="assets/img/cta-bg.jpg" alt="" style="width:100%;max-height:280px;object-fit:cover;opacity:0.18;position:absolute;left:0;top:0;z-index:0;">
      <div class="container position-relative" style="z-index:1;">
        <div class="row" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-8 text-center text-xl-start">
            <h2>kontak & Bantuan SI-ORMAS</h2>
            <p>Jika Anda membutuhkan bantuan, pertanyaan, saran, atau informasi lebih lanjut terkait SI-ORMAS, silakan hubungi admin melalui email di bawah ini.</p>
          </div>
            <div class="col-xl-4 cta-btn-container text-center">
              <a class="cta-btn align-middle btn btn-success" href="mailto:kesbangpol_natuna@yahoo.com">Hubungi Admin via Email</a>
            </div>
          </div>
          <div class="row gy-4 mt-4">
            <div class="col-lg-6">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Alamat</h3>
                  <p>Komplek Natuna Gerbang Utaraku,</p>
                  <p>Gedung Diklat I lantai 2.</p>
                  <p>Ranai, Kab. Natuna – Prov. Kepulauan Riau</p>
                </div>
              </div>
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Telepon</h3>
                  <p>+62</p>
                </div>
              </div>
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email</h3>
                  <p><a href="mailto:kesbangpol_natuna@yahoo.com">kesbangpol_natuna@yahoo.com</a></p>
                </div>
              </div>
            </div>
            <div class="col-lg-6" style="display:flex;align-items:center;justify-content:center;">
              <!-- Optional: Google Maps jika ingin -->
              <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!..." width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
            </div>
          </div>
        </div>
      </section>
      <!-- /kontak Section -->

      </main>

      <footer id="footer" class="footer dark-background">
        <div class="container">
          <h3 class="sitename">SI-ORMAS</h3>
          <p>Sistem Informasi Organisasi Masyarakat </p>
          <div class="container">
            <div class="copyright">
              <span>Copyright</span> <strong class="px-1 sitename">SI-ORMAS</strong> <span>All Rights Reserved</span>
            </div>
          </div>
        </div>
      </footer>

      <!-- Scroll Top -->
      <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
      <div id="preloader"></div>
      <!-- Vendor JS Files -->
      <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/vendor/php-email-form/validate.js"></script>
      <script src="assets/vendor/aos/aos.js"></script>
      <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
      <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
      <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
      <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
      <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
      <script src="assets/js/main.js"></script>
    </body>
    </html>
    <?php $conn->close(); ?>