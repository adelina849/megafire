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
				
				$data = array('page_content'=>'page_laporan_apar','list_laporan_apar'=>$list_laporan_apar,'msgbox_title' => $msgbox_title,'get_no_apar' => $get_no_apar,'dari' => $dari,'sampai' => $sampai);
				$this->load->view('admin/container',$data);
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	
}
