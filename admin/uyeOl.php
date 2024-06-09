<?php
session_start();
include("../baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici_adi = htmlspecialchars($_POST["kullanici_adi"]);
    $sifre = htmlspecialchars($_POST["sifre"]);

    // Kullanıcı adının alınmadığını kontrol et
    $check_username_query = "SELECT * FROM admin WHERE kullanici_adi = '$kullanici_adi'";
    $result = $baglan->query($check_username_query);
    if ($result->num_rows > 0) {
        // Kullanıcı adı zaten alınmış, kullanıcıya bir mesaj göster
        echo "<script>alert('Bu kullanıcı adı zaten alınmış. Lütfen farklı bir kullanıcı adı seçin.')</script>";
        // Hata durumunda formun tekrar gösterilmesi için sayfayı yeniden yükle
        echo "<script>window.location.href = 'uyeOl.php'</script>";
        exit();
    }

    // Kullanıcı adı alınmadıysa, kullanıcıyı veritabanına ekle
    $sql = "INSERT INTO admin (kullanici_adi, sifre) VALUES ('$kullanici_adi', '$sifre')";

    if ($baglan->query($sql) === TRUE) {
        // Üyelik başarıyla tamamlandı mesajını göster
        echo "<script>alert('Üyelik başarıyla tamamlandı. Giriş yapabilirsiniz.')</script>";
        // Giriş sayfasına yönlendir
        echo "<script>window.location.href = 'giris.php'</script>";
        exit(); // Betiğin devam etmesini engelle
    } else {
        echo "<script>alert('Üyelik oluşturulurken bir hata oluştu.')</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üye Ol</title>
    <link rel="stylesheet" href="style/giris.css">
</head>
<body>
    <div class="container">
        <div class="contact-form">
            <a href="anasayfa.html">
                <img src="../images/mervenur.jpg" alt="logo" class="admin_img">
            </a>
            <!-- Üyelik Formu -->
            <h2>Üye Ol</h2>
            <form action="uyeOl.php" method="post">
                <div class="txtb">
                    <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" id="kullaniciAdi" required>
                </div>
                <div class="txtb">
                    <input type="password" name="sifre" placeholder="Şifre" id="sifre" required>
                </div>
                <input type="submit" class="logbtn" value="Üye Ol" style="margin-bottom:15px;" >
                <div><a href="giris.php" >Giriş Yap</a></div>
            </form>
        </div>
    </div>
</body>
</html>
