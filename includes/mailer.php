<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';


function sendContactInquiryEmail(
    string $name,
    string $email,
    string $phone,
    string $message
): bool {

    $mail = new PHPMailer(true);

    try {

        /*
        |--------------------------------------------------------------------------
        | SMTP CONFIGURATION
        |--------------------------------------------------------------------------
        */

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = 'sales@alokglass.com';

        /*
         * PUT YOUR GOOGLE APP PASSWORD HERE
         *
         * Do NOT use your normal Google password.
         */
        $mail->Password = 'sroqsiqyyssrpmkn';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;


        /*
        |--------------------------------------------------------------------------
        | SENDER
        |--------------------------------------------------------------------------
        */

        $mail->setFrom(
            'sales@alokglass.com',
            'Alok Glass Website'
        );


        /*
        |--------------------------------------------------------------------------
        | RECIPIENT
        |--------------------------------------------------------------------------
        */

        $mail->addAddress(
            'sales@alokglass.com'
        );


        /*
        |--------------------------------------------------------------------------
        | REPLY TO CUSTOMER
        |--------------------------------------------------------------------------
        */

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $mail->addReplyTo(
                $email,
                $name
            );

        }


        /*
        |--------------------------------------------------------------------------
        | EMAIL CONTENT
        |--------------------------------------------------------------------------
        */

        $mail->isHTML(true);

        $mail->Subject = 'New Contact Inquiry - Alok Glass Works';

        $mail->Body = '
            <h2>New Contact Inquiry</h2>

            <p>
                <strong>Name:</strong>
                ' . htmlspecialchars($name) . '
            </p>

            <p>
                <strong>Email:</strong>
                ' . htmlspecialchars($email) . '
            </p>

            <p>
                <strong>Phone:</strong>
                ' . htmlspecialchars($phone) . '
            </p>

            <p>
                <strong>Message:</strong>
            </p>

            <p>
                ' . nl2br(htmlspecialchars($message)) . '
            </p>
        ';


        /*
        |--------------------------------------------------------------------------
        | PLAIN TEXT FALLBACK
        |--------------------------------------------------------------------------
        */

        $mail->AltBody =
            "New Contact Inquiry\n\n" .
            "Name: " . $name . "\n" .
            "Email: " . $email . "\n" .
            "Phone: " . $phone . "\n\n" .
            "Message:\n" . $message;


        /*
        |--------------------------------------------------------------------------
        | SEND
        |--------------------------------------------------------------------------
        */

        return $mail->send();

    } catch (Exception $e) {

        /*
         * Do not expose SMTP errors to website visitors.
         */

        error_log(
            'Contact inquiry email failed: ' .
            $mail->ErrorInfo
        );

        return false;
    }
}