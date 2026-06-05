<?php

//$conn = mysqli_connect("localhost", "root", "", "taja_db");
$conn = mysqli_connect(
    "sql111.infinityfree.com",
    "if0_41972705",
    "jvMSBAuEOrK",
    "if0_41972705_taja_db"
);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
