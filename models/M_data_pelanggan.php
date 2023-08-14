<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_data_pelanggan extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	
	function simpan
	(
		$jenis_pelanggan,
		$nik_pelanggan,
		$no_pelanggan,
		$nama_pelanggan,
		$tempat_lahir,
		$tgl_lahir,
		$tlp,
		$email,
		$wil_prov,
		$wil_kabkot,
		$wil_kec,
		$wil_des,
		$alamat,
		$ket_pelanggan,
		$user,
		$pass,
		$avatar

	)
	{
		$query = "
			INSERT INTO tb_pelanggan
			(
				id_pelanggan,
				jenis_pelanggan,
				nik_pelanggan,
				no_pelanggan,
				nama_pelanggan,
				tempat_lahir,
				tgl_lahir,
				tlp,
				email,
				wil_prov,
				wil_kabkot,
				wil_kec,
				wil_des,
				alamat,
				ket_pelanggan,
				user,
				pass,
				avatar,
				tgl_ins,
				user_ins
			)
			VALUES
			(
				(
					SELECT CONCAT(FRMTGL,ORD) AS id_pelanggan
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
							COALESCE(MAX(CAST(RIGHT(id_pelanggan,5) AS UNSIGNED)) + 1,1) AS ORD
							From tb_pelanggan
							WHERE DATE(tgl_ins) = DATE(NOW())
						) AS A
					) AS AA
				),
				
				'".$jenis_pelanggan."',
				'".$nik_pelanggan."',
				'".$no_pelanggan."',
				'".$nama_pelanggan."',
				'".$tempat_lahir."',
				'".$tgl_lahir."',
				'".$tlp."',
				'".$email."',
				'".$wil_prov."',
				'".$wil_kabkot."',
				'".$wil_kec."',
				'".$wil_des."',
				'".$alamat."',
				'".$ket_pelanggan."',
				'".$user."',
				'".$pass."',
				'".$avatar."',
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
		$id_pelanggan,
		$jenis_pelanggan,
		$nik_pelanggan,
		$no_pelanggan,
		$nama_pelanggan,
		$tempat_lahir,
		$tgl_lahir,
		$tlp,
		$email,
		$wil_prov,
		$wil_kabkot,
		$wil_kec,
		$wil_des,
		$alamat,
		$ket_pelanggan,
		$user,
		$pass,
		$avatar
	)
	{
		$query = "
				UPDATE tb_pelanggan SET
					jenis_pelanggan = '".$jenis_pelanggan."',
					nik_pelanggan = '".$nik_pelanggan."',
					no_pelanggan = '".$no_pelanggan."',
					nama_pelanggan = '".$nama_pelanggan."',
					tempat_lahir = '".$tempat_lahir."',
					tgl_lahir = '".$tgl_lahir."',
					tlp = '".$tlp."',
					email = '".$email."',
					wil_prov = '".$wil_prov."',
					wil_kabkot = '".$wil_kabkot."',
					wil_kec = '".$wil_kec."',
					wil_des = '".$wil_des."',
					alamat = '".$alamat."',
					ket_pelanggan = '".$ket_pelanggan."',
					user = '".$user."',
					pass = '".$pass."',
					avatar = '".$avatar."',
					tgl_updt = NOW(),
					user_updt = '".$this->session->userdata('ses_gbl_nama_akun')."'
				WHERE id_pelanggan = '".$id_pelanggan."'
				";
				
		/*SIMPAN DAN CATAT QUERY*/
			$this->db->query($query);
		/*SIMPAN DAN CATAT QUERY*/
	}
	
	function get_no_pelanggan()
	{
		$query = "SELECT CONCAT(FRMTGL,ORD) AS id_pelanggan
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
							COALESCE(MAX(CAST(RIGHT(id_pelanggan,5) AS UNSIGNED)) + 1,1) AS ORD
							From tb_pelanggan
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

/* End of file M_data_pelanggan.php */
/* Location: ./application/models/M_data_pelanggan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-12-30 15:11:17 */
/* http://harviacode.com */