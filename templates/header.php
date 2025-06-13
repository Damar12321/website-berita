<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'BeritaSpot - Portal Berita Terkini'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="sidebar">
        <a href="index.php" style="text-decoration: none; color: inherit;">
            <div class="logo">
                <i class="fas fa-newspaper"></i>
                <span>Damar News</span>
            </div>
        </a>
        
<ul class="menu">
            <li><a href="index.php" class="<?php echo empty($_GET) ? 'active' : ''; ?>"><i class="fas fa-home"></i> <span>Beranda</span></a></li>
            
            <li><a href="index.php?sort=trending" class="<?php echo (isset($_GET['sort']) && $_GET['sort'] === 'trending') ? 'active' : ''; ?>"><i class="fas fa-fire"></i> <span>Trending</span></a></li>
            
        </ul>
        
        <div class="kategori-title">KATEGORI</div>
        <ul class="kategori-list">
            <?php foreach ($kategori_list as $kategori): ?>
                <li>
                    <a href="index.php?kategori_id=<?php echo $kategori['id']; ?>" class="<?php echo (isset($_GET['kategori_id']) && $_GET['kategori_id'] == $kategori['id']) ? 'active' : ''; ?>">
                        <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    
    <div class="main-content">
        <div class="header">
            <form action="index.php" method="GET" class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" name="q" placeholder="Cari berita..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
            </form>
        </div>