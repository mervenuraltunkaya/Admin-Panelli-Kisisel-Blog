<?php
$servername = "localhost"; // Sunucu adı
$username = "root";        // Veritabanı kullanıcı adı
$password = "";            // Veritabanı şifresi
$dbname = "blog"; // Veritabanı adı

// Bağlantıyı oluştur
$baglan = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($baglan->connect_error) {
    die("Bağlantı hatası: " . $baglan->connect_error);
}

?>
