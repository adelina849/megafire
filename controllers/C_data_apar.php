<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_data_apar extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->model(array('M_data_apar'));
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
								SELECT * FROM tb_apar 
								WHERE (no_apar LIKE '%".$cari."%' OR jenis_apar LIKE '%".$cari."%')
								ORDER BY tgl_ins DESC
								LIMIT ".$this->uri->segment(2,0).",30
								;
							";
					$get_data_apar = $this->M_general->view_query_general($query);
					if(!empty($get_data_apar))
					{
						$jum_apar = $get_data_apar->num_rows();
						$list_data_apar = $get_data_apar;
					}
					else
					{
						$jum_apar = 0;
						$list_data_apar = false;
					}
				//1. GET DATA APAR
				
				
				$this->load->library('pagination');
				//$config['first_url'] = base_url().'admin/jabatan?'.http_build_query($_GET);
				//$config['base_url'] = base_url().'admin/jabatan/';
				
				$config['first_url'] = site_url('data-apar?'.http_build_query($_GET));
				$config['base_url'] = site_url('data-apar/');
				$config['total_rows'] = $jum_apar;
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
				
				$msgbox_title = " Data Dasar APAR";
				
				$data = array('page_content'=>'page_data_dasar_apar','halaman'=>$halaman,'list_data_apar'=>$list_data_apar,'msgbox_title' => $msgbox_title);
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
					
					$this->M_data_apar->ubah
					(
						$_POST['stat_edit'],
						$_POST['no_apar'],
						$_POST['jenis_apar'],
						$_POST['kapasitas'],
						$_POST['merek'],
						$_POST['ket_apar']
					);
				}
				else
				{
					$this->M_data_apar->simpan
					(
						$_POST['no_apar'],
						$_POST['jenis_apar'],
						$_POST['kapasitas'],
						$_POST['merek'],
						$_POST['ket_apar']
					);
					
				}
				header('Location: '.base_url().'data-apar');
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
				$query = "DELETE FROM tb_apar WHERE MD5(id_apar) = '".$this->uri->segment(2,0)."';";
				$this->M_general->exec_query_general($query);
				
				header('Location: '.base_url().'data-apar');
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}

	function cek_no_apar()
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
				$query = "SELECT no_apar FROM tb_apar WHERE no_apar = '".htmlentities(str_replace("'","",$_POST['no_apar']), ENT_QUOTES, 'UTF-8')."';";
				$ger_data_no_apar = $this->M_general->view_query_general($query);
				
				if(!empty($ger_data_no_apar))
				{
					$ger_data_no_apar = $ger_data_no_apar->row();
					echo $hasil_cek->no_apar;
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
}
