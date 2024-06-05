<?php

    $user = $_POST["username"];
    $pass = $_POST["password"];

    // Mengambil data dari API
    $apiUrl = "https://e-01-415004.uc.r.appspot.com/user";
    $apiResponse = file_get_contents($apiUrl);
    $apiData = json_decode($apiResponse, true);

    // Memeriksa apakah pengambilan data berhasil
    if ($apiData) {
        $found = false;

        // Memeriksa apakah username dan password cocok dengan data dari API
        foreach ($apiData as $item) {
            if ($item["username"] == $user && $item["password"] == $pass) {
                $found = true;
                break;
            }
        }

        // Jika autentikasi berhasil, buat sesi dan redirect ke halaman dashboard
        if ($found) {
            session_start();
            $_SESSION["username"] = $user;
            header("Location: ../dashboard.php");
        } else {
            // Jika autentikasi gagal, tampilkan pesan kesalahan
            echo "Autentikasi gagal. Username atau password tidak valid.";
        }
    } else {
        // Menampilkan pesan jika pengambilan data dari API gagal
        echo "Gagal mengambil data dari API.";
    }
?>