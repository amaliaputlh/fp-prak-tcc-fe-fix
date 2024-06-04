<?php
include 'database/config.php';

$id = $_GET["id"];
$url = "http://localhost:8080/barang/$id"; // URL dengan ID barang yang akan dihapus
//$token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwidXNlcm5hbWUiOiJhbWFsaWEiLCJpYXQiOjE3MTc0Mjc0MTcsImV4cCI6MTcxNzQzMTAxN30.3Kixqf1zPl_44nIkXAU6L4FMRHzlBnKkpdqzE_auxeM"; // Token yang dimasukkan secara manual

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $token // Menambahkan header Authorization dengan token
));
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    header("Location: ./barang.php");
    exit;
} else {
    echo "Gagal menghapus data.";
}
?>
