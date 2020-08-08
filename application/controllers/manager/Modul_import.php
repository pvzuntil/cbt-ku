    
<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Modul_import extends Member_Controller
{
	private $kode_menu = 'modul-import';
	private $kelompok = 'modul';
	private $url = 'manager/modul_import';

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbt_modul_model');
		$this->load->model('cbt_topik_model');
		$this->load->model('cbt_jawaban_model');
		$this->load->model('cbt_soal_model');
		$this->load->helper('directory');
		$this->load->helper('file');

		parent::cek_akses($this->kode_menu);
	}

	public function index()
	{
		$data['kode_menu'] = $this->kode_menu;
		$data['url'] = $this->url;


		$query_user = $this->users_model->get_user_by_username($this->access->get_username());
		$select = '';
		$counter = 0;
		if ($query_user->num_rows() > 0) {
			$query_user = $query_user->row();

			// Mengecek apakah user dibatasi hanya mengentry beberapa topik
			if (!empty($query_user->opsi1)) {
				$user_topik = explode(',', $query_user->opsi1);
				foreach ($user_topik as $topik_id) {
					$query_topik = $this->cbt_topik_model->get_by_kolom_join_modul('topik_id', $topik_id);
					if ($query_topik->num_rows() > 0) {
						$topik = $query_topik->row();
						$counter++;

						$jml_soal = $this->cbt_soal_model->count_by_kolom('soal_topik_id', $topik->topik_id)->row()->hasil;

						$select = $select . '<option value="' . $topik->topik_id . '">' . $topik->modul_nama . ' - ' . $topik->topik_nama . ' [' . $jml_soal . ']</option>';
					}
				}
			} else {
				// Jika user tidak dibatasi mengedit soal sesuai topik
				$query_modul = $this->cbt_modul_model->get_modul();
				if ($query_modul->num_rows() > 0) {
					$select = '';
					$query_modul = $query_modul->result();
					foreach ($query_modul as $temp) {
						$query_topik = $this->cbt_topik_model->get_by_kolom_join_modul('topik_modul_id', $temp->modul_id);
						if ($query_topik->num_rows()) {
							$select = $select . '<optgroup label="Modul ' . $temp->modul_nama . '">';

							$query_topik = $query_topik->result();
							foreach ($query_topik as $topik) {
								$counter++;

								$jml_soal = $this->cbt_soal_model->count_by_kolom('soal_topik_id', $topik->topik_id)->row()->hasil;
								$select = $select . '<option value="' . $topik->topik_id . '">' . $topik->modul_nama . ' - ' . $topik->topik_nama . ' [' . $jml_soal . ']</option>';
							}

							$select = $select . '</optgroup>';
						}
					}
				}
			}
		}

		if ($counter == 0) {
			$select = '<option value="kosong">Tidak Ada Data Topik</option>';
		}

		$data['select_topik'] = $select;

		$this->template->display_admin($this->kelompok . '/modul_import_view', 'Mengimport Soal', $data);
	}

	function import()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('topik', 'Topik', 'required');

		if ($this->form_validation->run() == TRUE) {
			$id_topik = $this->input->post('topik', true);
			$posisi = './public/uploads/';

			if (!empty($_FILES['userfile']['name'])) {
				$config['upload_path'] = $posisi;
				$config['allowed_types'] = 'xls|xlsx';
				$config['max_size']	= '0';
				$config['overwrite'] = true;
				$config['file_name'] = $_FILES['userfile']['name'];

				$this->load->library('upload', $config);
				if (!$this->upload->do_upload()) {
					$status['status'] = 0;
					$status['pesan'] = $this->upload->display_errors() . 'Tipe file yang di upload adalah ' . $_FILES['userfile']['type'];
				} else {
					$upload_data = $this->upload->data();
					$data['filename'] = 'File ' . $upload_data['file_name'] . ' BERHASIL di IMPORT';

					$status['status'] = 1;

					// disini proses import data
					$status['pesan'] = $this->import_file($upload_data['file_name'], $id_topik, $upload_data['file_ext']);
				}
			} else {
				$status['status'] = 0;
				$status['pesan'] = 'Pilih terlebih dahulu file yang akan di upload';
			}
		} else {
			$status['status'] = 0;
			$status['pesan'] = array_values($this->form_validation->error_array())[0];
		}
		echo json_encode($status);
	}

	function import_file($inputfile, $id_topik, $fileExt)
	{
		// $this->load->library('excel');

		// BEGIN RE-CODE ==========================================
		$inputFileName = './public/uploads/' . $inputfile;

		if ($fileExt === '.xls') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
		} else if ($fileExt === '.xlsx') {
			$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		}

		$spreadsheet = $reader->load($inputFileName);
		$spreadsheet = $spreadsheet->getActiveSheet()->toArray();

		$highestRow = count($spreadsheet);
		// END RE-CODE ============================================

		// var_dump($highestRow);
		// die();

		// $excel = PHPExcel_IOFactory::load($inputFileName);
		// $worksheet = $excel->getSheet(0);
		// $highestRow = $worksheet->getHighestRow();

		$pesan = '';

		if ($highestRow > 10) {
			$jmlsoalsukses = 0;
			$jmlsoalerror = 0;
			$row = 5;
			$kosong = 0;
			while ($kosong < 2) {
				$kosong = 0;
				// $kolomKode = $worksheet->getCellByColumnAndRow(2, $row)->getValue();//jenis, soal atau jawaban
				// $kolomIsi = $worksheet->getCellByColumnAndRow(3, $row)->getValue();//isi 
				// $kolomStatusJawaban = $worksheet->getCellByColumnAndRow(4, $row)->getValue();//jawaban benar atau salah
				// $kolomTingkatKesulitan = $worksheet->getCellByColumnAndRow(5, $row)->getValue();//tingkat kesulitan

				$kolomKode = $spreadsheet[$row][2]; //jenis, soal atau jawaban
				$kolomIsi = $spreadsheet[$row][3]; //isi 
				$kolomStatusJawaban = $spreadsheet[$row][4]; //jawaban benar atau salah
				$kolomTingkatKesulitan = $spreadsheet[$row][5]; //tingkat kesulitan

				if (empty($kolomKode)) {
					$kosong = +2;
				}
				if (empty($kolomIsi)) {
					$kosong = +2;
				}
				if (empty($kolomTingkatKesulitan) and $kolomKode == 'Q') {
					$kosong++;
				}

				if ($kosong == 0) {
					// Merubah html special char menjadi kode
					$kolomIsi = htmlspecialchars($kolomIsi);

					// Menambah tag br untuk baris baru
					$kolomIsi = str_replace("\r", "<br />", $kolomIsi);
					$kolomIsi = str_replace("\n", "<br />", $kolomIsi);
					// $soal_id = null;
					/**
					 * Jika tipe adalah Question
					 */
					if ($kolomKode == 'Q') {
						$question['soal_topik_id'] = $id_topik;
						$question['soal_detail'] = $kolomIsi;
						$question['soal_tipe'] = '1';
						$question['soal_difficulty'] = $kolomTingkatKesulitan;
						$question['soal_aktif'] = 1;

						$soal_id = $this->cbt_soal_model->save($question);
						$this->session->set_userdata('soal_id', $soal_id);

						$jmlsoalsukses++;


						/**
						 * Jika tipe adalah Answer
						 */
					} else if ($kolomKode == 'A') {
						$soal_id = $this->session->userdata('soal_id');

						$answer['jawaban_detail'] = $kolomIsi;
						if (!empty($kolomStatusJawaban)) {
							$answer['jawaban_benar'] = $kolomStatusJawaban;
						} else {
							$answer['jawaban_benar'] = '0';
						}
						$answer['jawaban_aktif'] = 1;
						$answer['jawaban_soal_id'] = $soal_id;

						$this->cbt_jawaban_model->save($answer);
					}
				} else {
					if ($kosong < 2) {
						$pesan = $pesan . 'Baris ke  ' . $row . ' GAGAL di simpan : ' . $kolomIsi . '<br>';
						$jmlsoalerror++;
					}
				}

				$row++;
			}
			$pesan = $pesan . 'Jumlah soal yang berhasil diimport adalah ' . $jmlsoalsukses . '<br>
                            Jumlah soal yang gagal di dimport adalah ' . $jmlsoalerror . '<br>
                            Jumlah total baris yang diproses adalah ' . ($row - 6) . '<br>';
		} else {
			$pesan = $pesan . 'Tidak Ada Yang Berhasil Di IMPORT. Cek kembali file excel yang dikirim';
		}
		// $pesan = $pesan . '</div>';

		return $pesan;
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
