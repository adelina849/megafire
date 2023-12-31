<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_login extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('captcha','array'));
		$this->load->library(array('form_validation'));
		$this->config->load('cap');
	}
		
	public function index()
	{
		clearstatcache();
		$this->load->view('admin/login.html');
		//echo'ADE';
	}
	
	function cek_login()
	{
		//$get_kode_kantor = htmlentities($_POST['kode_kantor'], ENT_QUOTES, 'UTF-8');
		$user = htmlentities(str_replace("'","",$_POST['user']), ENT_QUOTES, 'UTF-8');
		$pass = htmlentities(str_replace("'","",$_POST['pass']), ENT_QUOTES, 'UTF-8');
		$pass_enc = base64_encode( md5($pass) );
		$check = isset($_POST['chk_saya_bukan_robot']) ? "checked" : "unchecked";
		
		if($check == 'checked') //PASTIKAN CEKLIST DI CEK
		{
			//1. Cek User dan Pass
			$query_get_akun = "SELECT * FROM tb_akun WHERE user = '".$user."' AND pass = '".$pass_enc."';";
			$get_akun = $this->M_general->view_query_general($query_get_akun);
			if(!empty($get_akun))
			{
				$get_login = $get_akun->row();
				
				//2. Get Data kantor/tentang
				$get_ttg = $this->M_general->get_data_kantor();
				
				//3. Set session
				$user = array(
					'ses_gbl_id_tentang' => $get_ttg->id_tentang,
					'ses_gbl_nama_aplikasi' => $get_ttg->nama_aplikasi,
					'ses_gbl_judul_aplikasi' => $get_ttg->judul_aplikasi,
					'ses_gbl_ket_aplikasi' => $get_ttg->keterangan,
					'ses_gbl_tlp_aplikasi' => $get_ttg->tlp,
					'ses_gbl_email_aplikasi' => $get_ttg->email,
					'ses_gbl_web_aplikasi' => $get_ttg->web,
					'ses_gbl_url_video_aplikasi' => $get_ttg->url_video,
					'ses_gbl_alamat_aplikasi' => $get_ttg->alamat,
					'ses_gbl_versi_app' => $get_ttg->versi_app,
					
					'ses_gbl_id_akun' => $get_login->id_akun,
					'ses_gbl_nik_akun' => $get_login->nik,
					'ses_gbl_nama_akun' => $get_login->nama_pegawai,
					'ses_gbl_kelamin_akun' => $get_login->kelamin,
					'ses_gbl_tempat_lahir_akun' => $get_login->tampat_lahir,
					'ses_gbl_tgl_lahir_akun' => $get_login->tgl_lahir,
					'ses_gbl_email_akun' => $get_login->email,
					'ses_gbl_tlp_akun' => $get_login->tlp,
					'ses_gbl_alamat_akun' => $get_login->alamat,
					'ses_gbl_jenis_akun' => $get_login->jenis_akun,
					'ses_gbl_user_akun' => $get_login->user,
					'ses_gbl_pass_ori_akun' => $pass,
					'ses_gbl_pass_enc_akun' => $get_login->pass,
				);
				$this->session->set_userdata($user);
				//3. Set session
				
				//4. Redirect
				//echo'BERHASIL MASUK';
				header('Location: '.base_url('dashboard-admin'));
				//4. Redirect
			}
			else
			{
				//2. CEK DATA PEMILIK
				$query_get_akun = "SELECT * FROM tb_pelanggan WHERE user = '".$user."' AND pass = '".$pass_enc."' AND  isverif = '1';";
				$get_akun = $this->M_general->view_query_general($query_get_akun);
				if(!empty($get_akun))
				{
					$get_login = $get_akun->row();
					echo'ADA AKUN PMILIK';
					
					//2. Get Data kantor/tentang
					$get_ttg = $this->M_general->get_data_kantor();
					
					//3. Set session
					$user = array(
						'ses_gbl_id_tentang' => $get_ttg->id_tentang,
						'ses_gbl_nama_aplikasi' => $get_ttg->nama_aplikasi,
						'ses_gbl_judul_aplikasi' => $get_ttg->judul_aplikasi,
						'ses_gbl_ket_aplikasi' => $get_ttg->keterangan,
						'ses_gbl_tlp_aplikasi' => $get_ttg->tlp,
						'ses_gbl_email_aplikasi' => $get_ttg->email,
						'ses_gbl_web_aplikasi' => $get_ttg->web,
						'ses_gbl_url_video_aplikasi' => $get_ttg->url_video,
						'ses_gbl_alamat_aplikasi' => $get_ttg->alamat,
						'ses_gbl_versi_app' => $get_ttg->versi_app,
						
						'ses_gbl_id_akun' => $get_login->id_pelanggan,
						'ses_gbl_nik_akun' => $get_login->nik_pelanggan,
						'ses_gbl_nama_akun' => $get_login->nama_pelanggan,
						'ses_gbl_kelamin_akun' => $get_login->kelamin,
						'ses_gbl_tempat_lahir_akun' => $get_login->tempat_lahir,
						'ses_gbl_tgl_lahir_akun' => $get_login->tgl_lahir,
						'ses_gbl_email_akun' => $get_login->email,
						'ses_gbl_tlp_akun' => $get_login->tlp,
						'ses_gbl_alamat_akun' => $get_login->alamat,
						'ses_gbl_jenis_akun' => 'PEMILIK',
						'ses_gbl_user_akun' => $get_login->user,
						'ses_gbl_pass_ori_akun' => $pass,
						'ses_gbl_pass_enc_akun' => $get_login->pass,
					);
					$this->session->set_userdata($user);
					//3. Set session
					
					//4. Redirect
					//echo'BERHASIL MASUK';
					header('Location: '.base_url('dashboard-admin'));
					//4. Redirect
				}
				else
				{
					header('Location: '.base_url().'?from=none');
				}
			}
		}
		else
		{
			header('Location: '.base_url().'?from=cek');
		}
	}
	
	function logout()
	{
		
		$this->session->unset_userdata('ses_gbl_nama_aplikasi');
		$this->session->unset_userdata('ses_gbl_judul_aplikasi');
		$this->session->unset_userdata('ses_gbl_ket_aplikasi');
		$this->session->unset_userdata('ses_gbl_tlp_aplikasi');
		$this->session->unset_userdata('ses_gbl_email_aplikasi');
		$this->session->unset_userdata('ses_gbl_web_aplikasi');
		$this->session->unset_userdata('ses_gbl_url_video_aplikasi');
		$this->session->unset_userdata('ses_gbl_alamat_aplikasi');
		
		$this->session->unset_userdata('ses_gbl_id_akun');
		$this->session->unset_userdata('ses_gbl_nik_akun');
		$this->session->unset_userdata('ses_gbl_nama_akun');
		$this->session->unset_userdata('ses_gbl_kelamin_akun');
		$this->session->unset_userdata('ses_gbl_tempat_lahir_akun');
		$this->session->unset_userdata('ses_gbl_tgl_lahir_akun');
		$this->session->unset_userdata('ses_gbl_email_akun');
		$this->session->unset_userdata('ses_gbl_tlp_akun');
		$this->session->unset_userdata('ses_gbl_alamat_akun');
		$this->session->unset_userdata('ses_gbl_user_akun');
		$this->session->unset_userdata('ses_gbl_pass_ori_akun');
		$this->session->unset_userdata('ses_gbl_pass_enc_akun');
		
		
		header('Location: '.base_url());
	}
	
	function is_verifikasi_email_pemilik()
	{
		$id_pemilik = $this->uri->segment(2,0);
		$query = "SELECT * FROM tb_pelanggan WHERE MD5(id_pelanggan) = '".$id_pemilik."' ";
		$get_akun = $this->M_general->view_query_general($query);
		if(!empty($get_akun))
		{
			$get_login = $get_akun->row();
			
			$query_update = "UPDATE tb_pelanggan SET isVerif_email = '1' WHERE MD5(id_pelanggan) = '".$id_pemilik."'; ";
			$this->M_general->exec_query_general($query_update);
			
			echo'
					<center>
					<b style="color:green;">.:AKUN PEMILIK:.<br/>SELAMAT '.$get_login->nama_pelanggan.' </b>
					<br/>- Email anda : <b>'.$get_login->email.'</b> Telah Terverifikasi. 
					<br/>- Pastikan Admin telah melakukan verifikasi terhadap akun anda agar bisa melakukan proses login di aplikasi andorid
					</center>
					';
		}
		else
		{
			echo'<h1 style="color:red;">URL TIDAK VALID !</h1>';
		}
		
	}
	
	function is_verifikasi_email_petugas()
	{
		$id_petugas = $this->uri->segment(2,0);
		$query = "SELECT * FROM tb_petugas WHERE MD5(id_petugas) = '".$id_petugas."' ";
		$get_akun = $this->M_general->view_query_general($query);
		if(!empty($get_akun))
		{
			$get_login = $get_akun->row();
			
			$query_update = "UPDATE tb_petugas SET isVerif_email = '1' WHERE MD5(id_petugas) = '".$id_petugas."'; ";
			$this->M_general->exec_query_general($query_update);
			
			echo'
					<center>
					<b style="color:green;">.:AKUN PETUGAS:.<br/>SELAMAT '.$get_login->nama_petugas.' </b>
					<br/>- Email anda : <b>'.$get_login->email.'</b> Telah Terverifikasi. 
					<br/>- Pastikan Admin telah melakukan verifikasi terhadap akun anda agar bisa melakukan proses login di aplikasi andorid
					</center>
					';
		}
		else
		{
			echo'<h1 style="color:red;">URL TIDAK VALID !</h1>';
		}
		
	}

	function get_data_apar_scan()
	{
		$id_pembelian = $this->uri->segment(2,0);
		//1. Cek data apar
		$query = "SELECT * FROM tb_pembelian AS A WHERE MD5(id_pembelian) = '".$id_pembelian."' ;";
		$get_data_apar = $this->M_general->view_query_general($query);
		if(!empty($get_data_apar))
		{
			$data_apar = $get_data_apar->row();
			
			//1. GET DATA APAR
					$query = "
								SELECT
									A.id_pembelian AS id_apar
									,CASE WHEN A.pemilik_apar = '' THEN
										COALESCE(C.nama_pelanggan,'')
									ELSE
										A.pemilik_apar
									END AS pemilik_apar
									,A.desa,A.kecamatan,A.kabupaten,COALESCE(B.merek,'') AS merek_apar,A.lokasi_apar,A.penyimpanan
									,COALESCE(B.kapasitas,'') AS kapasitas
									,COALESCE(B.jenis_apar,'') AS jenis_apar,A.tgl_beli,DATE_ADD(A.tgl_beli, INTERVAL 1 YEAR) AS tgl_exp
									,DATEDIFF(DATE(NOW()),A.tgl_beli) AS selisih
									,DATEDIFF( DATE_ADD(A.tgl_beli, INTERVAL 1 YEAR) 
														,DATE(NOW())
											) AS selisih_exp
									,CASE WHEN DATE(NOW()) >= DATE_ADD(A.tgl_beli, INTERVAL 1 YEAR)  THEN
										'SUDAH EXPIRED'
									ELSE
										'BELUM EXPIRED'
									END AS sts_exp
									,CASE WHEN COALESCE(D.id_pembelian,'') = '' THEN 'BELUM DICEK' ELSE 'SUDAH DICEK' END AS sts_cek
								FROM tb_pembelian AS A
								LEFT JOIN tb_apar AS B ON A.id_apar = B.id_apar
								LEFT JOIN tb_pelanggan AS C ON A.id_pelanggan = C.id_pelanggan
								LEFT JOIN (SELECT id_pembelian FROM tb_cek_apar GROUP BY id_pembelian) AS D ON A.id_pembelian = D.id_pembelian
								WHERE md5(A.id_pembelian) = '".$id_pembelian."'
								;
							";
					$get_data_apar_hasil_scan = $this->M_general->view_query_general($query);
					if(!empty($get_data_apar_hasil_scan))
					{
						$get_data_apar_hasil_scan = $get_data_apar_hasil_scan->row();
					}
					else
					{
						$get_data_apar_hasil_scan = false;
					}
				//1. GET DATA APAR
			//echo $query;
			
			$data = array('data_apar'=>$data_apar,'get_data_apar_hasil_scan' => $get_data_apar_hasil_scan);
			clearstatcache();
			$this->load->view('admin/public_get_info_apar_scan.html',$data);
			
			
		}
		else
		{
			$data_apar = false;
			$get_data_apar_hasil_scan = false;
			
			$data = array('data_apar'=>$data_apar,'get_data_apar_hasil_scan' => $get_data_apar_hasil_scan);
			clearstatcache();
			$this->load->view('admin/public_get_info_apar_scan.html',$data);
		}
		
	}
}
