<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_transaksi_pembelian extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
	
	function get_no_transaksi_apar()
	{
		$query = "SELECT CONCAT(FRMTGL,ORD) AS id_pembelian
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
							COALESCE(MAX(CAST(RIGHT(id_pembelian,5) AS UNSIGNED)) + 1,1) AS ORD
							From tb_pembelian
							WHERE DATE(tgl_transaksi) = DATE(NOW())
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
	
	function simpan
	(
		$id_petugas,
		$id_pelanggan,
		$id_apar,
		$no_apar,
		$tgl_beli
	)
	{
		$query = "
			INSERT INTO tb_pembelian
			(
				id_pembelian,
				id_petugas,
				id_pelanggan,
				id_apar,
				no_apar,
				tgl_beli,
				tgl_transaksi
			)
			VALUES
			(
				(
					SELECT CONCAT(FRMTGL,ORD) AS id_pembelian
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
							COALESCE(MAX(CAST(RIGHT(id_pembelian,5) AS UNSIGNED)) + 1,1) AS ORD
							From tb_pembelian
							WHERE DATE(tgl_transaksi) = DATE(NOW())
						) AS A
					) AS AA
				),
				'".$id_petugas."',
				'".$id_pelanggan."',
				'".$id_apar."',
				'".$no_apar."',
				'".$tgl_beli."',
				NOW()
			)
		";
		
		/*SIMPAN DAN CATAT QUERY*/
			$this->db->query($query);
		/*SIMPAN DAN CATAT QUERY*/
	}
	
	function ubah
	(
		$id_pembelian,
		$id_petugas,
		$id_pelanggan,
		$id_apar,
		$no_apar,
		$tgl_beli
	)
	{
		$query = "
				UPDATE tb_pembelian SET
					id_petugas = '".$id_petugas."',
					id_pelanggan = '".$id_pelanggan."',
					id_apar = '".$id_apar."',
					no_apar = '".$no_apar."',
					tgl_beli = '".$tgl_beli."',
					tgl_update = NOW()
				WHERE id_pembelian = '".$id_pembelian."'
				";
				
		/*SIMPAN DAN CATAT QUERY*/
			$this->db->query($query);
		/*SIMPAN DAN CATAT QUERY*/
	}
	
	function simpan_pemindahan_apar(
		$id_pembelian
		,$lokasi_pemindahan
		,$penyimpanan_pemindahan
		,$tanggal_pindah
		,$alasan
	)
	{
		$query = "
				INSERT INTO tb_pemindahan_lokasi (
					id_pemindahan_lokasi
					,id_pembelian
					,lokasi_pemindahan
					,penyimpanan_pemindahan
					,tanggal_pindah
					,alasan
					,tgl_ins
					,user_ins
				)
				VALUES
				(
					(
						SELECT CONCAT(FRMTGL,ORD) AS id_pemindahan_lokasi
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
								COALESCE(MAX(CAST(RIGHT(id_pemindahan_lokasi,5) AS UNSIGNED)) + 1,1) AS ORD
								From tb_pemindahan_lokasi
								WHERE DATE(tgl_ins) = DATE(NOW())
							) AS A
						) AS AA
					)
					,'".$id_pembelian."'
					,'".$lokasi_pemindahan."'
					,'".$penyimpanan_pemindahan."'
					,'".$tanggal_pindah."'
					,'".$alasan."'
					,NOW()
					,'".$this->session->userdata('ses_gbl_nama_akun')."'
				);
		";
		
		
		/*SIMPAN DAN CATAT QUERY*/
			$this->db->query($query);
		/*SIMPAN DAN CATAT QUERY*/
	}
	
	function ubah_pemindahan_apar(
		$id_pemindahan_lokasi
		,$id_pembelian
		,$lokasi_pemindahan
		,$penyimpanan_pemindahan
		,$tanggal_pindah
		,$alasan
	)
	{
		$query = "
				UPDATE tb_pemindahan_lokasi SET
					lokasi_pemindahan = '".$lokasi_pemindahan."',
					penyimpanan_pemindahan = '".$penyimpanan_pemindahan."',
					tanggal_pindah = '".$tanggal_pindah."',
					alasan = '".$alasan."',
					tgl_updt = NOW(),
					user_updt = '".$this->session->userdata('ses_gbl_nama_akun')."'
				WHERE id_pemindahan_lokasi = '".$id_pemindahan_lokasi."'
				";
				
		/*SIMPAN DAN CATAT QUERY*/
			$this->db->query($query);
		/*SIMPAN DAN CATAT QUERY*/
	}
}

/* End of file M_transaksi_pembelian.php */
/* Location: ./application/models/M_transaksi_pembelian.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2019-12-30 15:11:17 */
/* http://harviacode.com */