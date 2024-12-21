<?php
// Oturumu başlat
global $db;
session_start();

// Veritabanı ayarları
include 'ayar.php';
include 'ukas.php';
include 'func.php';

$q = @$_GET["q"];

$data = $db->prepare("SELECT * FROM kategoriler WHERE k_kategori_link=?");
$data->execute([$q]);
$_data = $data->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Kategorisi</title>
    <link rel="stylesheet" href="style3.css"> <!-- Stil dosyasını ekleyin -->
</head>
<body>
<header><?php include 'header.php'; //üst bilgi ?></header>
<div class="container">
    <div class="category-header">
        <h2><?php echo $_data["k_kategori"]; ?></h2>
        <a href="Konuac.php?kategori=<?=$_data["k_kategori_link"]?>"><button>Konu Aç</button></a>
    </div>
    <div class="forum-list">
        <?php
        $dataList = $db->prepare("SELECT * FROM konular WHERE konu_kategori_link=? ORDER BY konu_id DESC");
        $dataList->execute([$q]);
        $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);

        foreach($dataList as $row) {
            echo '<div class="forum-item">
                    <div class="forum-info">
                        <a href="Konuac.php?link='.$row["konu_link"].'">'.$row["konu_ad"].'</a>
                        <p>'.$row["konu_mesaj"].'</p>
                    </div>
                    <div class="forum-meta">
                        <span>Konu Sahibi: <a href="profil.php?kadi='.uye_ID_den_kadi($row["konu_uye_id"]).'">'.uye_ID_den_isme($row["konu_uye_id"]).'</a></span>
                        <span>'.$row["konu_tarih"].'</span>
                    </div>
                </div>';
        }
        ?>
    </div>
</div>
<footer>
    <p>&copy; 2024 Forum Teması. Tüm hakları saklıdır.</p>
</footer>
</body>
</html>
