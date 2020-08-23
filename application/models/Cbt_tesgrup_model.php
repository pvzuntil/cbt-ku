<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cbt_tesgrup_model extends CI_Model
{
    public $table = 'cbt_tesgrup';

    function __construct()
    {
        parent::__construct();
    }

    function save($data)
    {
        $this->db->insert($this->table, $data);
    }

    function delete($kolom, $isi)
    {
        $this->db->where($kolom, $isi)
            ->delete($this->table);
    }

    function update($kolom, $isi, $data)
    {
        $this->db->where($kolom, $isi)
            ->update($this->table, $data);
    }

    function count_by_kolom($kolom, $isi)
    {
        $this->db->select('COUNT(*) AS hasil')
            ->where($kolom, $isi)
            ->from($this->table);
        return $this->db->get();
    }

    function count_by_tes_and_group($tes, $group)
    {
        $this->db->select('COUNT(*) AS hasil')
            ->where('(tstgrp_tes_id="' . $tes . '" AND tstgrp_grup_id="' . $group . '" )')
            ->from($this->table);
        return $this->db->get();
    }

    function get_by_kolom($kolom, $isi)
    {
        $this->db->where($kolom, $isi)
            ->from($this->table);
        return $this->db->get();
    }

    function get_by_kolom_limit($kolom, $isi, $limit)
    {
        $this->db->where($kolom, $isi)
            ->from($this->table)
            ->limit($limit);
        return $this->db->get();
    }

    function get_by_tanggal($tglawal, $tglakhir)
    {
        $this->db->where('(DATE(tes_begin_time)>="' . $tglawal . '" AND DATE(tes_begin_time)<="' . $tglakhir . '")')
            ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
            ->order_by('tes_begin_time ASC, tes_nama ASC')
            ->from($this->table);
        return $this->db->get();
    }

    function get_by_tanggal_and_grup($tglawal, $tglakhir, $grup_id)
    {
        $this->db->where('(DATE(tes_begin_time)>="' . $tglawal . '" AND DATE(tes_begin_time)<="' . $tglakhir . '" AND kelas="' . $grup_id . '")')
            ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
            ->order_by('tes_begin_time ASC, tes_nama ASC')
            ->from($this->table);
        return $this->db->get();
    }

    function get_datatable($start, $rows, $kelas, $lomba)
    {
        // if ($mataLomba == 'all') {
        //     $this->db->where('(tstgrp_grup_id="' . $grup_id . '")');
        // } else {
        //     $this->db->where('(tstgrp_grup_id="' . $grup_id . '" AND cbt_tesgrup.lomba = "' . $mataLomba . '")');
        // }
        // where('(tstgrp_grup_id="' . $grup_id . '" AND tes_begin_time<=NOW() AND tes_end_time>=NOW())')
        // $this->db->where('(tstgrp_grup_id="' . $grup_id . '")');
        $queryAnd = '';
        foreach ($lomba as $i => $lom) {
            $queryAnd .= ' modul_id = ' . $lom;
            if (count($lomba) - 1 != $i) {
                $queryAnd .= ' OR ';
            }
        }

        $this->db
            ->from($this->table)
            ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
            ->where('kelas = ' . $kelas . ' AND (' . $queryAnd . ')')
            // ->join('cbt_tes_user', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes_user.tesuser_tes_id', 'left')
            ->order_by('tes_begin_time ASC, tes_nama ASC')
            ->limit($rows, $start);
        return $this->db->get();
    }

    function get_datatable_count($kelas, $lomba)
    {
        $queryAnd = '';
        foreach ($lomba as $i => $lom) {
            $queryAnd .= ' modul_id = ' . $lom;
            if (count($lomba) - 1 != $i) {
                $queryAnd .= ' OR ';
            }
        }

        $this->db->select('COUNT(*) AS hasil')
            ->where('kelas = ' . $kelas . ' AND (' . $queryAnd . ')')
            // ->where('(tstgrp_grup_id="' . $grup_id . '" AND tes_begin_time<=NOW() AND tes_end_time>=NOW())')
            // ->where('(tstgrp_grup_id="' . $grup_id . '" AND cbt_tesgrup.lomba = "' . $mataLomba . '")')
            // ->where('(tstgrp_grup_id="' . $grup_id . '")')
            ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
            ->from($this->table);
        return $this->db->get();
    }

    public function getLomba($id)
    {
        $id_modul = $this->db->select('*')->from($this->table)->where('tstgrp_tes_id', $id)->group_by('modul_id')->get()->row()->modul_id;
        $namaLomba = $this->db->select('*')->from('cbt_modul')->where('modul_id', $id_modul)->get()->row()->modul_nama;
        return '<span class="badge badge-primary m-1 badge-lg">' . $namaLomba . '</span>';
    }

    public function getLombaRaw($id)
    {
        $id_modul = $this->db->select('*')->from($this->table)->where('tstgrp_tes_id', $id)->group_by('modul_id')->get()->row()->modul_id;
        return $id_modul;
    }

    public function getKelasRaw($id)
    {
        $daftarKelas = $this->db->select('*')->from($this->table)->where('tstgrp_tes_id', $id)->get()->result();
        $dataKelas = [];
        foreach ($daftarKelas as $kelas) {
            array_push($dataKelas, $kelas->kelas);
        }

        return $dataKelas;
    }

    public function getKelas($id)
    {
        $daftarKelas = $this->db->select('*')->from($this->table)->where('tstgrp_tes_id', $id)->get()->result();
        $dataKelas = [];
        foreach ($daftarKelas as $kelas) {
            array_push($dataKelas, $kelas->kelas);
        }

        $badgeKelas = '<span class="badge badge-success m-1 badge-lg">Kelas ';
        foreach ($dataKelas as $i => $kelas) {
            $badgeKelas .= $kelas;
            if ((count($dataKelas) - 1) != $i) {
                $badgeKelas .= ',';
            }
        }
        $badgeKelas .= '</span>';

        return $badgeKelas;
    }
}
