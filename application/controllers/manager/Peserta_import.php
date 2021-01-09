<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Peserta_import extends Member_Controller
{
    private $kode_menu = 'peserta-import';
    private $kelompok = 'peserta';
    private $url = 'manager/peserta_import';

    function __construct()
    {
        parent::__construct();
        $this->load->model('cbt_user_grup_model');
        $this->load->model('cbt_user_model');

        parent::cek_akses($this->kode_menu);
    }

    public function index()
    {
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        $this->load->library('form_validation');


        $data['select_kelas'] = $this->getkelas->result();
        $query_group = $this->cbt_lomba_model->get_all();
        if ($query_group->num_rows() > 0) {
            $select = '';
            $query_group = $query_group->result();
            foreach ($query_group as $temp) {
                $select = $select . '<option value="' . $temp->modul_id . '">' . $temp->modul_nama . '</option>';
            }
        } else {
            $select = '<option value="kosong" selected>-- Tidak ada Pelajaran --</option>';
        }
        $data['select_lomba'] = $select;
        $this->template->display_admin($this->kelompok . '/peserta_import_view', 'Import Peserta', $data);
    }

    public function import()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('kelas', 'Kelas', 'required');
        $this->form_validation->set_rules('pelajaran[]', 'Pelajaran', 'required');

        if ($this->form_validation->run() == TRUE) {
            $posisi = './public/uploads/';
            $kelas = $this->input->post('kelas', true);
            $pelajaran = $this->input->post('pelajaran[]', true);

            if (!empty($_FILES['userfile']['name'])) {
                $config['upload_path'] = $posisi;
                $config['allowed_types'] = 'xls|xlsx';
                $config['max_size']    = '0';
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
                    $status['pesan'] = $this->import_file($upload_data['file_name'], $upload_data['file_ext'], $kelas, $pelajaran);
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

    function import_file($inputfile, $fileExt, $kelas, $pelajaran)
    {
        $inputFileName = './public/uploads/' . $inputfile;

        if ($fileExt === '.xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else if ($fileExt === '.xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $reader->load($inputFileName);
        $spreadsheet = $spreadsheet->getActiveSheet()->toArray();

        $pesan = '';
        $highestRow = count($spreadsheet);

        // if ($highestRow > 10) {
        // 	$jmlsoalerror = 0;
        $row = 1;
        $jmlsiswa = 0;
        $kosong = 0;
        while ($kosong < 2) {
            $kosong = 0;

            if ($row > ($highestRow -1)) {
                $kosong = +2;
            }else{
                $nama = $spreadsheet[$row][0]; //nama
                $email = $spreadsheet[$row][1]; //email
                $password = $spreadsheet[$row][2]; //password
                $asalSekolah = $spreadsheet[$row][3]; //asal sekolah
    
                if (empty($nama) || empty($email) || empty($password) || empty($asalSekolah)) {
                    $kosong = +2;
                }
            }


            if ($kosong == 0) {
                if ($this->cbt_user_model->count_by_kolom('user_email', $email)->row()->hasil > 0) {
                    $row++;
                    continue;
                }
                $data['user_email'] = $email;
                $data['user_password'] = $password;
                $data['user_firstname'] = $nama;
                $data['user_detail'] = $asalSekolah;
                $data['kelas'] = $kelas;
                $data['lomba'] = json_encode($pelajaran);
                $data['active'] = 1;
                $this->cbt_user_model->save($data);
                $jmlsiswa++;
            } else {
                break;
            }

            $row++;
        }
        $pesan = $pesan . 'Jumlah siswa yang berhasil diimport adalah ' . $jmlsiswa . '';

        return $pesan;
    }
}
