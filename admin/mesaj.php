<?php
include("../baglanti.php");

// Veri silme işlemi
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $sql = "DELETE FROM iletisim WHERE id=$id";
  if ($baglan->query($sql) === TRUE) {
      header("Location: mesaj.php");
  } else {
      echo "Hata: " . $baglan->error;
  }
}
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gelen Mesajlar</title>
    <link rel="stylesheet" href="style/mesaj.css" />
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
                <h1>Gelen Mesajlar</h1>
            </header>
            <div class="admin-panel__table">
                <!-- Mesajlar tablosu -->
                <table>
                    <thead>
                        <tr>
                            <th>İsim</th>
                            <th>Email</th>
                            <th>Mesaj</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("../baglanti.php");

                        $sec = "Select * From iletisim";
                        $sonuc = $baglan->query($sec);

                        if ($sonuc->num_rows > 0) {
                            while ($cek = $sonuc->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $cek['adSoyad'] . "</td>";
                                echo "<td>" . $cek['email'] . "</td>";
                                echo "<td>" . $cek['mesaj'] . "</td>";
                                echo "<td>
                                <a href='mesaj.php?delete=" . $cek['id'] . "' class='delete' >Sil</a>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Mesaj bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
