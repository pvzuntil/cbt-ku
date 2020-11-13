<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cbt_juara_model extends CI_Model
{
    public $table = 'cbt_juara';
    // public $table = ''; XXX

    function __construct()
    {
        parent::__construct();
    }

    function save($data)
    {
        $this->db->insert('cbt_juara', $data);
        return $this->db->insert_id();
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

    function get_laporan()
    {
        return $this->db->select('*')->from('cbt_juara')->get();
    }

    function get_datatable($start, $rows, $search, $lomba, $kelas, $salin = '', $jenis = '')
    {
        // ->limit($rows, $start);

        $getTes = $this->db->select('*')
            ->from('cbt_tesgrup')
            ->where('cbt_tesgrup.modul_id = "' . $lomba . '" AND cbt_tesgrup.kelas = "' . $kelas . '" AND cbt_tesgrup.type = "' . $jenis . '"');
            
        $idTes = $getTes->get()->row()->tstgrp_tes_id ?? 00;

        $this->db->select('user_firstname, user_detail, time_span, tes_duration_time, SUM(`cbt_tes_soal`.`tessoal_nilai`) AS nilai, TIMESTAMPDIFF(SECOND, `tesuser_creation_time`, `end_time`) as detik, user_id')
            ->where('cbt_tes.tes_id = "' . $idTes . '" AND cbt_user.kelas = "'.$kelas.'"')
            ->from('cbt_tes_user')
            ->join('cbt_user', 'cbt_tes_user.tesuser_user_id = cbt_user.user_id')
            ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
            ->join('cbt_tes_soal', 'cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id')
            ->group_by('cbt_tes_user.tesuser_id')
            ->order_by('nilai DESC, detik ASC');

        if ($salin == 'salin') {
            $this->db->limit(6);
        }
        return $this->db->get();
    }

    function get_datatable_count($search, $lomba)
    {
        $sql = '';

        if ($lomba != 'all') {
            $sql = 'lomba = "' . $lomba . '"';
        }

        $this->db->select('COUNT(*) as hasil')
            ->where('( ' . $sql . ' )')
            ->from('cbt_tes_user')
            ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
            ->join('cbt_tes_soal', 'cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id');
        return $this->db->get();
    }
}
