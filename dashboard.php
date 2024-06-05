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
    <title>Management Product</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>

    <?php include "./component/navbar.php" ?>

    <div class="welcome">
        <h2>Selamat Datang</h2>
        <?php

        $user = $_SESSION["username"];

        // Mengambil data dari API
        $apiUrl = "https://e-01-415004.uc.r.appspot.com/user";
        $apiResponse = file_get_contents($apiUrl);
        $apiData = json_decode($apiResponse, true);

        // Memeriksa apakah pengambilan data berhasil
        if ($apiData) {
            // Mencari pengguna berdasarkan username
            foreach ($apiData as $item) {
                if ($item["username"] == $user) {
                    $fullname = $item["fullname"];
                    break;
                }
            }

            echo "<h1>$fullname</h1>";
        } else {
            // Menampilkan pesan jika pengambilan data dari API gagal
            echo "Gagal mengambil data dari API.";
        }
        ?>
    </div>
</body>

</html>