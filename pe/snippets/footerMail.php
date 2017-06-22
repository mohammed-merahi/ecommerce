<?php

        //get company email
        $xml        = simplexml_load_file("../../config/parametres.xml");
        $recipient  = $xml->xpath( '/parametres/affichage/contact/email' )[0];   

        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        //$subject = trim($_POST["subject"]);
        $subject = "";
		//$phone = trim($_POST["phone"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Merci de bien remplir le formulaire.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        //$recipient = "m.mohamed@cirtait.com";

        // Set the email subject.
        $subject = "Nouveau message de : $name";

        // Build the email content.
        $email_content  = "Nom : $name\n";
        $email_content .= "Email : $email\n\n";
        $email_content .= "Objet : $subject\n\n";
        //$email_content .= "Téléphone : $phone\n\n";
        $email_content .= "Message :\n$message\n";

        // Build the email headers.
        $email_headers = "De : $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Merci! Votre message a été envoyé.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Une erreur s'est produite lors de l'envoi de votre message.";
        }
 

?>
