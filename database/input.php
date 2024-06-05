<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
}

$nama = $_POST["nama"];
$jumlah = $_POST["jumlah"];
$jenis = $_POST["jenis"];
$harga = $_POST["harga"];

if ($_GET["op"] == "tambah") {
    $data = array(
        "nama" => $nama,
        "jumlah" => $jumlah,
        "jenis" => $jenis,
        "harga" => $harga
    );

    include 'config.php';

    $url = "https://e-01-415004.uc.r.appspot.com/barang";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        "Authorization: Bearer $token" // Menambahkan header Authorization dengan token
    ));
    $response = curl_exec($ch);

    if ($response === false) {
        echo "Gagal mengirim permintaan ke API: " . curl_error($ch);
        exit;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200) {
        header("Location: ../barang.php");
        exit;
    } else {
        echo "Gagal memproses permintaan: " . $httpCode;
        exit;
    }
} elseif ($_GET["op"] == "edit") {
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $data = array(
            "nama" => $nama,
            "jumlah" => $jumlah,
            "jenis" => $jenis,
            "harga" => $harga
        );
        
        include 'config.php';
        $url = "https://e-01-415004.uc.r.appspot.com/barang/$id"; // Perbaiki URL dengan menambahkan ID barang
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            "Authorization: Bearer $token" // Menambahkan header Authorization dengan token
        ));
        $response = curl_exec($ch);

        if ($response === false) {
            echo "Gagal mengirim permintaan ke API: " . curl_error($ch);
            exit;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 200) {
            header("Location: ../barang.php");
            exit;
        } else {
            echo "Gagal memproses permintaan: " . $httpCode;
            exit;
        }
    } else {
        echo "ID tidak ditemukan dalam parameter URL.";
        exit;
    }
} else {
    echo "Operasi tidak valid.";
    exit;
}
?>
