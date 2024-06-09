<?php
include("../baglanti.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['proje_adi'], $_POST['proje_turu'], $_POST['proje_aciklama']) && isset($_FILES['proje_resmi'])) {
        $proje_adi = $_POST['proje_adi'];
        $proje_turu = $_POST['proje_turu'];
        $proje_aciklama = $_POST['proje_aciklama'];

        // Dosya yükleme işlemi
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["proje_resmi"]["name"]);

        // Klasörün mevcut olup olmadığını kontrol edin
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Dosya taşınması işlemi
        if (move_uploaded_file($_FILES["proje_resmi"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO proje (proje_adi, proje_turu, proje_aciklama, fotograf) VALUES ('$proje_adi', '$proje_turu', '$proje_aciklama', '$target_file')";
            
            if ($baglan->query($sql) === TRUE) {
                header("Location: projelerim.php");
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
    echo 'window.location.href = "projelerim.php?confirmedDelete='.$id.'";';
    echo '}';
    echo '</script>';
}

// Silme işlemi onaylandıktan sonra gerçekleştirilecek işlem
if (isset($_GET['confirmedDelete'])) {
    $id = $_GET['confirmedDelete'];
    $sql = "DELETE FROM proje WHERE id=$id";
    if ($baglan->query($sql) === TRUE) {
        header("Location: projelerim.php");
    } else {
        echo "Hata: " . $baglan->error;
    }
}

// Veri düzenleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $proje_adi = $_POST['proje_adi'];
    $proje_turu = $_POST['proje_turu'];
    $proje_aciklama = $_POST['proje_aciklama'];

    $sql = "UPDATE proje SET proje_adi='$proje_adi', proje_turu='$proje_turu', proje_aciklama='$proje_aciklama' WHERE id=$id";


    if ($baglan->query($sql) === TRUE) {
        header("Location: projelerim.php");
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
            <h2 class="admin-panel__title">Portföy Yönetimi</h2>

            <!-- Yeni proje ekleme formu -->
            <div class="admin-panel__form">
                <form id="myForm" action="projelerim.php" method="post" enctype="multipart/form-data">
                    <div class="form__group">
                        <label for="proje_adi">Proje Adı:</label>
                        <input type="text" id="proje_adi" name="proje_adi" required autocomplete="off" />
                    </div>

                    <div class="form__group">
                        <label for="proje-turu">Proje Tipi:</label>
                        <select id="proje-turu" name="proje_turu" required autocomplete="off">
                            <option value="Web">Web</option>
                            <option value="Mobil">Mobil</option>
                        </select>
                    </div>

                    <div class="form__group">
                        <label for="proje_aciklama">Proje Açıklaması:</label>
                        <textarea id="proje_aciklama" name="proje_aciklama" required autocomplete="off"></textarea>
                    </div>

                    <div class="form__group">
                        <label for="proje_resmi">Proje Resmi:</label>
                        <input type="file" id="proje_resmi" name="proje_resmi" accept="image/*" autocomplete="off" style="color: white;" />
                    </div>

                    <button type="submit" class="button" id="update-button">Ekle</button>
                </form>
            </div>

            <!-- Proje listesi -->
            <h2>Proje Tablosu</h2>
            <div class="admin-panel__table">
                <table class="table">
                    <thead>
                        <tr>
                            
                            <th>Proje Adı</th>
                            <th>Proje Tipi</th>
                            <th>Proje Açıklaması</th>
                            <th>Proje Resmi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="proje-listesi">
                        <!-- PHP ile tablo satırları oluşturma -->
                        <?php
                        $sec = "SELECT * FROM proje";
                        $sonuc = $baglan->query($sec);

                        if ($sonuc->num_rows > 0) {
                            while ($cek = $sonuc->fetch_assoc()) {
                                echo "<tr>";
                                
                                echo "<td>" . $cek['proje_adi'] . "</td>";
                                echo "<td>" . $cek['proje_turu'] . "</td>";
                                echo "<td>" . $cek['proje_aciklama'] . "</td>";
                                echo "<td><img src='" . $cek['fotograf'] . "' alt='Proje Resmi' width='50'></td>";
                                echo "<td>
                                        <a href='projelerim.php?edit=" . $cek['id'] . "' class='edit' >Düzenle</a> |
                                        <a href='projelerim.php?delete=" . $cek['id'] . "' class='delete' >Sil</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Proje bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
            // Düzenleme formu
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $sql = "SELECT * FROM proje WHERE id=$id";
                $result = $baglan->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="admin-panel__form">
                        <form action="projelerim.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                            <div class="form__group">
                                <label for="proje_adi">Proje Adı:</label>
                                <input type="text" id="proje_adi" name="proje_adi" value="<?php echo $row['proje_adi']; ?>" required autocomplete="off" />
                            </div>

                            <div class="form__group">
                                <label for="proje_turu">Proje Tipi:</label>
                                <select id="proje_turu" name="proje_turu" required autocomplete="off">
                                    <option value="Web" <?php if ($row['proje_turu'] == 'Web') echo 'selected'; ?>>Web</option>
                                    <option value="Mobil" <?php if ($row['proje_turu'] == 'Mobil') echo 'selected'; ?>>Mobil</option>
                                </select>
                            </div>

                            <div class="form__group">
                                <label for="proje_aciklama">Proje Açıklaması:</label>
                                <textarea id="proje_aciklama" name="proje_aciklama" required autocomplete="off"><?php echo $row['proje_aciklama']; ?></textarea>
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
