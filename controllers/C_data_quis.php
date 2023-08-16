<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_data_quis extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->model(array('M_data_quis'));
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
				if((!empty($_GET['cari'])) && ($_GET['cari']!= "")  )
				{
					$cari = str_replace("'","",$_GET['cari']);
				}
				else
				{
					$cari = "";
				}
				
				//1. GET DATA APAR
					$query = "
								SELECT * FROM tb_quis 
								WHERE pertanyaan LIKE '%".$cari."%'
								ORDER BY idx ASC
								LIMIT ".$this->uri->segment(2,0).",30
								;
							";
					$get_data_quis = $this->M_general->view_query_general($query);
					if(!empty($get_data_quis))
					{
						$jum_quis = $get_data_quis->num_rows();
						$list_data_quis = $get_data_quis;
					}
					else
					{
						$jum_quis = 0;
						$list_data_quis = false;
					}
				//1. GET DATA APAR
				
				
				$this->load->library('pagination');
				//$config['first_url'] = base_url().'admin/jabatan?'.http_build_query($_GET);
				//$config['base_url'] = base_url().'admin/jabatan/';
				
				$config['first_url'] = site_url('data-quis?'.http_build_query($_GET));
				$config['base_url'] = site_url('data-quis/');
				$config['total_rows'] = $jum_quis;
				$config['uri_segment'] = 2;	
				$config['per_page'] = 30;
				$config['num_links'] = 2;
				$config['suffix'] = '?' . http_build_query($_GET, '', "&");
				//$config['use_page_numbers'] = TRUE;
				//$config['page_query_string'] = false;
				//$config['query_string_segment'] = '';
				$config['first_page'] = 'Awal';
				$config['last_page'] = 'Akhir';
				$config['next_page'] = '&laquo;';
				$config['prev_page'] = '&raquo;';
				
				
				$config['full_tag_open'] = '<div><ul class="pagination">';
				$config['full_tag_close'] = '</ul></div>';
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev page">';
				$config['first_tag_close'] = '</li>';
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next page">';
				$config['last_tag_close'] = '</li>';
				$config['next_link'] = 'Next &rarr;';
				$config['next_tag_open'] = '<li class="next page">';
				$config['next_tag_close'] = '</li>';
				$config['prev_link'] = '&larr; Previous';
				$config['prev_tag_open'] = '<li class="prev page">';
				$config['prev_tag_close'] = '</li>';
				$config['cur_tag_open'] = '<li class="active"><a href="">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="page">';
				$config['num_tag_close'] = '</li>';
				
				
				//inisialisasi config
				$this->pagination->initialize($config);
				$halaman = $this->pagination->create_links();
				
				$msgbox_title = " Data Pertanyaan/Quis untuk petugas";
				
				//2. IDX
					$query_idx = "SELECT COUNT(idx) AS idx FROM tb_quis;";
					$get_data_quis_idx = $this->M_general->view_query_general($query_idx);
					if(!empty($get_data_quis_idx))
					{
						$get_data_quis_idx = $get_data_quis_idx->row();
						$get_data_quis_idx = $get_data_quis_idx->idx + 1;
					}
					else
					{
						$get_data_quis_idx = 0;
					}
				//2. IDX
				
				
				$data = array('page_content'=>'page_data_dasar_quis','halaman'=>$halaman,'list_data_quis'=>$list_data_quis,'msgbox_title' => $msgbox_title,'get_data_quis_idx' => $get_data_quis_idx);
				$this->load->view('admin/container',$data);
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function simpan()
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
				if (!empty($_POST['stat_edit']))
				{	
					
					$this->M_data_quis->ubah
					(
						$_POST['stat_edit'],
						$_POST['pertanyaan'],
						$_POST['isBollean']
					);
				}
				else
				{
					$this->M_data_quis->simpan
					(
						$_POST['idx'],
						$_POST['pertanyaan'],
						$_POST['isBollean']
					);
					
				}
				header('Location: '.base_url().'data-quis');
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function hapus()
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
				$query = "DELETE FROM tb_quis WHERE MD5(idx) = '".$this->uri->segment(2,0)."';";
				$this->M_general->exec_query_general($query);
				
				header('Location: '.base_url().'data-quis');
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}

	function cek_idx_quis()
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
				$query = "SELECT idx FROM tb_quis WHERE idx = '".htmlentities(str_replace("'","",$_POST['idx']), ENT_QUOTES, 'UTF-8')."';";
				$ger_data_no_quis = $this->M_general->view_query_general($query);
				
				if(!empty($ger_data_no_quis))
				{
					$ger_data_no_quis = $ger_data_no_quis->row();
					echo $hasil_cek->idx;
				}
				else
				{
					return false;
				}
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	public function view_excel()
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
				if((!empty($_GET['cari'])) && ($_GET['cari']!= "")  )
				{
					$cari = str_replace("'","",$_GET['cari']);
				}
				else
				{
					$cari = "";
				}
				
				//1. GET DATA APAR
					$query = "
								SELECT * FROM tb_quis 
								WHERE pertanyaan LIKE '%".$cari."%'
								ORDER BY idx ASC
								;
							";
					$get_data_quis = $this->M_general->view_query_general($query);
					if(!empty($get_data_quis))
					{
						$jum_quis = $get_data_quis->num_rows();
						$list_data_quis = $get_data_quis;
					}
					else
					{
						$jum_quis = 0;
						$list_data_quis = false;
					}
				//1. GET DATA APAR
				
				$data = array('page_content'=>'excel_data_dasar_quis','list_data_quis'=>$list_data_quis);
				$this->load->view('admin/excel_data_dasar_quis.html',$data);
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
}
