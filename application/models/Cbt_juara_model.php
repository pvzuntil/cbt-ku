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

    function get_datatable($start, $rows, $search, $lomba, $kelas)
    {

        $this->db->select('user_firstname, user_detail, time_span, tes_duration_time, SUM(`cbt_tes_soal`.`tessoal_nilai`) AS nilai, TIMESTAMPDIFF(SECOND, `tesuser_creation_time`, `end_time`) as detik')
            ->where('cbt_tes.lomba = "' . $lomba . '" AND cbt_user.kelas = "' . $kelas . '"')
            ->from('cbt_tes_user')
            ->join('cbt_user', 'cbt_tes_user.tesuser_user_id = cbt_user.user_id')
            ->join('cbt_tes', 'cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id')
            ->join('cbt_tes_soal', 'cbt_tes_soal.tessoal_tesuser_id = cbt_tes_user.tesuser_id')
            ->group_by('cbt_tes_user.tesuser_id')
            ->order_by('nilai DESC, detik ASC')
            // ->limit($rows, $start);
            ->limit(6);
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
