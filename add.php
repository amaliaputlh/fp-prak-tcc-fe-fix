<?php
// session_start();
// if (!isset($_SESSION['username'])) {
//     header("location:index.php");
//     exit;
// }
include 'database/config.php';
$id = "";
$nama = "";
$jumlah = "";
$jenis = "";
$harga = "";

if (isset($_GET["op"])) {
    if ($_GET["op"] == "edit") {
        $judul = "Ubah Data Barang";
        $button = "Ubah";
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $url = "http://localhost:8080/barang/$id"; // Sesuaikan dengan URL endpoint API Anda
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $token")); // Menambahkan header Authorization dengan token
            $response = curl_exec($ch);
            $data = json_decode($response, true);
            curl_close($ch);

            if ($data) {
                $foundData = false;

                // Cek id dari setiap data
                foreach ($data as $item) {
                    if ($item["id"] == $id) {
                        $foundData = true;
                        $nama = $item["nama"];
                        $jumlah = $item["jumlah"];
                        $jenis = $item["jenis"];
                        $harga = $item["harga"];
                        break;
                    }
                }

                if (!$foundData) {
                    echo "ID tidak ditemukan dalam data.";
                }
            } else {
                echo "Gagal mengambil data dari API.";
            }
        } else {
            echo "ID tidak ditemukan dalam parameter URL.";
        }
    } else {
        $button = "Simpan";
        $judul = "Tambah Data Barang";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Management Product</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

    <form action="./database/input.php?op=<?= $_GET["op"] ?? "" ?>&id=<?= $id ?>" method="POST" enctype="multipart/form-data" class="form_add_inventaris">
        <div class="form_add_inventaris_title">
            <h3><?= $judul ?></h3>
        </div>
        <div class=" mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama Barang</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Barang" value="<?= $nama ?>">
            </div>
        </div>
        <div class=" mb-3 row">
            <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
            <div class="col-sm-3">
                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah" value="<?= $jumlah ?>">
            </div>
        </div>
        <div class=" mb-3 row">
            <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Jenis" value="<?= $jenis ?>">
            </div>
        </div>
        <div class=" mb-3 row">
            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga" value="<?= $harga ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <span class="col-sm-2"></span>
            <div class="col-sm-10">
                <input type="submit" name="simpan" value="<?= $button ?>" class="btn btn-primary">
                <a href="./barang.php" class="btn btn-danger ms-1">Batal</a>
            </div>
        </div>
    </form>
</body>

</html>
