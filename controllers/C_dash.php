<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_dash extends CI_Controller 
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
		if(($this->session->userdata('ses_gbl_user_akun') == null) or ($this->session->userdata('ses_gbl_pass_enc_akun') == null))
		{
			header('Location: '.base_url());
		}
		else
		{
			/*
			$cek_ses_login = $this->M_general->get_akun($this->session->userdata('ses_gbl_user_akun'),$this->session->userdata('ses_gbl_pass_enc_akun'));
			if(!empty($cek_ses_login))
			{
			*/
				//1. DATA APAR
					$query_get_data_apar = "SELECT COUNT(id_apar) AS CNT_APAR FROM tb_apar;";
					$get_data_apar = $this->M_general->view_query_general($query_get_data_apar);
					if(!empty($get_data_apar))
					{
						$get_data_apar = $get_data_apar->row();
						$get_data_apar = $get_data_apar->CNT_APAR;
					}
				//1. DATA APAR
				
				//2. DATA PEMILIK/PELANGGAN
					$query_get_data_pemilik = "SELECT COUNT(id_pelanggan) AS CNT_PEMILIK FROM tb_pelanggan;";
					$get_data_pemilik = $this->M_general->view_query_general($query_get_data_pemilik);
					if(!empty($get_data_pemilik))
					{
						$get_data_pemilik = $get_data_pemilik->row();
						$get_data_pemilik = $get_data_pemilik->CNT_PEMILIK;
					}
				//2. DATA PEMILIK/PELANGGAN
				
				//3. DATA PETUGAS
					$query_get_data_petugas = "SELECT COUNT(id_petugas) AS CNT_PETUGAS FROM tb_petugas;";
					$get_data_petugas = $this->M_general->view_query_general($query_get_data_petugas);
					if(!empty($get_data_petugas))
					{
						$get_data_petugas = $get_data_petugas->row();
						$get_data_petugas = $get_data_petugas->CNT_PETUGAS;
					}
				//3. DATA PETUGAS
				
				//4. DATA QUISIONER
					$query_get_data_quis = "SELECT COUNT(idx) AS CNT_QUIS FROM tb_quis;";
					$get_data_quis = $this->M_general->view_query_general($query_get_data_quis);
					if(!empty($get_data_quis))
					{
						$get_data_quis = $get_data_quis->row();
						$get_data_quis = $get_data_quis->CNT_QUIS;
					}
				//4. DATA QUISIONER
				
				//5. GRAFIK PENJUALAN
					$query_get_grafik_penjualan = "
							SELECT RIGHT(A.DATE_LIST,2) AS DATE_LIST,COALESCE(B.JUMLAH_KUNJUNGAN,0) AS JUM_KUNJUNGAN
							FROM
							(
								select * from
								(select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) AS DATE_LIST from
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
								 (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) v
								where DATE_LIST BETWEEN DATE(CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-01')) AND DATE(CONCAT(YEAR(NOW()),'-',MONTH(NOW()),'-',DATE_FORMAT(LAST_DAY(NOW()),'%d') ))
							) AS A
							LEFT JOIN
							(
								SELECT DATE(tgl_beli) AS DT, COUNT(id_pembelian) AS JUMLAH_KUNJUNGAN 
								FROM tb_pembelian
								GROUP BY DATE(tgl_beli)
							) AS B ON A.DATE_LIST = B.DT ORDER BY A.DATE_LIST ASC; 
					";
					$get_grafik_penjualan = $this->M_general->view_query_general($query_get_grafik_penjualan);
					// if(!empty($get_grafik_penjualan))
					// {
					// }
				//5. GRAFIK PENJUALAN
				
				
				$data = array('page_content' => 'page_dashboard','get_data_apar' => $get_data_apar,'get_data_pemilik' => $get_data_pemilik,'get_data_petugas' => $get_data_petugas,'get_data_quis' => $get_data_quis,'get_grafik_penjualan' =>$get_grafik_penjualan);
				$this->load->view('admin/container',$data);
			/*
			}
			else
			{
				header('Location: '.base_url());
			}
			*/
		}
	}
	
	function ubah_data_kantor()
	{
		if(($this->session->userdata('ses_gbl_user_akun') == null) or ($this->session->userdata('ses_gbl_pass_enc_akun') == null))
		{
			header('Location: '.base_url());
		}
		else
		{
			$cek_ses_login = $this->M_general->get_akun($this->session->userdata('ses_gbl_user_akun'),$this->session->userdata('ses_gbl_pass_enc_akun'));
			if(!empty($cek_ses_login))
			{
				$query = 
						"
							UPDATE tb_tentang SET
								nama_aplikasi= '".htmlentities(str_replace("'","",$_POST['nama_aplikasi']), ENT_QUOTES, 'UTF-8')."',
								judul_aplikasi= '".htmlentities(str_replace("'","",$_POST['judul_aplikasi']), ENT_QUOTES, 'UTF-8')."',
								keterangan= '".htmlentities(str_replace("'","",$_POST['keterangan']), ENT_QUOTES, 'UTF-8')."',
								alamat= '".htmlentities(str_replace("'","",$_POST['alamat']), ENT_QUOTES, 'UTF-8')."',
								tlp= '".htmlentities(str_replace("'","",$_POST['tlp']), ENT_QUOTES, 'UTF-8')."',
								email= '".htmlentities(str_replace("'","",$_POST['email']), ENT_QUOTES, 'UTF-8')."',
								web= '".htmlentities(str_replace("'","",$_POST['web']), ENT_QUOTES, 'UTF-8')."',
								url_video= '".htmlentities(str_replace("'","",$_POST['url_video']), ENT_QUOTES, 'UTF-8')."',
								versi_app= '".htmlentities(str_replace("'","",$_POST['versi_app']), ENT_QUOTES, 'UTF-8')."'
								WHERE id_tentang = '".htmlentities(str_replace("'","",$_POST['id_tentang']), ENT_QUOTES, 'UTF-8')."'

						";
				/*SIMPAN DAN CATAT QUERY*/
					$this->db->query($query);
				/*SIMPAN DAN CATAT QUERY*/
				
				$user = array(
					'ses_gbl_nama_aplikasi' => htmlentities(str_replace("'","",$_POST['nama_aplikasi']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_judul_aplikasi' => htmlentities(str_replace("'","",$_POST['judul_aplikasi']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_ket_aplikasi' => htmlentities(str_replace("'","",$_POST['keterangan']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_tlp_aplikasi' => htmlentities(str_replace("'","",$_POST['tlp']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_email_aplikasi' => htmlentities(str_replace("'","",$_POST['email']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_web_aplikasi' => htmlentities(str_replace("'","",$_POST['web']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_url_video_aplikasi' => htmlentities(str_replace("'","",$_POST['url_video']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_alamat_aplikasi' => htmlentities(str_replace("'","",$_POST['alamat']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_versi_app' => htmlentities(str_replace("'","",$_POST['versi_app']), ENT_QUOTES, 'UTF-8')
					
				);
				$this->session->set_userdata($user);
				
				//header('Location: '.base_url().'data-quis');
				echo'BERHASIL';
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function ubah_profil_akun()
	{
		if(($this->session->userdata('ses_gbl_user_akun') == null) or ($this->session->userdata('ses_gbl_pass_enc_akun') == null))
		{
			header('Location: '.base_url());
		}
		else
		{
			$cek_ses_login = $this->M_general->get_akun($this->session->userdata('ses_gbl_user_akun'),$this->session->userdata('ses_gbl_pass_enc_akun'));
			if(!empty($cek_ses_login))
			{
				$query = 
						"
							UPDATE tb_akun SET
									nik= '".htmlentities(str_replace("'","",$_POST['nik']), ENT_QUOTES, 'UTF-8')."',
									nama_pegawai= '".htmlentities(str_replace("'","",$_POST['nama_pegawai']), ENT_QUOTES, 'UTF-8')."',
									kelamin= '".htmlentities(str_replace("'","",$_POST['kelamin']), ENT_QUOTES, 'UTF-8')."',
									tampat_lahir= '".htmlentities(str_replace("'","",$_POST['tampat_lahir']), ENT_QUOTES, 'UTF-8')."',
									tgl_lahir= '".htmlentities(str_replace("'","",$_POST['tgl_lahir']), ENT_QUOTES, 'UTF-8')."',
									email= '".htmlentities(str_replace("'","",$_POST['email']), ENT_QUOTES, 'UTF-8')."',
									tlp= '".htmlentities(str_replace("'","",$_POST['tlp']), ENT_QUOTES, 'UTF-8')."',
									alamat= '".htmlentities(str_replace("'","",$_POST['alamat']), ENT_QUOTES, 'UTF-8')."',
									
									user= '".htmlentities(str_replace("'","",$_POST['user']), ENT_QUOTES, 'UTF-8')."',
									pass= '".base64_encode(md5(htmlentities(str_replace("'","",$_POST['pass']), ENT_QUOTES, 'UTF-8')))."'
								WHERE id_akun = '".htmlentities(str_replace("'","",$_POST['id_akun']), ENT_QUOTES, 'UTF-8')."'

						";
				/*SIMPAN DAN CATAT QUERY*/
					$this->db->query($query);
				/*SIMPAN DAN CATAT QUERY*/
				
				$user = array(
					'ses_gbl_id_akun'=>htmlentities(str_replace("'","",$_POST['id_akun']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_nik_akun'=>htmlentities(str_replace("'","",$_POST['nik']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_nama_akun'=>htmlentities(str_replace("'","",$_POST['nama_pegawai']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_kelamin_akun'=>htmlentities(str_replace("'","",$_POST['kelamin']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_tampat_lahir_akun'=>htmlentities(str_replace("'","",$_POST['tampat_lahir']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_tgl_lahir_akun'=>htmlentities(str_replace("'","",$_POST['tgl_lahir']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_email_akun'=>htmlentities(str_replace("'","",$_POST['email']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_tlp_akun'=>htmlentities(str_replace("'","",$_POST['tlp']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_alamat_akun'=>htmlentities(str_replace("'","",$_POST['alamat']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_user_akun'=>htmlentities(str_replace("'","",$_POST['user']), ENT_QUOTES, 'UTF-8'),
					'ses_gbl_pass_akun'=>htmlentities(str_replace("'","",$_POST['pass']), ENT_QUOTES, 'UTF-8')
				);
				$this->session->set_userdata($user);
				
				//header('Location: '.base_url().'data-quis');
				echo'BERHASIL';
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
}
