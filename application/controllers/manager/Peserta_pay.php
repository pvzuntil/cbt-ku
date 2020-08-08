<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;


class Peserta_pay extends Member_Controller
{
	private $kode_menu = 'peserta-pay';
	private $kelompok = 'peserta';
	private $url = 'manager/peserta_pay';

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbt_user_grup_model');
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_user_pay_model');
		$this->load->library('Send_email');

		parent::cek_akses($this->kode_menu);
		setlocale(LC_ALL, 'id-ID', 'id_ID');
	}

	public function index()
	{
		$data['kode_menu'] = $this->kode_menu;
		$data['url'] = $this->url;

		$query_cbt_user = $this->cbt_user_model->get_all_user_pay();

		if ($query_cbt_user->num_rows() > 0) {
			$select = '';
			$query_cbt_user = $query_cbt_user->result();
			foreach ($query_cbt_user as $temp) {
				if ($temp->status != null) {
					continue;
				} else {
					$select = $select . '<option value="' . $temp->user_id . '">' . $temp->user_firstname . ' - ' . $temp->user_email . '</option>';
				}
			}
		} else {
			$select = '<option value="100000">KOSONG</option>';
		}
		$data['select_group'] = $select;

		$this->template->display_admin($this->kelompok . '/peserta_pay_view', 'Daftar Peserta', $data);
	}

	function tambah()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('tambah-pay', 'User', 'required|strip_tags');
		$this->form_validation->set_rules('tambah-opsi', 'Opsi', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$data['cbt_user_id'] = $this->input->post('tambah-pay', true);
			$data['status'] = $this->input->post('tambah-opsi', true);
			$data['message'] = 'from admin';
			$data['date_pay'] = date('Y-m-d H:i:s');

			$this->cbt_user_pay_model->save($data);


			$status['status'] = 1;
			$status['pesan'] = 'Berhasil menambahkan pembayaran peserta';
		} else {
			$status['status'] = 0;
			$status['pesan'] = validation_errors();
		}

		echo json_encode($status);
	}

	function get_by_id($id = null)
	{
		$data['data'] = 0;
		if (!empty($id)) {
			$query = $this->cbt_user_pay_model->get_by_kolom('id', $id);
			if ($query->num_rows() > 0) {
				$query = $query->row();
				$data['data'] = 1;
				$data['id'] = $query->id;
				$data['nama'] = $query->user_firstname;
				$data['email'] = $query->user_email;
				$data['detail'] = $query->user_detail;
				$data['status'] = $query->status;
				$data['imgPay'] = $query->img_pay;
				$data['group'] = $query->grup_nama;
				$data['message'] = $query->message;
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
			$status['pesan'] = validation_errors();
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
			$status['pesan'] = validation_errors();
		}

		echo json_encode($status);
	}

	function get_datatable()
	{
		// variable initialization
		$status = $this->input->get('status') ?? 'semua';

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
		$query = $this->cbt_user_pay_model->get_datatable($start, $rows, 'user_firstname', $search, $status);
		$iFilteredTotal = $query->num_rows();

		$iTotal = $this->cbt_user_pay_model->get_datatable_count('user_firstname', $search, $status)->row()->hasil;

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
			$record[] = $temp->user_email;
			$record[] = $temp->user_firstname;

			$query_group = $this->cbt_user_grup_model->get_by_kolom_limit('grup_id', $temp->user_grup_id, 1)->row();

			$record[] = $query_group->grup_nama;
			$record[] = $temp->lomba == 'all' ? "Matematika & Sains" : ucfirst($temp->lomba);
			$record[] = strftime("%A, %d %B %Y", strtotime($temp->date_pay));

			if ($temp->status == 'wait') {
				$record[] = '<div class="badge">MENUNGGU KONFIRMASI</div>';
			} else if ($temp->status == 'allow') {
				$record[] =
					'<div class="badge badge-success">DITERIMA</div>';
			} else {
				$record[] = '<div class="badge badge-danger">DITOLAK</div>';
			}

			$record[] = $temp->status == 'allow'  ? '<button onclick="showDoc(\'' . $temp->id . '\')" style="cursor: pointer;" class="btn btn-default btn-xs">Lihat Dokumen</button>' : '';

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

	function export($status)
	{
		$query = $this->cbt_user_pay_model->get_data_export($status);

		$this->load->library('excel');

		$inputFileName = './public/form/form-data-pembayaran-peserta.xls';
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
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $row, $temp->status == 'allow' ? 'Diterima' : ($temp->status == 'deny' ? 'Ditolak' : 'Menunggu Konfirmasi'));
				// $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $row, $temp->active == '1' ? 'AKTIF' : 'BELUM AKTIF');
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $row, $temp->date_pay);

				$row++;
			}
		}

		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('Report');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Data Pembayaran Peserta - ' . date('Y-m-d H-i') . '.xlsx"');
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

	function konfirmpay()
	{
		$id = $this->input->post('id', true);
		$type = $this->input->post('type', true);
		$message = $this->input->post('message', true);

		$this->load->library('form_validation');

		$this->form_validation->set_rules('id', 'ID', 'required|strip_tags');
		$this->form_validation->set_rules('type', 'Aksi', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$this->cbt_user_pay_model->update('id', $id, [
				'status' => $type,
				'message' => $message
			]);

			$status['status'] = 1;
			$status['pesan'] = $type == 'allow' ? 'Berhasil mengkonfirmasi pembayaran' : 'Berhasil menolak pembayaran';
		} else {
			$status['status'] = 0;
			$status['pesan'] = validation_errors();
		}

		echo json_encode($status);
	}
}
