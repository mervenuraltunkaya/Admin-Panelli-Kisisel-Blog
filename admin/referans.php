<?php
include("../baglanti.php");

// Veri ekleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $adSoyad = $_POST['adSoyad'] ?? '';
    $gorev = $_POST['gorev'] ?? '';
    $gorus = $_POST['gorus'] ?? '';

    $sql = "INSERT INTO referans (adSoyad, gorev, gorus) VALUES ('$adSoyad', '$gorev', '$gorus')";

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
    echo 'window.location.href = "referans.php?confirmedDelete='.$id.'";';
    echo '}';
    echo '</script>';
}

// Silme işlemi onaylandıktan sonra gerçekleştirilecek işlem
if (isset($_GET['confirmedDelete'])) {
    $id = $_GET['confirmedDelete'];
    $sql = "DELETE FROM referans WHERE id=$id";
    if ($baglan->query($sql) === TRUE) {
        header("Location: referans.php");
    } else {
        echo "Hata: " . $baglan->error;
    }
}

// Veri düzenleme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'];
    $adSoyad = $_POST['adSoyad'];
    $gorev = $_POST['gorev'];
    $gorus = $_POST['gorus'];

    $sql = "UPDATE referans SET adSoyad='$adSoyad', gorev='$gorev', gorus='$gorus' WHERE id=$id";
    if ($baglan->query($sql) === TRUE) {
        header("Location: referans.php");
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
            <h2 class="admin-panel__title">Referans Yönetimi</h2>

            <!-- Yeni referans ekleme formu -->
            <div class="admin-panel__form">
                <form id="myForm" action="referans.php" method="post" enctype="multipart/form-data">
                    <div class="form__group">
                        <label for="adSoyad">Ad Soyad:</label>
                        <input type="text" id="adSoyad" name="adSoyad" required autocomplete="off" />
                    </div>
                    
                    <div class="form__group">
                        <label for="gorev">Görev:</label>
                        <input type="text" id="gorev" name="gorev" required autocomplete="off" />
                    </div>

                    <div class="form__group">
                        <label for="gorus">Görüş:</label>
                        <textarea id="gorus" name="gorus" required autocomplete="off"></textarea>
                    </div>

                    <button type="submit" class="button" name="add" id="add-button">Ekle</button>
                </form>
            </div>

            <!-- Referans listesi -->
            <h2>Referans Tablosu</h2>
            <div class="admin-panel__table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ad Soyad</th>
                            <th>Görev</th>
                            <th>Görüş</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody id="referans-listesi">
                        <!-- PHP ile tablo satırları oluşturma -->
                        <?php
                        $sec = "SELECT * FROM referans";
                        $sonuc = $baglan->query($sec);

                        if ($sonuc->num_rows > 0) {
                            while ($cek = $sonuc->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $cek['adSoyad'] . "</td>";
                                echo "<td>" . $cek['gorev'] . "</td>";
                                echo "<td>" . $cek['gorus'] . "</td>";
                                echo "<td>
                                        <a href='referans.php?edit=" . $cek['id'] . "' class='edit' >Düzenle</a> |
                                        <a href='referans.php?delete=" . $cek['id'] . "' class='delete' >Sil</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Referans bulunamadı.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php
            // Düzenleme formu
            if (isset($_GET['edit'])) {
                $id = $_GET['edit'];
                $sql = "SELECT * FROM referans WHERE id=$id";
                $result = $baglan->query($sql);
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <div class="admin-panel__form">
                        <form action="referans.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                            <div class="form__group">
                                <label for="adSoyad">Ad Soyad:</label>
                                <input type="text" id="adSoyad" name="adSoyad" value="<?php echo $row['adSoyad']; ?>" required autocomplete="off" />
                            </div>

                            <div class="form__group">
                                <label for="gorev">Görev:</label>
                                <input type="text" id="gorev" name="gorev" value="<?php echo $row['gorev']; ?>" required autocomplete="off" />
                            </div>

                            <div class="form__group">
                                <label for="gorus">Görüş:</label>
                                <textarea id="gorus" name="gorus" required autocomplete="off"><?php echo $row['gorus']; ?></textarea>
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
