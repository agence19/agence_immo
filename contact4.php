<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=agence_immo4;charset=utf8', 'root', ''); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $stmt = $pdo->prepare("INSERT INTO biens (description) VALUES (:description)");
    $stmt->execute(['description' => $description]);
    $bienId = $pdo->lastInsertId();
    if (!empty($_FILES['propertyImages']) && is_array($_FILES['propertyImages']['name'])) {
        $uploadDir = __DIR__ . '/uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        foreach ($_FILES['propertyImages']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['propertyImages']['error'][$key] === UPLOAD_ERR_OK) {
                $filename = basename($_FILES['propertyImages']['name'][$key]);
                $targetPath = $uploadDir . $filename;
                if (move_uploaded_file($tmpName, $targetPath)) {        
                    $stmt = $pdo->prepare("INSERT INTO photos (bien_id, chemin) VALUES (:bien_id, :chemin)");
                    $stmt->execute([
                        'bien_id' => $bienId,
                        'chemin' => 'uploads/' . $filename
                    ]);
                }
            }
        }
    }
    echo "✅ Bien ajouté avec succès !";
} else {
    echo "Formulaire non soumis correctement.";
}
