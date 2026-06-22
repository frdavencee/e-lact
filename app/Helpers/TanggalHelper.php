<?php

namespace App\Helpers;

if (!function_exists('angkaKeHuruf')) {
    function angkaKeHuruf(int $angka): string
    {
        $satuan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
        if ($angka < 12) return $satuan[$angka];
        if ($angka < 20) return angkaKeHuruf($angka - 10) . ' Belas';
        if ($angka < 100) {
            $puluhan = intdiv($angka, 10);
            $sisa = $angka % 10;
            return angkaKeHuruf($puluhan) . ' Puluh' . ($sisa ? ' ' . angkaKeHuruf($sisa) : '');
        }
        if ($angka < 200) return 'Seratus' . ($angka > 100 ? ' ' . angkaKeHuruf($angka - 100) : '');
        if ($angka < 1000) {
            $ratusan = intdiv($angka, 100);
            $sisa = $angka % 100;
            return angkaKeHuruf($ratusan) . ' Ratus' . ($sisa ? ' ' . angkaKeHuruf($sisa) : '');
        }
        if ($angka < 2000) return 'Seribu' . ($angka > 1000 ? ' ' . angkaKeHuruf($angka - 1000) : '');
        if ($angka < 1000000) {
            $ribuan = intdiv($angka, 1000);
            $sisa = $angka % 1000;
            return angkaKeHuruf($ribuan) . ' Ribu' . ($sisa ? ' ' . angkaKeHuruf($sisa) : '');
        }
        if ($angka < 1000000000) {
            $jutaan = intdiv($angka, 1000000);
            $sisa = $angka % 1000000;
            return angkaKeHuruf($jutaan) . ' Juta' . ($sisa ? ' ' . angkaKeHuruf($sisa) : '');
        }
        return (string)$angka;
    }
}

if (!function_exists('tanggalKeHuruf')) {
    function tanggalKeHuruf($date): array
    {
        $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        return [
            'nama_hari' => $hari[$date->dayOfWeek] ?? '',
            'tanggal' => angkaKeHuruf((int)$date->format('d')),
            'bulan' => $bulan[(int)$date->format('m')] ?? '',
            'tahun' => angkaKeHuruf((int)$date->format('Y')),
        ];
    }
}
