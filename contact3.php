<?php
include 'db3.php';
echo "<pre>";
print_r($_POST);
echo "</pre>";
if (isset($_POST['lastname'], $_POST['firstname'], $_POST['email'], $_POST['location'])) {
  $lastname = trim($_POST['lastname']);
  $firstname = trim($_POST['firstname']);
  $email = trim($_POST['email']);
  $location = trim($_POST['location']);
  if ($lastname && $firstname && $email && $location) {
    $stmt = $conn->prepare("INSERT IGNORE INTO users (lastname, firstname, email, location) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $lastname, $firstname, $email, $location);
    if ($stmt->execute()) {
      echo "✅ Bien ajouté avec succès !";
    } else {
      echo "❌ Erreur SQL : " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "⚠️ Tous les champs sont requis.";
  }
} else {
  echo "❌ Données non reçues.";
}
$conn->close();
?>
