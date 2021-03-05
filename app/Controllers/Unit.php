<?php

namespace App\Controllers;

use App\Repository\Master as RepoMaster;

class Unit extends BaseController
{
	protected $repoMaster ;

	public function __construct()
	{		
		$this->repoMaster = new RepoMaster();
    }

	public function index()
	{
		return view('unit/index');
	}
	
	public function view_data()
	{
		if ($this->request->isAJAX()) {	
			$no=1;
			$getdata = $this->repoMaster->getMasterUnit();
			foreach($getdata as $q){							
				$query[] = array(
                    'no' => $no++,
                    'kode_unit'=>$q['kode_unit'],               
                    'nama_unit' => $q['nama_unit'],           
                    'aksi' => '<a href="#" id="btn-update" data-kode="'.$q['kode_unit'].'" data-nama="'.$q['nama_unit'].'" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o " data-toggle="tooltip" title="Edit"></i></a>',
                );
			}
			$result = isset($query) ? array('data' => $query): array('data' => 0);
            echo json_encode($result);
		}		
		
	}

	function simpanData()
	{		
		if($this->request->isAJAX()){
			$kode = $this->request->getVar('kode');
			$data=[
				'kode_unit' =>$this->request->getVar('kode_unit'),
				'nama_unit' => $this->request->getVar('nama_unit')
			];
			if($kode!=null){				
				$query = $this->repoMaster->updateMasterUnit($data);
			}else{
				$query = $this->repoMaster->saveMasterUnit($data);
			}			
			$token = csrf_hash();
			if($query){
				echo json_encode(['status'=>true,'pesan'=>'Data Berhasil disimpan','token'=>$token]);
			}else{
				echo json_encode(['status'=>false,'pesan'=>'Data gagal disimpan','token'=>$token]);
			}			
		}
	}
}
