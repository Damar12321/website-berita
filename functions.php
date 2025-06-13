<?php
/**
 * File Fungsi
 * Berisi semua fungsi bantuan dan interaksi database.
 */

/**
 * Membuat koneksi ke database.
 * Langsung menghentikan program jika gagal.
 */
function getDbConnection() {
    $koneksi = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if (!$koneksi) {
        // Pesan error yang simpel, khas untuk pemula
        die("Koneksi ke database gagal: " . mysqli_connect_error());
    }
    return $koneksi;
}

/**
 * Membuat slug dari string untuk URL.
 */
function createSlug($string) {
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', "-", $slug);
    return trim($slug, '-');
}

/**
 * Mengambil semua data kategori dari database.
 */
function getAllKategori($koneksi) {
    $query = "SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC";
    $result = mysqli_query($koneksi, $query);
    // Mengambil semua hasil sekaligus
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Mengambil daftar berita berdasarkan kriteria tertentu.
 * Fungsi ini sekarang menerima klausa WHERE dan ORDER BY sebagai string.
 * Ini adalah pendekatan yang kurang aman tetapi lebih mudah dipahami bagi pemula.
 */
function getBerita($koneksi, $where_clause = "", $order_by_clause = "ORDER BY b.tanggal_posting DESC") {
    $query = "SELECT b.id, b.judul, b.isi, b.gambar, b.slug, b.tanggal_posting, k.nama_kategori, b.views 
              FROM berita b 
              JOIN kategori k ON b.kategori_id = k.id 
              $where_clause 
              $order_by_clause";

    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        // Menampilkan error SQL jika ada, membantu saat debugging
        die("Query Error: " . mysqli_error($koneksi));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


/**
 * Mengambil satu berita berdasarkan slug-nya.
 */
function getBeritaBySlug($koneksi, $slug) {
    // Menghindari SQL Injection dengan cara yang simpel
    $safe_slug = mysqli_real_escape_string($koneksi, $slug);
    
    $query = "SELECT b.*, k.nama_kategori 
              FROM berita b 
              JOIN kategori k ON b.kategori_id = k.id 
              WHERE b.slug = '$safe_slug'";
              
    $result = mysqli_query($koneksi, $query);
    return mysqli_fetch_assoc($result);
}

/**
 * Menambah jumlah view dari sebuah berita.
 */
function incrementViewCount($koneksi, $id) {
    // Pastikan ID adalah integer untuk keamanan
    $safe_id = (int)$id;
    
    $query = "UPDATE berita SET views = views + 1 WHERE id = $safe_id";
    mysqli_query($koneksi, $query);
}
?>