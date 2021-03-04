<?php 

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{

	public function __construct()
    {
		$this->session = session();
		$this->userModel = new UserModel();
        $this->validation = \Config\Services::validation();
    }

	public function index()
	{        
        return view('user/index');
	}

	public function view_data() {
        if($this->request->isAJAX()){
            $no = 1;
            $getdata = $this->userModel->findAll();
            foreach ($getdata as $q) {   
                $query[] = array(
                    'no' => $no++,
                    'username'=>$q['username'],               
                    'nama_pengguna' => $q['nama'], 
                    'kode_unit' => $q['kode_unit'],   
                    'level' => $q['role'],                     
                    'aksi' => array(
                        anchor('user/update/' . $q['id'], '<i class="fa fa-pencil-square-o " data-toggle="tooltip" title="Edit"></i>', 'class="btn btn-warning btn-sm"') . ' ' . 
                        anchor('user/delete/' . $q['id'], '<i class="fa fa-trash"></i>', 'class="btn btn-danger btn-sm" data-toggle="tooltip" title="delete" onclick="javasciprt: return confirm(\'Data Akan Dihapus ?\')"')
                    ),
                );
            }
            $result = isset($query) ? array('data' => $query): array('data' => 0);
            echo json_encode($result);
        }
        
    }

    public function create()
    {
        $data = array(
            'button' => 'Simpan',
            'action' => site_url('user/create_action'),
            'id' => set_value('id'),
            'username' => set_value('username'),
            'password' => set_value('password'),  
            'nama' => set_value('nama'),          
            'role' => set_value('role'),
            'kode_unit' => set_value('kode_unit'),
            'validation' => $this->validation
        );              
        $data['unit'] = $this->userModel->PilihUnit();
        return view('user/form_user',$data);
    }    

    public function create_action() {
        $this->set_rules();
        $isDataValid = $this->validation->withRequest($this->request)->run();
        if($isDataValid){
            $data = array(               
                'username' => $this->request->getPost('username'),
                'nama' => $this->request->getPost('nama'),
                'password' => $this->request->getVar('password'),           
                'role' => $this->request->getPost('role'),                               
                'kode_unit' => $this->request->getPost('kode_unit')
            );  
            $this->userModel->insert($data);
            return redirect('user');
        }
        return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
    }

    public function update($id) {
        $row = $this->userModel->find($id);
        $data = array(
            'button' => 'Update',
            'action' => site_url('user/update_action'),
            'id' => $row['id'],
            'username' => $row['username'], 
            'password' => set_value('password'),  
            'nama' => $row['nama'],
            'role' => $row['role'],
            'kode_unit' =>$row['kode_unit'],
            'validation' => $this->validation
        );       
        $data['unit'] = $this->userModel->PilihUnit();
        return view('user/form_user',$data);        
    }

    public function update_action() {
        $this->set_rulesUpdate();
        $isDataValid = $this->validation->withRequest($this->request)->run();
        if($isDataValid){
            $id = $this->request->getPost('id');
            $password = $this->request->getVar('password');
            $data = array(
                'nama' => $this->request->getPost('nama'),          
                'role' => $this->request->getPost('role'),                               
                'kode_unit' => $this->request->getPost('kode_unit'),
            ); 
            if(!empty($password)){
                $data['password'] = $this->request->getVar('password');
            }
            $this->userModel->update($id,$data);
            return redirect('user');
        }
        return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
    }

    public function delete($id) {
        $deleted = $this->userModel->delete($id);
        if($deleted){
            return redirect('user');
        }
    }

    public function profil() {
        $id = $this->session->userdata('uid');
        $row = $this->M_user->getProfilID($id);
        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('profil_update_action'),
                'id_user' => set_value('id_user', $row->id_user),
                'username' => set_value('username', $row->username), 
                'password' => set_value('password'),  
                'nama_pengguna' => set_value('nama_pengguna', $row->nama_pengguna),
                'usergroup' => $row->usergroup
            );
            $this->template->display('user/form_profile', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('profil'));
        }
    }

    public function profil_update_action() {
        $this->form_validation->set_rules('nama_pengguna', 'Nama Pengguna', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            redirect(site_url('home'));
        } else {
            $id=$this->input->post('id_user', TRUE);
            $password = $this->input->post('password', TRUE);
            $data = array(                
                'nama_pengguna' => $this->input->post('nama_pengguna', TRUE)
            );
            if(!empty($password)){
                $data['password'] = $this->bcrypt->hash_password($password);
            }
            $this->M_user->update($id,$data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('home'));
        }
    }

    public function set_rules() { 
        $this->validation->setRules([           
            'username' => [
                'label' => 'Username', 
                'rules' => 'required|is_unique[user_access.username,id,{id}]',
                'errors' => [
                    'required' => 'Username tidak boleh kosong',
                    'is_unique' => 'Username Sudah Digunakan.'
                ]
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'password' => 'Password tidak boleh kosong',
                ]
            ],
            'nama' => ['label' => 'Nama Pengguna', 'rules' => 'required','errors'=>['required'=>'Nama tidak boleh kosong']],
            'role' => ['label' => 'Hak Akses', 'rules' => 'required','errors'=>['required'=>'Hak akses tidak boleh kosong']],
            'kode_unit' => ['label' => 'Kode Unit', 'rules' => 'required','errors'=>['required'=>'Unit tidak boleh kosong']],
        ]);  
    }

    public function set_rulesUpdate() { 
        $this->validation->setRules([ 
            'nama' => ['label' => 'Nama Pengguna', 'rules' => 'required','errors'=>['required'=>'Nama tidak boleh kosong']],
            'role' => ['label' => 'Hak Akses', 'rules' => 'required','errors'=>['required'=>'Hak akses tidak boleh kosong']],
            'kode_unit' => ['label' => 'Kode Unit', 'rules' => 'required','errors'=>['required'=>'Unit tidak boleh kosong']],
        ]);  
    }
}
