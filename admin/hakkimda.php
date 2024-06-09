<?php
include("../baglanti.php");

// Formdan gelen verileri alıyoruz
$github = $_POST['github'] ?? '';
$linkedin = $_POST['linkedin'] ?? '';
$medium = $_POST['medium'] ?? '';
$hakkimda = $_POST['hakkimda'] ?? '';
$icerik = $_POST['icerik'] ?? '';

// Verileri veritabanına ekleyen sorgu
$sql = "UPDATE anasayfa SET linkedin='$linkedin', github='$github', medium='$medium', hakkimda='$hakkimda', icerik='$icerik' WHERE id=1";

// SQL sorgusunu çalıştır
if ($baglan->query($sql) === TRUE) {
   
} else {
    echo "Veri güncellenirken hata oluştu: " . $baglan->error;
}

// Bağlantıyı kapat
$baglan->close();
?>




<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hakkımda Düzenle</title>
    <link rel="stylesheet" href="style/hakkimda.css" />
    <link rel="stylesheet" href="style/sidebar.css" />
  </head>
  <body>
    <div class="container">
      <div class="sidebar">
        <!-- Yan menü -->
        <h2>Admin Paneli</h2>
        <img src="image/isimsiz.png" alt="" />
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

      <div class="main-content">
        <!-- Ana içerik -->
        <header>
          <h1>Hakkımda Sayfasını Düzenle</h1>
        </header>

        <div class="content">
          <!-- Hakkımda düzenleme formu -->
          <form action="hakkimda.php" method="POST">
          <label for="icerik">Giriş Yazısı:</label>
          <textarea id="icerik" name="icerik" rows="8" cols="50" ></textarea>

          <label for="hakkimda">Hakkımda:</label>
          <textarea id="hakkimda" name="hakkimda" rows="8" cols="50"></textarea>

          <div class="form-group">
          <label for="github"><i class="fa fa-github"></i> GitHub</label>
          <input type="text" id="github" name="github" placeholder="GitHub URL'si" />
          </div>
          <div class="form-group">
          <label for="linkedin"><i class="fa fa-linkedin"></i> LinkedIn</label>
          <input type="text" id="linkedin" name="linkedin" placeholder="LinkedIn URL'si" />
          </div>
          <div class="form-group">
          <label for="medium"><i class="fa fa-medium"></i> Medium</label>
          <input type="text" id="medium" name="medium" placeholder="Medium URL'si" />
          </div>
    
          <button type="submit">Güncelle</button>
          </form>

        </div>
      </div>
    </div>
  </body>
</html>
