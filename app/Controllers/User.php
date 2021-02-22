<?php 

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
	public function __construct()
    {
		$this->session = session();
		$this->userModel = new UserModel();
    }

	public function index()
	{        
        return view('user/index');
	}

	
}
