<?php
/**
 * File Utama (Controller)
 */

require_once 'config.php';
require_once 'functions.php';

$koneksi = getDbConnection();
$kategori_list = getAllKategori($koneksi);

// Logika untuk menampilkan detail berita
if (isset($_GET['slug']) && !empty($_GET['slug'])) {
    
    $slug = $_GET['slug'];
    $detail_berita = getBeritaBySlug($koneksi, $slug);

    if (!$detail_berita) {
        http_response_code(404);
        die("<h1>404 Not Found</h1><p>Berita yang Anda cari tidak ditemukan.</p><a href='index.php'>Kembali ke beranda</a>");
    }

    // Tambah jumlah view saat berita dibuka
    incrementViewCount($koneksi, $detail_berita['id']);

    $page_title = htmlspecialchars($detail_berita['judul']) . " - BeritaSpot";
    $page_heading = 'Detail Berita';

    require 'templates/header.php';
    require 'templates/detail_berita.php';

} else {
    // Logika untuk menampilkan daftar berita (beranda, kategori, pencarian, trending)

    $page_heading = 'Berita Terkini';
    $pagination_params = []; // Untuk link di paginasi
    $where_clause = "";
    $order_by_clause = "ORDER BY b.tanggal_posting DESC"; // Urutan default

    // Jika ada pencarian
    if (!empty($_GET['q'])) {
        $search_term = mysqli_real_escape_string($koneksi, $_GET['q']);
        $where_clause = "WHERE b.judul LIKE '%$search_term%' OR b.isi LIKE '%$search_term%'";
        $page_heading = 'Hasil Pencarian untuk: "' . htmlspecialchars($_GET['q']) . '"';
        $pagination_params['q'] = $_GET['q'];
    }
    // Jika ada filter kategori
    elseif (!empty($_GET['kategori_id'])) {
        $kategori_id = (int)$_GET['kategori_id'];
        $where_clause = "WHERE b.kategori_id = $kategori_id";
        foreach ($kategori_list as $k) {
            if ($k['id'] == $kategori_id) {
                $page_heading = 'Kategori: ' . htmlspecialchars($k['nama_kategori']);
                break;
            }
        }
        $pagination_params['kategori_id'] = $kategori_id;
    }
    // Jika mengurutkan berdasarkan trending
    elseif (!empty($_GET['sort']) && $_GET['sort'] === 'trending') {
        $where_clause = "WHERE b.views > 0";
        $order_by_clause = "ORDER BY b.views DESC, b.tanggal_posting DESC";
        $page_heading = 'Berita Trending';
        $pagination_params['sort'] = 'trending';
    }

    // Ambil SEMUA berita yang cocok dengan kriteria
    $all_berita = getBerita($koneksi, $where_clause, $order_by_clause);
    $total_berita = count($all_berita);

    // Logika Paginasi
    $limit = BERITA_PER_HALAMAN;
    $total_pages = $total_berita > 0 ? ceil($total_berita / $limit) : 0;
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $limit;
    
    // Potong array hasil query untuk halaman saat ini
    // Cara ini tidak efisien tapi mudah dipahami
    $berita_list = array_slice($all_berita, $offset, $limit);

    $page_title = 'BeritaSpot - ' . $page_heading;

    require 'templates/header.php';

    if (empty($berita_list)) {
        echo "<div class='no-results' style='padding: 20px; text-align: center;'>Tidak ada berita yang ditemukan.</div>";
    } else {
        require 'templates/list_berita.php';
    }
}

require 'templates/footer.php';
mysqli_close($koneksi);
?>