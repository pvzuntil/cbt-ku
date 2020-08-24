<?php

class MLib
{
    private $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }
    public function getLomba($rawLomba)
    {
        $daftarLomba = '';
        foreach (json_decode($rawLomba) as $i => $pilihanLomba) {
            if ($i != 0) {
                $daftarLomba .= ', ';
            }

            $getLomba = $this->ci->cbt_lomba_model->get_by_kolom('modul_id', $pilihanLomba)->row();
            $daftarLomba .= ucfirst($getLomba->modul_nama);
        }

        return $daftarLomba;
    }

    public function getLombaHR($rawLomba)
    {
        $daftarLomba = '';
        foreach (json_decode($rawLomba) as $i => $pilihanLomba) {
            if ($i != 0) {
                $daftarLomba .= ' <span class="number"> ';
            }

            $getLomba = $this->ci->cbt_lomba_model->get_by_kolom('modul_id', $pilihanLomba)->row();
            $daftarLomba .= ucfirst($getLomba->modul_nama);
        }

        return $daftarLomba;
    }

    public function getLombaArray($rawLomba)
    {
        $daftarLomba = [];
        foreach (json_decode($rawLomba) as $i => $pilihanLomba) {
            $getLomba = $this->ci->cbt_lomba_model->get_by_kolom('modul_id', $pilihanLomba)->row();
            array_push($daftarLomba, ucfirst($getLomba->modul_nama));
        }

        return $daftarLomba;
    }
}
