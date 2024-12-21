<?php
    ob_start();
    session_start();
    include 'ayar.php';
    include 'ukas.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forum Kategorisi</title>
        <link rel="stylesheet" href="style2.css"> <!-- Stil dosyasını ekleyin -->
    </head>
    <header>
        <?php include 'header.php'; //üst bilgi ?>
    </header>
    <body>
        <div class="container">
            <div class="content">
                <?php
                    $p=@$_GET["p"];
                    
                switch ($p){
                    case 'cikis':
                        if (@$_SESSION["uye_id"]){
                            ukas_cikis("Anasayfa.php");
                        }
                        else{
                            header("LOCATION:Anasayfa.php");
                        }
                        break;
                    case 'kayit':
                        if (@$_SESSION["uye_id"]){
                            header("LOCATION:Anasayfa.php");
                        }
                        else{
                            echo '<h1 style="font-size:30px;" class="text-center"><strong>Şimdi Kayıt Ol!</strong></h1>
                            <form action="" method="POST">
                                <center><strong style="margin-right:8px; color:#76b900; font-size: 18px;">Ad Soyad:</strong>
                                <input type="text" class="form-control" name="adsoyad"></center><br>
                                <strong style="margin-right:8px; margin-left:766px; font-size: 18px; color:#76b900;">Kullanıcı Adı:</strong>
                                <input type="text" class="form-control" name="kadi"><br><br>  
                                <strong style="margin-right:8px; margin-left: 835px; font-size: 18px; color:#76b900;">Şifre:</strong>
                                <input type="password" class="form-control" name="sifre"><br><br>
                                <strong style="margin-right: 8px; margin-left:764px; font-size: 18px; color:#76b900">Şifre (Tekrar):</strong>
                                <input type="password" class="form-control" name="sifret"><br><br>
                                <strong style="margin-right: 8px; margin-left: 808px; font-size: 18px; color:#76b900">E-Posta:</strong>
                                <input type="text" class="form-control" name="eposta"><br/><br>
                                <center><input style="padding:5px 20px; margin-bottom:10px;  font-weight:bold; font-size:15px; background-color:#76b900; border-color: #76b900; color: white;" type="submit" class="btn btn-block btn-danger" name="kayit" value="Kayıt Ol"></center>
                                
                                <center><a href="uyelik.php?p=giris" style=";font-size:18px;" class="btn btn-block btn-success"><strong><em>Şimdi giriş yap!</em></strong></a></center>
                                
                                <div style="margin-top:10px;"><center><a href="Anasayfa.php" style="  font-size: 18px;" class="text-dark"><strong><em>Anasayfaya dön</em></strong></a></center></div></form>';
                            
                            ukas_kayit("<center style='color:red; font-weight:bold;'><p class='text-warning'>Lütfen boş bırakmayınız!</p></center>",
                                "<center style='color:red; font-weight:bold;'><p class='text-danger'>Böyle bir e-posta mevcut! Lütfen başka bir tane deneyiniz!</p></center>",
                                "<center style='color:red; font-weight:bold;'><p class='text-warning'>Böyle bir kullanıcı adı mevcut! Lütfen başka bir tane deneyiniz!</p></center>",
                                "<center style='color:red; font-weight:bold;'><p class='text-success'>Başarıyla kaydoldun!</p></center>", "Anasayfa.php",
                                "<center style='color:red; font-weight:bold;'><p class='text-danger'>Kullanıcı adı veya şifre hatalı!</p></center>",
                                "<center style='color:red; font-weight:bold;'><p class='text-danger'>Kayıt başarısız!</p></center>",
                                "<center style='color:red; font-weight:bold;'><p>Şifreniz birbiriyle eşleşmiyor!</p></center>",
                                "<center style='color:red; font-weight:bold;'><p>Lütfen gerçek bir e-posta adresi giriniz!</p></center>");
                            
                        }
                        break;
                    default:
                        if (@$_SESSION["uye_id"]){
                            header("LOCATION:Anasayfa.php");
                        }else{
                            

                            echo '<h1 class="text-center"><strong>Giriş Yap</strong></h1>
                            <br/><form action="" method="POST">
                                <center><strong style="font-size:18px; margin-right:8px; color:#76b900">Kullanıcı Adı:</strong>
                                <input type="text" class="form-control" name="kadi"></center><br/>
                                <strong style="font-size:18px; margin-left: 847px; margin-right: 8px; color:#76b900">Şifre:</strong>
                                <input type="password" class="form-control" name="sifre"><br/><br>
                                <center><input style="margin-bottom:13px; margin-left:170px; font-weight:bold; font-size:15px; padding: 5px 16px; background-color: #76b900; border-color:#76b900; color:white;" type="submit" class="btn btn-block btn-success" name="giris" value="Giriş Yap"></center>
                                
                                <center><a href="uyelik.php?p=kayit" style="margin-left:155px;font-size:18px; margin-bottom:5px; display:block; " class="btn btn-block btn-success"><strong><em>Şimdi kayıt ol!</em></strong></a></center>
                                <center style="margin-left:136px;font-size:18px;"><a href="Anasayfa.php" class="text-dark"><strong><em>Anasayfaya Dön</em></strong></a></center></form>';
                            ukas_giris("Anasayfa.php","<center style='margin-left: 100px; font-weight:bold; color:red'><p class='text-warning'>Lütfen boş bırakmayınız!
                            </p></center>","<center style='margin-left: 70px; font-weight:bold; color:red'><p class='text-danger'>Kullanıcı adı veya şifre hatalı!</p></center>");
                        }
                    break;
                }
                ?>
            </div>
        </div>
        <footer>
            <p>&copy; 2024 Forum Teması. Tüm hakları saklıdır.</p>
        </footer>
    </body>
</html>