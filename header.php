<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Açılır Menü - Simgeyle</title>
    <style>
        /* Genel sayfa stili */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Menü kapsayıcısını sağa hizala */
        .dropdown {
            position: absolute;
            top: 40px; /* Yukarıdan boşluk */
            right: 80px; /* Sağdan 10 piksel boşluk */
        }

        /* Açılır menü içeriği */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #333;
            color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            right: 0; /* Menü içeriğini sağa hizala */
            top: 100%; /* Menü butonunun hemen altına yerleştir */
        }

        /* Menü bağlantıları */
        .dropdown-content a {
            color: cyan;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #444;
        }

        /* Hover yapıldığında menüyü göster */
        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Menü butonu stili */
        .menu-button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
        }

        /* Simge boyutu */
        .menu-button img {
            width: 60px;
            height: 60px;
        }

        /* Başlık stil */
        h1 {
            text-align: center;
            color: #76b900;
        }

        /* Linkin üzerine gelindiğinde stil */
        a {
            text-decoration: none;
            color: #76b900;
        }

        a:hover {
            color: #4CAF50;
        }
    </style>
</head>
<body>

    <!-- Ana sayfa bağlantısı -->
    <a href="Anasayfa.php" style="text-decoration: none; color: #76b900; display: block;">
        <center><h1>Display Card Center</h1></center>
    </a>

    <!-- Dropdown menü kısmı -->
    <div class="dropdown">
        <!-- Menü simgesi -->
        <button class="menu-button">
            <img src="simge.png" alt="Profil Simgesi">
        </button>
        <div class="dropdown-content">
            <?php if (@$_SESSION['uye_id']) { ?>
                <a href="profil.php?kadi=<?php echo @$_SESSION['uye_kadi']; ?>">Profilime Git</a>
                <a href="uyelik.php?p=cikis">Çıkış Yap</a>
            <?php } else { ?>
                <a href="uyelik.php?p=kayit">Üye Ol</a>
                <a href="uyelik.php">Giriş Yap</a>
            <?php } ?>
        </div>
    </div>

</body>
</html>
