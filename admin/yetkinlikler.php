
<?php
include ("../baglanti.php");

// Veri ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $yetkinlik_adi = $_POST['yetkinlik_adi'] ?? '';
    $yuzde = $_POST['yuzde'] ?? '';
    $kategori = $_POST['yetkinlik'] ?? '';

    $sql = "INSERT INTO yetkinlik (yetkinlik_adi, yuzde, kategori) VALUES ('$yetkinlik_adi', '$yuzde', '$kategori')";

    if ($baglan->query($sql) === TRUE) {
        echo "Veri başarıyla eklendi.";
    } else {
        echo "Hata: " . $sql . "<br>" . $baglan->error;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Admin Paneli</title>
    <link rel="stylesheet" href="style/projelerim.css" />
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
            <h2 class="admin-panel__title">Yetkinlik Yönetimi</h2>

            <!-- Yeni yetkinlik ekleme formu -->
            <div class="admin-panel__form">
                <form id="myForm" action="yetkinlikler.php" method="post" enctype="multipart/form-data">
                    <div class="form__group">
                        <label for="sertifika_adi">Yetkinlik Adı:</label>
                        <input type="text" id="yetkinlik_adi" name="yetkinlik_adi" required autocomplete="off" />
                    </div>
                    
                    <div class="form__group">
                        <label for="yuzde">Yetkinlik Yüzdesi:</label>
                        <input type="number" max="100" min="0"  id="yuzde" name="yuzde"  required autocomplete="off"  />
                    </div>

                    <div class="form__group">
                        <label for="yetkinlik-turu">Yetkinlik Kategorisi:</label>
                        <select id="yetkinlik-turu" name="yetkinlik" required autocomplete="off">
                            <option value="Frontend">Frontend</option>
                            <option value="Backend">Backend</option>
                            <option value="Mobil">Mobil</option>
                        </select>
                    </div>

                    <button type="submit" class="button" id="update-button">Ekle</button>
                </form>
            </div>

            <!-- Sertifika listesi -->
            <h2>Yetkinlik Tablosu</h2>
            <div class="admin-panel__table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Yetkinlik Adı</th>
                            <th>Yetkinlik Yüzdsi</th>
                            <th>Yetkinlik Kategorisi</th>
                        </tr>
                    </thead>
                    <tbody id="yetkinlik-listesi">
                        <!-- PHP ile tablo satırları oluşturma -->
                        <?php
                        $sec = "SELECT yetkinlik_adi, yuzde, kategori FROM yetkinlik";
                        $sonuc = $baglan->query($sec);

                        if ($sonuc->num_rows > 0) {
                            while ($cek = $sonuc->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $cek['yetkinlik_adi'] . "</td>";
                                echo "<td>" . $cek['yuzde'] . "</td>";
                                echo "<td>" . $cek['kategori'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Yetkinlik bulunamadı.</td></tr>";
                        }
                        $baglan->close();
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
