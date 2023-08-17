<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_transaksi_cek_apar extends CI_Controller 
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
				//1. CEK APAKAH ADA DATA PEMBELIAN APAR
				$query_cek_pembelian = "
										SELECT 
											A.*
											,COALESCE(B.nik,'') AS nik_petugas
											,COALESCE(B.nama_petugas,'') AS nama_petugas
										FROM tb_pembelian AS A
										LEFT JOIN tb_petugas AS B ON A.id_petugas = B.id_petugas
										WHERE md5(A.id_pembelian) = '".$this->uri->segment(2,0)."';
									";
				$get_data_pembelian = $this->M_general->view_query_general($query_cek_pembelian);
				if(!empty($get_data_pembelian))
				{
					$get_data_pembelian = $get_data_pembelian->row();
						
					
					//2. GET DATA CEK APAR
						$query = "
									SELECT id_pembelian,id_petugas,tgl_cek,ket_cek_apar 
									FROM tb_cek_apar 
									GROUP BY id_pembelian,id_petugas,tgl_cek,ket_cek_apar
									ORDER BY tgl_cek DESC
									;
								";
						$get_data_cek_apar = $this->M_general->view_query_general($query);
						if(!empty($get_data_cek_apar))
						{
							$list_data_cek_apar = $get_data_cek_apar;
						}
						else
						{
							$list_data_cek_apar = false;
						}
					//2. GET DATA CEK APAR
					
					//3. QUISIONER
						$query_quis = "SELECT * FROM tb_quis ORDER BY idx ASC";
						$list_query_quis = $this->M_general->view_query_general($query_quis);
						if(!empty($list_query_quis))
						{
							$list_query_quis = $list_query_quis;
						}
						else
						{
							$list_query_quis = false;
						}
					//3. QUISIONER
					
					
					
					$msgbox_title = "Pengecekan data APAR ".$get_data_pembelian->id_pembelian;
					
					$data = array('page_content'=>'page_transaksi_cek_apar','list_data_cek_apar'=>$list_data_cek_apar,'msgbox_title' => $msgbox_title,'get_data_pembelian' => $get_data_pembelian,'list_query_quis' => $list_query_quis);
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
	
	function simpan_cek_apar()
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
				$id_petugas = htmlentities(str_replace("'","",$_POST['id_petugas']), ENT_QUOTES, 'UTF-8');
				$pertanyaan = htmlentities(str_replace("'","",$_POST['pertanyaan']), ENT_QUOTES, 'UTF-8');
				$jawaban = htmlentities(str_replace("'","",$_POST['jawaban']), ENT_QUOTES, 'UTF-8');
				$tgl_cek = htmlentities(str_replace("'","",$_POST['tgl_cek']), ENT_QUOTES, 'UTF-8');
				$ket_cek_apar = htmlentities(str_replace("'","",$_POST['ket_cek_apar']), ENT_QUOTES, 'UTF-8');
				
				//1. CEK APAKAH SUDAH ADA ATAU BELUM
				$query = "
							SELECT * FROM tb_cek_apar
							WHERE id_pembelian = '".$id_pembelian."'
							AND id_petugas = '".$id_petugas."'
							AND pertanyaan = '".$pertanyaan."'
							AND tgl_cek = '".$tgl_cek."'
							-- AND ket_cek_apar = '".$ket_cek_apar."'
						";
				$get_data_cek_apar = $this->M_general->view_query_general($query);
				if(!empty($get_data_cek_apar))
				{
					$list_data_cek_apar = $get_data_cek_apar;
					//EDIT
					$query_edit = "UPDATE tb_cek_apar SET 
										jawaban = '".$jawaban."' 
										,ket_cek_apar = '".$ket_cek_apar."'
									WHERE id_pembelian = '".$id_pembelian."'
									AND id_petugas = '".$id_petugas."'
									AND pertanyaan = '".$pertanyaan."'
									AND tgl_cek = '".$tgl_cek."'
									
								";
					/*SIMPAN DAN CATAT QUERY*/
						$this->db->query($query_edit);
					/*SIMPAN DAN CATAT QUERY*/
				}
				else
				{
					$list_data_cek_apar = false;
					//SIMPAN
					$query_simpan = "
									INSERT tb_cek_apar (id_pembelian,id_petugas,pertanyaan,jawaban,tgl_cek,ket_cek_apar)
									VALUES
									(
										'".$id_pembelian."'
										,'".$id_petugas."'
										,'".$pertanyaan."'
										,'".$jawaban."'
										,'".$tgl_cek."'
										,'".$ket_cek_apar."'
									)
								";
					/*SIMPAN DAN CATAT QUERY*/
						$this->db->query($query_simpan);
					/*SIMPAN DAN CATAT QUERY*/
				}
				
				echo'BERHASIL';
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
	
	function hapus_cek_apar()
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
				$tgl_cek = htmlentities(str_replace("'","",$_POST['tgl_cek']), ENT_QUOTES, 'UTF-8');
				$ket_cek_apar = htmlentities(str_replace("'","",$_POST['ket_cek_apar']), ENT_QUOTES, 'UTF-8');
				
				$query = "DELETE FROM tb_cek_apar WHERE tgl_cek = '".$tgl_cek."' AND ket_cek_apar = '".$ket_cek_apar."' ;";
				/*SIMPAN DAN CATAT QUERY*/
					$this->db->query($query);
				/*SIMPAN DAN CATAT QUERY*/
				echo'BERHASIL';
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}

	function detail_cek_apar()
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
				$id_petugas = htmlentities(str_replace("'","",$_POST['id_petugas']), ENT_QUOTES, 'UTF-8');
				$tgl_cek = htmlentities(str_replace("'","",$_POST['tgl_cek']), ENT_QUOTES, 'UTF-8');
				$ket_cek_apar = htmlentities(str_replace("'","",$_POST['ket_cek_apar']), ENT_QUOTES, 'UTF-8');
				
				$query = "
							SELECT * 
							FROM tb_cek_apar 
							WHERE id_pembelian = '".$id_pembelian."'
							AND id_petugas = '".$id_petugas."'
							AND tgl_cek = '".$tgl_cek."'
							AND ket_cek_apar = '".$ket_cek_apar."'
							ORDER BY pertanyaan ASC
							;
						";
				$get_data_cek_apar = $this->M_general->view_query_general($query);
				if(!empty($get_data_cek_apar))
				{
					$list_data_cek_apar = $get_data_cek_apar;
					$list_result = $list_data_cek_apar->result();
					echo'<ul>';
					foreach($list_result as $row)
					{
						echo'<li>'.$row->pertanyaan.' : <b>'.$row->jawaban.'</b></li>';	
					}
					echo'</ul>';
				}
				else
				{
					$list_data_cek_apar = false;
				}
				
			}
			else
			{
				header('Location: '.base_url());
			}
		}
	}
}
