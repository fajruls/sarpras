<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends PX_Controller {
	public function __construct() {
			parent::__construct();
		}

	public function index(){
		if($this->session->userdata('peminjam') != FALSE){
			redirect('member/dashboard');
		}
		else
			redirect('member/login');
	}

	function login(){
		if($this->session->userdata('peminjam') != FALSE){
			redirect('member/dashboard');
		}
		else
			$this->load->view('frontend/member/login');
	}

	function dashboard(){
		$data['userdata'] = $this->session_peminjam;
		if($this->session->userdata('peminjam') == FALSE){
			redirect('member');
		}
		else
		$jml_barang = $this->model_basic->select_where('tbl_barang','status','tampilkan')->result();
		$jml_pinjam = $this->model_basic->select_where('tbl_pinjam','id_peminjam',$this->session_peminjam['id_peminjam'])->result();
		$ttl_barang = 0;
		foreach ($jml_barang as $stock) {
			$ttl_barang += $stock->stock;
		}
		$ttl_pinjam = 0;
		foreach ($jml_pinjam as $jml) {
			$ttl_pinjam += $jml->jml;
		}

		$data['ttl_barang'] = $ttl_barang;
		$data['ttl_pinjam'] = $ttl_pinjam;
		$data['content'] = $this->load->view('frontend/member/dashboard',$data,true);
		$this->load->view('frontend/index',$data);
	}

}
