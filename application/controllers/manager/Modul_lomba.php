<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Modul_lomba extends Member_Controller
{
	private $kode_menu = 'modul-lomba';
	private $kelompok = 'modul';
	private $url = 'manager/modul_lomba';

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_lomba_model');
		$this->load->model('cbt_soal_model');
		$this->load->model('cbt_tes_topik_set_model');

		parent::cek_akses($this->kode_menu);
	}

	public function index($page = null, $id = null)
	{
		$data['kode_menu'] = $this->kode_menu;
		$data['url'] = $this->url;

		$this->template->display_admin($this->kelompok . '/lomba_view', 'Daftar Topik', $data);
	}

	function tambah()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('tambah-lomba', 'Nama Pelajaran', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$data['modul_nama'] = $this->input->post('tambah-lomba', true);
			$data['modul_aktif'] = 1;

			//if($this->cbt_lomba_model->count_by_kolom('topik_nama', $data['topik_nama'])->row()->hasil>0){
			if ($this->cbt_lomba_model->count_by_topik_modul($data['modul_nama'])->row()->hasil > 0) {
				$status['status'] = 0;
				$status['pesan'] = 'Nama Pelajaran sudah terpakai !';
			} else {
				$this->cbt_lomba_model->save($data);

				$status['status'] = 1;
				$status['pesan'] = 'Pelajaran berhasil disimpan ';
			}
		} else {
			$status['status'] = 0;
			$status['pesan'] = array_values($this->form_validation->error_array())[0];
		}

		echo json_encode($status);
	}

	function get_by_id($id = null)
	{
		$data['data'] = 0;
		if (!empty($id)) {
			$query = $this->cbt_lomba_model->get_by_kolom('modul_id', $id);
			if ($query->num_rows() > 0) {
				$query = $query->row();
				$data['data'] = 1;
				$data['id'] = $query->modul_id;
				$data['lomba'] = $query->modul_nama;
			}
		}
		echo json_encode($data);
	}

	/**
	 * Menghapus topik yang dipilih
	 * @return [type] [description]
	 */
	function hapus_daftar_topik()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('edit-topik-id[]', 'Topik', 'required|strip_tags');
		if ($this->form_validation->run() == TRUE) {
			$topik_id = $this->input->post('edit-topik-id', TRUE);
			$error_hapus = 0;
			foreach ($topik_id as $kunci => $isi) {
				if ($isi == "on") {
					if ($this->cbt_tes_topik_set_model->count_by_kolom('tset_topik_id', $kunci)->row()->hasil > 0) {
						$error_hapus++;
					} else {
						// Memulai transaction mysql
						$this->db->trans_start();

						// hapus topik di database
						$this->cbt_lomba_model->delete('modul_id', $kunci);

						// Menutup transaction mysql
						$this->db->trans_complete();

						// // hapus file topik
						// $this->load->helper('directory');
						// $this->load->helper('file');

						// $folder = $this->config->item('upload_path') . '/topik_' . $kunci;
						// if (is_dir($folder)) {
						// 	delete_files($folder, TRUE);
						// 	rmdir($folder);
						// }
					}
				}
			}
			if ($error_hapus > 0) {
				$status['status'] = 2;
				$status['pesan'] = 'Daftar topik sebagian tidak dapat dihapus karena masih digunakan Tes !';
			} else {
				$status['status'] = 1;
				$status['pesan'] = 'Daftar Topik berhasil dihapus';
			}
		} else {
			$status['status'] = 0;
			$status['pesan'] = array_values($this->form_validation->error_array())[0];
		}

		echo json_encode($status);
	}

	function edit()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('edit-id', 'ID', 'required|strip_tags');
		$this->form_validation->set_rules('edit-lomba', 'Nama Pelajaran', 'required|strip_tags');
		$this->form_validation->set_rules('edit-pilihan', 'Pilihan', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$pilihan = $this->input->post('edit-pilihan', true);
			$id = $this->input->post('edit-id', true);
			$modul_id = $this->input->post('edit-modul-id', true);

			if ($pilihan == 'hapus') { //hapus
				if ($this->cbt_tes_topik_set_model->count_by_kolom('tset_topik_id', $id)->row()->hasil > 0) {
					$status['status'] = 0;
					$status['pesan'] = 'Topik masih dipakai pada Tes, tidak bisa dihapus.';
				} else {
					// hapus topik di database
					$this->cbt_lomba_model->delete('modul_id', $id);

					// // hapus file topik
					// $this->load->helper('directory');
					// $this->load->helper('file');

					// $folder = $this->config->item('upload_path') . '/topik_' . $id;
					// if (is_dir($folder)) {
					// 	delete_files($folder, TRUE);
					// 	rmdir($folder);
					// }

					$status['status'] = 1;
					$status['pesan'] = 'Topik berhasil dihapus !';
				}
			} else if ($pilihan == 'simpan') { //simpan
				$topik_asli = $this->input->post('edit-lomba-asli', true);
				$data['modul_nama'] = $this->input->post('edit-lomba', true);

				if ($topik_asli != $data['modul_nama']) {
					//if($this->cbt_lomba_model->count_by_kolom('topik_nama', $data['topik_nama'])->row()->hasil>0){
					if ($this->cbt_lomba_model->count_by_topik_modul($data['modul_nama'])->row()->hasil > 0) {
						$status['status'] = 0;
						$status['pesan'] = 'Nama Pelajaran sudah terpakai !';
					} else {
						$this->cbt_lomba_model->update('modul_id', $id, $data);

						$status['status'] = 1;
						$status['pesan'] = 'Pelajaran berhasil disimpan ';
					}
				} else {
					$this->cbt_lomba_model->update('modul_id', $id, $data);
					$status['status'] = 1;
					$status['pesan'] = 'Pelajaran Berhasil disimpan';
				}
			}
		} else {
			$status['status'] = 0;
			$status['pesan'] = array_values($this->form_validation->error_array())[0];
		}

		echo json_encode($status);
	}

	function get_datatable()
	{
		// variable initialization
		$modul = $this->input->get('modul');

		$search = "";
		$start = 0;
		$rows = 10;

		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->get_start();
		$rows = $this->get_rows();

		// run query to get user listing
		$query = $this->cbt_lomba_model->get_datatable($start, $rows, 'modul_nama', $search, $modul);
		$iFilteredTotal = $query->num_rows();

		$iTotal = $this->cbt_lomba_model->get_datatable_count('modul_nama', $search, $modul)->row()->hasil;

		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iTotal,
			"aaData" => array()
		);

		// get result after running query and put it in array
		$i = $start;
		$query = $query->result();
		foreach ($query as $temp) {
			$record = array();

			$record[] = ++$i;

			// $jml_soal = $this->cbt_soal_model->count_by_kolom('soal_topik_id', $temp->topik_id)->row()->hasil;

			$record[] = $temp->modul_nama;
			// $record[] = $jml_soal;
			$record[] = '<a onclick="edit(\'' . $temp->modul_id . '\')" style="cursor: pointer;" class="btn btn-default btn-xs">Edit</a>';
			$record[] = '<input type="checkbox" name="edit-topik-id[' . $temp->modul_id . ']" >';

			$output['aaData'][] = $record;
		}
		// format it to JSON, this output will be displayed in datatable

		echo json_encode($output);
	}

	/**
	 * funsi tambahan 
	 * 
	 * 
	 */

	function get_start()
	{
		$start = 0;
		if (isset($_GET['iDisplayStart'])) {
			$start = intval($_GET['iDisplayStart']);

			if ($start < 0)
				$start = 0;
		}

		return $start;
	}

	function get_rows()
	{
		$rows = 10;
		if (isset($_GET['iDisplayLength'])) {
			$rows = intval($_GET['iDisplayLength']);
			if ($rows < 5 || $rows > 500) {
				$rows = 10;
			}
		}

		return $rows;
	}

	function get_sort_dir()
	{
		$sort_dir = "ASC";
		$sdir = strip_tags($_GET['sSortDir_0']);
		if (isset($sdir)) {
			if ($sdir != "asc") {
				$sort_dir = "DESC";
			}
		}

		return $sort_dir;
	}
}
