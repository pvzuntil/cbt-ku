<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Juara extends Member_Controller

{
    private $url = 'manager/juara';

    function __construct()
    {
        parent::__construct();
        $this->load->helper('directory');
        $this->load->helper('file');
        $this->load->model('cbt_juara_model');
        $this->load->model('cbt_user_model');
    }

    public function index()
    {
        $data['url'] = $this->url;
        $this->load->helper('form');

        $query_cbt_user = $this->cbt_user_model->get_all_user();

        if ($query_cbt_user->num_rows() > 0) {
            $select = '';
            $query_cbt_user = $query_cbt_user->result();
            foreach ($query_cbt_user as $temp) {
                $lomba = $temp->lomba == 'all' ? 'Matematika & Sains' : ucfirst($temp->lomba);
                $select = $select . '<option value="' . $temp->user_id . '">' . $temp->user_firstname . ' - ' . $temp->user_email . ' - ' . $lomba . '</option>';
            }
        } else {
            $select = '<option value="100000">KOSONG</option>';
        }

        $data['select_group'] = $select;

        $data['nama'] = $this->access->get_nama();

        $data['post_max_size'] = ini_get('post_max_size');
        $data['upload_max_filesize'] = ini_get('upload_max_filesize');
        $data['waktu_server'] = date('Y-m-d H:i:s');

        $laporan = $this->cbt_juara_model->get_laporan()->row();
        $data['isiLaporan'] = $laporan->isi;
        $data['isPublic'] = $laporan->isPublic;

        $this->template->display_admin('tool/juara', 'Dashboard', $data);
    }

    function get_datatable_image()
    {
        // $posisi = $this->config->item('upload_path') . '';
        $posisi = 'public/images/';

        // variable initialization
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
        if (!is_dir($posisi)) {
            mkdir($posisi);
        }
        $query = directory_map($posisi, 1);

        // get result after running query and put it in array
        $iTotal = 0;
        $i = $start;

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );

        foreach ($query as $temp) {
            $record = array();

            $temp = str_replace("\\", "", $temp);

            $record[] = ++$i;
            $is_dir = 0;
            $is_image = 0;
            $info = pathinfo($temp);

            if (!is_dir($posisi . '/' . $temp)) {
                if ($info['extension'] == 'jpg' or $info['extension'] == 'png' or $info['extension'] == 'jpeg') {
                    $file_info = get_file_info($posisi . '/' . $temp);

                    $record[] = '<a style="cursor:pointer;" onclick="image_preview(\'' . $posisi . '\',\'' . $temp . '\')">' . $posisi . '/' . $temp . '</a>';
                    $record[] = '<a style="cursor:pointer;" onclick="image_preview(\'' . $posisi . '\',\'' . $temp . '\')"><img src="' . base_url() . $posisi . '/' . $temp . '" height="40" /></a>';
                    $record[] = date('Y-m-d H:i:s', $file_info['date']);
                    $record[] = '<a onclick="image_preview(\'' . $posisi . '\',\'' . $temp . '\')" style="cursor: pointer;" class="btn btn-default btn-xs">Pilih</a>';
                    $output['aaData'][] = $record;

                    $iTotal++;
                }
            }
        }

        $output['iTotalRecords'] = $iTotal;
        $output['iTotalDisplayRecords'] = $iTotal;

        echo json_encode($output);
    }

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


    function upload_file()
    {
        $this->load->library('form_validation');

        // $this->form_validation->set_rules('image-file', 'Gambar', 'required');

        // if ($this->form_validation->run() == TRUE) {
        // $id_topik = $this->input->post('image-topik-id', true);
        // $posisi = $this->config->item('upload_path') . '/topik_' . $id_topik;
        $posisi = 'public/images/';

        if (!is_dir($posisi)) {
            mkdir($posisi);
        }

        $field_name = 'image-file';
        if (!empty($_FILES[$field_name]['name'])) {
            $config['upload_path'] = $posisi;
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size']    = '0';
            $config['overwrite'] = true;
            $config['file_name'] = strtolower($_FILES[$field_name]['name']);

            if (file_exists($posisi . '/' . $config['file_name'])) {
                $status['status'] = 0;
                $status['pesan'] = 'Nama file sudah terdapat pada direktori, silahkan ubah nama file yang akan di upload';
            } else {
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload($field_name)) {
                    $status['status'] = 0;
                    $status['pesan'] = $this->upload->display_errors();
                } else {
                    $upload_data = $this->upload->data();

                    $status['status'] = 1;
                    $status['pesan'] = 'File ' . $upload_data['file_name'] . ' BERHASIL di IMPORT';
                    $status['image'] = '<img src="' . base_url() . $posisi . '/' . $upload_data['file_name'] . '" style="max-height: 110px;" />';
                    $status['image_isi'] = '<img src="' . base_url() . $posisi . '/' . $upload_data['file_name'] . '" style="max-width: 600px;" />';
                }
            }
        } else {
            $status['status'] = 0;
            $status['pesan'] = 'Pilih terlebih dahulu file yang akan di upload';
        }
        echo json_encode($status);
    }

    function get_datatable_juara()
    {
        $kelas = $this->input->get('kelas', true);
        $lomba = $this->input->get('lomba', true);
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
        $query = $this->cbt_juara_model->get_datatable($start, $rows, $search, $lomba, $kelas);

        $iFilteredTotal = $query->num_rows();

        $iTotal = count($query->result());

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );

        // get result after running query and put it in array
        $i = $start;
        $query = $query->result();
        $juara = 'Emas';

        foreach ($query as $temp) {
            $record = array();

            // $record[] = ++$i;
            $record[] = $temp->user_firstname;
            $record[] = $temp->user_detail;
            $record[] = $temp->nilai;

            $timeSpan = $temp->time_span;
            if (empty($timeSpan)) {
                // $record[] = 'Waktu habis';
                $record[] = '(' . $temp->tes_duration_time . ' Menit 0 Detik)';
            } else {
                $pecah = explode(',', $timeSpan);
                $record[] = ' (' . $pecah[0] . ' Menit ' . $pecah[1] . ' Detik)';
            }

            $record[] = 'Medali ' . $juara;
            $medali = 'medali ' . $juara;

            // $record[] = '';
            $record[] = '<a onclick="cert(\'' . $temp->user_id . '\', \'' . $lomba . '\', \'' . $medali . '\')" style="cursor: pointer;" class="btn btn-default btn-xs">Cetak sertifikat</a>';
            // $record[] = '<input type="checkbox" name="edit-user-id[' . $temp->user_id . ']" >';

            ++$i;
            if ($i > 0 && $i < 2) {
                // $i = 0;
                $juara = 'Perak';
            } else if ($i > 2) {
                $juara = 'Perunggu';
            }

            $output['aaData'][] = $record;
        }
        // format it to JSON, this output will be displayed in datatable

        echo json_encode($output);
    }

    function salin_data()
    {
        # code...
        $search = '';

        $start = 0;
        $rows = 0;

        $kelas = $this->input->post('kelas', true);
        $lomba = $this->input->post('lomba', true);

        // run query to get user listing
        $query = $this->cbt_juara_model->get_datatable($start, $rows, $search, $lomba, $kelas, 'salin');

        $i = $start;
        $query = $query->result();
        $juara = 'Emas 🥇';

        if (count($query) == 0) {
            return false;
        }

        foreach ($query as $temp) {
            $record = array();

            // $record[] = ++$i;
            $record['nama'] = $temp->user_firstname;
            $record['sekolah'] = $temp->user_detail;
            $record['nilai'] = $temp->nilai;

            $timeSpan = $temp->time_span;
            if (empty($timeSpan)) {
                // $record[] = 'Waktu habis';
                $record['durasi'] = $temp->tes_duration_time . ' Menit 0 Detik';
            } else {
                $pecah = explode(',', $timeSpan);
                $record['durasi'] = $pecah[0] . ' Menit ' . $pecah[1] . ' Detik';
            }

            $record['juara'] = 'Medali ' . $juara;

            ++$i;
            if ($i > 0 && $i < 2) {
                // $i = 0;
                $juara = 'Perak 🥈';
            } else if ($i > 2) {
                $juara = 'Perunggu 🥉';
            }

            $output[] = $record;
        }


        // echo json_encode($quer);
        echo json_encode($output);
    }

    function save_juara()
    {
        $isi = $this->input->post('isi', true);

        $counLaporan = $this->cbt_juara_model->get_laporan()->num_rows();

        if ($counLaporan > 0) {
            $this->cbt_juara_model->update('id', 1, [
                'isi' => $isi,
            ]);
            return 1;
        }

        $this->cbt_juara_model->save([
            'isi' => $isi,
            'isPublic' => 0
        ]);

        return 1;
    }

    function publikasi_juara()
    {
        $isPublic =  $this->input->post('isPublic');
        $this->cbt_juara_model->update('id', 1, [
            'isPublic' => $isPublic
        ]);
        echo $isPublic;
    }
}
