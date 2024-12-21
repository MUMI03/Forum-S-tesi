-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 26 Haz 2024, 12:50:13
-- Sunucu sürümü: 5.7.36
-- PHP Sürümü: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `displaycardcenter`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `k_id` int(11) NOT NULL,
  `k_kategori` varchar(200) COLLATE utf8_turkish_ci NOT NULL,
  `k_kategori_link` varchar(200) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`k_id`, `k_kategori`, `k_kategori_link`) VALUES
(1, 'RTX20 series', 'rtx20-series'),
(2, 'RTX30 series', 'rtx30-series'),
(3, 'RTX40 series', 'rtx40-series'),
(4, 'RTX 10 series', 'rtx-10-series');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `konular`
--

CREATE TABLE `konular` (
  `konu_id` int(11) NOT NULL,
  `konu_uye_id` int(11) NOT NULL,
  `konu_kategori_link` varchar(1000) COLLATE utf8_turkish_ci NOT NULL,
  `konu_ad` varchar(1000) COLLATE utf8_turkish_ci NOT NULL,
  `konu_link` varchar(1000) COLLATE utf8_turkish_ci NOT NULL,
  `konu_mesaj` varchar(5000) COLLATE utf8_turkish_ci NOT NULL,
  `konu_tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `konular`
--

INSERT INTO `konular` (`konu_id`, `konu_uye_id`, `konu_kategori_link`, `konu_ad`, `konu_link`, `konu_mesaj`, `konu_tarih`) VALUES
(5, 1, 'rtx20-series', '2080', '2080-596', '2080 konusunda bana yardımcı olur musunuz yeni bilgisayar alıyorum ve 2080 ile 2060 arasındaki farkları öğrenmek istiyorum.', '2024-06-12 23:15:23'),
(6, 1, 'rtx20-series', 'RTX20 serisi ile RTX10 serisi arasındaki farklar', 'rtx20-serisi-ile-rtx10-serisi-arasindaki-farklar-801', '', '2024-06-13 01:16:36'),
(8, 4, 'rtx30-series', 'RTX30 serisinden Fiyat Performans Ürünü Bir Ekran Kartı Önerisi İstiyorum', 'rtx30-serisinden-fiyat-performans-urunu-bir-ekran-karti-onerisi-istiyorum-295', 'Yeni bir bilgisayar topluyorum ve fiyatına göre performansı çok iyi bir 30 serisi ekran kartı istiyorum önerilerinizi bekliyorum.', '2024-06-25 15:43:36'),
(9, 1, 'rtx40-series', 'RTX4090TI', 'rtx4090ti-137', 'Ekran kartının fiyatı her baktığım yerde değişiyor nedeni nedir acaba?', '2024-06-25 15:49:45'),
(10, 1, 'rtx20-series', 'sadfdsaf', 'sadfdsaf-318', 'sdafasdfas', '2024-06-26 10:47:22');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyeler`
--

CREATE TABLE `uyeler` (
  `uye_id` int(11) NOT NULL,
  `uye_adsoyad` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
  `uye_kadi` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
  `uye_sifre` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
  `uye_eposta` varchar(300) COLLATE utf8_turkish_ci NOT NULL,
  `uye_onay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `uyeler`
--

INSERT INTO `uyeler` (`uye_id`, `uye_adsoyad`, `uye_kadi`, `uye_sifre`, `uye_eposta`, `uye_onay`) VALUES
(1, 'Muhammed Vahit Elik', 'mumi03', '0a3bfcce38c9a957b752588a785bbacc', 'muhammedelik03@gmail.com', 1),
(2, 'Mert Kurşun', 'mrtkrsn', '7dca7f457eb2931da34fdae0de646a4d', 'kurusnmert01@gmail.com', 0),
(3, 'admin', 'yönetici', '6116afedcb0bc31083935c1c262ff4c9', 'elikmuhammed03@gmail.com', 1),
(4, 'semih Yavuz', 'smh', '9786871ab2e3143ead36e29bc96da42d', 'semihyavuz_54@hotmail.com', 0);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `y_id` int(11) NOT NULL,
  `y_uye_id` int(11) NOT NULL,
  `y_konu_id` int(11) NOT NULL,
  `y_yorum` varchar(1000) COLLATE utf8_turkish_ci NOT NULL,
  `y_tarih` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`y_id`, `y_uye_id`, `y_konu_id`, `y_yorum`, `y_tarih`) VALUES
(21, 4, 6, 'Çok büyük bi fark var RTX teknolojisi sayesinde artık her şey çok daha gerçekçi', '2024-06-25 15:44:17'),
(23, 1, 6, 'RTX teknolojisini herkes çok övüyor bana bu teknolojiyi ayrıntılı bir şekilde açıklayabilir misiniz\r\n', '2024-06-25 15:48:08');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`k_id`);

--
-- Tablo için indeksler `konular`
--
ALTER TABLE `konular`
  ADD PRIMARY KEY (`konu_id`);

--
-- Tablo için indeksler `uyeler`
--
ALTER TABLE `uyeler`
  ADD PRIMARY KEY (`uye_id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`y_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `k_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `konular`
--
ALTER TABLE `konular`
  MODIFY `konu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `uye_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `y_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
