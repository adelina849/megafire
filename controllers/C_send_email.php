<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_send_email extends CI_Controller {

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
			$config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => 'admin@imsteknologi.com',
            'smtp_pass' => '@Admin849',
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n"
        );

        $this->load->library('email', $config);

        $this->email->from('admin@imsteknologi.com', 'invoice');
        $this->email->to('amazon.mulyanayusuf@gmail.com');
        $this->email->subject('Invoice');
        $this->email->message('Test');

        $this->email->send();
		//echo'SEND EMAIL';
	}
}
