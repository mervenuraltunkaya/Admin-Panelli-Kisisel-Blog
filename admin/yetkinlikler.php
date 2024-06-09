<?php
include("../baglanti.php");

// Veri ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
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

// Veri silme işlemi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Silme işlemine onay vermek için JavaScript ile bir onay kutusu göster
    echo '<script>';
    echo 'if(confirm("Bu kaydı silmek istediğinize emin misiniz?")){';
    echo 'window.location.href = "yetkinlikler.php?confirmedDelete='.$id.'";';
    echo '}';
    echo '</script>';
}

// Silme işlemi onaylandıktan sonra gerçekleştirilecek işlem
if (isset($_GET['confirmedDelete'])) {
    $id = $_GET['confirmedDelete'];
    $sql = "DELETE FROM yetkinlik WHERE id=$id";
    if ($baglan->query($sql) === TRUE) {
        header("Location: yetkinlikler.php");
    } else {
        echo "Hata: " . $baglan->error;
    }
}

// Veri düzenleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $yetkinlik_adi = $_POST['yetkinlik_adi'];
    $yuzde = $_POST['yuzde'];
    $kategori = $_POST['kategori'];

    $sql = "UPDATE yetkinlik SET yetkinlik_adi='$yetkinlik_adi', yuzde='$yuzde', kategori='$kategori' WHERE id=$id";

    if ($baglan->query($sql) === TRUE) {
        header("Location: yetkinlikler.php");
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
                    <input type="hidden" name="add" value="true">
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

            <!-- Yetkinlik listesi -->
            <h2>Yetkinlik Tablosu</h2>
            <div class="admin-panel__table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Yetkinlik Adı</th>
                            <th>Yetkinlik Yüzdesi</th>
                            <th>Yetkinlik Kategorisi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="yetkinlik-listesi">
                        <!-- PHP ile tablo satırları oluşturma -->
                        <?php
                        $sec = "SELECT id, yetkinlik_adi, yuzde, kategori FROM yetkinlik";
                        $sonuc = $baglan->query($sec);

                        if ($sonuc->num_rows > 0) {
                            while ($cek = $sonuc->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $cek['yetkinlik_adi'] . "</td>";
                                echo "<td>" . $cek['yuzde'] . "</td>";
                                echo "<td>" . $cek['kategori'] . "</td>";
                                echo "<td>
                                        <a href='yetkinlikler.php?edit=" . $cek['id'] . "' class='edit' >Düzenle</a> |
                                        <a href='yetkinlikler.php?delete=" . $cek['id'] . "' class='delete' >Sil</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Yetkinlik bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
            // Düzenleme formu
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $sql = "SELECT * FROM yetkinlik WHERE id=$id";
                $result = $baglan->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="admin-panel__form">
                        <form action="yetkinlikler.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                            <div class="form__group">
                                <label for="yetkinlik_adi">Yetkinlik Adı:</label>
                                <input type="text" id="yetkinlik_adi" name="yetkinlik_adi" value="<?php echo $row['yetkinlik_adi']; ?>" required autocomplete="off" />
                            </div>
                            
                            <div class="form__group">
                                <label for="yuzde">Yetkinlik Yüzdesi:</label>
                                <input type="number" max="100" min="0"  id="yuzde" name="yuzde" value="<?php echo $row['yuzde']; ?>" required autocomplete="off"  />
                            </div>

                            <div class="form__group">
                                <label for="kategori">Yetkinlik Kategorisi:</label>
                                <select id="kategori" name="kategori" required autocomplete="off">
                                    <option value="Frontend" <?php if ($row['kategori'] == 'Frontend') echo 'selected'; ?>>Frontend</option>
                                    <option value="Backend" <?php if ($row['kategori'] == 'Backend') echo 'selected'; ?>>Backend</option>
                                    <option value="Mobil" <?php if ($row['kategori'] == 'Mobil') echo 'selected'; ?>>Mobil</option>
                                </select>
                            </div>

                            <button type="submit" class="button" name="update" id="update-button">Güncelle</button>
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
