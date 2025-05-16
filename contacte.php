<?php
include 'db.php';
echo "<pre>";
print_r($_POST);
echo "</pre>";
if (isset($_POST['name'], $_POST['email'], $_POST['message'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $message = trim($_POST['message']);
  if ($name && $email && $message) {
    $stmt = $conn->prepare("INSERT IGNORE INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    if ($stmt->execute()) {
      echo "✅ Bien ajouté avec succès !";
    } else {
      echo "❌ Erreur SQL: " . $stmt->error;
    }
    $stmt->close();
  } else {
    echo "⚠️ Champs vides.";
  }
} else {
  echo "❌ Données non reçues.";
}

$conn->close();
?>
