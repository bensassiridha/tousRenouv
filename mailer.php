<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $firstname = strip_tags(trim($_POST["form-first-name"]));
        $firstname = str_replace(array("\r","\n"),array(" "," "),$firstname);
        $lastname = strip_tags(trim($_POST["form-last-name"]));
        $lastname = str_replace(array("\r","\n"),array(" "," "),$lastname);        
        $subject = strip_tags(trim($_POST["subject"]));
        $phone = strip_tags(trim($_POST["form-phone"]));
        $codepostal = strip_tags(trim($_POST["form-cp"]));
        $city = strip_tags(trim($_POST["form-city"]));
        $adresse = strip_tags(trim($_POST["form-adresse"]));
        $email = filter_var(trim($_POST["form-email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["form-about-project"]);

        // Check that data was sent to the mailer.
        if ( empty($firstname) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = 'youness.elbezzazi@gmail.com, contact@tousrenov.fr';

        // Set the email subject.
        $subject = $subject;

        // Build the email content.
        $email_content = "Nom: $firstname\n";
        $email_content = "Prénom: $lastname\n";
        $email_content = "Email: $email\n";
        $email_content = "Téléphone: $phone\n";
        $email_content = "Adresse: $adresse\n";
        $email_content .= "Code Postal: $codepostal\n\n";
        $email_content .= "Ville: $city\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $firstname $lastname <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>