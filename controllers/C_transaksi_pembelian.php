<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_transaksi_pembelian extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->model(array('M_transaksi_pembelian'));
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
									,COALESCE(C.no_pelanggan,'') AS no_pelanggan
									,COALESCE(C.nama_pelanggan,'') AS nama_pelanggan
									,COALESCE(C.nama_perusahaan,'') AS nama_perusahaan_pelanggan
									,COALESCE(C.jabatan,'') AS jabatan_pelanggan
									
									,COALESCE(D.no_apar,'') AS no_apar_ori
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
											
								ORDER BY A.tgl_transaksi DESC
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
				
				//3. GET NO TRANSAKSI APAR
					$get_no_tr_apar = $this->M_transaksi_pembelian->get_no_transaksi_apar();
					$get_no_tr_apar = $get_no_tr_apar->id_pembelian;
				//3. GET NO TRANSAKSI APAR
				
				$data = array('page_content'=>'page_transaksi_pembelian','halaman'=>$halaman,'list_pembelian'=>$list_pembelian,'msgbox_title' => $msgbox_title,'get_no_tr_apar' => $get_no_tr_apar);
				$this->load->view('admin/container',$data);
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function list_apar()
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
				if((!empty($_POST['cari'])) && ($_POST['cari']!= "")  )
				{
					$cari = htmlentities(str_replace("'","",$_POST['cari']), ENT_QUOTES, 'UTF-8');
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
								LIMIT 
								".htmlentities(str_replace("'","",$_POST['offset']), ENT_QUOTES, 'UTF-8')."
								,
								".htmlentities(str_replace("'","",$_POST['limit']), ENT_QUOTES, 'UTF-8')."
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
				
				if(!empty($list_data_apar))
				{
					echo '<div class="box-body table-responsive no-padding">';
						echo'<table width="100%" id="table_list_apar" class="table table-hover">';
							echo '<thead>
			<tr>';
										echo '<th width="5%">NO</th>';
										echo '<th width="15%">JENIS</th>';
										echo '<th width="20%">MEREK</th>';
										echo '<th width="15%">KAPASITAS</th>';
										echo '<th width="30%">KETERANGAN</th>';
										echo '<th width="15%">PILIH</th>';
									
										
							echo '</tr>
			</thead>';
							$list_result = $list_data_apar->result();
							//$no =$this->uri->segment(2,0)+1;
							$no = 1;
							echo '<tbody>';
							foreach($list_result as $row)
							{
								//echo'<tr id="tr_'.$no.'">';
								echo'<tr id="tr_list_apar-'.$no.'">';
								echo'<td>'.$no.'</td>';
								
									echo'<td>'.$row->jenis_apar.'</td>';
									echo'<td>'.$row->merek.'</td>';
									echo'<td>'.$row->kapasitas.'</td>';
									echo'<td>'.$row->ket_apar.'</td>';
									echo'<td>
										<button type="button" onclick="insert_apar('.$no.')" id="btn_pilih_apar_'.$no.'" class="btn btn-primary btn-sm" data-dismiss="modal">PILIH</button>
									</td>';
									
echo'<input type="hidden" id="get_tr_apar_2_'.$no.'" name="get_tr_apar_2_'.$no.'" value="get_tr_apar_2-'.$no.'" />';
echo'<input type="hidden" id="id_apar_'.$no.'" name="id_apar_'.$no.'" value="'.$row->id_apar.'" />';
echo'<input type="hidden" id="no_apar_'.$no.'" name="no_apar_'.$no.'" value="'.$row->no_apar.'" />';
echo'<input type="hidden" id="jenis_apar_'.$no.'" name="jenis_apar_'.$no.'" value="'.$row->jenis_apar.'" />';
echo'<input type="hidden" id="kapasitas_'.$no.'" name="kapasitas_'.$no.'" value="'.$row->kapasitas.'" />';
echo'<input type="hidden" id="merek_'.$no.'" name="merek_'.$no.'" value="'.$row->merek.'" />';
echo'<input type="hidden" id="ket_apar_'.$no.'" name="ket_apar_'.$no.'" value="'.$row->ket_apar.'" />';
echo'<input type="hidden" id="tgl_ins_'.$no.'" name="tgl_ins_'.$no.'" value="'.$row->tgl_ins.'" />';
echo'<input type="hidden" id="tgl_updt_'.$no.'" name="tgl_updt_'.$no.'" value="'.$row->tgl_updt.'" />';
echo'<input type="hidden" id="user_ins_'.$no.'" name="user_ins_'.$no.'" value="'.$row->user_ins.'" />';
echo'<input type="hidden" id="user_updt_'.$no.'" name="user_updt_'.$no.'" value="'.$row->user_updt.'" />';
									
								echo'</tr>';
								$no++;
							}
							
							echo '</tbody>';
						echo'</table>';
						echo'</div>';
				}
				else
				{
					echo'DATA APAR TIDAK DITEMUKAN !';
				}
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function list_pelanggan()
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
				if((!empty($_POST['cari'])) && ($_POST['cari']!= "")  )
				{
					$cari = htmlentities(str_replace("'","",$_POST['cari']), ENT_QUOTES, 'UTF-8');
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
								LIMIT 
								".htmlentities(str_replace("'","",$_POST['offset']), ENT_QUOTES, 'UTF-8')."
								,
								".htmlentities(str_replace("'","",$_POST['limit']), ENT_QUOTES, 'UTF-8')."
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
				
				if(!empty($list_data_pelanggan))
				{
					echo '<div class="box-body table-responsive no-padding">';
						echo'<table width="100%" id="table_list_apar" class="table table-hover">';
							echo '<thead>
			<tr>';
										echo '<th width="5%">NO</th>';
										echo '<th width="25%">NAMA</th>';
										echo '<th width="25%">PERUSHAAN</th>';
										echo '<th width="30%">ALAMAT</th>';
										echo '<th width="15%">PILIH</th>';
									
										
							echo '</tr>
			</thead>';
							$list_result = $list_data_pelanggan->result();
							//$no =$this->uri->segment(2,0)+1;
							$no = 1;
							echo '<tbody>';
							foreach($list_result as $row)
							{
								//echo'<tr id="tr_'.$no.'">';
								echo'<tr id="tr_list_pelanggan-'.$no.'">';
								echo'<td>'.$no.'</td>';
								
									echo'<td>'.$row->nama_pelanggan.'</td>';
									echo'<td>
										<b>- </b>'.$row->nama_perusahaan.'
										<br/> <b>- </b>'.$row->jabatan.'
									</td>';
									echo'<td>'.$row->alamat.'</td>';
									echo'<td>
										<button type="button" onclick="insert_pelanggan('.$no.')" id="btn_pilih_pelanggan_'.$no.'" class="btn btn-primary btn-sm" data-dismiss="modal">PILIH</button>
									</td>';
									
echo'<input type="hidden" id="get_tr_pelanggan_2_'.$no.'" name="get_tr_pelanggan_2_'.$no.'" value="get_tr_pelanggan_2-'.$no.'" />';
echo'<input type="hidden" id="id_pelanggan_'.$no.'" name="id_pelanggan_'.$no.'" value="'.$row->id_pelanggan.'" />';

echo'<input type="hidden" id="id_pelanggan_'.$no.'" name="id_pelanggan_'.$no.'" value="'.$row->id_pelanggan.'" />';
echo'<input type="hidden" id="id_pelanggan_md5_'.$no.'" name="id_pelanggan_md5_'.$no.'" value="'.md5($row->id_pelanggan).'" />';
echo'<input type="hidden" id="jenis_pelanggan_'.$no.'" name="jenis_pelanggan_'.$no.'" value="'.$row->jenis_pelanggan.'" />';
echo'<input type="hidden" id="nik_pelanggan_'.$no.'" name="nik_pelanggan_'.$no.'" value="'.$row->nik_pelanggan.'" />';
echo'<input type="hidden" id="no_pelanggan_'.$no.'" name="no_pelanggan_'.$no.'" value="'.$row->no_pelanggan.'" />';
echo'<input type="hidden" id="nama_pelanggan_'.$no.'" name="nama_pelanggan_'.$no.'" value="'.$row->nama_pelanggan.'" />';
									
								echo'</tr>';
								$no++;
							}
							
							echo '</tbody>';
						echo'</table>';
						echo'</div>';
				}
				else
				{
					echo'DATA APAR TIDAK DITEMUKAN !';
				}
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function list_petugas()
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
				if((!empty($_POST['cari'])) && ($_POST['cari']!= "")  )
				{
					$cari = htmlentities(str_replace("'","",$_POST['cari']), ENT_QUOTES, 'UTF-8');
				}
				else
				{
					$cari = "";
				}
				
				
				//1. GET DATA petugas/PEMILIK
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
								FROM tb_petugas AS A
								WHERE (nik LIKE '%".$cari."%' OR nama_petugas LIKE '%".$cari."%')
								ORDER BY tgl_ins DESC
								LIMIT 
								".htmlentities(str_replace("'","",$_POST['offset']), ENT_QUOTES, 'UTF-8')."
								,
								".htmlentities(str_replace("'","",$_POST['limit']), ENT_QUOTES, 'UTF-8')."
								;
							";
					$get_data_petugas = $this->M_general->view_query_general($query);
					if(!empty($get_data_petugas))
					{
						$jum_petugas = $get_data_petugas->num_rows();
						$list_data_petugas = $get_data_petugas;
					}
					else
					{
						$jum_petugas = 0;
						$list_data_petugas = false;
					}
				//1. GET DATA petugas/PEMILIK
				
				if(!empty($list_data_petugas))
				{
					echo '<div class="box-body table-responsive no-padding">';
						echo'<table width="100%" id="table_list_apar" class="table table-hover">';
							echo '<thead>
			<tr>';
										echo '<th width="5%">NO</th>';
										echo '<th width="25%">NAMA</th>';
										echo '<th width="25%">PENUGASAN</th>';
										echo '<th width="30%">ALAMAT</th>';
										echo '<th width="15%">PILIH</th>';
									
										
							echo '</tr>
			</thead>';
							$list_result = $list_data_petugas->result();
							//$no =$this->uri->segment(2,0)+1;
							$no = 1;
							echo '<tbody>';
							foreach($list_result as $row)
							{
								//echo'<tr id="tr_'.$no.'">';
								echo'<tr id="tr_list_petugas-'.$no.'">';
								echo'<td>'.$no.'</td>';
								
									echo'<td>'.$row->nama_petugas.'</td>';
									echo'<td>
										<b>- </b>'.$row->tempat_tugas.'
										<br/> <b>- </b>'.$row->jabatan.'
									</td>';
									echo'<td>'.$row->alamat.'</td>';
									echo'<td>
										<button type="button" onclick="insert_petugas('.$no.')" id="btn_pilih_petugas_'.$no.'" class="btn btn-primary btn-sm" data-dismiss="modal">PILIH</button>
									</td>';
									
echo'<input type="hidden" id="get_tr_petugas_2_'.$no.'" name="get_tr_petugas_2_'.$no.'" value="get_tr_petugas_2-'.$no.'" />';

echo'<input type="hidden" id="id_petugas_'.$no.'" name="id_petugas_'.$no.'" value="'.$row->id_petugas.'" />';
echo'<input type="hidden" id="id_petugas_md5_'.$no.'" name="id_petugas_md5_'.$no.'" value="'.md5($row->id_petugas).'" />';
echo'<input type="hidden" id="nik_'.$no.'" name="nik_'.$no.'" value="'.$row->nik.'" />';
echo'<input type="hidden" id="nama_petugas_'.$no.'" name="nama_petugas_'.$no.'" value="'.$row->nama_petugas.'" />';
									
								echo'</tr>';
								$no++;
							}
							
							echo '</tbody>';
						echo'</table>';
						echo'</div>';
				}
				else
				{
					echo'DATA APAR TIDAK DITEMUKAN !';
				}
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
					
					$this->M_transaksi_pembelian->ubah
					(
						$_POST['stat_edit'],
						$_POST['id_petugas'],
						$_POST['id_pelanggan'],
						$_POST['id_apar'],
						$_POST['no_apar'],
						$_POST['tgl_beli']
					);
				}
				else
				{
					$this->M_transaksi_pembelian->simpan
					(
						$_POST['id_petugas'],
						$_POST['id_pelanggan'],
						$_POST['id_apar'],
						$_POST['no_apar'],
						$_POST['tgl_beli']
					);
					
					//GENERATE QR CODE
						$this->load->library('ciqrcode'); //pemanggilan library QR CODE
						$config['cacheable']    = true; //boolean, the default is true
						$config['cachedir']     = './assets/'; //string, the default is application/cache/
						$config['errorlog']     = './assets/'; //string, the default is application/logs/
						$config['imagedir']     = './assets/global/images/qrcode/'; //direktori penyimpanan qr code
						$config['quality']      = true; //boolean, the default is true
						$config['size']         = '1024'; //interger, the default is 1024
						$config['black']        = array(224,255,255); // array, default is array(255,255,255)
						$config['white']        = array(70,130,180); // array, default is array(0,0,0)
						$this->ciqrcode->initialize($config);
				 
						$image_name= $_POST['no_apar'].'.png'; //buat name dari qr code sesuai dengan nim
				 
						$params['data'] = $_POST['no_apar']; //data yang akan di jadikan QR CODE
						$params['level'] = 'H'; //H=High
						$params['size'] = 10;
						$params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
						$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
					//GENERATE QR CODE
					
				}
				header('Location: '.base_url().'transaksi-pembelian');
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function generate_qr()
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
				$id_pembelian = htmlentities(str_replace("'","",$_POST['id_pembelian']), ENT_QUOTES, 'UTF-8');
				//GENERATE QR CODE
					$this->load->library('ciqrcode'); //pemanggilan library QR CODE
					$config['cacheable']    = true; //boolean, the default is true
					$config['cachedir']     = './assets/'; //string, the default is application/cache/
					$config['errorlog']     = './assets/'; //string, the default is application/logs/
					$config['imagedir']     = './assets/global/images/qrcode/'; //direktori penyimpanan qr code
					$config['quality']      = true; //boolean, the default is true
					$config['size']         = '1024'; //interger, the default is 1024
					$config['black']        = array(224,255,255); // array, default is array(255,255,255)
					$config['white']        = array(70,130,180); // array, default is array(0,0,0)
					$this->ciqrcode->initialize($config);
			 
					$image_name= $id_pembelian.'.png'; //buat name dari qr code sesuai dengan nim
			 
					$params['data'] = $id_pembelian; //data yang akan di jadikan QR CODE
					$params['level'] = 'H'; //H=High
					$params['size'] = 10;
					$params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
					$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
				//GENERATE QR CODE
				
				echo $id_pembelian;
				echo'BERHASIL';
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
				
				$query = "DELETE FROM tb_pembelian WHERE (id_pembelian) = '".$this->uri->segment(2,0)."';";
				$this->M_general->exec_query_general($query);
				
				@unlink('./assets/global/images/qrcode/'.$this->uri->segment(2,0).'.png');
				
				header('Location: '.base_url().'transaksi-pembelian');
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}


	function simpan_data_awal()
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
				$id_pembelian = htmlentities(str_replace("'","",$_POST['id_pembelian']), ENT_QUOTES, 'UTF-8');
				$pemilik_apar = htmlentities(str_replace("'","",$_POST['pemilik_apar']), ENT_QUOTES, 'UTF-8');
				$desa = htmlentities(str_replace("'","",$_POST['desa']), ENT_QUOTES, 'UTF-8');
				$kecamatan = htmlentities(str_replace("'","",$_POST['kecamatan']), ENT_QUOTES, 'UTF-8');
				$lokasi_apar = htmlentities(str_replace("'","",$_POST['lokasi_apar']), ENT_QUOTES, 'UTF-8');
				$penyimpanan = htmlentities(str_replace("'","",$_POST['penyimpanan']), ENT_QUOTES, 'UTF-8');
				
				$query = "
						UPDATE tb_pembelian SET
							pemilik_apar = '".$pemilik_apar."'
							,desa = '".$desa."'
							,kecamatan = '".$kecamatan."'
							,lokasi_apar = '".$lokasi_apar."'
							,penyimpanan = '".$penyimpanan."'
						WHERE id_pembelian = '".$id_pembelian."'
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
	
	function view_list_pemindahaan_apar()
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
				
				//1. CEK APAKAH ADA DATA PEMBELIAN APAR
				$query_cek_pembelian = "SELECT * FROM tb_pembelian WHERE md5(id_pembelian) = '".$this->uri->segment(2,0)."' ;";
				$get_data_pembelian = $this->M_general->view_query_general($query_cek_pembelian);
				if(!empty($get_data_pembelian))
				{
					$get_data_pembelian = $get_data_pembelian->row();
						
					
					//2. GET PEMINDAHAAN DATA APAR
						$query = "
									SELECT * 
									FROM tb_pemindahan_lokasi
									WHERE md5(id_pembelian) = '".$this->uri->segment(2,0)."'
									ORDER BY tgl_ins DESC
									;
								";
						$get_data_pemindahan_apar = $this->M_general->view_query_general($query);
						if(!empty($get_data_pemindahan_apar))
						{
							$list_data_pemindahan_apar = $get_data_pemindahan_apar;
						}
						else
						{
							$list_data_pemindahan_apar = false;
						}
					//2. GET PEMINDAHAAN DATA APAR
					
					
					
					$msgbox_title = "LIST PEMINDAHAN APAR ".$get_data_pembelian->id_pembelian;
					
					$data = array('page_content'=>'page_transaksi_pemindahan_apar','list_data_pemindahan_apar'=>$list_data_pemindahan_apar,'msgbox_title' => $msgbox_title,'get_data_pembelian' => $get_data_pembelian);
					$this->load->view('admin/container',$data);
				}
				else
				{
					header('Location: '.base_url().'transaksi-pembelian');
				}
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function simpan_pemindahan_apar()
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
				//1. CEK APAKAH ADA DATA PEMBELIAN APAR
				$query_cek_pembelian = "SELECT * FROM tb_pembelian WHERE (id_pembelian) = '".$_POST['id_pembelian']."' ;";
				$get_data_pembelian = $this->M_general->view_query_general($query_cek_pembelian);
				if(!empty($get_data_pembelian))
				{
					$get_data_pembelian = $get_data_pembelian->row();
					if (!empty($_POST['stat_edit']))
					{	
						
						$this->M_transaksi_pembelian->ubah_pemindahan_apar
						(
							$_POST['stat_edit']
							,$_POST['id_pembelian']
							,$_POST['lokasi_pemindahan']
							,$_POST['penyimpanan_pemindahan']
							,$_POST['tanggal_pindah']
							,$_POST['alasan']
						);
					}
					else
					{
						$this->M_transaksi_pembelian->simpan_pemindahan_apar
						(
							$_POST['id_pembelian']
							,$_POST['lokasi_pemindahan']
							,$_POST['penyimpanan_pemindahan']
							,$_POST['tanggal_pindah']
							,$_POST['alasan']
						);
						
					}
					header('Location: '.base_url().'transaksi-pembelian-pemindahan-apar-view/'.md5($_POST['id_pembelian']));
				}
				else
				{
					header('Location: '.base_url().'transaksi-pembelian');
				}
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
}
