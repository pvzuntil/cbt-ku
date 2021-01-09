<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tes_dashboard extends Tes_Controller
{
	private $kelompok = 'ujian';
	private $url = 'tes_dashboard';
	private $willCheck = [
		// [
		// 	'tableName' => 'telepon',
		// 	'displayName' => 'Nomer Telepon (WhatsApp)',
		// 	'value' => false,
		// 	'type' => 'text',
		// 	'rule' => 'required|numeric|min_length[10]',
		// ],
		// [
		// 	'tableName' => 'kelas',
		// 	'displayName' => 'Kelas',
		// 	'value' => false,
		// 	'type' => 'kelas',
		// 	'rule' => 'required',
		// ],
		// [
		// 	'tableName' => 'lomba',
		// 	'displayName' => 'Pelajaran',
		// 	'value' => false,
		// 	'type' => 'lomba',
		// 	'rule' => 'required'
		// ]
	];

	function __construct()
	{
		parent::__construct();
		$this->load->model('cbt_user_model');
		$this->load->model('cbt_user_pay_model');
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
		$this->load->model('cbt_juara_model');
		$this->load->model('cbt_lomba_model');

		$this->load->library('MLib');

		setlocale(LC_ALL, 'id-ID', 'id_ID');
	}

	public function index()
	{
		$this->load->helper('form');
		$data['group'] = $this->access_tes->get_group();
		$data['url'] = $this->url;
		$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));

		$username = $this->access_tes->get_username();
		$currentUser = $this->cbt_user_model->get_by_kolom_limit('user_email', $username, 1)->row();
		$user_id = $currentUser->user_id;
		$data['nama'] = $currentUser->user_firstname;
		$query_tes = $this->cbt_tes_user_model->get_by_user_status($user_id);
		$data['currentUser'] = $currentUser;

		$parseCurrentUser = json_decode(json_encode($currentUser), true);

		$newWillCheck = [];
		$item = '';

		$get_laporan = $this->cbt_juara_model->get_laporan();
		$data['pengumuman'] = $get_laporan->row();

		$data['daftarLomba'] = $this->mlib->getLombaHR($currentUser->lomba);

		for ($i = 0; $i < count($this->willCheck); $i++) {
			$getValue = $parseCurrentUser[$this->willCheck[$i]['tableName']];
			$this->willCheck[$i]['value'] = $getValue == null ? false : true;

			if (!$this->willCheck[$i]['value']) {
				array_push($newWillCheck, $this->willCheck[$i]);
				$item .= $this->willCheck[$i]['tableName'] . ',';
			}
		}

		$data['willCheck'] = $newWillCheck;
		$data['item'] = $item;

		if ($query_tes->num_rows() > 0) {
			$query_tes = $query_tes->result();
			$tanggal = new DateTime();
			foreach ($query_tes as $tes) {
				// Cek apakah tes sudah melebihi batas waktu
				$tanggal_tes = new DateTime($tes->tesuser_creation_time);
				$tanggal_tes->modify('+' . $tes->tes_duration_time . ' minutes');
				if ($tanggal > $tanggal_tes) {
					// jika waktu sudah melebihi waktu ketentuan, maka status tes diubah menjadi 4
					$data_tes['tesuser_status'] = 4;
					$this->cbt_tes_user_model->update('tesuser_id', $tes->tesuser_id, $data_tes);
				}
			}
		}

		$userPay = $this->cbt_user_pay_model->get_by_kolom('cbt_user_id', $user_id)->row();

		if ($userPay != null) {
			if ($userPay->status == 'allow') {
				$data['showPay'] = false;
				if ($userPay->isShow == 0) {
					$data['isShow'] = $userPay->isShow;
					$this->cbt_user_pay_model->update('id', $userPay->id, ['isShow' => 1]);
				} else {
					$data['isShow'] = 1;
				}
			} else {
				$data['showPay'] = true;
				$data['userPay'] = $userPay;
				$data['userPay_status'] = $userPay->status;

				$date_pay = $userPay->date_pay;
				$explodeMulai = explode(' ', $date_pay);
				$explodeMulaiJam = explode(':', $explodeMulai[1]);

				$data['date_pay'] = strftime("%A, %d %B %Y", strtotime($explodeMulai[0])) . ' ' . $explodeMulaiJam[0] . ':' . $explodeMulaiJam[1];
			}
		}

		if ($userPay == null) {
			$data['showPay'] = true;
			$data['userPay_status'] = 'none';
		}

		// dd($userPay);
		if ((int) $currentUser->kelas == 1 || (int) $currentUser->kelas == 2) {
			$data['level'] = 1;
		} else if ((int) $currentUser->kelas == 3 || (int) $currentUser->kelas == 4) {
			$data['level'] = 2;
		} else if ((int) $currentUser->kelas == 5 || (int) $currentUser->kelas == 6) {
			$data['level'] = 3;
		} else if ((int) $currentUser->kelas >= 7 && (int) $currentUser->kelas <= 9) {
			$data['level'] = 4;
		} else {
			$data['level'] = '';
		}

		// BAYAR SETTING
		$query = $this->db->query('select konfigurasi_isi from cbt_konfigurasi where konfigurasi_kode like "bayar_%"')->result();
		$data['conf_bayar'] = $query;

		$query = $this->cbt_konfigurasi_model->get_by_kolom_limit('konfigurasi_kode', 'bayar_aktif', 1);
		if ($query->num_rows() > 0) {
			$data['bayar_aktif'] = $query->row()->konfigurasi_isi;
		}

		$this->template->display_tes($this->kelompok . '/tes_dashboard_view', 'Dashboard', $data);
	}

	/**
	 * Konfirmasi tes yang akan dilakukan
	 *
	 * @param      <type>  $tes_id  The tes identifier
	 */
	function konfirmasi_test($tes_id = null)
	{
		if (!empty($tes_id)) {
			$query_tes = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $tes_id, 1);
			if ($query_tes->num_rows() > 0) {
				$query_tes = $query_tes->row();

				$tanggal = new DateTime();
				$tanggal_tes = new DateTime($query_tes->tes_end_time);
				if ($tanggal < $tanggal_tes) {
					// Cek terlebih dahulu, apakah sudah pernah memulai tes
					$username = $this->access_tes->get_username();
					$user_id = $this->cbt_user_model->get_by_kolom_limit('user_email', $username, 1)->row()->user_id;

					if ($this->cbt_tes_user_model->count_by_user_tes($user_id, $query_tes->tes_id)->row()->hasil == 0) {
						// Menampilkan konfirmasi Tes
						$data['tes_id'] = $query_tes->tes_id;
						$data['nama'] = $this->access_tes->get_nama();
						$data['group'] = $this->access_tes->get_group();
						$data['timestamp'] = strtotime(date('Y-m-d H:i:s'));
						$data['url'] = $this->url;
						$data['tes_nama'] = $query_tes->tes_nama;
						$data['tes_waktu'] = $query_tes->tes_duration_time . ' menit';
						$data['tes_poin'] = $query_tes->tes_score_right;
						$data['tes_max_score'] = $query_tes->tes_max_score;
						if ($query_tes->tes_token == 1) {
							$data['tes_token'] = '
				        		<tr style="height: 45px;">
		                            <td></td>
		                            <td style="vertical-align: middle;text-align: right;">Token : </td>
		                            <td style="vertical-align: middle;"><input type="text" name="token" id="token" autocomplete="off"></td>
		                            <td></td>
		                        </tr>
				        	';
						} else {
							$data['tes_token'] = '<input type="hidden" name="token" id="token">';
						}

						if ($data['tes_max_score'] > 0) {
							$this->template->display_tes($this->kelompok . '/tes_start_view', 'Mulai Tes', $data);
						} else {
							redirect('tes_dashboard');
						}
					} else {
						redirect('tes_dashboard');
					}
				} else {
					redirect('tes_dashboard');
				}
			} else {
				redirect('tes_dashboard');
			}
		} else {
			redirect('tes_dashboard');
		}
	}

	/**
	 * Memulai tes
	 * nilai status
	 * 		0 = gagal
	 * 		1 = sukses
	 * 		2 = gagal, halaman dikembalikan ke dashboard
	 */
	function mulai_tes()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('tes-id', 'Tes', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$tes_id = $this->input->post('tes-id', TRUE);
			$token = $this->input->post('token', TRUE);

			$username = $this->access_tes->get_username();
			$user_id = $this->cbt_user_model->get_by_kolom_limit('user_email', $username, 1)->row()->user_id;

			$query_tes = $this->cbt_tes_model->get_by_kolom_limit('tes_id', $tes_id, 1);
			if ($query_tes->num_rows() > 0) {
				$query_tes = $query_tes->row();
				// Cek apakah tes sudah pernah dilakukan
				if ($this->cbt_tes_user_model->count_by_user_tes($user_id, $tes_id)->row()->hasil == 0) {
					// Mengecek apakah token di isi sesuai ketentuan tes
					$is_ok = 1;
					if ($query_tes->tes_token == 1) {
						if (empty($token)) {
							$is_ok = 0;
						} else {
							// pengecekan token apakah sesuai dengan yang dibuat operator
							$query_token = $this->cbt_tes_token_model->get_by_token_now_limit($token, 1);
							if ($query_token->num_rows() > 0) {
								$query_token = $query_token->row();

								// Mengecek token apakah dapat digunakan oleh semua TES
								if ($query_token->token_tes_id == 0) {
									// Jika token dapat digunakan oleh semua TES
									// token_aktif==1 maka berarti token aktif 1 hari
									if ($query_token->token_aktif == 1) {
										$data_tes['tesuser_token'] = $token;
									} else {
										if ($this->cbt_tes_token_model->count_by_token_lifetime($token, $query_token->token_aktif)->row()->hasil > 0) {
											$data_tes['tesuser_token'] = $token;
										} else {
											$is_ok = 0;
										}
									}
								} else {
									// Jika token hanya spesifik untuk salah satu Tes
									// token_aktif==1 maka berarti token aktif 1 hari
									if ($query_token->token_tes_id == $tes_id) {
										if ($query_token->token_aktif == 1) {
											$data_tes['tesuser_token'] = $token;
										} else {
											if ($this->cbt_tes_token_model->count_by_token_lifetime($token, $query_token->token_aktif)->row()->hasil > 0) {
												$data_tes['tesuser_token'] = $token;
											} else {
												$is_ok = 0;
											}
										}
									} else {
										$is_ok = 0;
									}
								}
							} else {
								$is_ok = 0;
							}
						}
					}
					if ($is_ok == 1) {
						// Mengecek apakah test mempunyai data soal
						if ($this->cbt_tes_topik_set_model->count_by_kolom('tset_tes_id', $query_tes->tes_id)->row()->hasil > 0) {
							// Memulai transaction mysql
							$this->db->trans_start();

							// 1. Memasukkan data ke test_user
							$data_tes['tesuser_tes_id'] = $tes_id;
							$data_tes['tesuser_user_id'] = $user_id;
							$data_tes['tesuser_status'] = 1;
							$data_tes['tesuser_creation_time'] = date('Y-m-d H:i:s');

							$tests_users_id = $this->cbt_tes_user_model->save($data_tes);

							// Mengambil data topik yang ada pada tes
							$query_subject_set = $this->cbt_tes_topik_set_model->get_by_kolom('tset_tes_id', $tes_id)->result();
							$i_soal = 0;
							// Mengambil data topik berdasarkan tes
							foreach ($query_subject_set as $subject_set) {
								// Mengambil data soal sesuai jumlah berdasarkan topik, tipe, dan kesulitan
								// Mengecek apakah soal diacak atau tidak
								// Soal yang tidak diacak, diurutkan berdasarkan soal_id
								if ($subject_set->tset_acak_soal == 1) {
									$query_soal = $this->cbt_soal_model->get_by_topik_tipe_kesulitan_select_limit($subject_set->tset_topik_id, $subject_set->tset_tipe, $subject_set->tset_difficulty, 'soal_id,soal_topik_id,soal_tipe,soal_audio', $subject_set->tset_jumlah);
								} else {
									$query_soal = $this->cbt_soal_model->get_by_topik_tipe_kesulitan_select_limit_tanpa_acak($subject_set->tset_topik_id, $subject_set->tset_tipe, $subject_set->tset_difficulty, 'soal_id,soal_topik_id,soal_tipe,soal_audio', $subject_set->tset_jumlah);
								}
								if ($query_soal->num_rows() > 0) {
									$query_soal = $query_soal->result();
									$insert_soal = array();
									foreach ($query_soal as $soal) {
										// Memasukkan data soal ke table tests_logs
										$data_soal['tessoal_tesuser_id'] = $tests_users_id;
										$data_soal['tessoal_soal_id'] = $soal->soal_id;
										//$data_soal['tessoal_nilai'] = 0;
										$data_soal['tessoal_nilai'] = $query_tes->tes_score_unanswered;
										$data_soal['tessoal_creation_time'] = date('Y-m-d H:i:s');
										$data_soal['tessoal_order'] = ++$i_soal;

										$insert_soal[] = $data_soal;
									}
									// menggunakan batch query langsung untuk mengehemat waktu dan memory
									$this->cbt_tes_soal_model->save_batch($insert_soal);

									// Mengambil data soal pada test_log 
									$query_test_log = $this->cbt_tes_soal_model->get_by_testuser_select($tests_users_id, $subject_set->tset_topik_id, 'tessoal_id, soal_id, soal_tipe')->result();
									foreach ($query_test_log as $test_log) {
										// Jika tipe soal pilihan ganda
										if ($test_log->soal_tipe == 1) {
											// Jika jawaban diacak 
											if ($subject_set->tset_acak_jawaban == 1) {
												// mendapatkan jawaban dari soal yang ada dengan diacak terlebih dahulu
												$query_jawaban = $this->cbt_jawaban_model->get_by_soal_limit($test_log->soal_id, $subject_set->tset_jawaban);
												// Jika jumlah jawaban lebih dari 0
												if ($query_jawaban->num_rows() > 0) {
													$query_jawaban = $query_jawaban->result();
													$i_jawaban = 0;
													$insert_jawaban = array();
													foreach ($query_jawaban as $jawaban) {
														// Menyimpan data soal
														$data_jawaban['soaljawaban_jawaban_id'] = $jawaban->jawaban_id;
														$data_jawaban['soaljawaban_order'] = ++$i_jawaban;
														$data_jawaban['soaljawaban_selected'] = 0;
														$data_jawaban['soaljawaban_tessoal_id'] = $test_log->tessoal_id;

														$insert_jawaban[] = $data_jawaban;
													}
													//insert batch
													$this->cbt_tes_soal_jawaban_model->save_batch($insert_jawaban);
												}
											} else {
												// Mendapatkan jawaban yang tidak diacak
												$query_jawaban = $this->cbt_jawaban_model->get_by_soal_tanpa_acak($test_log->soal_id);
												// Jika jumlah jawaban lebih dari 0
												if ($query_jawaban->num_rows() > 0) {
													$query_jawaban = $query_jawaban->result();
													$i_jawaban = 0;
													$insert_jawaban = array();
													foreach ($query_jawaban as $jawaban) {
														// Menyimpan data soal
														$data_jawaban['soaljawaban_jawaban_id'] = $jawaban->jawaban_id;
														$data_jawaban['soaljawaban_order'] = ++$i_jawaban;
														$data_jawaban['soaljawaban_selected'] = 0;
														$data_jawaban['soaljawaban_tessoal_id'] = $test_log->tessoal_id;

														$insert_jawaban[] = $data_jawaban;
													}
													//insert batch
													$this->cbt_tes_soal_jawaban_model->save_batch($insert_jawaban);
												}
											}
										}
									}
								}
							}
							// Menutup transaction mysql
							$this->db->trans_complete();

							$status['status'] = 1;
							$status['tes_id'] = $tes_id;
							$status['pesan'] = 'Pembuatan tes untuk user berhasil';
						} else {
							$status['status'] = 2;
							$status['pesan'] = '';
						}
					} else {
						$status['status'] = 0;
						$status['pesan'] = 'Silahkan cek Token yang dimasukkan !';
					}
				} else {
					$status['status'] = 2;
					$status['pesan'] = '';
				}
			} else {
				$status['status'] = 2;
				$status['pesan'] = '';
			}
		} else {
			$status['status'] = 0;
			$status['pesan'] = array_values($this->form_validation->error_array())[0];
		}

		echo json_encode($status);
	}


	/**
	 * Merubah password user tes
	 */
	function password()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('password-old', 'Password Lama', 'required|strip_tags');
		$this->form_validation->set_rules('password-new', 'Password Baru', 'required|strip_tags');
		$this->form_validation->set_rules('password-confirm', 'Confirm Password', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$old = $this->input->post('password-old', TRUE);
			$new = $this->input->post('password-new', TRUE);
			$confirm = $this->input->post('password-confirm', TRUE);

			$username = $this->access_tes->get_username();

			if ($this->cbt_user_model->count_by_username_password($username, $old) > 0) {
				if ($new == $confirm) {
					$data['user_password'] = $new;

					$this->cbt_user_model->update('user_email', $username, $data);
					$status['status'] = 1;
					$status['error'] = '';
				} else {
					$status['status'] = 0;
					$status['error'] = 'Kedua password baru tidak sama';
				}
			} else {
				$status['status'] = 0;
				$status['error'] = 'Password Lama tidak Sesuai';
			}
		} else {
			$status['status'] = 0;
			$status['error'] = array_values($this->form_validation->error_array())[0];
		}

		echo json_encode($status);
	}

	/**
	 * Mendapatkan daftar tes yang dapat diikuti
	 */
	function get_datatable()
	{

		// variable initialization
		$search = "";
		$start = 0;
		$rows = 499;

		$username = $this->access_tes->get_username();
		$currentUser = $this->cbt_user_model->get_by_kolom_limit('user_email', $username, 1)->row();

		$user_id = $currentUser->user_id;
		$userLomba = json_decode($currentUser->lomba);
		$userkelas = $currentUser->kelas;

		// $group = $this->access_tes->get_group();
		// $grup_id = $this->cbt_user_grup_model->get_by_kolom_limit('grup_nama', $group, 1)->row()->grup_id;

		// get search value (if any)
		if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
			$search = $_GET['sSearch'];
		}

		// limit
		$start = $this->get_start();
		$rows = $this->get_rows();

		// run query to get user listing
		$query = $this->cbt_tesgrup_model->get_datatable($start, $rows, $userkelas, $userLomba);
		// dd($query);
		$iFilteredTotal = $query->num_rows();

		$iTotal = count($query->result());

		$output = array(
			"sEcho" => isset($_GET['sEcho']) ? intval($_GET['sEcho']) : '',
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iTotal,
			"aaData" => array()
		);

		// get result after running query and put it in array
		$i = $start;
		$query = $query->result();

		foreach ($query as $temp) {
			$record = array();

			$adaSoal = $this->cbt_tes_topik_set_model->count_by_kolom('tset_tes_id', $temp->tes_id)->row()->hasil;

			if ($adaSoal > 0) {
				$sedangMengerjakan = $this->cbt_tes_user_model->get_sedang_mengerjakan($user_id, $temp->tes_id)->row();
				// echo json_encode($sedangMengerjakan);
				// die();

				$record[] = ++$i;
				$record[] = $temp->tes_nama;

				$mulai = $temp->tes_begin_time;
				$explodeMulai = explode(' ', $mulai);
				$explodeMulaiJam = explode(':', $explodeMulai[1]);

				$record[] = strftime("%A, %d %B %Y", strtotime($explodeMulai[0])) . ' ' . $explodeMulaiJam[0] . ':' . $explodeMulaiJam[1];

				$selesai = $temp->tes_end_time;
				$explodeSelesai = explode(' ', $selesai);
				$explodeSelesaiJam = explode(':', $explodeSelesai[1]);

				$record[] = strftime("%A, %d %B %Y", strtotime($explodeSelesai[0])) . ' ' . $explodeSelesaiJam[0] . ':' . $explodeSelesaiJam[1];

				if ($sedangMengerjakan == null) {

					$waktuMulaiTes = $temp->tes_begin_time;
					$waktuSelesaiTes = $temp->tes_end_time;
					$waktuNow = date("Y-m-d H:i:s");

					if ($waktuNow >= $waktuMulaiTes && $waktuNow <= $waktuSelesaiTes) {
						$record[] = '';
						$record[] = '';
						$record[] = '<a href="' . site_url() . '/' . $this->url . '/konfirmasi_test/' . $temp->tes_id . '" style="cursor: pointer;" class="btn btn-success btn-xs">Kerjakan</a>';
					} else {
						if ($waktuNow >= $waktuSelesaiTes) {
							$record[] = '';
							$record[] = '';
							$record[] = '<button href="#" style="cursor: pointer;" class="btn btn-warning btn-xs btn-disabled" disable>Expired</button>';
						} else {
							$record[] = '';
							$record[] = '';
							$record[] = '<button href="#" style="cursor: pointer;" class="btn btn-default btn-xs btn-disabled" disable>Belum dimulai</button>';
						}
					}
				} else {
					$tanggal = new DateTime();
					$query_test_user = $this->cbt_tes_user_model->get_by_user_tes($user_id, $temp->tes_id)->row();
					$tanggal_tes = new DateTime($query_test_user->tesuser_creation_time);
					$tanggal_tes->modify('+' . $temp->tes_duration_time . ' minutes');

					if ($tanggal < $tanggal_tes and $query_test_user->tesuser_status != 4) {
						// nilai kosong karena masih dalam pengerjaan
						$record[] = '';
						$record[] = '';
						// Jika masih dalam waktu pengerjaan, maka tes dilanjutkan
						$record[] = '<a href="' . site_url() . '/tes_kerjakan/index/' . $temp->tes_id . '" style="cursor: pointer;" class="btn btn-primary btn-xs">Lanjutkan</a>';
					} else {
						$timeSpan = $query_test_user->time_span;
						if (empty($timeSpan)) {
							// $record[] = 'Waktu habis';
							$record[] = '(' . $temp->tes_duration_time . ' Menit 0 Detik)';
						} else {
							$pecah = explode(',', $timeSpan);
							$record[] = ' (' . $pecah[0] . ' Menit ' . $pecah[1] . ' Detik)';
						}

						// menampilkan nilai
						// Cek apakah tes yang selesai ditampilkan nilainya
						if ($temp->tes_results_to_users == 1) {
							$record[] = $this->cbt_tes_soal_model->get_nilai($query_test_user->tesuser_id)->row()->hasil;
						} else {
							$record[] = '';
						}

						// mengecek apakah detail tes ditampilkan
						if ($temp->tes_detail_to_users == 1) {
							$record[] = '<a href="' . site_url() . '/tes_hasil_detail/index/' . $query_test_user->tesuser_id . '" style="cursor: pointer;" class="btn btn-default btn-xs">Lihat Detail</a>';
						} else {
							$record[] = '';
						}
					}
				}

				$output['aaData'][] = $record;
			}
		}
		// ============== END NEW LOGIC

		// Cek apakah tes yang terdaftar pada group memiliki soal sesuai topik yang ada
		// if ($this->cbt_tes_topik_set_model->count_by_kolom('tset_tes_id', $temp->tes_id)->row()->hasil > 0) {
		// 	$record[] = ++$i;
		// 	$record[] = $temp->tes_nama . '|' . $temp->tesuser_user_id;

		// 	$mulai = $temp->tes_begin_time;
		// 	$explodeMulai = explode(' ', $mulai);
		// 	$explodeMulaiJam = explode(':', $explodeMulai[1]);

		// 	$record[] = strftime("%A, %d %B %Y", strtotime($explodeMulai[0])) . ' ' . $explodeMulaiJam[0] . ':' . $explodeMulaiJam[1];

		// 	$selesai = $temp->tes_end_time;
		// 	$explodeSelesai = explode(' ', $selesai);
		// 	$explodeSelesaiJam = explode(':', $explodeSelesai[1]);

		// 	$record[] = strftime("%A, %d %B %Y", strtotime($explodeSelesai[0])) . ' ' . $explodeSelesaiJam[0] . ':' . $explodeSelesaiJam[1];


		// 	// Cek apakah sudah mengikuti tes tetapi belum selesai
		// 	if ($this->cbt_tes_user_model->count_by_user_tes($user_id, $temp->tes_id)->row()->hasil > 0) {
		// 		// Cek apakah sudah selesai atau belum, jika blum selesai maka tes bisa dilanjutkan
		// 		$tanggal = new DateTime();
		// 		$query_test_user = $this->cbt_tes_user_model->get_by_user_tes($user_id, $temp->tes_id)->row();
		// 		$tanggal_tes = new DateTime($query_test_user->tesuser_creation_time);
		// 		$tanggal_tes->modify('+' . $temp->tes_duration_time . ' minutes');

		// 		if ($tanggal < $tanggal_tes and $query_test_user->tesuser_status != 4) {
		// 			// nilai kosong karena masih dalam pengerjaan
		// 			$record[] = '';
		// 			$record[] = '';
		// 			// Jika masih dalam waktu pengerjaan, maka tes dilanjutkan
		// 			$record[] = '<a href="' . site_url() . '/tes_kerjakan/index/' . $temp->tes_id . '" style="cursor: pointer;" class="btn btn-default btn-xs">Lanjutkan</a>';
		// 		} else {
		// 			$timeSpan = $temp->time_span ?? false;
		// 			if ($timeSpan == false) {
		// 				// $record[] = 'Waktu habis';
		// 				$record[] = '(' . $temp->tes_duration_time . ' Menit 0 Detik)';
		// 			} else {
		// 				$pecah = explode(',', $timeSpan);
		// 				$record[] = ' (' . $pecah[0] . ' Menit ' . $pecah[1] . ' Detik)';
		// 			}

		// 			// menampilkan nilai
		// 			// Cek apakah tes yang selesai ditampilkan nilainya
		// 			if ($temp->tes_results_to_users == 1) {
		// 				$record[] = $this->cbt_tes_soal_model->get_nilai($query_test_user->tesuser_id)->row()->hasil;
		// 			} else {
		// 				$record[] = '';
		// 			}

		// 			// mengecek apakah detail tes ditampilkan
		// 			if ($temp->tes_detail_to_users == 1) {
		// 				$record[] = '<a href="' . site_url() . '/tes_hasil_detail/index/' . $query_test_user->tesuser_id . '" style="cursor: pointer;" class="btn btn-default btn-xs">Lihat Detail</a>';
		// 			} else {
		// 				$record[] = '';
		// 			}
		// 		}
		// 	} else {
		// 		$waktuMulaiTes = $temp->tes_begin_time;
		// 		$waktuSelesaiTes = $temp->tes_end_time;
		// 		$waktuNow = date("Y-m-d H:i:s");

		// 		if ($waktuNow >= $waktuMulaiTes && $waktuNow <= $waktuSelesaiTes) {
		// 			$record[] = '';
		// 			$record[] = '';
		// 			$record[] = '<a href="' . site_url() . '/' . $this->url . '/konfirmasi_test/' . $temp->tes_id . '" style="cursor: pointer;" class="btn btn-success btn-xs">Kerjakan</a>';
		// 		} else {
		// 			if ($waktuNow >= $waktuSelesaiTes) {
		// 				$record[] = '';
		// 				$record[] = '';
		// 				$record[] = '<a href="#" style="cursor: pointer;" class="btn btn-warning btn-xs btn-disabled" disabled>Expired</a>';
		// 			} else {
		// 				$record[] = '';
		// 				$record[] = '';
		// 				$record[] = '<a href="#" style="cursor: pointer;" class="btn btn-success btn-xs btn-disabled" disabled>Belum dimulai</a>';
		// 			}
		// 		}
		// 	}

		// 	$output['aaData'][] = $record;
		// }
		// }
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

	function optional()
	{

		$secureCheck = json_decode(base64_decode($this->input->post('secureCheck', true)));

		$this->load->library('form_validation');
		foreach ($secureCheck as $check) {
			$this->form_validation->set_rules($check->tableName, $check->displayName, $check->rule);
		}

		if ($this->form_validation->run() == TRUE) {
			$username = $this->access_tes->get_username();
			$currentUser = $this->cbt_user_model->get_by_kolom_limit('user_email', $username, 1)->row();

			$data = [];
			foreach ($secureCheck as $check) {
				$data[$check->tableName] = $this->input->post($check->tableName, true);
			}
			$this->cbt_user_model->update('user_id', $currentUser->user_id, $data);

			$status['status'] = 1;
			$status['error'] = 'Terimakasih sudah melengkapi data.';
		} else {
			$status['status'] = 0;
			$status['error'] = array_values($this->form_validation->error_array())[0];
		}
		echo json_encode($status);
	}

	function pay()
	{
		$username = $this->access_tes->get_username();
		$currentUser = $this->cbt_user_model->get_by_kolom_limit('user_email', $username, 1)->row();
		$user_id = $currentUser->user_id;

		$this->load->library('form_validation');

		$this->form_validation->set_rules('uploadImgPayText', 'Gambar', 'required');

		if ($this->form_validation->run() == TRUE) {
			$imgPay = $this->input->post('uploadImgPayText');
			$explodeImgPay = explode('data:image/', $imgPay);
			$explodeImgPay = explode(';base64,', $explodeImgPay[1]);
			$imgExt = $explodeImgPay[0];
			$imgPay = $explodeImgPay[1];
			$imgName = 'public/images/pay/' . $user_id . '-' . time() . '.' . $imgExt;

			$file =  file_put_contents('./' . $imgName, base64_decode($imgPay));

			$this->cbt_user_pay_model->save([
				'cbt_user_id' => $user_id,
				'pay' => 1,
				'status' => 'wait',
				'date_pay' => date('Y-m-d H:i:s'),
				'img_pay' => $imgName
			]);

			$status['status'] = 1;
			$status['pesan'] = 'Berhasil mengirim bukti pembayaran. Silahkan tunggu paling lambat 24 Jam untuk admin mengkonfirmasi bukti pembayaran anda. Jika belum dikonfirmasi dalam 24 jam, silahkan hubungi panitia.';
		} else {
			$status['status'] = 0;
			$status['pesan'] = array_values($this->form_validation->error_array())[0];
		}
		echo json_encode($status);
	}
	function cert_save()
	{
		$username = $this->access_tes->get_username();
		$currentUser = $this->cbt_user_model->get_by_kolom_limit('user_email', $username, 1)->row();
		$user_id = $currentUser->user_id;
		$this->load->library('form_validation');

		$this->form_validation->set_rules('cert-nama', 'Nama Lengkap', 'required|strip_tags');
		$this->form_validation->set_rules('cert-sekolah', 'Asal Sekolah', 'required|strip_tags');

		if ($this->form_validation->run() == TRUE) {
			$data['user_firstname'] = $this->input->post('cert-nama', true);
			$data['user_detail'] = $this->input->post('cert-sekolah', true);
			$data['downloadCert'] = 1;

			$this->cbt_user_model->update('user_id', $user_id, $data);
			$status['status'] = 1;
			$status['pesan'] = 'Perubahan berhasil disimpan';
		} else {
			$status['status'] = 0;
			$status['error'] = array_values($this->form_validation->error_array())[0];
		}

		echo json_encode($status);
	}
}
