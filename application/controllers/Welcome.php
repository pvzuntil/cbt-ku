<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	private $kelompok = 'ujian';
	private $url = 'welcome';

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbt_konfigurasi_model');
		$this->load->library('access_tes');
		$this->load->library('user_agent');
		$this->load->model('cbt_konfigurasi_model');
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_user_model');
		$this->load->library('session');
		$this->load->model('cbt_juara_model');
		$this->load->model('cbt_lomba_model');


		$this->load->library('Send_email');
		$this->load->library('GetKelas');
	}

	public function index()
	{
		// ========================================
		$data['url'] = $this->url;
		$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));

		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'tutup_daftar', 1);
		$data['tutup_daftar'] = 'ya';
		if ($query->num_rows() > 0) {
			$data['tutup_daftar'] = $query->row()->konfigurasi_isi;
		}

		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'pilihan_kelas', 1);
		if ($query->num_rows() > 0) {
			$data['pilihan_kelas'] = $query->row()->konfigurasi_isi;
		}

		// $getKelas = new GetKelas();
		$data['data_kelas'] = $this->getkelas->get($data['pilihan_kelas']);
		// dd($data['data_kelas']);

		$get_laporan = $this->cbt_juara_model->get_laporan();
		$data['pengumuman'] = $get_laporan->row();

		$query_group = $this->cbt_lomba_model->get_all();
		if ($query_group->num_rows() > 0) {
			$select = '';
			$query_group = $query_group->result();
			foreach ($query_group as $temp) {
				$select = $select . '<option value="' . $temp->modul_id . '">' . $temp->modul_nama . '</option>';
			}
		} else {
			$select = '<option value="kosong" selected>-- Tidak ada Lomba --</option>';
		}
		$data['select_lomba'] = $select;

		if ($this->agent->is_browser()) {
			if ($this->agent->browser() == 'Internet Explorer') {
				$this->template->display_user('blokbrowser_view', 'Browser yang didukung');
			} else {
				$akses_cbt = 1;
				if ($this->agent->is_mobile()) {
					$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_mobile_lock_xambro', 1);
					if ($query->row()->konfigurasi_isi == "ya") {
						$agent = $this->agent->agent_string();
						if (strpos($agent, 'ZYACBT') == false) {
							$akses_cbt = 0;
						}
					}
				}
				if ($akses_cbt == 1) {
					if (!$this->access_tes->is_login()) {
						$data['link_login_operator'] = "tidak";
						$query_konfigurasi = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'link_login_operator', 1);
						$query_maintenance = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'main_mode', 1);
						if ($query_konfigurasi->num_rows() > 0) {
							$data['link_login_operator'] = $query_konfigurasi->row()->konfigurasi_isi;
						}

						if (isset($_COOKIE['dev'])) {
							$dev = true;
						} else {
							$dev = false;
						}

						if ($query_maintenance->row()->konfigurasi_isi == 'ya' && !$dev) {
							$this->load->view('/main.php');
						} else {
							$this->template->display_user($this->kelompok . '/welcome_view', 'Selamat Datang', $data);
						}
					} else {
						redirect('tes_dashboard');
					}
				} else {
					$this->template->display_user('lockmobile_view', 'Exam Browser');
				}
			}
		} else {
			$this->template->display_user('blokbrowser_view', 'Browser yang didukung');
		}
	}

	function login()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Email', 'required|strip_tags');
		$this->form_validation->set_rules('password', 'Password', 'required|strip_tags');
		if ($this->form_validation->run() == TRUE) {
			$this->form_validation->set_rules('token', 'token', 'callback_check_login');
			if ($this->form_validation->run() == FALSE) {
				//Jika login gagal
				$status['status'] = 0;
				$status['error'] = array_values($this->form_validation->error_array())[0];
			} else {
				//Jika sukses
				$status['status'] = 1;
			}
		} else {
			$status['status'] = 0;
			$status['error'] = array_values($this->form_validation->error_array())[0];
		}
		echo json_encode($status);
	}

	function logout()
	{
		$this->access_tes->logout();
		redirect('welcome');
	}

	function check_login()
	{
		$username = $this->input->post('username', TRUE);
		$password = $this->input->post('password', TRUE);

		$login = $this->access_tes->login($username, $password, $this->input->ip_address());
		if ($login == 1) {
			return TRUE;
		} else if ($login == 2) {
			$this->form_validation->set_message('check_login', 'Password yang dimasukkan salah');
			return FALSE;
		} else if ($login == 3) {
			$this->form_validation->set_message('check_login', 'Akun ini belum di aktivasi, silahkan aktivasi terlebih dahulu ! Cek juga folder spam email anda');
			return FALSE;
		} else {
			$this->form_validation->set_message('check_login', 'Email yang dimasukkan tidak dikenal');
			return FALSE;
		}
	}

	function tambah()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('tambah-email', 'Email', 'required|strip_tags|valid_emails');
		$this->form_validation->set_rules('tambah-password', 'Password', 'required|strip_tags|min_length[8]');
		$this->form_validation->set_rules('tambah-re-password', 'Konfirmasi password', 'required|strip_tags|min_length[8]|matches[tambah-password]');
		$this->form_validation->set_rules('tambah-nama', 'Nama Lengkap', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-detail', 'Nama Sekolah', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-kelas', 'Kelas', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-telepon', 'Nomer Telepon', 'required|strip_tags|numeric|min_length[10]');
		$this->form_validation->set_rules('tambah-lomba[]', 'Mata Lomba', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$randomNumber = rand(000001, 999999);
			$email = $this->input->post('tambah-email', true);
			$data['user_email'] = $email;
			$data['user_password'] = $this->input->post('tambah-password', true);
			$data['user_firstname'] = $this->input->post('tambah-nama', true);
			$data['user_detail'] = $this->input->post('tambah-detail', true);
			$data['telepon'] = $this->input->post('tambah-telepon', true);
			$data['kelas'] = $this->input->post('tambah-kelas', true);
			$data['lomba'] = json_encode($this->input->post('tambah-lomba', true));
			$data['active'] = 0;
			$data['kode'] = $randomNumber;

			if ($this->cbt_user_model->count_by_kolom('user_email', $data['user_email'])->row()->hasil > 0) {
				$status['status'] = 0;
				$status['pesan'] = 'Email sudah terpakai !';
			} else {

				$send = new Send_email();
				$send = $send->send($email, 'verif', [
					'randomNumber' => $randomNumber,
					'user_firstname' => $data['user_firstname']
				]);

				if ($send['status']) {
					$data['url_verif'] = $send['url'];
					$this->cbt_user_model->save($data);

					$status['status'] = 1;
					$status['pesan'] = 'Berhasil mendaftar, silahkan cek email anda untuk memverifikasi akun';
				} else {
					$status['status'] = 0;
					$status['pesan'] = 'Silahkan periksa koneksi internet anda !';
				}
			}
		} else {
			$status['status'] = 0;
			$status['pesan'] = array_values($this->form_validation->error_array())[0];
		}

		echo json_encode($status);
	}

	function verifikasi($param = null)
	{

		$stepOne = base64_decode($param);
		$stepTwo = base64_decode($stepOne);

		$explodeParam = explode(';', $stepTwo);


		$email = $explodeParam[1];
		$kode = $explodeParam[2];

		$get_verif = $this->cbt_user_model->get_verif($email, $param);

		if ($get_verif) {

			if ($this->cbt_user_model->count_by_kolom('user_email', $email)->row()->hasil > 0 && $this->cbt_user_model->count_by_kolom('kode', $kode)->row()->hasil > 0) {
				$this->cbt_user_model->activation($email);
				$this->session->set_flashdata('verif', 'Akun anda berhasil diverifikasi, silahkan login untuk melanjutkan !');
				return redirect('welcome');
			}
		}

		return redirect('welcome');
	}

	function request_lupa()
	{
		$email = $this->input->post('lupa-email', true);

		$this->load->library('form_validation');

		$this->form_validation->set_rules('lupa-email', 'Email', 'required|strip_tags|valid_emails');
		if ($this->form_validation->run() == TRUE) {
			$isEmail = $this->cbt_user_model->get_by_username($email);

			if ($isEmail == false) {
				$status['status'] = 0;
				$status['error'] = 'Email tidak ditemukan !';
			} else if ($isEmail != false && $isEmail->active == 0) {
				$status['status'] = 0;
				$status['error'] = 'Email anda belum diaktivasi, silahkan aktavasi terlebih dahulu ! dan pastikan cek juga folder spam pada email anda.';
			} else {
				$send = new Send_email();
				$send  = $send->send($email, 'lupa', [
					'user_firstname' => $isEmail->user_firstname,
					'kode' => $isEmail->kode,
					'old' => $isEmail->user_password
				]);

				if ($send['status']) {
					$this->cbt_user_model->update('user_email', $email, [
						'url_lupa' => $send['url']
					]);

					$status['status'] = 1;
					$status['error'] = 'Permintaan anda sudah terkirim, silahkan cek email anda !';
				}
			}
			// echo $isEmail;
			// $status['status'] = 1;
		} else {
			$status['status'] = 0;
			$status['error'] = array_values($this->form_validation->error_array())[0];
		}
		// echo json_encode($isEmail);
		echo json_encode($status);
	}

	function reset($param = null)
	{
		if ($param == '') {
			return redirect('welcome');
		}

		$ceklink = $this->cbt_user_model->count_by_kolom('url_lupa', $param);

		$data['url'] = $this->url;

		$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));
		if ($ceklink->row()->hasil == 0) {
			$data['exp'] = true;

			return $this->template->display_user($this->kelompok . '/reset_view', 'Selamat Datang', $data);
		}

		$data['exp'] = false;
		$stepOne = base64_decode($param);
		$stepTwo = base64_decode($stepOne);
		$passdata = explode(';', $stepTwo);


		$email = $passdata[1];
		$data['email'] = $email;


		return $this->template->display_user($this->kelompok . '/reset_view', 'Selamat Datang', $data);
	}

	function do_reset()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'required|strip_tags|valid_emails');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
		$this->form_validation->set_rules('password-konfirmasi', 'Password konfirmasi', 'required|min_length[8]|matches[password]');

		$email = $this->input->post('email', true);
		$pass = $this->input->post('password', true);


		if ($this->form_validation->run() == TRUE) {
			$this->cbt_user_model->update('user_email', $email, [
				'user_password' => $pass,
				'url_lupa' => NULL
			]);

			// $this->session->set_flashdata('verif', 'Password anda berhasil diubah, silahkan login untuk melanjutkan !');
			$status['status'] = 1;
			$status['pesan'] = 'Password anda berhasil diubah, silahkan login untuk melanjutkan !';
			// return redirect('welcome');
		} else {
			$status['status'] = 0;
			$status['pesan'] = array_values($this->form_validation->error_array())[0];
		}
		echo json_encode($status);
	}

	function dev($param)
	{
		if ($param == 'untillNess1013===') {
			setcookie("dev", true, time() + 30 * 24 * 60 * 60, '/');
			echo 'masuk';
		}

		if ($param == 'untillNess1013___') {
			setcookie("dev", true, time() - 3600, '/');
			echo 'keluar';
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
