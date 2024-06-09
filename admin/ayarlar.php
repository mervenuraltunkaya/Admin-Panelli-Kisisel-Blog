<?php
// Veritabanı bağlantısını sağlayalım
include("../baglanti.php");

// Formdan gelen kullanıcı adı ve şifreyi alalım
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Kullanıcı adı ve şifreyi veritabanında güncelleyelim
    $sql = "UPDATE admin SET kullanici_adi='$username', sifre='$password' WHERE id=0"; // Burada id=0, varsayılan admin kullanıcısını belirtir. Eğer farklı bir yapı kullanıyorsanız bu sorguyu buna göre ayarlayın.

    if ($baglan->query($sql) === TRUE) {
    } else {
        echo "Hata: " . $sql . "<br>" . $baglan->error;
    }
}
?>


<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kullanıcı Bilgilerini Güncelle</title>
    <link rel="stylesheet" href=style/ayar.css />
    <link rel="stylesheet" href="style/sidebar.css" />
  </head>

  <body>
    <div class="container">
      <!-- Yan menü -->
      <div class="sidebar">
        <h2>Admin Paneli</h2>
        <ul>
                <li><a href="admin.php">Giriş</a></li>
                <li><a href="hakkimda.php">Hakkımda</a></li>
                <li><a href="egitim.php">Eğitim</a></li>
                <li><a href="deneyim.php">Deneyim</a></li>
                <li><a href="yetkinlikler.php">Yetkinlikler</a></li>
                <li><a href="projelerim.php">Projeler</a></li>
                <li><a href="sertifika.php">Sertifikalar</a></li>
                <li><a href="referans.php">Referanslar</a></li>
                <li><a href="mesaj.php">Gelen Mesajlar</a></li>
                <li><a href="ayarlar.php">Ayarlar</a></li>
            </ul>
      </div>

      <!-- Ana içerik -->
      <div class="main-content">
        <header>
          <h1>Kullanıcı Bilgilerini Güncelle</h1>
        </header>
        <div class="content">
          <form action="ayarlar.php" method="post">
            <label for="username" style="color:white;">Kullanıcı Adı:</label>
            <input type="text" id="username" name="username" required />

            <label for="password" style="color:white;">Yeni Şifre:</label>
            <input type="password" id="password" name="password" required />

            <button type="submit">Güncelle</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
