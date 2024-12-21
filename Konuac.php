<?php
global $db;
session_start();
include 'ayar.php'; // Veri tabanı ayarları
include 'ukas.php'; // Kullanıcı kimlik doğrulama sistemi
include 'func.php'; // Ek fonksiyonlar
?>

        
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konu Oluştur</title>
    <link rel="stylesheet" href="style2.css"> <!-- Tema stil dosyanızı buraya ekleyin -->
</head>
<header><center><?php include 'header.php'; ?></center></header>,
<footer>
    <p>&copy; 2024 Forum Teması. Tüm hakları saklıdır.</p>
</footer>
<body>
    <?php
    if (!@$_SESSION["uye_id"]){
    echo '<center><h1>Konu oluşturmak için <a href="uyelik.php">giriş yap</a>ın veya <a href="uyelik.php?q=kayit">kayıt ol</a>un.</h1></center>';
    exit;
    }
    $kategori = @$_GET["kategori"];
    ?>    
<div class="container">
    <div class="content">
        
        <h2 style="color:darkgreen;" >Konu Oluştur</h2>
        <?php
        if ($_POST){
            $ad     = $_POST["ad"];
            $mesaj  = $_POST["mesaj"];
            $link   = permalink($ad) . "-" . rand(000,999);

            $dataAdd = $db->prepare("INSERT INTO konular SET
                    konu_ad = ?,
                    konu_link = ?,
                    konu_mesaj = ?,
                    konu_uye_id = ?,
                    konu_kategori_link = ?
                ");
            $dataAdd->execute([
                $ad,
                $link,
                $mesaj,
                @$_SESSION["uye_id"],
                $kategori
            ]);

            if ($dataAdd) {
                echo '<p class="alert alert-success">Başarıyla konunuz oluşturuldu</p>';
                header("REFRESH:1;URL=Konular.php?link=" . $link);
            } else {
                echo '<p class="alert alert-danger">Hay aksi bir hata ile karşılaştık, lütfen tekrar deneyiniz</p>';
                header("REFRESH:1;URL=Konuac.php");
            }
        }
        ?>
        <strong style="color:darkgreen;" ><?= @kategori_linkten_kategori_ad($kategori) ?> Kategorisinde Konu Açmaktasınız</strong>
        <form style="color:darkgreen;"  action="" method="post">
            <div class="form-group">
                <label for="ad"><strong>Konu Başlığı:</strong></label>
                <input type="text" id="ad" name="ad" required>
            </div>
            <div class="form-group">
                <label for="mesaj"><strong>Konu Mesajı:</strong></label>
                <div style="display:block; margin-right:20px;"><textarea id="mesaj" name="mesaj" cols="30" rows="10" required></textarea></div>
            </div>
            <input style="padding:5px 20px; font-weight:bold; background-color:white; border-color:#a9a9a9; color:black; font-size:15px;" type="submit" value="Konuyu Aç">
        </form>
    </div>
</div>
</body>
</html>
