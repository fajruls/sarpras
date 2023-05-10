<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends PX_Controller {
	public function __construct() {
			parent::__construct();
		}

	public function index(){
		if($this->session->userdata('petugas') != FALSE){
			redirect('admin/dashboard');
		}
		else
			redirect('admin/login');
	}

	function login(){
		if($this->session->userdata('petugas') != FALSE){
			redirect('admin/dashboard');
		}
		else
			$this->load->view('backend/admin/login');
	}

	function dashboard(){
		$data['userdata'] = $this->session_petugas;
		if($this->session->userdata('petugas') == FALSE){
			redirect('admin');
		}
		else
		$jml_barang = $this->model_basic->select_all('tbl_barang');
		$jml_peminjam = $this->model_basic->select_all('tbl_peminjam');
		$jml_pinjam = $this->model_basic->select_all('tbl_pinjam');
		$ttl_barang = 0;
		foreach ($jml_barang as $stock) {
			$ttl_barang += $stock->stock;
		}
		$ttl_pinjam = 0;
		foreach ($jml_pinjam as $jml) {
			$ttl_pinjam += $jml->jml;
		}

		$data['jml_barang'] = count($jml_barang);
		$data['jml_peminjam'] = count($jml_peminjam);
		$data['ttl_barang'] = $ttl_barang;
		$data['ttl_pinjam'] = $ttl_pinjam;
		$data['content'] = $this->load->view('backend/admin/dashboard',$data,true);
		$this->load->view('backend/index',$data);
	}


}
