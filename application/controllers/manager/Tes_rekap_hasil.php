<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;


class Tes_rekap_hasil extends Member_Controller
{
    private $kode_menu = 'tes-rekap';
    private $kelompok = 'tes';
    private $url = 'manager/tes_rekap_hasil';

    function __construct()
    {
        parent::__construct();
        $this->load->model('cbt_user_model');
        $this->load->model('cbt_user_grup_model');
        $this->load->model('cbt_tes_model');
        $this->load->model('cbt_tes_token_model');
        $this->load->model('cbt_tes_topik_set_model');
        $this->load->model('cbt_tes_user_model');
        $this->load->model('cbt_tesgrup_model');
        $this->load->model('cbt_soal_model');
        $this->load->model('cbt_jawaban_model');
        $this->load->model('cbt_tes_soal_model');
        $this->load->model('cbt_tes_soal_jawaban_model');

        parent::cek_akses($this->kode_menu);
    }

    public function index()
    {
        $data['kode_menu'] = $this->kode_menu;
        $data['url'] = $this->url;

        $username = $this->access->get_username();
        $user_id = $this->users_model->get_login_info($username)->id;

        $tanggal_awal = date('Y-m-d', strtotime('- 1 days'));
        $tanggal_akhir = date('Y-m-d', strtotime('+ 1 days'));

        $data['rentang_waktu'] = $tanggal_awal . ' - ' . $tanggal_akhir;

        $query_group = $this->getkelas->result();
        $select = '';
        foreach ($query_group as $temp) {
            $select = $select . '<option value="' . $temp . '">Kelas ' . $temp . '</option>';
        }
        $data['select_group'] = $select;

        $getPeserta = $this->db->query('SELECT cbt_user.user_firstname, cbt_user.user_id FROM `cbt_tes_user` INNER JOIN cbt_user ON cbt_user.user_id = cbt_tes_user.tesuser_user_id GROUP BY tesuser_user_id')->result();
        $select = '';
        foreach ($getPeserta as $temp) {
            $select = $select . '<option value="' . $temp->user_id . '">' . $temp->user_firstname . '</option>';
        }
        $data['select_peserta'] = $select;


        $this->template->display_admin($this->kelompok . '/tes_rekap_hasil_tes_view', 'Rekapitulasi Hasil Tes', $data);
    }

    public function export()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('pilih-grup', 'Grup', 'required|strip_tags');
        $this->form_validation->set_rules('nama-grup', 'Grup', 'required|strip_tags');
        $this->form_validation->set_rules('pilih-rentang-waktu', 'Rentang Waktu', 'required|strip_tags');

        // $this->load->library('excel');
        $this->load->library('tools');

        $inputFileName = './public/form/form-data-rekap-hasil-tes.xlsx';
        $spreadsheet = IOFactory::load($inputFileName);
        $spreadsheet->setActiveSheetIndex(0);

        // $excel = PHPExcel_IOFactory::load($inputFileName);
        // $spreadsheet = $excel->getSheet(0);

        if ($this->form_validation->run() == TRUE) {
            $rentang_waktu = $this->input->post('pilih-rentang-waktu', true);
            $tanggal = explode(" - ", $rentang_waktu);
            $grup = $this->input->post('pilih-grup', true);
            $nama_grup = $this->input->post('nama-grup', true);

            // Mengambil Data Peserta berdasarkan grup
            $query_user = $this->cbt_user_model->get_by_kolom('kelas', $grup);
            // Mengambil data Tes dalam rentang. Data tes diambil dari data daftar Tes
            $query_tes = $this->cbt_tesgrup_model->get_by_tanggal_and_grup($tanggal[0], $tanggal[1], $grup);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C3', $nama_grup);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C4', $this->tools->indonesian_date($tanggal[0], 'j F Y', '') . ' - ' . $this->tools->indonesian_date($tanggal[1], 'j F Y', ''));
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', $query_tes->num_rows());

