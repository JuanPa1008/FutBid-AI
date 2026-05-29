<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function enviarCorreoGanador(
    $correo,
    $nombre,
    $playera,
    $monto
){

$mail = new PHPMailer(true);

try{

$mail->isSMTP();

$mail->Host='smtp.gmail.com';

$mail->SMTPAuth=true;

$mail->Username='jpcarrillo59@gmail.com'; // TU GMAIL

$mail->Password='rqsi lbce pvli cxvz'; 
// reemplaza por tu contraseña de aplicación actual

$mail->SMTPSecure=PHPMailer::ENCRYPTION_STARTTLS;

$mail->Port=587;

$mail->CharSet='UTF-8';

$mail->setFrom(
'jpcarrillo59@gmail.com',
'FutBid AI'
);

$mail->addAddress($correo,$nombre);

$mail->isHTML(true);

$mail->Subject='🏆 Ganaste una subasta en FutBid AI';

$mail->Body="

<h2>¡Felicidades $nombre! 🎉</h2>

<p>Tu oferta fue la ganadora.</p>

<hr>

<b>👕 Playera:</b> $playera <br>
<b>💰 Monto final:</b> $$monto MXN <br>

<hr>

<h3>📌 Información de pago</h3>

<b>Banco:</b> BBVA <br>
<b>Titular:</b> FutBid AI <br>
<b>Cuenta:</b> 1234567890 <br>
<b>CLABE:</b> 012345678901234567 <br>

<br>

⚠️ <b>Tienes 24 horas para realizar el pago.</b>

<br><br>

Una vez realizado el pago, envía tu comprobante para confirmar tu compra.

<br><br>

Gracias por usar FutBid AI 🚀

";

$mail->send();

return true;

}catch(Exception $e){

echo "Error al enviar correo:<br>";
echo $mail->ErrorInfo;

return false;

}

}
?>