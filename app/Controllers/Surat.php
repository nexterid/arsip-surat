<?php

namespace App\Controllers;

use App\Models\SuratModel;
use App\Repository\Surat as RepoSurat;

class Surat extends BaseController
{
	protected $repoSurat ;

	public function __construct()
	{
		$this->repoSurat = new RepoSurat();
    }

	public function masuk()
	{
		return view('suratmasuk/index');
	}

	public function keluar()
	{
		return view('suratmasuk/index');
	}

	public function getSuratMasuk()
	{
		if ($this->request->isAJAX()) {		
			$tanggal = 	$this->request->getPost('tanggal');			
			$getdata = $this->repoSurat->getSuratMasuk($tanggal);			
			foreach($getdata as $q){
				$kode_file = trim($q['kode_klasifikasi']).','.trim($q['nomor_agenda']).','.tgl_db($q['tanggal_agenda']);
				// var_dump($kode_file);die;
				$query[] = array(
					'kode_klasifikasi' => $q['kode_klasifikasi'],
					'no_agenda' => $q['nomor_agenda'],             
					'tgl_agenda' => tgl_indo($q['tanggal_agenda']),
					'asal_surat' => $q['asal_surat'],
					'nomor_surat' => $q['nomor_surat'],
					'tgl_surat' => tgl_indo($q['tanggal_surat']),  
					'isi_surat' => $q['isi_surat'],  
					'sifat_surat' => $q['sifat_surat'],
					'disposisi_direktur' => $q['disposisi_direktur'], 
					'disposisi_direktur_ke' => $q['disposisi_direktur_ke'], 
					'disposisi_wadir' => $q['disposisi_wadir'],  
					'disposisi_wadir_ke' => $q['disposisi_wadir_ke'],
					'nama_unit' => $q['nama_unit'],
					'file_lampiran' =>anchor('surat/masuk/file/' . $kode_file, '<i class="fa fa-file-pdf-o"></i> File', 'target="_blank" class="btn btn-success btn-sm" data-toggle="tooltip" title="Lihat Lampiran"'),
					'aksi' =>array(                    
						anchor('surat/masuk/' . $q['kode_klasifikasi'], '<i class="fa fa-pdf"></i> aksi', 'target="_blank" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Lihat Lampiran"')
					),
				);
			}
			$token = csrf_hash();
			$result = isset($query) ? array('data' => $query,'token'=>$token): array('data' => 0,'token'=>$token);
			echo json_encode($result);
		}		
		
	}

	public function getfileSuratMasuk($kode_file)
	{		
		// $getFileLampiran['lampiran']= $this->repoSurat->getFileSuratMasuk($kode_file);			
		// return view('suratmasuk/lampiran',$getFileLampiran);

		$getFileLampiran= $this->repoSurat->getFileSuratMasuk($kode_file);
		$content = $getFileLampiran->file;
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename=LampiranSuarat.pdf');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		
		return view("suratmasuk/lampiran", [
			"title"=>"Display PDF",
			"pdf"=>$content
		]);
	}

	public function download($file){	
		$name = 'lampiran_file.pdf';
		$path = base_url()."lampiran";
		$data = file_put_contents($path."/".$name, base64_decode($file));
		header('Content-type: application/pdf');
		force_download($name, $data);
	}

}
