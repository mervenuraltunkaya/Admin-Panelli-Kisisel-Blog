<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include("../baglanti.php");

if (isset($_POST["kullanici_adi"], $_POST["sifre"])) {
    $kullanici_adi = htmlspecialchars($_POST["kullanici_adi"]);
    $sifre = htmlspecialchars($_POST["sifre"]);

    // SQL sorgusunu hazırlayıp kullanıcı adı ve şifreyi kontrol edelim
    $sql = "SELECT * FROM admin WHERE kullanici_adi = '$kullanici_adi' AND sifre = '$sifre'";
    $result = $baglan->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION["user"] = $kullanici_adi;
        header("location: admin.php");
        exit(); // Yönlendirmeden sonra betiğin devam etmesini engeller
    } else {
        echo "<script>alert('Kullanıcı Adı veya Şifre Yanlış!')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Giriş</title>
    <link rel="stylesheet" href="style/giris.css" />
</head>
<body>
    <div class="container">
        <div class="contact-form">
            <a href="anasayfa.html">
                <img src="../images/mervenur.jpg" alt="logo" class="admin_img" />
            </a>
            <!-- Giriş Formu -->
            <h2>Giriş Yap</h2>
            <form action="giris.php" method="post">
                <div class="txtb">
                    <input
                        type="text"
                        name="kullanici_adi"
                        placeholder="Kullanıcı Adı"
                        id="kullaniciAdi"
                        required
                    />
                </div>
                <div class="txtb">
                    <input
                        type="password"
                        name="sifre"
                        placeholder="Şifre"
                        id="sifre"
                        required
                    />
                </div>
                <input type="submit" class="logbtn" value="Giriş Yap" style="margin-bottom: 15px;" />
                <div><a href="uyeOl.php" >Üye Ol!</a></div>
            </form>
        </div>
    </div>
</body>
</html>
