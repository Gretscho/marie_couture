<?php
// Remplace cette adresse par celle du client
$to = "destinataire@example.com";

// Sécurité basique
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Vérifie que les données sont présentes
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = clean_input($_POST["nom"] ?? '');
    $email = clean_input($_POST["email"] ?? '');
    $message = clean_input($_POST["message"] ?? '');

    // Validation de base
    if (empty($nom) || empty($email) || empty($message)) {
        http_response_code(400);
        echo "Veuillez remplir tous les champs.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Adresse email invalide.";
        exit;
    }

    // Préparation du mail
    $subject = "Nouveau message de $nom";
    $body = "Nom: $nom\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Envoi
    if (mail($to, $subject, $body, $headers)) {
        echo "✅ Message envoyé avec succès.";
    } else {
        http_response_code(500);
        echo "❌ Erreur lors de l'envoi du message.";
    }
} else {
    http_response_code(403);
    echo "Méthode non autorisée.";
}
?>

