<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendEmail($recipient_email, $email_content)
{
  try {
    $currentDate = date("d/m");
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    // Username email
    $mail->Username = 'admin@gmail.com';

    // Mật khẩu ứng dụng 
    $mail->Password = 'makhauungdung';

    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';

    $mail->setFrom("admin@gmail.com", "XOM225 MANAGER");
    $mail->addAddress($recipient_email);

    // Tao 1 bản sao gửi vào mail dưới đây
    $mail->addCC('admin2@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = ("XOM225 NOTIFICATION ($currentDate)");
    $htmlCode = '<div style="border-style:solid;border-width:thin;border-color:#dadce0;border-radius:8px;padding:40px 20px" align="center" class="m_-8448117101150819138mdv2rw">
      <div style="font-family:\'Google Sans\',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);line-height:32px;padding-bottom:24px;text-align:center;word-break:break-word">
        <div style="font-size:24px">Xóm trọ có 1 thông báo mới</div>
      </div>
      <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">
        ' . $email_content . '
      </div>

      <div style="text-align: center; width: 100%; margin-top: 50px;">
        <a href="https://xomtro.000webhostapp.com/admin">Xem ngay</a>
      </div>
    </div>';
    $mail->Body = $htmlCode;
    $mail->send();

    header("Location:../pages/handle/checkcode.php");
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}
