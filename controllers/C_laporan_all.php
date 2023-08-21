<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_laporan_all extends CI_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		//$this->load->model(array('M_data_apar'));
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
				if((!empty($_GET['dari'])) && ($_GET['dari']!= "")  )
				{
					$dari = $_GET['dari'];
					$sampai = $_GET['sampai'];
				}
				else
				{
					$nw = date("Y-m-d");
					$dari = date('Y-m-d', strtotime($nw. ' - 1 month'));
					$sampai = date("Y-m-d");
				}
				
				if((!empty($_GET['cari'])) && ($_GET['cari']!= "")  )
				{
					$cari = str_replace("'","",$_GET['cari']);
				}
				else
				{
					$cari = "";
				}
				
				if(strtoupper($this->session->userdata('ses_gbl_jenis_akun')) == 'PEMILIK')
				{
					$cari_pemilik = "AND A.id_pelanggan = '".$this->session->userdata('ses_gbl_id_akun')."' ";
				}
				else
				{
					$cari_pemilik = "";
				}
				
				//1. GET DATA APAR
					$query = "
								SELECT
									A.id_apar
									,CASE WHEN A.pemilik_apar = '' THEN
										COALESCE(C.nama_pelanggan,'')
									ELSE
										A.pemilik_apar
									END AS pemilik_apar
									,A.desa,A.kecamatan,COALESCE(B.merek,'') AS merek_apar,A.lokasi_apar,A.penyimpanan
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
								WHERE DATE(A.tgl_beli) BETWEEN '".$dari."' AND '".$sampai."'
								".$cari_pemilik."
								AND (A.pemilik_apar LIKE '%".$cari."%' OR COALESCE(C.nama_pelanggan,'') LIKE '%".$cari."%')
								ORDER BY A.tgl_beli DESC
								;
							";
					$get_data_apar = $this->M_general->view_query_general($query);
					if(!empty($get_data_apar))
					{
						$list_laporan_apar = $get_data_apar;
					}
					else
					{
						$list_laporan_apar = false;
					}
				//1. GET DATA APAR
				
				$msgbox_title = 'Laporan APAR';
				
				$data = array('page_content'=>'page_laporan_apar','list_laporan_apar'=>$list_laporan_apar,'msgbox_title' => $msgbox_title,'dari' => $dari,'sampai' => $sampai);
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
	
	public function lap_pemindahan_apar()
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
				if((!empty($_GET['dari'])) && ($_GET['dari']!= "")  )
				{
					$dari = $_GET['dari'];
					$sampai = $_GET['sampai'];
				}
				else
				{
					$nw = date("Y-m-d");
					$dari = date('Y-m-d', strtotime($nw. ' - 1 month'));
					$sampai = date("Y-m-d");
				}
				
				if((!empty($_GET['cari'])) && ($_GET['cari']!= "")  )
				{
					$cari = str_replace("'","",$_GET['cari']);
				}
				else
				{
					$cari = "";
				}
				
				if(strtoupper($this->session->userdata('ses_gbl_jenis_akun')) == 'PEMILIK')
				{
					$cari_pemilik = "AND B.id_pelanggan = '".$this->session->userdata('ses_gbl_id_akun')."' ";
				}
				else
				{
					$cari_pemilik = "";
				}
				
				//1. GET DATA APAR
					$query = "
								SELECT 
									COALESCE(B.id_pembelian,'') AS id_apar 
									,COALESCE(B.lokasi_apar,'') AS lokasi_awal 
									,COALESCE(B.penyimpanan,'') AS penyimpanan_awal
									,A.lokasi_pemindahan
									,A.penyimpanan_pemindahan
									,CASE WHEN A.petugas = '' THEN
										(SELECT nama_petugas FROM tb_petugas WHERE id_petugas = B.id_petugas GROUP BY nama_petugas)
									ELSE
										A.petugas
									END AS petugas
									,A.alasan
									,A.tanggal_pindah
								FROM tb_pemindahan_lokasi AS A 
								LEFT JOIN tb_pembelian AS B ON A.id_pembelian = B.id_pembelian
								LEFT JOIN tb_petugas AS C ON B.id_petugas = C.id_petugas
								WHERE DATE(A.tanggal_pindah) BETWEEN '".$dari."' AND '".$sampai."'
								".$cari_pemilik."
								AND (COALESCE(B.id_pembelian,'') LIKE '%".$cari."%' OR A.lokasi_pemindahan LIKE '%".$cari."%' OR A.penyimpanan_pemindahan LIKE '%".$cari."%')
								ORDER BY A.tanggal_pindah DESC
								;
							";
					$get_data_apar = $this->M_general->view_query_general($query);
					if(!empty($get_data_apar))
					{
						$list_laporan_apar = $get_data_apar;
					}
					else
					{
						$list_laporan_apar = false;
					}
				//1. GET DATA APAR
				
				
				$msgbox_title = 'Laporan Perpindahan Lokasi APAR';
				
				$data = array('page_content'=>'page_laporan_pemindahan_apar','list_laporan_apar'=>$list_laporan_apar,'msgbox_title' => $msgbox_title,'dari' => $dari,'sampai' => $sampai);
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
	
	public function lap_pengecekan_apar()
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
				if((!empty($_GET['dari'])) && ($_GET['dari']!= "")  )
				{
					$dari = $_GET['dari'];
					$sampai = $_GET['sampai'];
				}
				else
				{
					$nw = date("Y-m-d");
					$dari = date('Y-m-d', strtotime($nw. ' - 1 month'));
					$sampai = date("Y-m-d");
				}
				
				if((!empty($_GET['cari'])) && ($_GET['cari']!= "")  )
				{
					$cari = str_replace("'","",$_GET['cari']);
				}
				else
				{
					$cari = "";
				}
				
				//1. GET PERTANYAAN/QUIS
					$query_quis = "SELECT * FROM tb_quis ORDER BY idx ASC";
					$list_quis = $this->M_general->view_query_general($query_quis);
					if(!empty($list_quis))
					{
						$list_quis = $list_quis;
					}
					else
					{
						$list_quis = false;
					}
				//1. GET PERTANYAAN/QUIS
				
				//2. SET QUERY PERTANYAAN
					if(!empty($list_quis))
					{
						$list_result = $list_quis->result();
						$no_q = 1;
						$add_query_quis = "";
						$add_max_query_quis = "";
						foreach($list_result as $row)
						{
							$add_query_quis = $add_query_quis.",CASE WHEN A.pertanyaan = '".$row->pertanyaan."' THEN A.JWB2 ELSE '' END AS F".$row->idx."";
							
							$add_max_query_quis = $add_max_query_quis.",MAX(F".$row->idx.") AS F".$row->idx."";
							
							$no_q++;
						}
					}
				//2. SET QUERY PERTANYAAN
				
				//3. GET LAPORAN CEK APAR
					$query_lap_cek_apar = "
							SELECT
								A.id_apar,A.lokasi,A.penyimpanan,A.kapasitas,A.jenis,A.pemilik_apar,A.merek
								".$add_max_query_quis.",A.ket_cek_apar,A.tgl_cek,A.nama_petugas
							FROM
							(
								SELECT
									A.id_apar,A.lokasi,A.penyimpanan,A.kapasitas,A.jenis,A.pemilik_apar,A.merek
									".$add_query_quis."
									,COALESCE(A.tgl_cek,'') AS tgl_cek,COALESCE(A.ket_cek_apar,'') AS ket_cek_apar, COALESCE(A.nama_petugas,'') AS nama_petugas 
								FROM
								(
									SELECT
										A.id_pembelian AS id_apar
										,COALESCE((SELECT lokasi_pemindahan FROM tb_pemindahan_lokasi WHERE id_pembelian = A.id_pembelian GROUP BY lokasi_pemindahan ORDER BY tgl_ins DESC LIMIT 0,1),A.lokasi_apar) AS lokasi
										,COALESCE((SELECT penyimpanan_pemindahan FROM tb_pemindahan_lokasi WHERE id_pembelian = A.id_pembelian GROUP BY penyimpanan_pemindahan ORDER BY tgl_ins DESC LIMIT 0,1),A.penyimpanan) AS penyimpanan
										,COALESCE(E.kapasitas,'') AS kapasitas
										,COALESCE(E.jenis_apar,'') AS jenis
										,CASE WHEN A.pemilik_apar = '' THEN
											COALESCE(B.nama_pelanggan,'')
										ELSE
											A.pemilik_apar
										END AS pemilik_apar
										,COALESCE(E.merek,'') AS merek
										,COALESCE(C.nama_petugas,'') AS nama_petugas
										,D.*
										,CASE WHEN D.jawaban = 'Y' THEN 'YA' ELSE 'TIDAK' END AS JWB2
									FROM tb_pembelian AS A
									LEFT JOIN tb_pelanggan AS B ON A.id_pelanggan = B.id_pelanggan
									LEFT JOIN tb_petugas AS C ON A.id_petugas = C.id_petugas
									LEFT JOIN tb_cek_apar AS D ON A.id_pembelian = D.id_pembelian AND D.tgl_cek = (SELECT MAX(tgl_cek) AS tgl_cek FROM tb_cek_apar WHERE id_pembelian = A.id_pembelian)
									LEFT JOIN tb_apar AS E ON A.id_apar = E.id_apar
								) AS A
							) AS A
							GROUP BY A.id_apar,A.lokasi,A.penyimpanan,A.kapasitas,A.jenis,A.pemilik_apar,A.merek,A.ket_cek_apar,A.tgl_cek,A.tgl_cek
					";
					
					
					$list_lap_cek_apar = $this->M_general->view_query_general($query_lap_cek_apar);
					if(!empty($list_lap_cek_apar))
					{
						$list_lap_cek_apar = $list_lap_cek_apar;
					}
					else
					{
						$list_lap_cek_apar = false;
					}
				//3. GET LAPORAN CEK APAR
				
				$msgbox_title = 'Laporan Pemeriksaan/Pengecekan APAR';
				
				$data = array('page_content'=>'page_laporan_pengecekan_apar','list_lap_cek_apar'=>$list_lap_cek_apar,'msgbox_title' => $msgbox_title,'dari' => $dari,'sampai' => $sampai,'list_quis' => $list_quis);
				$this->load->view('admin/container',$data);
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	
}
