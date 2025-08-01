<?php
// Veritabanı bağlantısı
$pdo = new PDO('mysql:host=localhost;dbname=kutuphane', 'root', '');
$pdo->exec('SET CHARSET UTF8'); 

// Kitap.php sınıfını dahil etme
include 'kitap.php';

// Kitap ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Kitap nesnesi oluşturma
    $kitap = new Kitap($_POST['baslik'], $_POST['yazar'], $_POST['tur']);
    // Kitap ekleme
    Kitap::kitapEkle($pdo, $kitap); 
    $_SESSION['kitap_eklendi'] = true; 
    header("Location: index.php");
    exit();
}

// Kitapları listeleme
$kitaplar = Kitap::kitaplariListele($pdo);

// Toplam kitap sayısını sorgulama
$sorgu = $pdo->query("SELECT COUNT(*) FROM kitaplar");
$kitapSayisi = $sorgu->fetchColumn();
?>

<!DOCTYPE html>
<html lang="tr">
<!-- Html Kodu -->
<head>
    <meta charset="UTF-8">
    <title>Kütüphane Uygulaması</title>
    <style>
        form { margin-bottom: 20px; }
        input[type="text"] {
            width: 300px;
            padding: 5px;
            margin: 6px 0;
            display: block;
        }
        button[type="submit"] {
            padding: 6px 12px;
            margin-top: 10px;
        }
        td, th { padding: 10px; }
    </style>
</head>
<body>
    <h1>Kütüphane Uygulaması</h1>

    <!-- Kitap Ekleme Formu -->
    <form method="POST">
        <input type="text" name="baslik" placeholder="Kitap Adı" required>
        <input type="text" name="yazar" placeholder="Yazar" required>
        <input type="text" name="tur" placeholder="Tür" required>
        <button type="submit">Kitap Ekle</button>
    </form>

    <h2>Kitap Listesi</h2>

    <!-- Toplam kitap sayısı gösterimi -->
    <p>Toplam Kitap Sayısı: <?= $kitapSayisi ?></p>

    <table>
        <tr>
            <th>Kitap Adı</th>
            <th>Yazar</th>
            <th>Tür</th>
        </tr>
        <!-- Kitapları listeleme -->
        <?php foreach ($kitaplar as $kitap): ?>
        <tr>
            <td><?= htmlspecialchars($kitap['baslik']) ?></td>
            <td><?= htmlspecialchars($kitap['yazar']) ?></td>
            <td><?= htmlspecialchars($kitap['tur']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>



