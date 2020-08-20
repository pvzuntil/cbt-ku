<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Peserta_kartu extends Member_Controller
{
	private $kode_menu = 'peserta-kartu';
	private $kelompok = 'peserta';
	private $url = 'manager/peserta_kartu';

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_konfigurasi_model');

		parent::cek_akses($this->kode_menu);
	}

	public function index()
	{
		$data['kode_menu'] = $this->kode_menu;
		$data['url'] = $this->url;

		$select = '';
		foreach ($this->getkelas->result() as $temp) {
			$select = $select . '<option value="' . $temp . '">Kelas ' . $temp . '</option>';
		}
		$data['select_group'] = $select;

		$this->template->display_admin($this->kelompok . '/peserta_kartu_view', 'Cetak Kartu Peserta', $data);
	}

	/**
	 * Cetak kartu hanya untuk satu grup saja
	 */
	public function cetak_kartu($grup_id = null)
	{
		$data['kode_menu'] = $this->kode_menu;

		$kartu = '<h3>Data Peserta Kosong</h3>';
		if (!empty($grup_id)) {
			$query_user = $this->cbt_user_model->get_by_kolom('kelas', $grup_id);
			// dd($query_user->num_rows());
			// dd($grup_id);
			if ($query_user->num_rows() > 0) {
				$kartu = '';
				$query_user = $query_user->result();

				$query_konfig = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'cbt_nama', 1);
				$cbt_nama = 'Computer Based-Test';
				if ($query_konfig->num_rows() > 0) {
					$cbt_nama = $query_konfig->row()->konfigurasi_isi;
				}

				foreach ($query_user as $temp) {
					$kartu = $kartu . '
						<div class="kartu">
							<div class="header">' . $cbt_nama . '</div>
							<hr />
							<table>
								<tr>
									<td width="95px">Nama</td>
									<td width="5px">:</td>
									<td width="210px">' . $temp->user_firstname . '</td>
								</tr>
								<tr>
									<td>Username</td>
									<td>:</td>
									<td>' . $temp->user_name . '</td>
								</tr>
								<tr>
									<td>Password</td>
									<td>:</td>
									<td>' . $temp->user_password . '</td>
								</tr>
								<tr>
									<td>Kelas</td>
									<td>:</td>
									<td>' . $temp->kelas . '</td>
								</tr>
								<tr>
									<td>Keterangan</td>
									<td>:</td>
									<td>' . $temp->user_detail . '</td>
								</tr>
							</table>
						</div>
					';
				}
			}
		}

		$data['kartu'] = $kartu;

		$this->load->view($this->kelompok . '/peserta_cetak_kartu_view', $data);
	}
}
