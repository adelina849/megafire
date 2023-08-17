<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_data_pelanggan extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->model(array('M_data_pelanggan'));
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
				
				//1. GET DATA PELANGGAN/PEMILIK
					$query = "
								SELECT 
									* 
									,
									SUBSTRING_INDEX(A.wil_prov,'|',1) AS kode_prov,
									SUBSTRING_INDEX(A.wil_prov,'|',-1) AS nama_prov,
									
									SUBSTRING_INDEX(A.wil_kabkot,'|',1) AS kode_kabkot,
									SUBSTRING_INDEX(A.wil_kabkot,'|',-1) AS nama_kabkot,
									
									SUBSTRING_INDEX(A.wil_kec,'|',1) AS kode_kec,
									SUBSTRING_INDEX(A.wil_kec,'|',-1) AS nama_kec,
									
									SUBSTRING_INDEX(A.wil_des,'|',1) AS kode_des,
									SUBSTRING_INDEX(A.wil_des,'|',-1) AS nama_des
								FROM tb_pelanggan AS A
								WHERE (nik_pelanggan LIKE '%".$cari."%' OR no_pelanggan LIKE '%".$cari."%' OR nama_pelanggan LIKE '%".$cari."%')
								ORDER BY tgl_ins DESC
								LIMIT ".$this->uri->segment(2,0).",50
								;
							";
					$get_data_pelanggan = $this->M_general->view_query_general($query);
					if(!empty($get_data_pelanggan))
					{
						$jum_pelanggan = $get_data_pelanggan->num_rows();
						$list_data_pelanggan = $get_data_pelanggan;
					}
					else
					{
						$jum_pelanggan = 0;
						$list_data_pelanggan = false;
					}
				//1. GET DATA PELANGGAN/PEMILIK
				
				
				$this->load->library('pagination');
				//$config['first_url'] = base_url().'admin/jabatan?'.http_build_query($_GET);
				//$config['base_url'] = base_url().'admin/jabatan/';
				
				$config['first_url'] = site_url('data-pemilik?'.http_build_query($_GET));
				$config['base_url'] = site_url('data-pemilik/');
				$config['total_rows'] = $jum_pelanggan;
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
				
				$msgbox_title = " Data Dasar Pelanggan";
				
				//1. GET DATA PROVINSI
					$query = "SELECT kode,nama FROM wilayah_2020 WHERE length(kode) = 2  GROUP BY kode,nama ORDER BY nama ASC;";
					$get_data_prov = $this->M_general->view_query_general($query);
				//1. GET DATA PROVINSI
				
				//2. GET NO PELANGGAN
					$get_no_pelanggan = $this->M_data_pelanggan->get_no_pelanggan();
					if(!empty($get_no_pelanggan))
					{
						$get_no_pelanggan = $get_no_pelanggan->id_pelanggan;
					}
					else
					{
						$get_no_pelanggan = "";
					}
				//2. GET NO PELANGGAN
				
				$data = array('page_content'=>'page_data_dasar_pelanggan','halaman'=>$halaman,'list_data_pelanggan'=>$list_data_pelanggan,'msgbox_title' => $msgbox_title,'get_data_prov' => $get_data_prov,'get_no_pelanggan' => $get_no_pelanggan);
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
					
					$this->M_data_pelanggan->ubah
					(
						$_POST['stat_edit'],
						$_POST['jenis_pelanggan'],
						$_POST['nik_pelanggan'],
						$_POST['no_pelanggan'],
						$_POST['nama_pelanggan'],
						$_POST['kelamin'],
						$_POST['tempat_lahir'],
						$_POST['tgl_lahir'],
						$_POST['tlp'],
						$_POST['email'],
						$_POST['wil_prov'],
						$_POST['wil_kabkot'],
						$_POST['wil_kec'],
						$_POST['wil_des'],
						$_POST['alamat'],
						$_POST['ket_pelanggan'],
						$_POST['nama_perusahaan'],
						$_POST['jabatan'],
						$_POST['user'],
						$_POST['pass'],
						$_POST['avatar']
					);
				}
				else
				{
					$this->M_data_pelanggan->simpan
					(
						$_POST['jenis_pelanggan'],
						$_POST['nik_pelanggan'],
						$_POST['no_pelanggan'],
						$_POST['nama_pelanggan'],
						$_POST['kelamin'],
						$_POST['tempat_lahir'],
						$_POST['tgl_lahir'],
						$_POST['tlp'],
						$_POST['email'],
						$_POST['wil_prov'],
						$_POST['wil_kabkot'],
						$_POST['wil_kec'],
						$_POST['wil_des'],
						$_POST['alamat'],
						$_POST['ket_pelanggan'],
						$_POST['nama_perusahaan'],
						$_POST['jabatan'],
						'', //$_POST['user'],
						'', //$_POST['pass'],
						'' //$_POST['avatar']

					);
					
				}
				header('Location: '.base_url().'data-pemilik');
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
				$query = "DELETE FROM tb_pelanggan WHERE MD5(id_pelanggan) = '".$this->uri->segment(2,0)."';";
				$this->M_general->exec_query_general($query);
				
				header('Location: '.base_url().'data-pemilik');
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function simpan_akun()
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
				$query = "
							UPDATE tb_pelanggan 
								SET 
									user = '".htmlentities(str_replace("'","",$_POST['user']), ENT_QUOTES, 'UTF-8')."',
									pass = '".base64_encode(md5(htmlentities(str_replace("'","",$_POST['pass']), ENT_QUOTES, 'UTF-8')))."'
							WHERE MD5(id_pelanggan) = '".htmlentities(str_replace("'","",$_POST['id_pelanggan']), ENT_QUOTES, 'UTF-8')."';
						";
				$this->M_general->exec_query_general($query);
				
				echo'BERHASIL';
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function get_list_kabkot()
	{
		$cari_kabkot = " AND LEFT(kode,2) = LEFT('".$_POST['kode_prov']."',2)";
		$get_kabkot = $this->M_general->get_kabkot($cari_kabkot);
		if(!empty($get_kabkot))
		{
			$list_result = $get_kabkot->result();
			foreach($list_result as $row)
			{
				echo'<option value="'.$row->kode.'|'.$row->nama.'">'.$row->nama.'</option>';
			}
		}
	}

	function get_list_kec()
	{
		$cari_kec = " AND LEFT(kode,5) = LEFT('".$_POST['kode_kabkot']."',5)";
		$get_kec = $this->M_general->get_kec($cari_kec);
		if(!empty($get_kec))
		{
			$list_result = $get_kec->result();
			foreach($list_result as $row)
			{
				echo'<option value="'.$row->kode.'|'.$row->nama.'">'.$row->nama.'</option>';
			}
		}
	}
	
	function get_list_desa()
	{
		$cari_desa = " AND LEFT(kode,8) = LEFT('".$_POST['kode_kec']."',8)";
		$get_desa = $this->M_general->get_desa($cari_desa);
		if(!empty($get_desa))
		{
			$list_result = $get_desa->result();
			foreach($list_result as $row)
			{
				echo'<option value="'.$row->kode.'|'.$row->nama.'">'.$row->nama.'</option>';
			}
		}
	}
	
	function cek_data_pelanggan()
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
				$query = "SELECT no_pelanggan FROM tb_pelanggan WHERE no_pelanggan = '".htmlentities(str_replace("'","",$_POST['no_pelanggan']), ENT_QUOTES, 'UTF-8')."';";
				$ger_data_pelanggan = $this->M_general->view_query_general($query);
				
				if(!empty($ger_data_pelanggan))
				{
					$ger_data_pelanggan = $ger_data_pelanggan->row();
					echo $hasil_cek->no_pelanggan;
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
				
				//1. GET DATA PELANGGAN/PEMILIK
					$query = "
								SELECT 
									* 
									,
									SUBSTRING_INDEX(A.wil_prov,'|',1) AS kode_prov,
									SUBSTRING_INDEX(A.wil_prov,'|',-1) AS nama_prov,
									
									SUBSTRING_INDEX(A.wil_kabkot,'|',1) AS kode_kabkot,
									SUBSTRING_INDEX(A.wil_kabkot,'|',-1) AS nama_kabkot,
									
									SUBSTRING_INDEX(A.wil_kec,'|',1) AS kode_kec,
									SUBSTRING_INDEX(A.wil_kec,'|',-1) AS nama_kec,
									
									SUBSTRING_INDEX(A.wil_des,'|',1) AS kode_des,
									SUBSTRING_INDEX(A.wil_des,'|',-1) AS nama_des
								FROM tb_pelanggan AS A
								WHERE (nik_pelanggan LIKE '%".$cari."%' OR no_pelanggan LIKE '%".$cari."%' OR nama_pelanggan LIKE '%".$cari."%')
								ORDER BY tgl_ins DESC
								LIMIT ".$this->uri->segment(2,0).",50
								;
							";
					$get_data_pelanggan = $this->M_general->view_query_general($query);
					if(!empty($get_data_pelanggan))
					{
						$jum_pelanggan = $get_data_pelanggan->num_rows();
						$list_data_pelanggan = $get_data_pelanggan;
					}
					else
					{
						$jum_pelanggan = 0;
						$list_data_pelanggan = false;
					}
				//1. GET DATA PELANGGAN/PEMILIK
				
				$data = array('page_content'=>'excel_data_dasar_pelanggan','list_data_pelanggan'=>$list_data_pelanggan);
				$this->load->view('admin/excel_data_dasar_pelanggan.html',$data);
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
}
