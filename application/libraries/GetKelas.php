<?php

class GetKelas
{
    // private $dataKelas;

    // public function __construct($dataKelas)
    // {
    //     $this->dataKelas = json_decode($dataKelas);
    // }

    public function get($dataKelas)
    {
        $dataKelas = json_decode($dataKelas);

        $data = [];
        foreach ($dataKelas as $kelas) {
            switch ($kelas) {
                case 'sd':
                    $daftarKelas = [1, 2, 3, 4, 5, 6];
                    foreach ($daftarKelas as $da) {
                        array_push($data, $da);
                    }
                    break;
                case 'smp':
                    $daftarKelas = [7, 8, 9];
                    foreach ($daftarKelas as $da) {
                        array_push($data, $da);
                    }
                    break;
                case 'sma':
                    $daftarKelas = [10, 11, 12];
                    foreach ($daftarKelas as $da) {
                        array_push($data, $da);
                    }
                    break;
            }
        }

        return $data;
    }
}