            if ($query_user->num_rows() > 0 and $query_tes->num_rows() > 0) {
                $query_tes = $query_tes->result();
                $query_user = $query_user->result();

                $kolom = 4;
                foreach ($query_tes as $tes) {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue($this->tools->getAlpha($kolom) . '8', $tes->tes_nama);
                    if ($kolom == 25) {
                        $kolom = 4;
                    } else {
                        $kolom++;
                    }
                }

                $row = 9;
                foreach ($query_user as $user) {
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row, ($row - 8));
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $row, $user->user_firstname);
                    $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $row, $user->kelas);

                    $kolom = 4;
                    foreach ($query_tes as $tes) {
                        // Mendapatkan nilai tiap Tes untuk setiap siswa
                        $query_nilai = $this->cbt_tes_user_model->get_nilai_by_tes_user($tes->tes_id, $user->user_id);
                        if ($query_nilai->num_rows() > 0) {
                            $query_nilai = $query_nilai->row();
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue($this->tools->getAlpha($kolom) . $row, $query_nilai->nilai);
                        } else {
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue($this->tools->getAlpha($kolom) . $row, 0);
                        }

                        if ($kolom == 25) {
                            $kolom = 4;
                        } else {
                            $kolom++;
                        }
                    }

                    $row++;
                }
            }
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Report');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data Hasil Tes - ' . date('Y-m-d H-i') . '.xlsx"');
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

        // $filename = 'Data Rekap Hasil Tes.xlsx'; //save our workbook as this file name
        // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //mime type
        // header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        // header('Cache-Control: max-age=0'); //no cache

        // //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
        // //if you want to save it as .XLSX Excel 2007 format
        // $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        // //force user to download the Excel file without writing it to server's HD
        // $objWriter->save('php://output');
    }

    public function load_lomba()
    {
        $post = $this->input->post();

        $getTes = $this->db->query('select tesuser_tes_id from cbt_tes_user where tesuser_user_id = "' . $post['id'] . '"')->result();

        $listTes = [];
        foreach ($getTes as $tes) {
            $query_test = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $tes->tesuser_tes_id, 1)->row();
            $data = [
                'id' => $query_test->tes_id,
                'name' => $query_test->tes_nama
            ];

            $listTes[] = $data;
        }
        echo json_encode($listTes);
    }

    public function tes_hasil_export($idUser, $idTes)
    {
        if (!empty($idUser) || !empty($idTes)) {
            $getTesUser = $this->db->query('SELECT * FROM cbt_tes_user WHERE tesuser_user_id = "' . $idUser . '" AND tesuser_tes_id = "' . $idTes . '"')->row();

            $query_testuser = $this->cbt_tes_user_model->get_by_kolom_limit('tesuser_id', $getTesUser->tesuser_id, 1);
            if ($query_testuser->num_rows() > 0) {
                $query_testuser = $query_testuser->row();

                $query_test = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $query_testuser->tesuser_tes_id, 1)->row();
                $query_user = $this->cbt_user_model->get_by_kolom_limit('user_id', $query_testuser->tesuser_user_id, 1)->row();

                $data['tes_user_id'] = $getTesUser->tesuser_id;
                $data['tes_nama'] = $query_test->tes_nama;
                $data['tes_mulai'] = $query_testuser->tesuser_creation_time;
                $data['user'] = $query_user;

                $nilai = $this->cbt_tes_soal_model->get_nilai($getTesUser->tesuser_id)->row();
                $data['nilai'] = $nilai->hasil . '  /  ' . $query_test->tes_max_score . '  (nilai / nilai maksimal) ';

                $data['benar'] = ($nilai->total_soal - $nilai->jawaban_salah) . '  /  ' . $nilai->total_soal . '  (jawaban benar/ total soal)';

                $query = $this->cbt_tes_soal_model->get_datatable(0, 9999, 'soal_detail', '', $getTesUser->tesuser_id)->result();
                $i = 0;
                $data['content'] = [];

                foreach ($query as $temp) {
                    $record = array();

                    $record['no'] = ++$i;

                    if ($temp->soal_tipe == 1) {
                        $record['type'] = 'pg';
                    } else if ($temp->soal_tipe == 2) {
                        $record['type'] = 'Essay';
                    } else if ($temp->soal_tipe == 3) {
                        $record['type'] = 'Jawaban Singkat';
                    }

                    $soal = $temp->soal_detail;
                    $soal = str_replace("[base_url]", base_url(), $soal);
                    if (!empty($temp->soal_audio)) {
                        continue;
                        // $posisi = $this->config->item('upload_path') . '/topik_' . $temp->soal_topik_id;
                        // $soal = $soal . '<br />
                        //     <audio controls>
                        //       <source src="' . base_url() . $posisi . '/' . $temp->soal_audio . '" type="audio/mpeg">
                        //     Your browser does not support the audio element.
                        //     </audio>
                        // ';
                    }

                    $record['soal'] = strip_tags($soal);
                    $record['jawaban'] = [];

                    // echo $record['soal'];
                    // return;

                    // $jawaban_table = '
                    //     <table class="table" border="0">
                    //         <tr>
                    //           <td colspan="4">' . $soal . '</td>
                    //         </tr>
                    // ';

                    // cek tipe soal
                    // Jika soal adalah jenis pilihan ganda
                    if ($temp->soal_tipe == 1) {
                        $query_jawaban = $this->cbt_tes_soal_jawaban_model->get_by_tessoal($temp->tessoal_id);
                        if ($query_jawaban->num_rows() > 0) {
                            $query_jawaban = $query_jawaban->result();
                            $a = 0;
                            // $jawaban_table = $jawaban_table . '
                            //         <tr>
                            //               <td width="5%"> </td>
                            //               <td width="5%">Kunci</td>
                            //               <td width="5%">Pilihan</td>
                            //               <td width="85%">Jawaban</td>
                            //         </tr>
                            //     ';
                            foreach ($query_jawaban as $jawaban) {
                                $temp_jawaban = strip_tags($jawaban->jawaban_detail);
                                $temp_jawaban = str_replace("[base_url]", base_url(), $temp_jawaban);

                                $temp_benar = '';
                                if ($jawaban->jawaban_benar == 1) {
                                    $temp_benar = '1';
                                }
                                $temp_pilihan = '';
                                if ($jawaban->soaljawaban_selected == 1) {
                                    $temp_pilihan = '1';
                                }

                                // $jawaban_table = $jawaban_table . '
                                //     <tr>
                                //           <td width="5%">' . ++$a . '.</td>
                                //           <td width="5%">' . $temp_benar . '</td>
                                //           <td width="5%">' . $temp_pilihan . '</td>
                                //           <td width="85%">' . $temp_jawaban . '</td>
                                //     </tr>
                                // ';

                                $record['jawaban'][] = [
                                    'pilih' => $temp_pilihan,
                                    'kunci' => $temp_benar,
                                    'text' => $temp_jawaban,
                                ];
                            }
                        }
                    } else if ($temp->soal_tipe == 2) {
                        continue;
                        // Jika soal adalah soal essay
                        // $jawaban_table = $jawaban_table . '
                        //     <tr>
                        //         <td width="5%"></td>
                        //         <td width="5%">Skor</td>
                        //         <td width="90%" colspan="2">Jawaban</td>
                        //     </tr>
                        //     <tr>
                        //         <td width="5%"></td>
                        //         <td width="5%">' . $temp->tessoal_nilai . '</td>
                        //         <td width="90%" colspan="2"><div style="width:100%;"><pre style="white-space: pre-wrap;word-wrap: break-word;">' . $temp->tessoal_jawaban_text . '</pre></div></td>
                        //     </tr>
                        // ';
                    } else if ($temp->soal_tipe == 3) {
                        continue;
                        // Jika soal adalah soal Jawaban Singkat
                        // $jawaban_table = $jawaban_table . '
                        //     <tr>
                        //         <td width="5%"></td>
                        //         <td width="5%">Skor</td>
                        //         <td width="90%" colspan="2">Jawaban Singkat</td>
                        //     </tr>
                        //     <tr>
                        //         <td width="5%"></td>
                        //         <td width="5%">' . $temp->tessoal_nilai . '</td>
                        //         <td width="90%" colspan="2"><div style="width:100%;">' . $temp->tessoal_jawaban_text . '</div></td>
                        //     </tr>
                        // ';
                    }
                    // $jawaban_table = $jawaban_table . '</table>';
                    // $record[] = $jawaban_table;
                    // $data['content'][] = $record; // SAID

                    $data['content'][] = $record;
                }
                // echo json_encode($data);
                // return;

                $this->load->library('tools');


                $inputFileName = './public/form/form-result-tes.xlsx';
                $spreadsheet = IOFactory::load($inputFileName);
                $spreadsheet->setActiveSheetIndex(0);

                // $spreadsheet->setActiveSheetIndex(0)->getColumnDimension('B')->setAutoSize(true);
                $spreadsheet->setActiveSheetIndex(0)->getStyle('A9:A999')->getAlignment()->setHorizontal('center')->setVertical('center');
                $spreadsheet->setActiveSheetIndex(0)->getStyle('C9:E999')->getAlignment()->setHorizontal('center')->setVertical('center');

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B3', ': ' . $data['user']->user_firstname);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B4', ': ' . $data['user']->user_detail);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B5', ': ' . $data['user']->kelas);
                if ((int) $data['user']->kelas == 1 || (int) $data['user']->kelas == 2) {
                    $level = 1;
                } else if ((int) $data['user']->kelas == 3 || (int) $data['user']->kelas == 4) {
                    $level = 2;
                } else if ((int) $data['user']->kelas == 5 || (int) $data['user']->kelas == 6) {
                    $level = 3;
                } else if ((int) $data['user']->kelas >= 7 && (int) $data['user']->kelas <= 9) {
                    $level = 4;
                } else {
                    $level = '';
                }
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B6', ': Level ' . $level);

                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E4', ': ' . $data['tes_nama']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E5', ': ' . $data['nilai']);
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E6', ': ' . $data['benar']);
                // $spreadsheet->setActiveSheetIndex(0)->setCellValue('C4', $this->tools->indonesian_date($tanggal[0], 'j F Y', '') . ' - ' . $this->tools->indonesian_date($tanggal[1], 'j F Y', ''));
                // $spreadsheet->setActiveSheetIndex(0)->setCellValue('C5', $query_tes->num_rows());

                if (count($data['content']) > 0) {
                    // $kolom = ;
                    $indexSoal = 0;
                    foreach ($data['content'] as $i => $soal) {
                        $rowSoal = $i + 9 + $indexSoal;
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . ($rowSoal), ($i + 1));
                        $spreadsheet->setActiveSheetIndex(0)->getStyle('B' . ($rowSoal))->getAlignment()->setWrapText(true);
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . ($rowSoal), html_entity_decode(htmlspecialchars_decode($soal['soal']), ENT_QUOTES, 'UTF-8'));
                        $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . ($rowSoal), 'SOAL');

                        foreach ($data['content'][$i]['jawaban'] as $j => $jawaban) {
                            $rowJawaban = $rowSoal + 1 + $j;
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . ($rowJawaban), html_entity_decode(htmlspecialchars_decode($jawaban['text']), ENT_QUOTES, 'UTF-8'));
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . ($rowJawaban), 'JAWABAN');
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . ($rowJawaban), html_entity_decode(htmlspecialchars_decode($jawaban['kunci']), ENT_QUOTES, 'UTF-8'));
                            $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . ($rowJawaban), html_entity_decode(htmlspecialchars_decode($jawaban['pilih']), ENT_QUOTES, 'UTF-8'));

                            $indexKunci = 0;
                            $indexPilih = 0;

                            if ($jawaban['kunci'] == 1) {
                                $indexKunci = $j;
                            }

                            if ($jawaban['pilih'] == 1) {
                                $indexPilih = $j;
                            }

                            if ($indexKunci == $indexPilih) {
                                $spreadsheet->getActiveSheet()->getStyle('A' . $rowSoal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3ADB17');
                                $spreadsheet->getActiveSheet()->getStyle('D' . $rowSoal . ':E' . $rowSoal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3ADB17');
                            } else {
                                $spreadsheet->getActiveSheet()->getStyle('A' . $rowSoal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DB1409');
                                $spreadsheet->getActiveSheet()->getStyle('D' . $rowSoal . ':E' . $rowSoal)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DB1409');
                            }

                            $indexSoal++;
                        }
                        // $spreadsheet->setActiveSheetIndex(0)->setCellValue($this->tools->getAlpha($kolom) . $i, $soal['soal']);
                    }

                    // $kolom = 4;
                    // foreach ($query_tes as $tes) {
                    //     $spreadsheet->setActiveSheetIndex(0)->setCellValue($this->tools->getAlpha($kolom) . '8', $tes->tes_nama);
                    //     if ($kolom == 25) {
                    //         $kolom = 4;
                    //     } else {
                    //         $kolom++;
                    //     }
                    // }

                    // $row = 9;
                    // foreach ($query_user as $user) {
                    //     $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $row, ($row - 8));
                    //     $spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $row, $user->user_firstname);
                    //     $spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $row, $user->kelas);

                    //     $kolom = 4;
                    //     foreach ($query_tes as $tes) {
                    //         // Mendapatkan nilai tiap Tes untuk setiap siswa
                    //         $query_nilai = $this->cbt_tes_user_model->get_nilai_by_tes_user($tes->tes_id, $user->user_id);
                    //         if ($query_nilai->num_rows() > 0) {
                    //             $query_nilai = $query_nilai->row();
                    //             $spreadsheet->setActiveSheetIndex(0)->setCellValue($this->tools->getAlpha($kolom) . $row, $query_nilai->nilai);
                    //         } else {
                    //             $spreadsheet->setActiveSheetIndex(0)->setCellValue($this->tools->getAlpha($kolom) . $row, 0);
                    //         }

                    //         if ($kolom == 25) {
                    //             $kolom = 4;
                    //         } else {
                    //             $kolom++;
                    //         }
                    //     }

                    //     $row++;
                    // }
                }

                // Rename worksheet
                $spreadsheet->getActiveSheet()->setTitle('Report-Tes');

                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $spreadsheet->setActiveSheetIndex(0);

                // Redirect output to a client’s web browser (Xlsx)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Hasil Tes - ' . $data['user']->user_firstname . ' - ' . $data['tes_nama'] . ' - ' . date('Y-m-d H-i') . '.xlsx"');
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

                // echo json_encode($data);
                // dd($data);
            } else {
                redirect('manager/tes_rekap_hasil');
            }
        } else {
            redirect('manager/tes_rekap_hasil');
        }
    }

    public function load_detail()
    {
        $idUser = $this->input->post('idUser');
        $idTes = $this->input->post('idTes');
        $getTesUser = $this->db->query('SELECT * FROM cbt_tes_user WHERE tesuser_user_id = "' . $idUser . '" AND tesuser_tes_id = "' . $idTes . '"')->row();
        echo site_url() . '/manager/tes_hasil_detail/index/' . $getTesUser->tesuser_id;
        return;
    }
}
