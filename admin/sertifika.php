<?php
include("../baglanti.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['sertifika_adi']) && isset($_FILES['fotograf'])) {
        $sertifika_adi = mysqli_real_escape_string($baglan, $_POST['sertifika_adi']);
        
        // Dosya yükleme işlemi
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fotograf"]["name"]);

        // Klasörün mevcut olup olmadığını kontrol edin
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Dosya taşınması işlemi
        if (move_uploaded_file($_FILES["fotograf"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO sertifika (sertifika_adi, fotograf) VALUES ('$sertifika_adi', '$target_file')";
            
            // SQL komutunu ekrana yazdırın (debug amaçlı)
            // echo $sql;

            if ($baglan->query($sql) === TRUE) {
                echo "Yeni sertifika başarıyla eklendi.";
            } else {
                echo "Hata: " . $sql . "<br>" . $baglan->error;
            }
        } else {
            echo "Dosya yüklenirken bir hata oluştu.";
        }
    } else {
        echo "Lütfen tüm alanları doldurun.";
    }
}

// Veri silme işlemi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Silme işlemine onay vermek için JavaScript ile bir onay kutusu göster
    echo '<script>';
    echo 'if(confirm("Bu kaydı silmek istediğinize emin misiniz?")){';
    echo 'window.location.href = "sertifika.php?confirmedDelete='.$id.'";';
    echo '}';
    echo '</script>';
}

// Silme işlemi onaylandıktan sonra gerçekleştirilecek işlem
if (isset($_GET['confirmedDelete'])) {
    $id = $_GET['confirmedDelete'];
    $sql = "DELETE FROM proje WHERE id=$id";
    if ($baglan->query($sql) === TRUE) {
        header("Location: sertifika.php");
    } else {
        echo "Hata: " . $baglan->error;
    }
}

// Veri düzenleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $sertifika_adi = mysqli_real_escape_string($baglan, $_POST['sertifika_adi']);
    $sql = "UPDATE sertifika SET sertifika_adi='$sertifika_adi'";

    $sql .= " WHERE id=$id";
    if ($baglan->query($sql) === TRUE) {
        header("Location: sertifika.php");
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
            <h2 class="admin-panel__title">Sertifika Yönetimi</h2>

            <!-- Yeni sertifika ekleme formu -->
            <div class="admin-panel__form">
                <form id="myForm" action="sertifika.php" method="post" enctype="multipart/form-data">
                    <div class="form__group">
                        <label for="sertifika_adi">Sertifika Adı:</label>
                        <input type="text" id="sertifika_adi" name="sertifika_adi" required autocomplete="off" />
                    </div>
                    
                    <div class="form__group">
                        <label for="sertifika_resmi">Sertifika Resmi:</label>
                        <input type="file" id="sertifika_resmi" name="fotograf" accept="image/*" required autocomplete="off" style="color: white;" />
                    </div>

                    <button type="submit" class="button" id="update-button">Ekle</button>
                </form>
            </div>

            <!-- Sertifika listesi -->
            <h2>Sertifika Tablosu</h2>
            <div class="admin-panel__table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sertifika Adı</th>
                            <th>Sertifika Resmi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="sertifika-listesi">
                        <!-- PHP ile tablo satırları oluşturma -->
                        <?php
                        $sec = "SELECT * FROM sertifika";
                        $sonuc = $baglan->query($sec);

                        if ($sonuc->num_rows > 0) {
                            while ($cek = $sonuc->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $cek['id'] . "</td>";
                                echo "<td>" . $cek['sertifika_adi'] . "</td>";
                                echo "<td><img src='" . $cek['fotograf'] . "' alt='Sertifika Resmi' width='50'></td>";
                                echo "<td>
                                        <a href='sertifika.php?edit=" . $cek['id'] . "' class='edit' >Düzenle</a> |
                                        <a href='sertifika.php?delete=" . $cek['id'] . "' class='delete' >Sil</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Sertifika bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
            // Düzenleme formu
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $sql = "SELECT * FROM sertifika WHERE id=$id";
                $result = $baglan->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="admin-panel__form">
                        <form action="sertifika.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                            <div class="form__group">
                                <label for="sertifika_adi">Sertifika Adı:</label>
                                <input type="text" id="sertifika_adi" name="sertifika_adi" value="<?php echo $row['sertifika_adi']; ?>" required autocomplete="off" />
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
