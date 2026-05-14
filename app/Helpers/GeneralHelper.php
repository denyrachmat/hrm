<?php

use Illuminate\Support\Facades\DB;

function getCompany()
{
    $data = DB::table('companies')
        ->select('companies.*')
        ->first();
    return $data;
}

function currency($angka)
{
    $hasil_currency = number_format($angka, 0, ',', '.');
    return $hasil_currency;
}

function getNameEmployee($id)
{
    return DB::table('employees')
        ->where('employees.id', $id)
        ->first();
}

function convertDate($date)
{
    $dateString = $date;
    $dateTime = DateTime::createFromFormat('Y-m', $dateString);
    $formattedDate = $dateTime->format('M Y');
    return $formattedDate;
}

function convertToWords($number)
{
    $words = "";
    $units = array("", "Thousand", "Million", "Billion", "Trillion");

    $number = number_format($number, 0, '.', ',');

    $parts = explode(',', $number);

    $count = count($parts);

    if ($count > count($units)) {
        return "Value too large";
    }

    for ($i = 0; $i < $count; $i++) {
        $part = (int)$parts[$i];

        if ($part != 0) {
            $words .= convertThreeDigitToWords($part) . " " . $units[$count - $i - 1] . " ";
        }
    }

    return $words;
}

function convertThreeDigitToWords($number)
{
    $words = "";
    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine");
    $teens = array("Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");

    $hundreds = (int)($number / 100);
    $tensAndOnes = $number % 100;

    if ($hundreds > 0) {
        $words .= $ones[$hundreds] . " Hundred ";
    }

    if ($tensAndOnes > 0) {
        if ($tensAndOnes < 10) {
            $words .= $ones[$tensAndOnes];
        } elseif ($tensAndOnes < 20) {
            $words .= $teens[$tensAndOnes - 10];
        } else {
            $words .= $tens[(int)($tensAndOnes / 10)];
            if ($tensAndOnes % 10 > 0) {
                $words .= " " . $ones[$tensAndOnes % 10];
            }
        }
    }

    return $words;
}
