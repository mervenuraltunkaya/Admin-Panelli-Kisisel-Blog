<?php
include ("../baglanti.php");

// Veri ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $kurum_adi = $_POST['kurum_adi'] ?? '';
    $yil = $_POST['yil'] ?? '';
    $pozisyon = $_POST['pozisyon'] ?? '';

    $sql = "INSERT INTO deneyim (kurum_adi, yil, pozisyon) VALUES ('$kurum_adi', '$yil', '$pozisyon')";

    if ($baglan->query($sql) === TRUE) {
        header("Location: deneyim.php");
    } else {
        echo "Hata: " . $sql . "<br>" . $baglan->error;
    }
}

// Veri silme işlemi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Silme işlemine onay vermek için JavaScript ile bir onay kutusu göster
    echo '<script>';
    echo 'if(confirm("Bu kaydı silmek istediğinize emin misiniz?")){';
    echo 'window.location.href = "deneyim.php?confirmedDelete='.$id.'";';
    echo '}';
    echo '</script>';
}

// Silme işlemi onaylandıktan sonra gerçekleştirilecek işlem
if (isset($_GET['confirmedDelete'])) {
    $id = $_GET['confirmedDelete'];
    $sql = "DELETE FROM proje WHERE id=$id";
    if ($baglan->query($sql) === TRUE) {
        header("Location: deneyim.php");
    } else {
        echo "Hata: " . $baglan->error;
    }
}

// Veri düzenleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $kurum_adi = $_POST['kurum_adi'] ?? '';
    $yil = $_POST['yil'] ?? '';
    $pozisyon = $_POST['pozisyon'] ?? '';

    $sql = "UPDATE deneyim SET kurum_adi='$kurum_adi', yil='$yil', pozisyon='$pozisyon' WHERE id=$id";

    if ($baglan->query($sql) === TRUE) {
        header("Location: deneyim.php");
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
            <h2 class="admin-panel__title">Deneyim Yönetimi</h2>

            <!-- Yeni deneyim ekleme formu -->
            <div class="admin-panel__form">
                <form id="myForm" action="deneyim.php" method="post">
                    <div class="form__group">
                        <label for="kurum_adi">Kurum Adı:</label>
                        <input type="text" id="kurum_adi" name="kurum_adi" required autocomplete="off" />
                    </div>
                    
                    <div class="form__group">
                        <label for="yil">Yıl:</label>
                        <input type="month" id="yil" name="yil" required autocomplete="off" />
                    </div>

                    <div class="form__group">
                        <label for="pozisyon">Pozisyon:</label>
                        <input id="pozisyon" name="pozisyon" required autocomplete="off"/>
                    </div>

                    <button type="submit" name="submit" class="button" id="update-button">Ekle</button>
                </form>
            </div>

            <!-- Deneyim listesi -->
            <h2>Deneyim Tablosu</h2>
            <div class="admin-panel__table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kurum</th>
                            <th>Zaman</th>
                            <th>Pozisyon</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="deneyim-listesi">
                        <!-- PHP ile tablo satırları oluşturma -->
                        <?php
                        $sec = "SELECT id, kurum_adi, yil, pozisyon FROM deneyim";
                        $sonuc = $baglan->query($sec);

                        if ($sonuc->num_rows > 0) {
                            while ($cek = $sonuc->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $cek['kurum_adi'] . "</td>";
                                echo "<td>" . $cek['yil'] . "</td>";
                                echo "<td>" . $cek['pozisyon'] . "</td>";
                                echo "<td>
                                        <a href='deneyim.php?edit=" . $cek['id'] . "' class='edit' >Düzenle</a> |
                                        <a href='deneyim.php?delete=" . $cek['id'] . "' class='delete' >Sil</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Deneyim bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
            // Düzenleme formu
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $sql = "SELECT * FROM deneyim WHERE id=$id";
                $result = $baglan->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="admin-panel__form">
                        <form id="editForm" action="deneyim.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <div class="form__group">
                                <label for="kurum_adi">Kurum Adı:</label>
                                <input type="text" id="kurum_adi" name="kurum_adi" value="<?php echo $row['kurum_adi']; ?>" required autocomplete="off" />
                            </div>
                            
                            <div class="form__group">
                                <label for="yil">Yıl:</label>
                                <input type="month" id="yil" name="yil" value="<?php echo $row['yil']; ?>" required autocomplete="off" />
                            </div>

                            <div class="form__group">
                                <label for="pozisyon">Pozisyon:</label>
                                <input id="pozisyon" name="pozisyon" value="<?php echo $row['pozisyon']; ?>" required autocomplete="off" />
                            </div>

                            <button type="submit" name="update" class="button">Güncelle</button>
                        </form>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</body>
</html>
