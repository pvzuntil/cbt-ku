<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Member_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['url'] = 'dashboard';
        $this->load->helper('form');
        $this->load->model('cbt_user_model');
        $this->load->model('cbt_user_pay_model');
        $this->load->model('cbt_tes_model');

        $data['nama'] = $this->access->get_nama();

        $data['post_max_size'] = ini_get('post_max_size');
        $data['upload_max_filesize'] = ini_get('upload_max_filesize');
        $data['waktu_server'] = date('Y-m-d H:i:s');

        $dir1 = './public/uploads/';
        $dir2 = './uploads/';

        $data['dir_public_uploads'] = 'Not Writeable';
        if (is_writable($dir1)) {
            $data['dir_public_uploads'] = 'Writeable';
        }

        $data['dir_uploads'] = 'Not Writeable';
        if (is_writable($dir2)) {
            $data['dir_uploads'] = 'Writeable';
        }

        $data['countPeserta'] = $this->cbt_user_model->countDashboard('user_id');
        $data['countPesertaAktif'] = $this->cbt_user_model->countDashboard('user_id', ['active', 1]);
        $data['countPesertaPayIsPay'] = $this->cbt_user_pay_model->countDashboard('id', ['status', 'allow']);
        $data['countPesertaPayIsWait'] = $this->cbt_user_pay_model->countDashboard('id', ['status', 'wait']);
        $data['countPesertaPayIsNope'] = $data['countPesertaAktif'] - $data['countPesertaPayIsPay'];
        $data['countTes'] = $this->cbt_tes_model->countDashboard('tes_id');

        $getPesertaPay = $this->db->query('select * from cbt_user_pay inner join cbt_user on cbt_user.user_id = cbt_user_pay.cbt_user_id where status = "allow"')->result();
        $getIdLomba = $this->db->query('select modul_id, modul_nama from cbt_modul')->result();
        $lombaYangDiIkuti = [
            'all' => 0,
        ];

        foreach ($getIdLomba as $idLomba) {
            $lombaYangDiIkuti[$idLomba->modul_id] = 0;
        }

        foreach ($getPesertaPay as $pesertaPay) {
            $ikutLomba = json_decode($pesertaPay->lomba);
            foreach ($ikutLomba as $lomba) {
                $lombaYangDiIkuti['all']++;
                $lombaYangDiIkuti[$lomba]++;
            }
        }

        $data['infoLomba'] = [
            'lomba'=> $getIdLomba,
            'count' => $lombaYangDiIkuti
        ];


		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'bayar_tarif', 1);
		if ($query->num_rows() > 0) {
			$data['bayar_tarif'] = $query->row()->konfigurasi_isi;
        }
    
		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'bayar_jenis', 1);
		if ($query->num_rows() > 0) {
			$data['bayar_jenis'] = $query->row()->konfigurasi_isi;
		}
        
        // var_dump($countTes);
        // die();
        $this->template->display_admin('manager/dashboard_view', 'Dashboard', $data);
    }

    function password()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('password-old', 'Password Lama', 'required|strip_tags');
        $this->form_validation->set_rules('password-new', 'Password Baru', 'required|strip_tags');
        $this->form_validation->set_rules('password-confirm', 'Confirm Password', 'required|strip_tags');

        if ($this->form_validation->run() == TRUE) {
            $old = $this->input->post('password-old', TRUE);
            $new = $this->input->post('password-new', TRUE);
            $confirm = $this->input->post('password-confirm', TRUE);

            $username = $this->access->get_username();

            if ($this->users_model->get_user_count($username, $old) > 0) {
                if ($new == $confirm) {
                    $this->users_model->change_password($username, $new);
                    $status['status'] = 1;
                    $status['error'] = '';
                } else {
                    $status['status'] = 0;
                    $status['error'] = 'Kedua password baru tidak sama';
                }
            } else {
                $status['status'] = 0;
                $status['error'] = 'Password Lama tidak Sesuai';
            }
        } else {
            $status['status'] = 0;
            $status['error'] =
                array_values($this->form_validation->error_array())[0];
        }

        echo json_encode($status);
    }
}
