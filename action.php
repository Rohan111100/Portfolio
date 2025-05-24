<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Honeypot check (bot trap)
    if (!empty($_POST["honeypot"])) {
        header("Location: contact.html?error=1");
        exit;
    }

    // Sanitize inputs
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));

    // Validate inputs
    if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message)) {
        header("Location: contact.html?error=1");
        exit;
    }

    // Email settings
    $to = "your@email.com";  // ✅ Change this to your email
    $subject = "New Contact Message from $name";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = "From: $name <$email>";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        header("Location: contact.html?success=1");
    } else {
        header("Location: contact.html?error=1");
    }
    exit;
}
?>
