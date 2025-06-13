<h2 class="section-title"><?php echo $page_heading; ?></h2>
        
<div class="berita-grid">
    <?php foreach ($berita_list as $berita): ?>
        <a href="index.php?slug=<?php echo htmlspecialchars($berita['slug']); ?>" style="text-decoration: none; color: inherit;">
            <div class="berita-card">
                <img src="<?php echo htmlspecialchars($berita['gambar']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="berita-img">
                <div class="berita-content">
                    <div class="kategori-tag"><?php echo htmlspecialchars($berita['nama_kategori']); ?></div>
                    <h3 class="berita-title"><?php echo htmlspecialchars($berita['judul']); ?></h3>
                    <p class="berita-excerpt"><?php echo htmlspecialchars(substr($berita['isi'], 0, 150)) . '...'; ?></p>                   
                </div>
                <div class="berita-meta">
                        <span><?php echo date('d M Y', strtotime($berita['tanggal_posting'])); ?></span>
                        <span><i class="far fa-eye"></i> <?php echo $berita['views']; ?></span>
                    </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<?php if ($total_pages > 1): ?>
<div class="pagination">
    <?php 
        // Bangun query string dari parameter yang ada untuk link pagination
        $pagination_query = http_build_query($pagination_params); 
    ?>

    <?php if ($current_page > 1): ?>
        <a href="?<?php echo $pagination_query; ?>&page=<?php echo $current_page - 1; ?>"><i class="fas fa-chevron-left"></i></a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?<?php echo $pagination_query; ?>&page=<?php echo $i; ?>" class="<?php echo $i == $current_page ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
    
    <?php if ($current_page < $total_pages): ?>
        <a href="?<?php echo $pagination_query; ?>&page=<?php echo $current_page + 1; ?>"><i class="fas fa-chevron-right"></i></a>
    <?php endif; ?>
</div>
<?php endif; ?>