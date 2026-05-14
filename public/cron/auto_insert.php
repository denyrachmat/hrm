<?php
// Jalan craete tagihan tiap hari jam 8
date_default_timezone_set('Asia/Jakarta');
ini_set('date.timezone', 'Asia/Jakarta');
include 'koneksi.php';

// mulai cron
$pesan = "✅✅ [CRON AUTO INSERT ABSEN] ✅✅\n";
$pesan .= "Mulai Cron :  " . date('Y-m-d H:i:s') . "\n";
sendTelegramNotification($pesan);

$dayOfWeek = date('N');
if ($dayOfWeek >= 6) { // Saturday (6) or Sunday (7)
    $pesan .= "Hari ini adalah hari libur (Sabtu/Minggu). Tidak perlu melakukan absen.\n";
    sendTelegramNotification($pesan);
    exit();
}
// cek off day
$tgl = date('Y-m-d');
$queryOffDay = "SELECT * FROM offdays WHERE date ='$tgl'";
$dataOffDay = mysqli_query($koneksi, $queryOffDay);

// jika ada
if (mysqli_num_rows($dataOffDay) > 0) {
    $pesan .= "Hari ini adalah hari libur. Tidak perlu melakukan absen.\n";
    sendTelegramNotification($pesan);
    exit();
}

// cek sudah absen / belum
$created = date('Y-m-d H:i:s');


$query = "SELECT * FROM attendances WHERE employee_id = 1 and date ='$tgl'";
$dataX = mysqli_query($koneksi, $query);


if ($dataX->num_rows < 1) {
        try {
            mysqli_query($koneksi, "INSERT INTO attendances
            (employee_id,date,clock_in,clock_out,latitude,longitude,file_attachment,image_clock_out,is_present,description,selisih,activity,point,created_at,updated_at)
            VALUES
            ('1', '$tgl','08:01:40','18:41:28','-6.4685122','106.7569285',null,null,'Yes','Tepat Waktu',0,'Update aplikasi rms dan marsweb',5,'$created','$created')");

            $pesan = "✅✅ [CRON AUTO INSERT ABSEN] ✅✅\n";
            $pesan .= "Data absen berhasil di tambahkan!\n";
            sendTelegramNotification($pesan);
            echo "Berhasil insert data absen\n";
        } catch (Throwable $t) {
            $pesan = "❌🚫 [CRON AUTO INSERT ABSEN] 🚫❌\n";
            $pesan .= "Ada error nih !\n";
            $pesan .= "Error occurred:  " . $t->getMessage() . "\n";
            sendTelegramNotification($pesan);
        }
} else {
    $error_message = "⚠️⚠️ [CRON AUTO INSERT ABSEN] ⚠️⚠️\nSudah ada absen pada tanggal : " . $tgl . "";
    sendTelegramNotification($error_message);
}
$koneksi->close();

$pesan = "✅✅ [CRON AUTO INSERT ABSEN] ✅✅\n";
$pesan .= "Selesai Cron :  " . date('Y-m-d H:i:s') . "\n";
sendTelegramNotification($pesan);


function sendTelegramNotification($message)
{
    $botToken = "7151936034:AAGRt1nRqVOK3LBO0mnlwFpUW37J7-_qrbo";
    $chatId = "-1002033244755";

    $apiUrl = "https://api.telegram.org/bot$botToken/sendMessage";
    $params = [
        'chat_id' => $chatId,
        'text' => $message,
    ];

    $query = http_build_query($params);
    $url = $apiUrl . '?' . $query;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
