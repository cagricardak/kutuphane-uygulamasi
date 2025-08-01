<?php
class Kitap {
    //Değişkenler
	public $baslik;
    public $yazar;
    public $tur;

    // Statik değişken toplam kitap sayısı
    public static $toplamKitapSayisi = 0;

    // Yapıcı metod
    public function __construct($baslik, $yazar, $tur) {
        $this->baslik = $baslik;
        $this->yazar = $yazar;
        $this->tur = $tur;
    }

    // Kitapları listeleme metodu
    public static function kitaplariListele($pdo) {
        $sorgu = $pdo->query("SELECT * FROM kitaplar");
        return $sorgu->fetchAll(PDO::FETCH_ASSOC);
    }

    // Kitap ekleme metodu
    public static function kitapEkle($pdo, $kitap) {
        $sorgu = $pdo->prepare("INSERT INTO kitaplar (baslik, yazar, tur) VALUES (?, ?, ?)");
        $sorgu->execute([$kitap->baslik, $kitap->yazar, $kitap->tur]);

        // Kitap eklendikten sonra toplam kitap sayısını güncelleme
        self::guncelleToplamKitapSayisi($pdo);
    }

    // Kitap silme metodu
    public static function kitapSil($pdo, $id) {
        $sorgu = $pdo->prepare("DELETE FROM kitaplar WHERE id = ?");
        $sorgu->execute([$id]);

        // Kitap silindikten sonra toplam kitap sayısını güncelleme
        self::guncelleToplamKitapSayisi($pdo);
    }

    // Toplam kitap sayısını güncelleme
    public static function guncelleToplamKitapSayisi($pdo) {
        $sorgu = $pdo->query("SELECT COUNT(*) FROM kitaplar");
        self::$toplamKitapSayisi = $sorgu->fetchColumn();
    }
}

?>


