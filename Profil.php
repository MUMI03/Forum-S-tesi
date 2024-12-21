<?php
global $db;
session_start();
include 'ayar.php'; // Veri tabanı ayarları
include 'ukas.php'; // Kullanıcı kimlik doğrulama sistemi
include 'func.php'; // Ek fonksiyonlar

$kadi = @$_GET["kadi"];
$data = $db->prepare("SELECT * FROM uyeler WHERE uye_kadi=?");
$data->execute([$kadi]);
$_data = $data->fetch(PDO::FETCH_ASSOC);

if (!$_data) {
    echo '<center><h1>Kullanıcı bulunamadı.</h1></center>';
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - <?= $_data["uye_adsoyad"] ?></title>
    <link rel="stylesheet" href="style.css"> <!-- Tema stil dosyanızı buraya ekleyin -->
</head>
<header><center><?php include 'header.php'; ?></center></header>
<body>
<div class="container">
    <div class="content">
        
        <h2><?= $_data["uye_adsoyad"] ?></h2>
        <p><strong>E-posta:</strong> <?= $_data["uye_eposta"] ?></p>

        <?php if (@$_SESSION["uye_onay"] == 1) { // Yalnızca yönetici ise görünsün ?>
            <div class="admin-button">
                <a href="Admin Paneli.php" style="font-weight:bold; padding: 6px 8px; background-color: #ee2c2c; color: white; text-decoration: none; border-radius: 5px;">Admin Paneli</a> 
            </div>
        <?php } ?>
        <hr>
        <div class="profile-sections">
            <div class="section">
                <h3>Açtığı Konular</h3>
                <ul>
                    <?php
                    $dataList = $db->prepare("SELECT * FROM konular WHERE konu_uye_id=?");
                    $dataList->execute([$_data["uye_id"]]);
                    $konular = $dataList->fetchAll(PDO::FETCH_ASSOC);

                    if ($konular) {
                        foreach ($konular as $row) {
                            echo '<li><a href="konular.php?link=' . $row["konu_link"] . '">' . $row["konu_ad"] . '</a></li>';
                        }
                    } else {
                        echo '<li>Henüz konu oluşturulmamış.</li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="section">
                <h3>Yorumlar</h3>
                <ul>
                    <?php
                    $dataList = $db->prepare("SELECT * FROM yorumlar WHERE y_uye_id=? LIMIT 50");
                    $dataList->execute([$_data["uye_id"]]);
                    $yorumlar = $dataList->fetchAll(PDO::FETCH_ASSOC);

                    $konu_idler = [];
                    foreach ($yorumlar as $row) {
                        $konu_idler[] = $row["y_konu_id"];
                    }

                    $konu_idler = array_unique($konu_idler);

                    if ($konu_idler) {
                        $i = 0;
                        foreach ($konu_idler as $konuid) {
                            $konu_cek = $db->prepare("SELECT * FROM konular WHERE konu_id=?");
                            $konu_cek->execute([$konuid]);
                            $_konu_cek = $konu_cek->fetch(PDO::FETCH_ASSOC);

                            echo '<li><a href="konular.php?link=' . $_konu_cek["konu_link"] . '">' . $_konu_cek["konu_ad"] . '</a></li>';

                            if ($i == 10) {
                                break;
                            }
                            $i++;
                        }
                    } else {
                        echo '<li>Henüz yorum yapılmamış.</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>
</body>
</html>
