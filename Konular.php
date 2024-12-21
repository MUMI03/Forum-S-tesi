<?php
ob_start();
session_start();

// Veritabanı ayarları
include 'ayar.php';
include 'ukas.php';
include 'func.php';

// Konu linki buraya gelecek
$link = @$_GET["link"];

// Yorum silme işlemi
if (isset($_GET['delete']) && isset($_SESSION["uye_id"])) {
    $yorum_id = intval($_GET['delete']);

    // Yorum sahibini kontrol et
    $kontrol = $db->prepare("SELECT * FROM yorumlar WHERE y_id=? AND y_uye_id=?");
    $kontrol->execute([$yorum_id, $_SESSION["uye_id"]]);
    if ($kontrol->rowCount() > 0) {
        $sil = $db->prepare("DELETE FROM yorumlar WHERE y_id=?");
        $sil->execute([$yorum_id]);
        header("Location: Konular.php?link=$link"); // Yorum silindikten sonra yönlendirme
        exit();
    } else {
        echo '<p class="alert alert-danger">Bu yorumu silmeye yetkiniz yok.</p>';
    }
}

// Konu verilerini getir
$data = $db->prepare("SELECT * FROM konular WHERE konu_link=?");
$data->execute([$link]);
$_data = $data->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Konuları</title>
    <link rel="stylesheet" href="style.css"> <!-- Stil dosyasını ekleyin -->
</head>
<body>
<header>
<?php include 'header.php'; //üst bilgi ?>
</header>
<div class="container">
    <div class="content">
        <div class="topic-header">
            <h2><?=$_data["konu_ad"]?></h2>
            <strong>Konu Sahibi:</strong>
            <a href="profil.php?kadi=<?=uye_ID_den_kadi($_data["konu_uye_id"])?>">
                <?=uye_ID_den_isme($_data["konu_uye_id"])?>
            </a>
            <p><?=$_data["konu_mesaj"]?></p>
            <small><?=$_data["konu_tarih"]?></small>
        </div>
        <hr>
        <div class="comments">
            <h3>Yorumlar:</h3>
            <?php
            $dataList = $db->prepare("SELECT * FROM yorumlar WHERE y_konu_id=?");
            $dataList->execute([$_data["konu_id"]]);
            $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);

            foreach ($dataList as $row) {
                echo '
                    <div class="comment">
                        <a href="profil.php?kadi='.uye_ID_den_kadi($row["y_uye_id"]).'">
                            <strong id="yorum'.$row["y_id"].'">'.uye_ID_den_isme($row["y_uye_id"]).'</strong>
                        </a><br>
                        <p>'.$row["y_yorum"].'</p>
                        <small><b>Tarih:</b> '.$row["y_tarih"].'</small>';
                
                // Kullanıcı kendi yorumunu silebilir
                if (isset($_SESSION["uye_id"]) && $_SESSION["uye_id"] == $row["y_uye_id"]) {
                    echo '<form method="get" action="" style="display:inline;">
                            <input type="hidden" name="link" value="'.$link.'">
                            <input type="hidden" name="delete" value="'.$row["y_id"].'">
                            <button type="submit" style="color:red;">Sil</button>
                          </form>';
                }

                echo '</div><hr>';
            }
            ?>
        </div>
        <?php
        if (@$_SESSION["uye_id"]) {
            if ($_POST) {
                $yorum = $_POST["yorum"];
                
                $dataAdd = $db->prepare("INSERT INTO yorumlar SET y_uye_id=?, y_konu_id=?, y_yorum=?");
                $dataAdd->execute([$_SESSION["uye_id"], $_data["konu_id"], $yorum]);

                if ($dataAdd) {
                    $yorumcek = $db->prepare("SELECT * FROM yorumlar WHERE y_uye_id=? AND y_konu_id=? ORDER BY y_id DESC");
                    $yorumcek->execute([$_SESSION["uye_id"], $_data["konu_id"]]);
                    $_yorumcek = $yorumcek->fetch(PDO::FETCH_ASSOC);
                    
                    header("Location: Konular.php?link=" . $link . "#yorum" . $_yorumcek["y_id"]);
                    exit();
                } else {
                    header("Location: Konular.php?link=" . $link . "#yorumyap");
                    exit();
                }
            }

            echo '<h4 id="yorumyap">Yorum Yap:</h4>
                <form action="" method="post">
                    <div style="display:block; margin-right:20px;"><textarea name="yorum" cols="30" rows="10"></textarea></div>
                    <br>
                    <input type="submit" value="Yorum Yap">
                </form>';
        } else {
            echo 'Yorum yapabilmek için <a href="uyelik.php">giriş yap</a>ın ya da <a href="uyelik.php?q=kayit">kayıt ol</a>un.';
        }
        ?>
    </div>
    <div class="sidebar">
        <div class="sidebar-section">
            <h3>Son Konular</h3>
            <ul>
                <?php
                $dataList = $db->prepare("SELECT * FROM konular ORDER BY konu_id DESC LIMIT 10");
                $dataList->execute();
                $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);
                foreach ($dataList as $row) {
                    echo '<li><a href="Konular.php?link='.$row["konu_link"].'">'.$row["konu_ad"].'</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="sidebar-section">
            <h3>Son Yorumlar</h3>
            <ul>
                <?php
                $dataList = $db->prepare("SELECT * FROM yorumlar ORDER BY y_id DESC LIMIT 50");
                $dataList->execute();
                $dataList = $dataList->fetchALL(PDO::FETCH_ASSOC);
                $konu_idler = [];
                foreach ($dataList as $row) {
                    array_push($konu_idler, $row["y_konu_id"]);
                }
                $konu_idler = array_unique($konu_idler);
                foreach ($konu_idler as $konuid) {
                    $konu_cek = $db->prepare("SELECT * FROM konular WHERE konu_id=?");
                    $konu_cek->execute([$konuid]);
                    $_konu_cek = $konu_cek->fetch(PDO::FETCH_ASSOC);
                    echo '<li><a href="Konular.php?link='.$_konu_cek["konu_link"].'">'.$_konu_cek["konu_ad"].'</a></li>';
                    if ($i == 10) {
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
