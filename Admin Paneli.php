<?php
global $db;
session_start();

include 'ayar.php';

include 'ukas.php';

include 'func.php';

if (@$_SESSION["uye_onay"] != 1){
    echo '<center><h1>Sadece Yöneticiler Görebilir</h1></center>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <?php include 'header.php';?>
</header>
<center>
    <br><br>
    <h2>Admin Paneli</h2>
    <hr>
    <h3>Kategori Ekle</h3>
    <?php
    if ($_POST && !isset($_GET['duzenle_id'])){
        $kategori = $_POST['kategori'];
        $kategoriLink = permalink($kategori);

        $dataAdd = $db->prepare("INSERT INTO kategoriler SET
            k_kategori=?,
            k_kategori_link=?");

        $dataAdd->execute([
            $kategori,
            $kategoriLink,
        ]);

        if ($dataAdd) {
            echo '<p class="alert alert-success">Kategori başarıyla eklendi</p>';
            header("refresh:1;url=Admin Paneli.php");
        } else {
            echo '<p class="alert alert-danger">Hay aksi bir sorunla karşılaştık, lütfen tekrar deneyiniz.</p>';
            header("refresh:1;url=Admin Paneli.php");
        }
    }
    ?>
    <form action="" method="post">
        <strong>Kategori:</strong>
        <input type="text" name="kategori" required>
        <br><br>
        <input type="submit" value="Kategori Oluştur">
    </form>

    <hr>
    <?php
    if (isset($_GET['duzenle_id'])) {
        $duzenle_id = $_GET['duzenle_id'];
        $kategoriQuery = $db->prepare("SELECT * FROM kategoriler WHERE k_id = ?");
        $kategoriQuery->execute([$duzenle_id]);
        $kategoriData = $kategoriQuery->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <?php if (isset($_GET['duzenle_id'])): ?>
    <h3>Kategori Düzenle</h3>
    <form action="" method="post">
        <strong>Kategori:</strong>
        <input type="text" name="kategori" value="<?= isset($kategoriData) ? $kategoriData['k_kategori'] : '' ?>" required>
        <br><br>
        <input type="submit" value="Kategori Güncelle">
    </form>
    <?php
    if ($_POST && isset($_GET['duzenle_id'])) {
        $kategori = $_POST['kategori'];
        $kategoriLink = permalink($kategori);

        $update = $db->prepare("UPDATE kategoriler SET k_kategori = ?, k_kategori_link = ? WHERE k_id = ?");
        $update->execute([$kategori, $kategoriLink, $duzenle_id]);

        if ($update) {
            echo '<p class="alert alert-success">Kategori başarıyla güncellendi.</p>';
            header("refresh:1;url=Admin Paneli.php");
        } else {
            echo '<p class="alert alert-danger">Güncelleme sırasında bir hata oluştu.</p>';
        }
    }
    ?>
    <?php endif; ?>

    <hr>
    <ol>
        <?php
        $dataList = $db->prepare("SELECT * FROM kategoriler");
        $dataList->execute();
        $dataList = $dataList->fetchAll(PDO::FETCH_ASSOC);
        foreach($dataList as $row){
            echo '<li>';
            echo '<a href="kategori.php?q='.$row["k_kategori_link"].'">'.$row["k_kategori"].'</a>';
            echo ' <a href="?duzenle_id='.$row['k_id'].'">Düzenle</a>';
            echo ' <a href="?sil_id='.$row['k_id'].'" onclick="return confirm(\'Bu kategoriyi silmek istediğinizden emin misiniz?\');">Sil</a>';
            echo '</li>';
        }
        ?>
    </ol>
</center>
<footer>
    <p>&copy; 2024 Forum Teması. Tüm hakları saklıdır.</p>
</footer>
</body>
</html>
