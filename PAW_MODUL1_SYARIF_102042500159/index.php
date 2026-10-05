<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$produk = [
    [
        "nama" => "LENOVO LOQ",
        "kategori" => "Laptop",
        "harga" => 13000000,
        "stok" => 2
    ],
    [
        "nama" => "XIAOMI A24I",
        "kategori" => "Monitor",
        "harga" => 1800000,
        "stok" => 4
    ],
    [
        "nama" => "FURYCUBE M68HE",
        "kategori" => "Keyboard",
        "harga" => 850000,
        "stok" => 4
    ],
    [
        "nama" => "PLAYSTATION 5 SLIM",
        "kategori" => "Console",
        "harga" => 8499000,
        "stok" => 1
    ],
    [
        "nama" => "LOGITECH G102",
        "kategori" => "Mouse",
        "harga" => 350000,
        "stok" => 5
    ],
    [
        "nama" => "HUAWEI PURA 90S PRO",
        "kategori" => "SmartPhone",
        "harga" => 16000000,
        "stok" => 3
    ]
];

if (!isset($_SESSION["produk"])){
    $_SESSION["produk"] = $produk;
}

if (isset($_POST["reset"])) {
    $_SESSION["produk"] = $produk;

}

if (isset($_POST["beli"])) {
    $index = $_POST["index"];
    if ($_SESSION["produk"][$index]["stok"] > 0) {
        $_SESSION["produk"][$index]["stok"]--;
    }
    header("Location: " . $_SERVER["PHP_SELF"]);
    exit;
}
$produk = $_SESSION["produk"];

$jumlahProduk = count($produk);

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cia Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            CIA Store
        </div>
        <div class="menu">
            <a href="#">Home</a>
            <a href="#produk">Produk</a>
            <a href="#">Tentang</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-small">
                CIA Store
            </div>
            <h1>
                Belanja Electronic<br>
                <span>Tanpa Ribet</span>
            </h1>
            <p>
                Temukan berbagai produk elektronik
                untuk kebutuhanmu.
            </p>
            <a href="#produk" class="hero-button">
                Lihat Produk
            </a>
        </div>
        <div class="hero-decoration"></div>
    </section>

    <section class="product-section" id="produk">
        <div class="section-header">
            <div>
                <small>OUR PRODUCTS</small>
                <h2>Katalog Produk</h2>
            </div>

            <div class="catalog-actions">
                <div class="total-product">
                    Total Produk:
                    <strong><?= $jumlahProduk ?></strong>
                </div>
                <form method="POST">
                    <button
                        type="submit"
                        name="reset"
                        class="reset-button"
                    >
                        Reset Stok
                    </button>
                </form>
            </div>
        </div>
    
        <div class="product-grid">
            <?php foreach ($produk as $key => $item): ?>
                <?php
                if ($item["stok"] > 0) {
                    $status = "Tersedia";
                } else {
                    $status = "Stok Habis";
                }

                if ($item["harga"] >= 1000000) {
                    $persentaseDiskon = 10;
                    $nilaiDiskon =
                        $item["harga"] * $persentaseDiskon / 100;
                    $hargaSetelahDiskon =
                        $item["harga"] - $nilaiDiskon;
                } else {
                    $persentaseDiskon = 0;
                    $hargaSetelahDiskon =
                        $item["harga"];
                }
                ?>

                <div class="card">
                    <div class="category">
                        <?= htmlspecialchars($item["kategori"]) ?>
                    </div>

                    <h3>
                        <?= htmlspecialchars($item["nama"]) ?>
                    </h3>

                    <?php if ($persentaseDiskon > 0): ?>
                        <div class="harga-normal">
                            Rp<?= number_format(
                                $item["harga"],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </div>

                        <div class="diskon">
                            DISKON <?= $persentaseDiskon ?>%
                        </div>

                        <div class="harga-setelah">
                            Rp<?= number_format(
                                $hargaSetelahDiskon,
                                0,
                                ',',
                                '.'
                            ) ?>
                        </div>

                    <?php else: ?>
                        <div class="harga">
                            Rp<?= number_format(
                                $item["harga"],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </div>
                    <?php endif; ?>

                    <div class="stock">
                        Stok: <?= $item["stok"] ?>
                        <?php if ($item["stok"] > 0): ?>

                            <span class="tersedia">
                                Tersedia
                            </span>
                        <?php else: ?>

                            <span class="habis">
                                Stok Habis
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if ($item["stok"] > 0): ?>

                        <form method="POST">
                            <input
                                type="hidden"
                                name="index"
                                value="<?= $key ?>"
                            >
                            <button
                                type="submit"
                                name="beli"
                                class="buy-button"
                            >
                                Beli Sekarang
                            </button>
                        </form>
                    <?php else: ?>
                        <button class="buy-button" disabled>
                            Stok Habis
                        </button>
                    <?php endif; ?>
                </div>
            
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>




