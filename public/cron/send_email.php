<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$today = date('Y-m-d');

// get email company
$emailCompany = "SELECT * FROM companies where id='1'";
$queryemailCompany = mysqli_query($koneksi, $emailCompany);
$datanya = mysqli_fetch_array($queryemailCompany);
// $email = $datanya['email_remainder_first'];

$email = array(
    $datanya['email_remainder_first'],
    $datanya['email_remainder_second']
);


// get data employee
$query = "select * from employees";
$dataX = mysqli_query($koneksi, $query);
$mail = new PHPMailer(true);
if ($dataX->num_rows > 0) {
    while ($row = mysqli_fetch_array($dataX)) {
        if ($row['end_contract_date'] != null || $row['end_contract_date'] != '') {
            $selisihHari = strtotime($row['end_contract_date']) - strtotime($today);
            $selisihHari = $selisihHari / (60 * 60 * 24);
            if ($selisihHari == 90) {
                $pesan = generatePesan($row['employee_id'], $row['full_name'], 'End contract date', $row['end_contract_date']);
                sendEmail($mail, $pesan, $email);
            }
        }

        if ($row['kitas_validity'] != null || $row['kitas_validity'] != '') {
            $selisihHari = strtotime($row['kitas_validity']) - strtotime($today);
            $selisihHari = $selisihHari / (60 * 60 * 24);
            if ($selisihHari == 90) {
                $pesan = generatePesan($row['employee_id'], $row['full_name'], 'Kitas No', $row['kitas_validity']);
                sendEmail($mail, $pesan, $email);
            }
        }

        if ($row['passport_validity'] != null || $row['passport_validity'] != '') {
            $selisihHari = strtotime($row['passport_validity']) - strtotime($today);
            $selisihHari = $selisihHari / (60 * 60 * 24);
            if ($selisihHari == 150) {
                $pesan = generatePesan($row['employee_id'], $row['full_name'], 'Passport', $row['passport_validity']);
                sendEmail($mail, $pesan, $email);
            }
        }
    }
} else {
    echo "0 results";
}

$koneksi->close();

function sendEmail($mail, $pesan, $email)
{
    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hexamatics2@gmail.com';
        $mail->Password   = 'orrxplzggelotyug';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->setFrom('hexamatics2@gmail.com', 'System Remainder');
        foreach ($email as $recipient) {
            $mail->addAddress($recipient);
        }
        $mail->isHTML(true);
        $mail->Subject = 'Remainder due date';
        $mail->Body    = $pesan;
        $mail->AltBody = '';
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function generatePesan($employee_id, $full_name, $field, $date)
{
    $pesan = '
<div style="text-align: center">
<table
   style="text-align: left;max-width: 640px; color:#737373;border-collapse:collapse;border-left:1px solid #e4e4e4;border-right:1px solid #e4e4e4; vertical-align: top">
   <tbody>
      <tr>
         <td
            style="background-color:#f8f8f8;padding-left:18px;border-bottom:1px solid #e4e4e4;border-top:1px solid #e4e4e4;border-top-left-radius: 10px;">
         </td>
         <td valign="middle"
            style="padding:13px 10px 8px 0px;background-color:#f8f8f8;border-top:1px solid #e4e4e4;border-bottom:1px solid #e4e4e4">
            <table style="width: 100%; border-collapse: collapse; border: 0; vertical-align: middle">
               <tr>
                  <td style="text-align: left"> <img src="https://rms-hexamatics.id/storage/uploads/logos/XV9ti2PBUtjn1x59LzS9ADi9otamooZcip6QJsGy.png" style="width:200px" alt="BNI46"
                     border="0">
                  </td>
               </tr>
            </table>
         </td>
         <td
            style="background-color:#f8f8f8;padding-right:18px;border-top:1px solid #e4e4e4;border-bottom:1px solid #e4e4e4;border-top-right-radius: 10px;">
         </td>
      </tr>
      <tr>
         <td style="padding-left:18px"></td>
         <td style="padding:18px 0px 12px 0px;vertical-align:top;border-bottom:1px solid #e4e4e4">
            <div>
               <div>
                  <div style="color:#737373;">
                     <h4>Halo Admin Rms-hexamatic,</h4>
                  </div>
               </div>
               <p>This is notification for ' . $field . ' of employee will expired at ' . $date . '</p>
               <table style="border-collapse: separate; border-spacing: 0; width: 100%; border: 2px solid #dddddd; border-radius: 5px;padding:10px">
                  <tr>
                     <th style="text-align: left; padding: 8px; border-top-left-radius: 5px;width:30%">Emplyee ID</th>
                     <td style="text-align: left; padding: 8px;width:2%">:</td>
                     <td style="text-align: left; padding: 8px;">' . $employee_id . '</td>
                  </tr>
                  <tr>
                     <th style="text-align: left; padding: 8px; border-top-right-radius: 5px;width:30%">Eployee Name</th>
                     <td style="text-align: left; padding: 8px;width:2%">:</td>
                     <td style="text-align: left; padding: 8px;">' . $full_name . '</td>
                  </tr>
               </table>
               <br>
               <div>
                  <p>
                     Thank You
                  </p>
               </div>
            </div>
   </tbody>
</table>
</div>
</div>
</td>
</tr>
</tbody>
</table>
</div>';
    return $pesan;
}
