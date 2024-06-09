<?php
session_start();

// Kullanıcı oturumunu kontrol et
if (!isset($_SESSION["user"])) {
    header("location: giris.php"); // Kullanıcı giriş yapmamışsa giriş sayfasına yönlendir
    exit(); // Yönlendirmeden sonra betiğin devam etmesini engeller
}

// Çıkış işlemi
if(isset($_POST['logout'])) {
    session_destroy(); // Oturumu sonlandır
    header("location: giris.php"); // Giriş sayfasına yönlendir
    exit(); // Yönlendirmeden sonra betiğin devam etmesini engeller
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>
    <!-- Admin paneli için stil dosyaları -->
    <link rel="stylesheet" href="style/admin.css" />
    <link rel="stylesheet" href="style/sidebar.css" />
</head>
<body>
    <div class="container">
        <!-- Yan panel -->
        <aside class="sidebar">
            <h2>Admin Paneli</h2>
            <ul>
                <!-- Menü bağlantıları -->
                <li><a href="admin.php">Giriş</a></li>
                <li><a href="hakkimda.php">Hakkımda</a></li>
                <li><a href="egitim.php">Eğitim</a></li>
                <li><a href="deneyim.php">Deneyim</a></li>
                <li><a href="yetkinlikler.php">Yetkinlikler</a></li>
                <li><a href="projelerim.php">Projeler</a></li>
                <li><a href="sertifika.php">Sertifikalar</a></li>
                <li><a href="referans.php">Referanslar</a></li>
                <li><a href="mesaj.php">Gelen Mesajlar</a></li>
            </ul>
        </aside>
        <!-- Ana içerik alanı -->
        <main class="main-content">
            <header>
                <!-- Kullanıcıya selam ve çıkış butonu -->
                <h1>Merhaba, Merve</h1>
                <form action="" method="post">
                    <input type="submit" name="logout" value="Çıkış" />
                </form>
            </header>
            <div class="content">
                <!-- Ana içerik buraya gelecek -->
                <p>İçeriklerini bu panelde dilediğin gibi değiştirebilirsin!</p>
            </div>
        </main>
    </div>
</body>
</html>
