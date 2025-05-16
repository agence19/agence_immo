<?php
include 'db1.php';  
echo "<pre>";
print_r($_POST);
echo "</pre>";
if (isset($_POST['name'], $_POST['email'], $_POST['message'], $_POST['subject'])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $message = trim($_POST['message']);
  $subject = trim($_POST['subject']);
  $agent = isset($_POST['agent']) ? trim($_POST['agent']) : 'Non spécifié'; 
  if ($name && $email && $message && $subject) {
    $stmt = $conn->prepare("INSERT IGNORE INTO contacts (name, email, message, subject, agent) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $message, $subject, $agent);
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
