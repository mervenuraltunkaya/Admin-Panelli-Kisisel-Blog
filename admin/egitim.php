<?php
include ("../baglanti.php");

// Veri ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $kurum_adi = $_POST['kurum_adi'] ?? '';
    $bas_tarih = $_POST['bas_tarih'] ?? '';
    $bit_tarih = $_POST['bit_tarih'] ?? '';

    $sql = "INSERT INTO egitim (kurum_adi, bas_tarih, bit_tarih) VALUES ('$kurum_adi', '$bas_tarih', '$bit_tarih')";

    if ($baglan->query($sql) === TRUE) {
        header("Location: egitim.php");
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
    echo 'window.location.href = "egitim.php?confirmedDelete='.$id.'";';
    echo '}';
    echo '</script>';
}

// Silme işlemi onaylandıktan sonra gerçekleştirilecek işlem
if (isset($_GET['confirmedDelete'])) {
    $id = $_GET['confirmedDelete'];
    $sql = "DELETE FROM egitim WHERE id=$id";
    if ($baglan->query($sql) === TRUE) {
        header("Location: egitim.php");
    } else {
        echo "Hata: " . $baglan->error;
    }
}


// Veri düzenleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $kurum_adi = $_POST['kurum_adi'] ?? '';
    $bas_tarih = $_POST['bas_tarih'] ?? '';
    $bit_tarih = $_POST['bit_tarih'] ?? '';

    $sql = "UPDATE egitim SET kurum_adi='$kurum_adi', bas_tarih='$bas_tarih', bit_tarih='$bit_tarih' WHERE id=$id";

    if ($baglan->query($sql) === TRUE) {
        header("Location: egitim.php");
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
            </ul>
        </div>
        <div class="main-content">
            <h2 class="admin-panel__title">Eğitim Yönetimi</h2>

            <!-- Yeni eğitim ekleme formu -->
            <div class="admin-panel__form">
                <form id="myForm" action="egitim.php" method="post">
                    <div class="form__group">
                        <label for="kurum_adi">Kurum:</label>
                        <input type="text" id="kurum_adi" name="kurum_adi" required autocomplete="off" />
                    </div>
                    
                    <div class="form__group">
                        <label for="bas_tarih">Başlangıç Yılı:</label>
                        <input type="number" min="1900" max="2100" id="bas_tarih" name="bas_tarih" required autocomplete="off" />
                    </div>

                    <div class="form__group">
                        <label for="bit_tarih">Bitiş Yılı:</label>
                        <input type="number" min="1900" max="2100" id="bit_tarih" name="bit_tarih" required autocomplete="off" />
                    </div>

                    <button type="submit" name="submit" class="button">Ekle</button>
                </form>
            </div>

            <!-- Eğitim listesi -->
            <h2>Eğitim Tablosu</h2>
            <div class="admin-panel__table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Kurum</th>
                            <th>Başlangıç Yılı</th>
                            <th>Bitiş Yılı</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="egitim-listesi">
                        <!-- PHP ile tablo satırları oluşturma -->
                        <?php
                        $sec = "SELECT id, kurum_adi, bas_tarih, bit_tarih FROM egitim";
                        $sonuc = $baglan->query($sec);

                        if ($sonuc->num_rows > 0) {
                            while ($cek = $sonuc->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $cek['kurum_adi'] . "</td>";
                                echo "<td>" . $cek['bas_tarih'] . "</td>";
                                echo "<td>" . $cek['bit_tarih'] . "</td>";
                                echo "<td>
                                        <a href='egitim.php?edit=" . $cek['id'] . "' class='edit' >Düzenle</a> |
                                        <a href='egitim.php?delete=" . $cek['id'] . "' class='delete' >Sil</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Eğitim bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
            // Düzenleme formu
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $sql = "SELECT * FROM egitim WHERE id=$id";
                $result = $baglan->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="admin-panel__form">
                        <form id="editForm" action="egitim.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <div class="form__group">
                                <label for="kurum_adi">Kurum:</label>
                                <input type="text" id="kurum_adi" name="kurum_adi" value="<?php echo $row['kurum_adi']; ?>" required autocomplete="off" />
                            </div>
                            
                            <div class="form__group">
                                <label for="bas_tarih">Başlangıç Yılı:</label>
                                <input type="number" min="1900" max="2100" id="bas_tarih" name="bas_tarih" value="<?php echo $row['bas_tarih']; ?>" required autocomplete="off" />
                            </div>

                            <div class="form__group">
                                <label for="bit_tarih">Bitiş Yılı:</label>
                                <input type="number" min="1900" max="2100" id="bit_tarih" name="bit_tarih" value="<?php echo $row['bit_tarih']; ?>" required autocomplete="off" />
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
