<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends PX_Controller {
	public function __construct() {
			parent::__construct();
	}

    public function index(){
		if($this->session->userdata('petugas') != FALSE){
			redirect('admin/dashboard');
		}else if($this->session->userdata('peminjam') != FALSE){
			redirect('member/dashboard');
		}
		else
			redirect('auth/login');
	}

	function login(){
		if($this->session->userdata('petugas') != FALSE){
			redirect('admin/dashboard');
		}else if($this->session->userdata('peminjam') != FALSE){
			redirect('member/dashboard');
		}
		else
			$this->load->view('auth/login');
	}

    function do_login() {
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$user_data = $this->model_basic->select_where('tbl_petugas','username',$username)->row();
		$user_data_member = $this->model_basic->select_where('tbl_peminjam', 'username', $username)->row();
		if($user_data){
			if($this->encrypt->decode($user_data->password) == $password){
				$data_user = array(
					'id_petugas' => $user_data->id_petugas,
					'username' => $user_data->username,
					'password' => $password,
					'name' => $user_data->name,
					'email' => $user_data->email,
					'photo' => $user_data->photo
					);
				$this->session->set_userdata('petugas',$data_user);
				$this->returnJson(array('status' => 'ok','msg' => 'Login berhasil, anda akan di alihkan.','redirect' => base_url('admin/dashboard')));
			}
			else
				$this->returnJson(array('status' => 'error','msg' => 'Login gagal, password anda salah.'));
		}
		else if($user_data_member){
			if($this->encrypt->decode($user_data_member->password) == $password){
				$data_user = array(
					'id_peminjam' => $user_data_member->id_peminjam,
					'username' => $user_data_member->username,
					'password' => $password,
					'name' => $user_data_member->name,
					'email' => $user_data_member->email,
					);
				$this->session->set_userdata('peminjam',$data_user);
				$this->returnJson(array('status' => 'ok','msg' => 'Login berhasil, anda akan di alihkan.','redirect' => base_url('member_system/profile')));
			}
			else
				$this->returnJson(array('status' => 'error','msg' => 'Login gagal, password anda salah.'));
		}
		else
			$this->returnJson(array('status' => 'error','msg' => 'Login gagal, username tidak terdaftar.'));
	}

	function do_logout() {
		if($this->session->userdata('petugas') != FALSE){
			$this->session->unset_userdata('petugas');
			redirect('home');
		}else if($this->session->userdata('peminjam') != FALSE){
			$this->session->unset_userdata('peminjam');
			redirect('home');
		}
		else
			redirect('home');
	}

}