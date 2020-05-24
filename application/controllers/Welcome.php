<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ZYA CBT
 * Achmad Lutfi
 * achmdlutfi@gmail.com
 * achmadlutfi.wordpress.com
 */
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
	}

	public function index()
	{


		// ========================================
		$data['url'] = $this->url;
		$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));

		$query_group = $this->cbt_user_grup_model->get_group();

		if ($query_group->num_rows() > 0) {
			$select = '';
			$query_group = $query_group->result();
			foreach ($query_group as $temp) {
				$select = $select . '<option value="' . $temp->grup_id . '">' . $temp->grup_nama . '</option>';
			}
		} else {
			$select = '<option value="100000">KOSONG</option>';
		}
		$data['select_group'] = $select;

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
						if ($query_konfigurasi->num_rows() > 0) {
							$data['link_login_operator'] = $query_konfigurasi->row()->konfigurasi_isi;
						}
						$this->template->display_user($this->kelompok . '/welcome_view', 'Selamat Datang', $data);
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
				$status['error'] = validation_errors();
			} else {
				//Jika sukses
				$status['status'] = 1;
			}
		} else {
			$status['status'] = 0;
			$status['error'] = validation_errors();
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
			$this->form_validation->set_message('check_login', 'Akun ini belum di aktivasi, silahkan aktivasi terlebih dahulu !');
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
		$this->form_validation->set_rules('tambah-password', 'Password', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-nama', 'Nama Lengkap', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-detail', 'Nama Sekolah', 'required|strip_tags|max_length[30]');
		$this->form_validation->set_rules('tambah-group', 'Level', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$randomNumber = rand(000001, 999999);
			$email = $this->input->post('tambah-email', true);
			$data['user_email'] = $email;
			$data['user_password'] = $this->input->post('tambah-password', true);
			$data['user_firstname'] = $this->input->post('tambah-nama', true);
			$data['user_detail'] = $this->input->post('tambah-detail', true);
			$data['user_grup_id'] = $this->input->post('tambah-group', true);
			$data['active'] = 0;
			$data['kode'] = $randomNumber;

			if ($this->cbt_user_grup_model->count_by_kolom('grup_id', $data['user_grup_id'])->row()->hasil > 0) {
				if ($this->cbt_user_model->count_by_kolom('user_email', $data['user_email'])->row()->hasil > 0) {
					$status['status'] = 0;
					$status['pesan'] = 'Email sudah terpakai !';
				} else {
					$this->cbt_user_model->save($data);

					$config = [
						'mailtype'  => 'html',
						'charset'   => 'utf-8',
						'protocol'  => 'smtp',
						'smtp_host' => 'smtp.gmail.com',
						'smtp_user' => 'penyimpanan13@gmail.com',  // Email gmail
						'smtp_pass'   => 'DriveData',  // Password gmail
						'smtp_crypto' => 'ssl',
						'smtp_port'   => 465,
						'crlf'    => "\r\n",
						'newline' => "\r\n"
					];
					$this->load->library('email', $config);
					$this->email->from('no-reply@kompetisi.com', 'Kompetisi On line Matematika Sains');
					$this->email->to($email);
					$this->email->subject('Kode Verifikasi Akun Kompetinsi On line Matematika Sains');

					$url = base64_encode($email . ';' . $randomNumber);
					$url = base64_encode($url);

					$emailMessage = '';
					$emailMessage .= '<h2 style="color: black">Hallo, ' . $data['user_firstname'] . ' .!</h2>';
					$emailMessage .= '<p style="color: black">Silakan tekan tombol di bawah ini untuk verifikasi alamat email.</p>';
					$emailMessage .= '<br />';
					$emailMessage .= '<a href="' . base_url() . 'index.php/welcome/verifikasi/' . $url . '" style="background-color: #55b9f3; padding: 10px 20px 10px 20px; margin-bottom: 10px; text-decoration: none; color: white">Verifikasi</a>';
					$emailMessage .= '<br />';
					$emailMessage .= '<br />';
					$emailMessage .= '<p style="color: black">Jika kamu tidak merasa mendaftar akun di QEC, abaikan saja email ini</p>';
					$emailMessage .= '<p style="color: black">Terimakasih,</p>';
					$emailMessage .= '<p style="color: black">Panitia QEC.</p>';
					$this->email->message($emailMessage);

					$this->email->send();

					$status['status'] = 1;
					$status['pesan'] = 'Berhasil mendaftar, silahkan cek email anda untuk memverifikasi akun';
				}
			} else {
				$status['status'] = 0;
				$status['pesan'] = 'Data Group tidak tersedia, Silahkan tambah data Group';
			}
		} else {
			$status['status'] = 0;
			$status['pesan'] = validation_errors();
		}

		echo json_encode($status);
	}

	function verifikasi($param = null)
	{
		$stepOne = base64_decode($param);
		$stepTwo = base64_decode($stepOne);

		$explodeParam = explode(';', $stepTwo);
		$email = $explodeParam[0];
		$kode = $explodeParam[1];

		if ($this->cbt_user_model->count_by_kolom('user_email', $email)->row()->hasil > 0 && $this->cbt_user_model->count_by_kolom('kode', $kode)->row()->hasil > 0) {
			$this->cbt_user_model->activation($email);
			$this->session->set_flashdata('verif', 'Akun anda berhasil diverifikasi, silahkan login untuk melanjutkan !');
			return redirect('welcome');
		} else {
			echo 'gak';
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
