<?php

namespace App\Support;

use Carbon\Carbon;

class Format
{
    public static function rupiah($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }

    public static function tanggal($tanggal): string
    {
        return $tanggal ? Carbon::parse($tanggal)->format('d-m-Y') : '-';
    }
}
