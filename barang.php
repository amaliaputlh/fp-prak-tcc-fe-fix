<?php
session_start();
if (!isset($_SESSION['username'])) header("location:index.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Data Barang</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="barang.js"></script>
</head>

<body>

    <?php include "./component/navbar.php" ?>

    <div class="add_inventaris">
        <a href="./add.php?op=tambah">+ Tambah</a>
    </div>

    <div class="table_inventaris">
        <table class="table">
            <thead>
                <th>No</th>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Jenis</th>
                <th>Harga</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                <?php
                include 'database/config.php';
                
                // URL API yang ingin diambil datanya
                $api_url = "http://localhost:8080/barang";

                // Menyiapkan opsi untuk permintaan HTTP
                $options = array(
                    'http' => array(
                        'header' => "Authorization: Bearer $token\r\n" // Menyertakan token dalam header Authorization
                    )
                );

                // Membuat konteks untuk permintaan HTTP
                $context = stream_context_create($options);

                // Mengambil data dari URL menggunakan file_get_contents dengan menyertakan konteks yang sudah dibuat
                $data = file_get_contents($api_url, false, $context);

                // Menerjemahkan data JSON menjadi array
                $inventaris = json_decode($data, true);

                // Memproses data
                foreach ($inventaris as $no => $data) {
                    // Validasi dan sanitasi data sebelum menampilkannya
                    $id = htmlspecialchars($data["id"]);
                    $nama = htmlspecialchars($data["nama"]);
                    $jumlah = htmlspecialchars($data["jumlah"]);
                    $jenis = htmlspecialchars($data["jenis"]);
                    $harga = htmlspecialchars($data["harga"]);
                ?>
                    <tr>
                        <td><?= $no + 1 ?></td>
                        <td><?= $id ?></td>
                        <td><?= $nama ?></td>
                        <td><?= $jumlah ?></td>
                        <td><?= $jenis ?></td>
                        <td><?= $harga ?></td>
                        <td>
                            <a href="./add.php?op=edit&id=<?= $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                            <a href="./hapus.php?id=<?= $id ?>&nama=<?= $nama ?>"><button type="button" class="btn btn-danger ms-1">Delete</button></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>