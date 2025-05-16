<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "agence_immo1"; 
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("❌ Connexion échouée : " . $conn->connect_error);
}
?>
