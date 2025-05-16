<?php
include 'db2.php';
echo "<pre>";
print_r($_POST);
echo "</pre>";
if (isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['message'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $message = trim($_POST['message']);
  if ($name && $email && $phone && $message) {
    $stmt = $conn->prepare("INSERT IGNORE INTO contacts (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);
    if ($stmt->execute()) {
      echo "✅ Bien ajouté avec succès !";
    } else {
      echo "❌ Erreur SQL: " . $stmt->error;
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
