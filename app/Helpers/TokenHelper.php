<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psy\Readline\Hoa\Console;

class TokenHelper
{
    public static function generateJWTToken($id, $employee_id, $user_email)
    {
        $alg = "HS256";
        $key = config('app.JWT_SECRET_KEY');

        // Mendapatkan waktu saat ini
        $current_time = time();

        // Mendapatkan waktu 1 bulan dari sekarang (dalam detik)
        $one_month_in_seconds = 30 * 24 * 60 * 60;

        // Menghitung waktu kadaluarsa
        $expired_time = $current_time + $one_month_in_seconds;

        // Menyiapkan payload
        $payload = [
            'id'           => $id,
            'employee_id'  => $employee_id,
            'email'        => $user_email,
            'iat'          => $current_time,
            'expired_at'   => $expired_time
        ];

        return JWT::encode($payload, $key, $alg);
    }

    public static function decodeJWTBearerToken($token)
    {
        try {
            $alg = "HS256";
            $key = config('app.JWT_SECRET_KEY');
            return JWT::decode($token, new Key($key, $alg));
        } catch (\Throwable $th) {
            return false;
        }
    }

    public static function checkExpiredToken($token)
    {
        $decoded = self::decodeJWTBearerToken($token);
        logger("Decoded token:", ['decoded' => $decoded]);
        if (!$decoded) {
            return true; // Token tidak valid, dianggap expired
        }

        $current_time = time();
        return $current_time > $decoded->expired_at;
    }
}
