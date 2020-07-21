<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengumuman extends CI_Controller
{
	private $kelompok = 'ujian';
	private $url = 'pengumuman';

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbt_konfigurasi_model');
		$this->load->library('access_tes');
		$this->load->library('user_agent');
		$this->load->model('cbt_konfigurasi_model');
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_juara_model');
		$this->load->library('session');

		$this->load->library('Send_email');
	}

	public function index()
	{

		// ========================================
		$data['url'] = $this->url;
		$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));

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
						$get_laporan = $this->cbt_juara_model->get_laporan();
						$data['pengumuman'] = $get_laporan->row();
						$this->template->display_user($this->kelompok . '/pengumuman_view', 'Selamat Datang', $data);
					}
				} else {
					$this->template->display_user('lockmobile_view', 'Exam Browser');
				}
			}
		} else {
			$this->template->display_user('blokbrowser_view', 'Browser yang didukung');
		}
	}
}
