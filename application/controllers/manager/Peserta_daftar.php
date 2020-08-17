<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;


class Peserta_daftar extends Member_Controller
{
	private $kode_menu = 'peserta-daftar';
	private $kelompok = 'peserta';
	private $url = 'manager/peserta_daftar';

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_user_model');
		$this->load->library('Send_email');

		parent::cek_akses($this->kode_menu);
	}

	public function index()
	{
		$data['kode_menu'] = $this->kode_menu;
		$data['url'] = $this->url;

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

		$this->template->display_admin($this->kelompok . '/peserta_daftar_view', 'Daftar Peserta', $data);
	}

	function tambah()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('tambah-email', 'Email', 'required|strip_tags|valid_emails');
		$this->form_validation->set_rules('tambah-password', 'Password', 'required|strip_tags|min_length[8]');
		$this->form_validation->set_rules('tambah-nama', 'Nama Lengkap', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-detail', 'Nama Sekolah', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-kelas', 'Kelas', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-telepon', 'Nomer Telepon', 'required|strip_tags|numeric|min_length[10]');
		$this->form_validation->set_rules('tambah-lomba', 'Mata Lomba', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-group', 'Level', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$randomNumber = rand(000001, 999999);
			$email = $this->input->post('tambah-email', true);
			$data['user_email'] = $email;
			$data['user_password'] = $this->input->post('tambah-password', true);
			$data['user_firstname'] = $this->input->post('tambah-nama', true);
			$data['user_detail'] = $this->input->post('tambah-detail', true);
			$data['user_grup_id'] = $this->input->post('tambah-group', true);
			$data['telepon'] = $this->input->post('tambah-telepon', true);
			$data['kelas'] = $this->input->post('tambah-kelas', true);
			$data['lomba'] = $this->input->post('tambah-lomba', true);
			$data['active'] = 0;
			$data['kode'] = $randomNumber;

			if ($this->cbt_user_grup_model->count_by_kolom('grup_id', $data['user_grup_id'])->row()->hasil > 0) {
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
						$status['pesan'] = 'Data Peserta berhasil disimpan ';
					} else {
						$status['status'] = 0;
						$status['pesan'] = 'Silahkan periksa koneksi internet anda !';
					}
				}
			} else {
				$status['status'] = 0;
				$status['pesan'] = 'Data Group tidak tersedia, Silahkan tambah data Group';
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
			$query = $this->cbt_user_model->get_by_kolom('user_id', $id);
			if ($query->num_rows() > 0) {
				$query = $query->row();
				$data['data'] = 1;
				$data['id'] = $query->user_id;
				$data['username'] = $query->user_name;
				$data['password'] = $query->user_password;
				$data['nama'] = $query->user_firstname;
				$data['email'] = $query->user_email;
				$data['detail'] = $query->user_detail;
				$data['telepon'] = $query->telepon;
				$data['group'] = $query->user_grup_id;
				$data['active'] = $query->active;
				$data['kelas'] = $query->kelas;
				$data['lomba'] = $query->lomba;
			}
		}
		echo json_encode($data);
	}

	/**
	 * Menghapus siswa yang dipilih
	 * @return [type] [description]
	 */
	function hapus_daftar_siswa()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('edit-user-id[]', 'Siswa', 'required|strip_tags');
		if ($this->form_validation->run() == TRUE) {
			$user_id = $this->input->post('edit-user-id', TRUE);
			foreach ($user_id as $kunci => $isi) {
				if ($isi == "on") {
					$this->cbt_user_model->delete('user_id', $kunci);
				}
			}
			$status['status'] = 1;
			$status['pesan'] = 'Daftar Siswa berhasil dihapus';
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
		$this->form_validation->set_rules('edit-pilihan', 'Pilihan', 'required|strip_tags');
		$this->form_validation->set_rules('edit-password', 'Password', 'required|strip_tags');
		$this->form_validation->set_rules('edit-nama', 'Nama Lengkap', 'required|strip_tags');
		$this->form_validation->set_rules('edit-email', 'Email', 'strip_tags');
		$this->form_validation->set_rules('edit-detail', 'Keterangan', 'strip_tags');
		$this->form_validation->set_rules('edit-group', 'Group', 'required|strip_tags');
		$this->form_validation->set_rules('edit-telepon', 'Nomer Telepon', 'required|strip_tags|numeric|min_length[10]');
		$this->form_validation->set_rules('edit-active', 'Status', 'required|strip_tags');
		$this->form_validation->set_rules('edit-kelas', 'Kelas', 'required|strip_tags');
		$this->form_validation->set_rules('edit-lomba', 'Mata Lomba', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$pilihan = $this->input->post('edit-pilihan', true);
			$id = $this->input->post('edit-id', true);

			if ($pilihan == 'hapus') { //hapus
				$this->cbt_user_model->delete('user_id', $id);
				$status['status'] = 1;
				$status['pesan'] = 'Data Peserta berhasil dihapus !';
			} else if ($pilihan == 'simpan') { //simpan
				// $data['user_password'] = $this->input->post('edit-password', true);
				$data['user_firstname'] = $this->input->post('edit-nama', true);
				// $data['user_email'] = $this->input->post('edit-email', true);
				$data['user_grup_id'] = $this->input->post('edit-group', true);
				$data['user_detail'] = $this->input->post('edit-detail', true);
				$data['telepon'] = $this->input->post('edit-telepon', true);
				$data['active'] = $this->input->post('edit-active', true);
				$data['kelas'] = $this->input->post('edit-kelas', true);
				$data['lomba'] = $this->input->post('edit-lomba', true);

				$this->cbt_user_model->update('user_id', $id, $data);

				$status['status'] = 1;
				$status['pesan'] = 'Data Peserta berhasil disimpan ';
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
		$group = $this->input->get('group');
		$kelas = $this->input->get('kelas');

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
		$query = $this->cbt_user_model->get_datatable($start, $rows, 'user_firstname', $search, $group, $kelas);
		$iFilteredTotal = $query->num_rows();

		$iTotal = $this->cbt_user_model->get_datatable_count('user_firstname', $search, $group, $kelas)->row()->hasil;

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
			$record[] = $temp->user_firstname;

			// $query_group = $this->cbt_user_grup_model->get_by_kolom_limit('grup_id', $temp->user_grup_id, 1)->row();

			// $record[] = $query_group->grup_nama;
			$record[] = $temp->kelas;
			// $record[] = $temp->lomba == 'all' ? "Matematika & Sains" : ucfirst($temp->lomba);

			$daftarLomba = $this->mlib->getLombaArray($temp->lomba);
			$elementLomba = '';
			foreach ($daftarLomba as $lomba) {
				$elementLomba .= '<span class="badge badge-primary mr-1">' . $lomba . '</span>';
			}
			$record[] = $elementLomba;
			$record[] = $temp->user_detail;

			$details = '';
			$details .= $temp->active == 1 ? '<div class="badge badge-success" style="margin-right: 5px">AKTIF</div>' : '<div class="badge badge-danger" style="margin-right: 5px">BELUM AKTIF</div>';
			if ($temp->status == 'wait') {
				$details .= '<div class="badge badge-secondary">MENUNGGU KONFIRMASI</div>';
			} else if ($temp->status == 'allow') {
				$details .=
					'<div class="badge badge-success">SUDAH MEMBAYAR</div>';
			} else {
				$details .= '<div class="badge badge-danger">BELUM MEMBAYAR</div>';
			}

			$record[] = $details;

			$record[] = '<a onclick="edit(\'' . $temp->user_id . '\')" style="cursor: pointer;" class="btn btn-default btn-xs">Edit</a>';
			$record[] = '<input type="checkbox" name="edit-user-id[' . $temp->user_id . ']" >';

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

	function export($groupName, $kelas)
	{
		$query = $this->cbt_user_model->get_data_export($groupName, $kelas);

		$this->load->library('excel');

		$inputFileName = './public/form/form-data-peserta.xls';
		$spreadsheet = IOFactory::load($inputFileName);
		$spreadsheet->setActiveSheetIndex(0);

		if ($query->num_rows() > 0) {
			$query = $query->result();
			$row = 2;
			foreach ($query as $temp) {
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row, ($row - 1));
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $row, $temp->user_email);
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $row, $temp->user_firstname);
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $row, $temp->grup_nama);
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $row, $temp->user_detail);
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $row, $temp->kelas);
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $row, $temp->lomba == 'all' ? 'Matematika & Sains' : $temp->lomba);
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $row, $temp->telepon);
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $row, $temp->active == '1' ? 'AKTIF' : 'BELUM AKTIF');
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $row, $temp->user_regdate);

				$row++;
			}
		}

		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('Report');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Data Peserta - ' . date('Y-m-d H-i') . '.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
	}
}
