<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerController extends Controller
{

    // ========== [ Compose Email ] ================
    public function composeEmail(Request $request) {
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);     // Passing `true` enables exceptions

        try {

            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'pikapipikapi63@gmail.com';   //  sender username
            $mail->Password = 'nikul1234@';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            $mail->setFrom('pikapipikapi63@gmail.com', 'BookIspot');
            $mail->addAddress($request['emailRecipient']);

            $mail->addReplyTo('pikapipikapi63@gmail.com', 'BookISpot');

            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $request['emailSubject'];
            $mail->Body    = $request['emailBody'];

            if( !$mail->send() ) {
                return "Email not sent.";
            } else {
                return "Email has been sent.";
            }
        } catch (Exception $e) {
            return 'Message could not be sent.'.$e->errorMessage();
        }
    }
}

