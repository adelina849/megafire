<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'C_login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

	//LOGIN
		$route['login-proses'] = "C_login/cek_login";
		$route['login-proses/(:any)'] = 'C_login/cek_login';
		
		$route['logout'] = "C_login/logout";
		$route['logout/(:any)'] = 'C_login/logout';
	//LOGIN
	
	//DASHBOARD
		$route['dashboard-admin'] = "C_dash/index";
		$route['dashboard-admin/(:any)'] = 'C_dash/index';
	//DASHBOARD
	
	//DATA APAR
		$route['data-apar'] = "C_data_apar/index";
		$route['data-apar/(:any)'] = 'C_data_apar/index';
		
		$route['data-apar-cek-no-apar'] = "C_data_apar/cek_no_apar";
		$route['data-apar-cek-no-apar/(:any)'] = 'C_data_apar/cek_no_apar';
		
		$route['data-apar-simpan'] = "C_data_apar/simpan";
		$route['data-apar-simpan/(:any)'] = 'C_data_apar/simpan';
		
		$route['data-apar-hapus'] = "C_data_apar/hapus";
		$route['data-apar-hapus/(:any)'] = 'C_data_apar/hapus';
		
		$route['data-apar-excel'] = "C_data_apar/view_excel";
		$route['data-apar-excel/(:any)'] = 'C_data_apar/view_excel';
	//DATA APAR
	
	//DATA PEMILIK
		$route['data-pemilik'] = "C_data_pelanggan/index";
		$route['data-pemilik/(:any)'] = 'C_data_pelanggan/index';
		
		$route['data-pemilik-simpan'] = "C_data_pelanggan/simpan";
		$route['data-pemilik-simpan/(:any)'] = 'C_data_pelanggan/simpan';
		
		$route['data-pemilik-hapus'] = "C_data_pelanggan/hapus";
		$route['data-pemilik-hapus/(:any)'] = 'C_data_pelanggan/hapus';
		
		$route['data-pemilik-excel'] = "C_data_pelanggan/view_excel";
		$route['data-pemilik-excel/(:any)'] = 'C_data_pelanggan/view_excel';
	//DATA PEMILIK
	
	//DATA PETUGAS
		$route['data-petugas'] = "C_data_petugas/index";
		$route['data-petugas/(:any)'] = 'C_data_petugas/index';
		
		$route['data-petugas-simpan'] = "C_data_petugas/simpan";
		$route['data-petugas-simpan/(:any)'] = 'C_data_petugas/simpan';
		
		$route['data-petugas-hapus'] = "C_data_petugas/hapus";
		$route['data-petugas-hapus/(:any)'] = 'C_data_petugas/hapus';
		
		$route['data-petugas-excel'] = "C_data_petugas/view_excel";
		$route['data-petugas-excel/(:any)'] = 'C_data_petugas/view_excel';
	//DATA PETUGAS
	
	//DATA QUIS
		$route['data-quis'] = "C_data_quis/index";
		$route['data-quis/(:any)'] = 'C_data_quis/index';
		
		$route['data-quis-simpan'] = "C_data_quis/simpan";
		$route['data-quis-simpan/(:any)'] = 'C_data_quis/simpan';
		
		$route['data-quis-hapus'] = "C_data_quis/hapus";
		$route['data-quis-hapus/(:any)'] = 'C_data_quis/hapus';
		
		$route['data-quis-excel'] = "C_data_quis/view_excel";
		$route['data-quis-excel/(:any)'] = 'C_data_quis/view_excel';
	//DATA QUIS
	
	//PEMBELIAN
		$route['transaksi-pembelian'] = "C_transaksi_pembelian/index";
		$route['transaksi-pembelian/(:any)'] = 'C_transaksi_pembelian/index';
		
		$route['transaksi-pembelian-simpan'] = "C_transaksi_pembelian/simpan";
		$route['transaksi-pembelian-simpan/(:any)'] = 'C_transaksi_pembelian/simpan';
		
		$route['transaksi-pembelian-hapus'] = "C_transaksi_pembelian/hapus";
		$route['transaksi-pembelian-hapus/(:any)'] = 'C_transaksi_pembelian/hapus';
		
		$route['transaksi-pembelian-pemindahan-apar-view'] = "C_transaksi_pembelian/view_list_pemindahaan_apar";
		$route['transaksi-pembelian-pemindahan-apar-view/(:any)'] = 'C_transaksi_pembelian/view_list_pemindahaan_apar';
		
		$route['transaksi-pembelian-pemindahan-apar-view-simpan'] = "C_transaksi_pembelian/simpan_pemindahan_apar";
		$route['transaksi-pembelian-pemindahan-apar-view-simpan/(:any)'] = 'C_transaksi_pembelian/simpan_pemindahan_apar';
		
		$route['transaksi-cek-apar'] = "C_transaksi_cek_apar/index";
		$route['transaksi-cek-apar/(:any)'] = 'C_transaksi_cek_apar/index';
	//PEMBELIAN
