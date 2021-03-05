<?php

namespace App\Controllers;

use App\Repository\Master as RepoMaster;

class Klasifikasi extends BaseController
{
	protected $repoMaster ;

	public function __construct()
	{		
		$this->repoMaster = new RepoMaster();
    }

	public function index()
	{
		return view('klasifikasi/index');
	}
	
	public function view_data()
	{
		if ($this->request->isAJAX()) {	
			$no=1;
			$getdata = $this->repoMaster->getMasterKlasifikasi();
			foreach($getdata as $q){							
				$query[] = array(
                    'no' => $no++,
                    'kode'=>$q['kode_klasifikasi'],               
                    'nama' => $q['nama'], 
					'rumpun' => $q['rumpun'],          
                    'aksi' => '<a href="#" id="btn-update" data-kode="'.trim($q['kode_klasifikasi']).'" data-nama="'.$q['nama'].'" data-rumpun="'.$q['kode_rumpun'].'"class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o " data-toggle="tooltip" title="Edit"></i></a>',
                );
			}
			$result = isset($query) ? array('data' => $query): array('data' => 0);
            echo json_encode($result);
		}		
		
	}

	function getRumpun()
	{
		if($this->request->isAJAX()){
			$getrumpun = $this->repoMaster->getRumpun();
			echo json_encode($getrumpun);
		}
	}

	function simpanData()
	{		
		if($this->request->isAJAX()){
			$kode = $this->request->getVar('kode');
			$data=[
				'kode_klasifikasi' =>$this->request->getVar('kode_klasifikasi'),
				'keterangan' => $this->request->getVar('nama_klasifikasi'),
				'kode_rumpun' => $this->request->getVar('rumpun')
			];
			if($kode!=null){				
				$query = $this->repoMaster->updateMasterKlasifikasi($data);
			}else{
				$query = $this->repoMaster->saveMasterKlasifikasi($data);
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
