<?php

class GetKelas
{
    private $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }


    public function getConfigKelas()
    {

        $query = $this->ci->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'pilihan_kelas', 1);
        return $query->row()->konfigurasi_isi;
    }

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

    public function result()
    {
        return $this->get($this->getConfigKelas());
    }
}
