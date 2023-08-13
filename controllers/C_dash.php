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
			$cek_ses_login = $this->M_general->get_akun($this->session->userdata('ses_gbl_user_akun'),$this->session->userdata('ses_gbl_pass_enc_akun'));
			if(!empty($cek_ses_login))
			{
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
				
				
				$data = array('page_content' => 'page_dashboard','get_data_apar' => $get_data_apar,'get_data_pemilik' => $get_data_pemilik,'get_data_petugas' => $get_data_petugas,'get_data_quis' => $get_data_quis);
				$this->load->view('admin/container',$data);
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
}
