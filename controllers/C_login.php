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
				header('Location: '.base_url());
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
}
