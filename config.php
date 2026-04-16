<?php
$servername = "localhost"; // Gantikan dengan nama pelayan jika perlu
$username = "root"; // Gantikan dengan nama pengguna pangkalan data anda
$password = ""; // Gantikan dengan kata laluan pangkalan data anda
$dbname = "bercuitm"; // Gantikan dengan nama pangkalan data anda


// Mewujudkan sambungan
$conn = new mysqli($servername, $username, $password, $dbname);

// Semak sambungan
if ($conn->connect_error) {
    die("Sambungan gagal: " . $conn->connect_error);
}
?>
