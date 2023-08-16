<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_transaksi_pembelian extends CI_Controller 
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
				
				//1. LIST DATA APAR
					$query = "
								SELECT
									A.*
									,COALESCE(B.nik,'') AS nik_petugas
									,COALESCE(B.nama_petugas,'') AS nama_petugas
									,COALESCE(B.jabatan,'') AS jabatan_petugas
									,COALESCE(B.tempat_tugas,'') AS tempat_tugas_petugas
									
									,COALESCE(C.nik_pelanggan,'') AS nik_pelanggan
									,COALESCE(C.nama_pelanggan,'') AS nama_pelanggan
									,COALESCE(C.nama_perusahaan,'') AS nama_perusahaan_pelanggan
									,COALESCE(C.jabatan,'') AS jabatan_pelanggan
									
									,COALESCE(D.no_apar,'') AS no_apar
									,COALESCE(D.jenis_apar,'') AS jenis_apar
									,COALESCE(D.kapasitas,'') AS kapasitas_apar
									,COALESCE(D.merek,'') AS merek_apar
								FROM tb_pembelian AS A
								LEFT JOIN tb_petugas AS B ON A.id_petugas = B.id_petugas
								LEFT JOIN tb_pelanggan AS C ON A.id_pelanggan = C.id_pelanggan
								LEFT JOIN tb_apar AS D ON A.id_apar = D.id_apar
								
								WHERE 
										(
											A.no_apar LIKE '%".$cari."%'
											OR A.pemilik_apar LIKE '%".$cari."%'
											OR A.penyimpanan LIKE '%".$cari."%'
											OR A.lokasi_apar LIKE '%".$cari."%'
											OR A.desa LIKE '%".$cari."%'
											OR A.kecamatan LIKE '%".$cari."%'
											
											OR COALESCE(B.nama_petugas,'') LIKE '%".$cari."%'
											OR COALESCE(C.nama_pelanggan,'') LIKE '%".$cari."%'
											OR COALESCE(D.no_apar,'') LIKE '%".$cari."%'
										)
											
								ORDER BY A.id_pembelian DESC
								LIMIT ".$this->uri->segment(2,0).",30
								;
							";
					$get_list_pembelian = $this->M_general->view_query_general($query);
					if(!empty($get_list_pembelian))
					{
						$list_pembelian = $get_list_pembelian;
					}
					else
					{
						$list_pembelian = false;
					}
				//1. LIST DATA APAR
				
				//2. JUM ROW DATA APAR
					$query = "
								SELECT
									COUNT(A.id_pembelian) AS CNT_PEMBELIAN
								FROM tb_pembelian AS A
								LEFT JOIN tb_petugas AS B ON A.id_petugas = B.id_petugas
								LEFT JOIN tb_pelanggan AS C ON A.id_pelanggan = C.id_pelanggan
								LEFT JOIN tb_apar AS D ON A.id_apar = D.id_apar
								
								WHERE 
										(
											A.no_apar LIKE '%".$cari."%'
											OR A.pemilik_apar LIKE '%".$cari."%'
											OR A.penyimpanan LIKE '%".$cari."%'
											OR A.lokasi_apar LIKE '%".$cari."%'
											OR A.desa LIKE '%".$cari."%'
											OR A.kecamatan LIKE '%".$cari."%'
											
											OR COALESCE(B.nama_petugas,'') LIKE '%".$cari."%'
											OR COALESCE(C.nama_pelanggan,'') LIKE '%".$cari."%'
											OR COALESCE(D.no_apar,'') LIKE '%".$cari."%'
										)
								;
							";
					$get_jum_pembelian = $this->M_general->view_query_general($query);
					if(!empty($get_jum_pembelian))
					{
						$get_jum_pembelian = $get_jum_pembelian->num_rows();
					}
					else
					{
						$get_jum_pembelian = 0;
					}
				//2. JUM ROW DATA APAR
				
				
				$this->load->library('pagination');
				//$config['first_url'] = base_url().'admin/jabatan?'.http_build_query($_GET);
				//$config['base_url'] = base_url().'admin/jabatan/';
				
				$config['first_url'] = site_url('transaksi-pembelian?'.http_build_query($_GET));
				$config['base_url'] = site_url('transaksi-pembelian/');
				$config['total_rows'] = $get_jum_pembelian;
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
				
				$msgbox_title = " Data Pembelian APAR (Termasuk Pembeli dan Petugas)";
				
				
				$data = array('page_content'=>'page_transaksi_pembelian','halaman'=>$halaman,'list_pembelian'=>$list_pembelian,'msgbox_title' => $msgbox_title);
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
