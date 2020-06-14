<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cbt_user_model extends CI_Model
{
    public $table = 'cbt_user';

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

    function get_by_kolom($kolom, $isi)
    {
        $this->db->select('user_id,user_grup_id,user_name,user_password,user_email,user_firstname,user_detail,user_regdate, telepon, active, kelas, lomba')
            ->where($kolom, $isi)
            ->from($this->table);
        return $this->db->get();
    }

    function get_by_kolom_limit($kolom, $isi, $limit)
    {
        $this->db->select('user_id,user_grup_id,user_name,user_password,user_email,user_firstname,user_detail,user_regdate, telepon, kelas, lomba')
            ->where($kolom, $isi)
            ->from($this->table)
            ->limit($limit);
        return $this->db->get();
    }

    function count_by_username_password($username, $password)
    {
        $this->db->select('COUNT(*) AS hasil')
            ->where('(user_email="' . $username . '" AND user_password="' . $password . '")')
            ->from($this->table);
        return $this->db->get()->row()->hasil;
    }

    function get_by_username($username)
    {
        $this->db->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
            ->where('user_email', $username)
            ->limit(1);
        $query = $this->db->get($this->table);
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    function get_datatable($start, $rows, $kolom, $isi, $group)
    {
        $query = '';
        if ($group != 'semua') {
            $query = 'AND user_grup_id=' . $group;
        }
        $this->db
            ->where('(' . $kolom . ' LIKE "%' . $isi . '%" ' . $query . ' OR user_email LIKE "%' . $isi . '%")')
            ->from($this->table)
            ->order_by('user_regdate', 'ASC')
            ->limit($rows, $start);
        return $this->db->get();
    }

    function get_datatable_count($kolom, $isi, $group)
    {
        $query = '';
        if ($group != 'semua') {
            $query = 'AND user_grup_id=' . $group;
        }
        $this->db->select('COUNT(*) AS hasil')
            ->where('(' . $kolom . ' LIKE "%' . $isi . '%" ' . $query . ')')
            ->from($this->table);
        return $this->db->get();
    }

    /**
     * export data user yang belum mengerjakan
     */
    function get_by_tes_group_urut_tanggal($tes_id, $grup_id, $urutkan, $tanggal, $keterangan)
    {
        $sql = 'tes_begin_time>="' . $tanggal[0] . '" AND tes_end_time<="' . $tanggal[1] . '" AND tesuser_id IS NULL';

        if ($tes_id != 'semua') {
            $sql = $sql . ' AND tes_id="' . $tes_id . '"';
        }
        if ($grup_id != 'semua') {
            $sql = $sql . ' AND user_grup_id="' . $grup_id . '"';
        }
        $order = '';
        if ($urutkan == 'nama') {
            $order = 'user_firstname ASC';
        } else if ($urutkan == 'waktu') {
            $order = 'tes_begin_time DESC';
        } else {
            $order = 'tes_id ASC';
        }

        if (!empty($keterangan)) {
            $sql = $sql . ' AND user_detail LIKE "%' . $keterangan . '%"';
        }

        $this->db->select('cbt_tes.*,cbt_user_grup.grup_nama, cbt_tes.*, cbt_user.*, "0" AS nilai, "Belum mengerjakan" AS tesuser_creation_time')
            ->where('( ' . $sql . ' )')
            ->from($this->table)
            ->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
            ->join('cbt_tesgrup', 'cbt_tesgrup.tstgrp_grup_id = cbt_user_grup.grup_id')
            ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
            ->join('cbt_tes_user', '(cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id) AND (cbt_tes_user.tesuser_user_id = cbt_user.user_id)', 'left')
            ->order_by($order);
        return $this->db->get();
    }

    /**
     * datatable untuk hasil tes yang belum mengerjakan
     *
     */
    function get_datatable_hasiltes($start, $rows, $tes_id, $grup_id, $urutkan, $tanggal, $keterangan)
    {
        $sql = 'tes_begin_time>="' . $tanggal[0] . '" AND tes_end_time<="' . $tanggal[1] . '" AND tesuser_id IS NULL';

        if ($tes_id != 'semua') {
            $sql = $sql . ' AND tes_id="' . $tes_id . '"';
        }
        if ($grup_id != 'semua') {
            $sql = $sql . ' AND user_grup_id="' . $grup_id . '"';
        }
        $order = '';
        if ($urutkan == 'nama') {
            $order = 'user_firstname ASC';
        } else if ($urutkan == 'waktu') {
            $order = 'tes_begin_time DESC';
        } else {
            $order = 'tes_id ASC';
        }

        if (!empty($keterangan)) {
            $sql = $sql . ' AND user_detail LIKE "%' . $keterangan . '%"';
        }

        $this->db->select('cbt_tes.*,cbt_user_grup.grup_nama, cbt_tes.*, cbt_user.*, "0" AS nilai')
            ->where('( ' . $sql . ' )')
            ->from($this->table)
            ->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
            ->join('cbt_tesgrup', 'cbt_tesgrup.tstgrp_grup_id = cbt_user_grup.grup_id')
            ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
            ->join('cbt_tes_user', '(cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id) AND (cbt_tes_user.tesuser_user_id = cbt_user.user_id)', 'left')
            ->order_by($order)
            ->limit($rows, $start);
        return $this->db->get();
    }

    function get_datatable_hasiltes_count($tes_id, $grup_id, $urutkan, $tanggal, $keterangan)
    {
        $sql = '(tes_begin_time>="' . $tanggal[0] . '" AND tes_end_time<="' . $tanggal[1] . '") AND tesuser_id IS NULL';

        if ($tes_id != 'semua') {
            $sql = $sql . ' AND tes_id="' . $tes_id . '"';
        }
        if ($grup_id != 'semua') {
            $sql = $sql . ' AND user_grup_id="' . $grup_id . '"';
        }

        if (!empty($keterangan)) {
            $sql = $sql . ' AND user_detail LIKE "%' . $keterangan . '%"';
        }

        $this->db->select('COUNT(*) AS hasil')
            ->where('( ' . $sql . ' )')
            ->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
            ->join('cbt_tesgrup', 'cbt_tesgrup.tstgrp_grup_id = cbt_user_grup.grup_id')
            ->join('cbt_tes', 'cbt_tesgrup.tstgrp_tes_id = cbt_tes.tes_id')
            ->join('cbt_tes_user', '(cbt_tes_user.tesuser_tes_id = cbt_tes.tes_id) AND (cbt_tes_user.tesuser_user_id = cbt_user.user_id)', 'left')
            ->from($this->table);
        return $this->db->get();
    }

    function activation($email)
    {
        $this->db->where('user_email', $email)
            ->update('cbt_user', ['active' => 1]);

        $this->db->where('user_email', $email)
            ->update('cbt_user', ['url_verif' => NULL]);
    }

    function get_verif($email, $url)
    {
        $get_email = $this->count_by_kolom('user_email', $email);
        $get_url = $this->count_by_kolom('url_verif', $url);

        if ((int) $get_email->row()->hasil > 0 && (int) $get_url->row()->hasil > 0) {
            return true;
        }

        return false;
    }

    function get_data_export($groupName)
    {
        $data = $this->db->select('user_id,user_grup_id,user_name,user_password,user_email,user_firstname,user_detail,user_regdate, telepon, active, grup_nama, kelas, lomba');

        if ($groupName != 'semua') {
            $data->where('user_grup_id', $groupName);
        }

        $data->join('cbt_user_grup', 'cbt_user.user_grup_id = cbt_user_grup.grup_id')
            ->from($this->table)
            ->order_by('user_regdate', 'ASC');
        return $this->db->get();
    }

    function get_all_user()
    {
        $data = $this->db->select('user_id, user_firstname, status, user_email')
            ->from($this->table)
            ->where('cbt_user.active = 1')
            ->join('cbt_user_pay', 'cbt_user.user_id = cbt_user_pay.cbt_user_id', 'left');
        return  $this->db->get();
    }
}
