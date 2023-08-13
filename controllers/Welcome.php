<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('captcha','array'));
		$this->load->library(array('form_validation'));
		$this->config->load('cap');
		//$this->load->model(array('M_gl_hak_akses','M_gl_dashboard','M_gl_produk'));
	}
		
	public function index()
	{
		//$this->load->view('welcome_message');
		//echo date('Y-m-d H:i:s',strtotime('2021-10-17 20:34:21'));
		//echo date('Y-m-d h:i:s',strtotime('2021-10-17 20:34:21'));
		//echo $this->session->userdata('ses_gnl_tglStockProduk');
		//echo $this->session->userdata('ses_kode_kantor');
		//echo $this->session->userdata('ses_gnl_isPajakAktif');
		//echo $this->session->userdata('ses_kode_kantor');
		//echo DATE('Y-01-01');
		//echo substr('2021-09-09',0,-6).'-01-01';
		//$this->M_gl_produk->update_rata_penjualan3_bulan_tb_produk($this->session->userdata('ses_kode_kantor'));
		
		//$newDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' -10 minutes'));
		//$newDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' -1 day'));
		//$newDate = date('Y', strtotime(date('Y-m-d H:i:s'). ' 2 year'));
		//$newDate = date('Y-m', strtotime(date('Y-m-d H:i:s'). ' -1 month'));
		//echo $newDate;
		
		/*
		$tahun = '2022';
		$bulan = '01';
		$Date = "".$tahun."-".$bulan."-01";
		$daet2 = date('Y-m-d', strtotime($Date. ' - 1 month'));
		//echo date('Y-m-d', strtotime($Date. ' + 2 days'));
		echo $daet2;
		echo '<br/>'.substr($daet2,0,4);
		echo '<br/>'.substr($daet2,5,2);
		*/
		
		/*
			$file = fopen("ujicoba.txt", "x");

			if ($file) {
				echo "File berhasil dibuat";
			} else {
				echo "File gagal dibuat";
			}
			//$fclose($file);
		*/
		
		/*
		$str = "Hello world. It's a beautiful day.";
		$arrStr = explode(" ",$str);
		//print_r (explode(" ",$str));
		echo $arrStr[2];
		*/
		
		$myString = 'Hello, there!';

		if ( strstr( $myString, 'the' ) ) {
		  echo "Text found";
		} else {
		  echo "Text not found";
		}
		
		echo '<br/>'.strlen ('ADELINA');;
		


		
	}
}
