<?php 

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
	public function __construct()
    {
		$this->session = session();
		$this->userModel = new UserModel();
    }

	public function index()
	{
        $data=['title'=>'Login Arsip Surat Rsudkraton'];
        return view('auth/login',$data);
	}

	public function login()
	{
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $data = $this->userModel->where('username', $username)->first();
        if($data){
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if($verify_pass){
                $ses_data = [
                    'uid'       => $data['id'],
                    'nama'     	=> $data['nama'],
                    'role'    	=> $data['role'],
                    'kode_unit' => $data['kode_unit'],
                    'logged_in'	=> TRUE
                ];
                $this->session->set($ses_data);
                return redirect()->to('/home');
            }else{
                $this->session->setFlashdata('msg', 'Password Salah');
                return redirect()->back()->withInput();
            }
        }else{
            $this->session->setFlashdata('msg', 'Username tidak ditemukan');
            return redirect()->back()->withInput();
        }
	}

    public function logout()
    {
        session()->destroy();
        return redirect('auth');
    }
}
