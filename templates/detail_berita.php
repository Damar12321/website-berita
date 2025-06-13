<div class="detail-container">
    <a href="index.php" class="back-button">
        <i class="fas fa-arrow-left"></i> Kembali ke Beranda
    </a>
    
    <img src="<?php echo htmlspecialchars($detail_berita['gambar']); ?>" alt="<?php echo htmlspecialchars($detail_berita['judul']); ?>" class="detail-img">
    
    <div class="detail-kategori"><?php echo htmlspecialchars($detail_berita['nama_kategori']); ?></div>
    <h1 class="detail-title"><?php echo htmlspecialchars($detail_berita['judul']); ?></h1>
    
    <div class="detail-meta">
        <span><i class="far fa-calendar"></i> <?php echo date('d M Y', strtotime($detail_berita['tanggal_posting'])); ?></span>
        <span><i class="far fa-clock"></i> 5 min read</span>
    </div>
    
    <div class="detail-content">
        <?php echo nl2br(htmlspecialchars($detail_berita['isi'])); ?>
    </div>
</div>x`