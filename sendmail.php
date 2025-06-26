<?php
// Configuration de l'adresse email de réception
$destinataire = "ton-email@example.com"; // ⚠️ À remplacer par ton email

// Sécuriser les données et vérifier leur présence
$nom = isset($_POST['nom']) ? strip_tags(trim($_POST['nom'])) : null;
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : null;
$message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : null;

// Validation
if (!$nom || !$email || !$message || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.html?error=1");
    exit();
}

// Préparation du message
$sujet = "Nouveau message de contact";
$contenu = "Nom : $nom\n";
$contenu .= "Email : $email\n";
$contenu .= "Message :\n$message\n";

// En-têtes
$headers = "From: $nom <$email>" . "\r\n" .
           "Reply-To: $email" . "\r\n" .
           "X-Mailer: PHP/" . phpversion();

// Envoi
$success = mail($destinataire, $sujet, $contenu, $headers);

// Redirection
if ($success) {
    header("Location: index.html?success=1");
} else {
    header("Location: index.html?error=1");
}
exit();
?>
