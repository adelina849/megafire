<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_data_petugas extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	
	function simpan
	(
		$nik,
		$nama_petugas,
		$kelamin,
		$tampat_lahir,
		$tgl_lahir,
		$tlp,
		$email,
		$wil_prov,
		$wil_kabkot,
		$wil_kec,
		$wil_des,
		$alamat,
		$ket_petugas,
		$tempat_tugas,
		$jabatan,
		$user,
		$pass,
		$avatar_url

	)
	{
		$query = "
			INSERT INTO tb_petugas
			(
				id_petugas,
				nik,
				nama_petugas,
				kelamin,
				tampat_lahir,
				tgl_lahir,
				tlp,
				email,
				wil_prov,
				wil_kabkot,
				wil_kec,
				wil_des,
				alamat,
				ket_petugas,
				tempat_tugas,
				jabatan,
				user,
				pass,
				avatar_url,
				tgl_ins,
				user_ins
			)
			VALUES
			(
				(
					SELECT CONCAT(FRMTGL,ORD) AS id_petugas
					From
					(
						SELECT CONCAT(Y,M,D) AS FRMTGL
						 ,CASE
							WHEN (ORD >= 10 AND ORD < 99) THEN CONCAT('000',CAST(ORD AS CHAR))
							WHEN (ORD >= 100 AND ORD < 999) THEN CONCAT('00',CAST(ORD AS CHAR))
							WHEN (ORD >= 1000 AND ORD < 9999) THEN CONCAT('0',CAST(ORD AS CHAR))
							WHEN ORD >= 10000 THEN CAST(ORD AS CHAR)
							ELSE CONCAT('0000',CAST(ORD AS CHAR))
							END As ORD
						From
						(
							SELECT
							CAST(LEFT(NOW(),4) AS CHAR) AS Y,
							CAST(MID(NOW(),6,2) AS CHAR) AS M,
							MID(NOW(),9,2) AS D,
							COALESCE(MAX(CAST(RIGHT(id_petugas,5) AS UNSIGNED)) + 1,1) AS ORD
							From tb_petugas
							WHERE DATE(tgl_ins) = DATE(NOW())
						) AS A
					) AS AA
				),
				
				'".$nik."',
				'".$nama_petugas."',
				'".$kelamin."',
				'".$tampat_lahir."',
				'".$tgl_lahir."',
				'".$tlp."',
				'".$email."',
				'".$wil_prov."',
				'".$wil_kabkot."',
				'".$wil_kec."',
				'".$wil_des."',
				'".$alamat."',
				'".$ket_petugas."',
				'".$tempat_tugas."',
				'".$jabatan."',
				'".$user."',
				'".$pass."',
				'".$avatar_url."',
				NOW(),
				'".$this->session->userdata('ses_gbl_nama_akun')."'
			)
		";
		
		/*SIMPAN DAN CATAT QUERY*/
			$this->db->query($query);
		/*SIMPAN DAN CATAT QUERY*/
	}
	
	function ubah
	(
		$id_petugas,
		$nik,
		$nama_petugas,
		$kelamin,
		$tampat_lahir,
		$tgl_lahir,
		$tlp,
		$email,
		$wil_prov,
		$wil_kabkot,
		$wil_kec,
		$wil_des,
		$alamat,
		$ket_petugas,
		$tempat_tugas,
		$jabatan,
		$user,
		$pass,
		$avatar_url
	)
	{
		$query = "
				UPDATE tb_petugas SET
					nik = '".$nik."',
					nama_petugas = '".$nama_petugas."',
					kelamin = '".$kelamin."',
					tampat_lahir = '".$tampat_lahir."',
					tgl_lahir = '".$tgl_lahir."',
					tlp = '".$tlp."',
					email = '".$email."',
					wil_prov = '".$wil_prov."',
					wil_kabkot = '".$wil_kabkot."',
					wil_kec = '".$wil_kec."',
					wil_des = '".$wil_des."',
					alamat = '".$alamat."',
					ket_petugas = '".$ket_petugas."',
					tempat_tugas = '".$tempat_tugas."',
					jabatan = '".$jabatan."',
					avatar_url = '".$avatar_url."',
					tgl_updt = NOW(),
					user_updt = '".$this->session->userdata('ses_gbl_nama_akun')."'
				WHERE id_petugas = '".$id_petugas."'
				";
				
		/*SIMPAN DAN CATAT QUERY*/
			$this->db->query($query);
		/*SIMPAN DAN CATAT QUERY*/
	}
	
	function get_no_petugas()
	{
		$query = "SELECT CONCAT(FRMTGL,ORD) AS id_petugas
					From
					(
						SELECT CONCAT(Y,M,D) AS FRMTGL
						 ,CASE
							WHEN (ORD >= 10 AND ORD < 99) THEN CONCAT('000',CAST(ORD AS CHAR))
							WHEN (ORD >= 100 AND ORD < 999) THEN CONCAT('00',CAST(ORD AS CHAR))
							WHEN (ORD >= 1000 AND ORD < 9999) THEN CONCAT('0',CAST(ORD AS CHAR))
							WHEN ORD >= 10000 THEN CAST(ORD AS CHAR)
							ELSE CONCAT('0000',CAST(ORD AS CHAR))
							END As ORD
						From
						(
							SELECT
							CAST(LEFT(NOW(),4) AS CHAR) AS Y,
							CAST(MID(NOW(),6,2) AS CHAR) AS M,
							MID(NOW(),9,2) AS D,
							COALESCE(MAX(CAST(RIGHT(id_petugas,5) AS UNSIGNED)) + 1,1) AS ORD
							From tb_petugas
							WHERE DATE(tgl_ins) = DATE(NOW())
						) AS A
					) AS AA";
					
		$query = $this->db->query($query);
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
	}
}

/* End of file M_data_petugas.php */
/* Location: ./application/models/M_data_petugas.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-12-30 15:11:17 */
/* http://harviacode.com */