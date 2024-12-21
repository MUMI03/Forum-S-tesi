<?php

//Oturumu başlat
global $db;
session_start();

//Veri tabanı ayarları
include 'ayar.php';

//Ukas php
include 'ukas.php';

//Fonksiyonlar
include 'func.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Card Center</title>
    <link rel="stylesheet" href="style.css"> <!-- Stil dosyasını ekleyin -->
</head>
<body>
<header>
    <?php include 'header.php'; //üst bilgi ?>
</header>
<div class="container">
    <div class="sidebar">
        <h2>Kategoriler</h2>
        <ul>
            <?php
            $dataList = $db->prepare("SELECT * FROM kategoriler LIMIT 10");
            $dataList->execute();
            $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);
            foreach($dataList as $row){
                echo '<li><a href="Kategori.php?q=' . $row["k_kategori_link"] . '">' . $row["k_kategori"] . '</a></li>';
            }
            ?>
        </ul>
    </div>
    <div class="content">
        <div class="new-topics">
            <strong>Yeni Açılan Konular:</strong>
            <hr>
            <ul>
                <?php
                $dataList = $db->prepare("SELECT * FROM konular ORDER BY konu_id DESC LIMIT 10");
                $dataList->execute();
                $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);
                foreach($dataList as $row){
                    echo '<li><a href="Konular.php?link=' . $row["konu_link"] . '">' . $row["konu_ad"] . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="recent-replies">
            <strong>Son Cevaplananlar:</strong>
            <hr>
            <ul>
                <?php
                $dataList = $db->prepare("SELECT * FROM yorumlar ORDER BY y_id DESC LIMIT 50");
                $dataList->execute();
                $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);
                $konu_idler = [];
                foreach($dataList as $row){
                    array_push($konu_idler, $row["y_konu_id"]);
                }
                $konu_idler = array_unique($konu_idler);
                foreach ($konu_idler as $konuid){
                    $konu_cek = $db->prepare("SELECT * FROM konular WHERE konu_id=?");
                    $konu_cek->execute([$konuid]);
                    $_konu_cek = $konu_cek->fetch(PDO::FETCH_ASSOC);
                    echo '<li><a href="Konular.php?link=' . $_konu_cek["konu_link"] . '">' . $_konu_cek["konu_ad"] . '</a></li>';
                    if ($i == 10){
                        break;
                    }
                    @$i++;
                }
                ?>
            </ul>
        </div>
    </div>
</div>
<footer>
    <p>&copy; 2024 Forum Teması. Tüm hakları saklıdır.</p>
</footer>
</body>
</html>
