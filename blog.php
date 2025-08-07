<?php
require_once 'db.php';
$kegiatan = [];
$result = $conn->query("SELECT * FROM kegiatan_ormas ORDER BY tanggal_kegiatan DESC");
while ($row = $result->fetch_assoc()) {
    $kegiatan[] = $row;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistem Informasi Organisasi Masyarakat</title>
  <meta name="description" content="Kegiatan-kegiatan Organisasi Masyarakat Kabupaten Natuna">
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
</head>

<body class="blog-page">

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

    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.jpeg);">
      <div class="container position-relative">
        <h1>Kegiatan Ormas Kabupaten Natuna</h1>
        <p>Kumpulan kegiatan terbaru organisasi masyarakat</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Beranda</a></li>
            <li class="current">Kegiatan Ormas</li>
          </ol>
        </nav>
      </div>
    </div>

    <section id="blog-posts" class="blog-posts section">
      <div class="container">
        <div class="row gy-4">
          <?php if(count($kegiatan) > 0): foreach ($kegiatan as $item): ?>
          <div class="col-lg-4">
          <article>
            <div class="post-img">
              <img src="<?= htmlspecialchars($item['link_foto_kegiatan']) ?>" alt="" class="img-fluid" style="width:100%;height:220px;object-fit:cover;">
            </div>
            <h2 class="title">
              <a href="blog-details.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['nama_kegiatan']) ?></a>
            </h2>
            <div class="d-flex align-items-center">
              <img src="<?= htmlspecialchars($item['link_foto_kegiatan']) ?>" alt="" class="img-fluid post-author-img flex-shrink-0" style="width:40px;height:40px;object-fit:cover;">
              <div class="post-meta">
                <p class="post-author"><?= htmlspecialchars($item['ormas_penyelenggara']) ?></p>
                <p class="post-date">
                  <time datetime="<?= $item['tanggal_kegiatan'] ?>">
                    <?= date('d F Y', strtotime($item['tanggal_kegiatan'])) ?>
                  </time>
                </p>
              </div>
            </div>
            <div class="card-actions">
              <button type="button"
                class="btn btn-sm btn-warning btn-edit-kegiatan"
                title="Edit"
                data-id="<?= $item['id'] ?>"
                data-nama="<?= htmlspecialchars($item['nama_kegiatan'], ENT_QUOTES) ?>"
                data-ormas="<?= htmlspecialchars($item['ormas_penyelenggara'], ENT_QUOTES) ?>"
                data-tanggal="<?= $item['tanggal_kegiatan'] ?>"
                data-foto="<?= htmlspecialchars($item['link_foto_kegiatan'], ENT_QUOTES) ?>"
                data-singkat="<?= htmlspecialchars($item['deskripsi_singkat'], ENT_QUOTES) ?>"
                data-lengkap="<?= htmlspecialchars($item['deskripsi_lengkap'], ENT_QUOTES) ?>">
                <i class="bi bi-pencil"></i>
              </button>
              <form method="POST" action="forms/delete_kegiatan.php" style="display:inline;" onsubmit="return confirm('Yakin hapus kegiatan ini?');">
                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </div>
          </article>
        </div>
          <?php endforeach; else: ?>
            <div class="col-12 text-center"><em>Tidak ada data kegiatan ORMAS.</em></div>
          <?php endif; ?>
        </div>
      </div>
      <!-- Modal Edit Kegiatan -->
      <div class="modal fade" id="modalEditKegiatan" tabindex="-1" aria-labelledby="modalEditKegiatanLabel" aria-hidden="true">
        <div class="modal-dialog">
          <form method="post" id="formEditKegiatan" action="forms/edit_kegiatan.php">
            <input type="hidden" name="id" id="edit_id">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalEditKegiatanLabel">Edit Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-2">
                  <label>Nama Kegiatan</label>
                  <input type="text" name="nama_kegiatan" id="edit_nama_kegiatan" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label>Ormas Penyelenggara</label>
                  <input type="text" name="ormas_penyelenggara" id="edit_ormas_penyelenggara" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label>Tanggal Kegiatan</label>
                  <input type="date" name="tanggal_kegiatan" id="edit_tanggal_kegiatan" class="form-control" required>
                </div>
                <div class="mb-2">
                  <label>Link Foto Kegiatan</label>
                  <input type="url" name="link_foto_kegiatan" id="edit_link_foto_kegiatan" class="form-control" placeholder="https://..." required>
                </div>
                <div class="mb-2">
                  <label>Deskripsi Singkat</label>
                  <input type="text" name="deskripsi_singkat" id="edit_deskripsi_singkat" class="form-control">
                </div>
                <div class="mb-2">
                  <label>Deskripsi Lengkap</label>
                  <textarea name="deskripsi_lengkap" id="edit_deskripsi_lengkap" rows="4" class="form-control"></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <script>
      document.querySelectorAll('.btn-edit-kegiatan').forEach(btn => {
        btn.addEventListener('click', function() {
          document.getElementById('edit_id').value = this.getAttribute('data-id');
          document.getElementById('edit_nama_kegiatan').value = this.getAttribute('data-nama');
          document.getElementById('edit_ormas_penyelenggara').value = this.getAttribute('data-ormas');
          document.getElementById('edit_tanggal_kegiatan').value = this.getAttribute('data-tanggal');
          document.getElementById('edit_link_foto_kegiatan').value = this.getAttribute('data-foto');
          document.getElementById('edit_deskripsi_singkat').value = this.getAttribute('data-singkat');
          document.getElementById('edit_deskripsi_lengkap').value = this.getAttribute('data-lengkap');
          var modal = new bootstrap.Modal(document.getElementById('modalEditKegiatan'));
          modal.show();
        });
      });
      </script>
    </section>

    <!-- Blog Pagination Section (optional) -->
    <!-- ...pagination jika ingin... -->
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
      <p>Sistem Informasi Organisasi Masyarakat Kabupaten Natuna</p>
      <div class="container">
        <div class="copyright">
          <span>Copyright</span> <strong class="px-1 sitename">SI-ORMAS</strong> <span>All Rights Reserved</span>
        </div>
      </div>
    </div>
  </footer>

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>
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