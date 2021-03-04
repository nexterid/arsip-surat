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
		return view('suratkeluar/index');
	}

	public function getSuratMasuk()
	{
		if ($this->request->isAJAX()) {		
			$tanggal = 	$this->request->getPost('tanggal');			
			$getdata = $this->repoSurat->getSuratMasuk($tanggal);
			// dd($getdata);
			foreach($getdata as $q){
				$kode_file = trim($q['kode_klasifikasi']).','.trim($q['nomor_agenda']).','.tgl_db($q['tanggal_agenda']);
				$disposisi = '<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
									<div class="btn-group" role="group">
									<a id="btnGroupDrop1" role="button" href="#" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-send"></i> Disposi</a>
										<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
											<a class="dropdown-item" href="#" id="disDirektur" data-kode="'.$kode_file.'">Disposisi Direktur</a>
											<a class="dropdown-item" href="#" id="disWadir" data-kode="'.$kode_file.'">Disposisi Wadir</a>
											<a class="dropdown-item" href="#" id="disUnit" data-kode="'.$kode_file.'">Disposisi Unit</a>
										</div>
									</div>
								</div>';
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
					'aksi' => $disposisi
				);
			}
			$token = csrf_hash();
			$result = isset($query) ? array('data' => $query,'token'=>$token): array('data' => 0,'token'=>$token);
			echo json_encode($result);
		}		
		
	}

	public function getSuratKeluar()
	{
		if ($this->request->isAJAX()) {		
			$tanggal = 	$this->request->getPost('tanggal');			
			$getdata = $this->repoSurat->getSuratKeluar($tanggal);
			foreach($getdata as $q){
				$status = $q['status_surat']==1 ?'<span class="label label-success">Aktif</span>':'<span class="label label-danger">Non Aktif</span>';
				$kode_file = trim($q['kode_klasifikasi']).','.trim($q['nomor_agenda']).','.tgl_db($q['tanggal_surat']);				
				$query[] = array(
					'kode_klasifikasi' => $q['kode_klasifikasi'],
					'no_agenda' => $q['nomor_agenda'],             
					'tgl_agenda' => tgl_indo($q['tanggal_agenda']),
					'kepada' => $q['kepada'],					
					'tgl_surat' => tgl_indo($q['tanggal_surat']),  
					'isi_surat' => $q['isi_surat'],  
					'kode_rumpun' => $q['kode_rumpun'],				
					'status' => $status,
					'file_lampiran' =>anchor('surat/keluar/file/' . $kode_file, '<i class="fa fa-file-pdf-o"></i> File', 'target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" title="Lihat Lampiran"'),
				);
			}
			$token = csrf_hash();
			$result = isset($query) ? array('data' => $query,'token'=>$token): array('data' => 0,'token'=>$token);
			echo json_encode($result);
		}		
		
	}

	function saveDisposisi()
	{		
		if($this->request->isAJAX()){
			// var_dump($_REQUEST);die;
			$jenis_disposisi = $this->request->getVar('jenis_diposisi');
			$primary_key =[
				'kode_klasifikasi' => $this->request->getVar('kode_klasifikasi'),
				'nomor_agenda' => $this->request->getVar('no_agenda'),
				'tanggal_agenda' =>tgl_db($this->request->getVar('tgl_agenda'))
			];			
			$getkode = explode(",", $this->request->getVar('disposisi_ke'));
			$kode_unit = $getkode[0];
			$nama_unit = $getkode[1];
			if($jenis_disposisi=='disposisi_direktur'){
				$data = [					
					'tgl_disposisi_direktur' => tgl_db($this->request->getVar('tgl_disposisi')),
					'disposisi_direktur_unit' => $kode_unit ,
					'disposisi_direktur_ke' =>$nama_unit,
					'disposisi_direktur' => $this->request->getVar('isi_disposisi'),
				];				
				$query= $this->repoSurat->saveDisposisi($primary_key,$data);
				$token = csrf_hash();
				echo json_encode(['status'=>true,'pesan'=>'Disposisi berhasil disimpan','token'=>$token]);
			}else if($jenis_disposisi=='disposisi_wadir'){
				$data = [					
					'tgl_disposisi_wadir' => tgl_db($this->request->getVar('tgl_disposisi')),
					'disposisi_wadir_ke' => $kode_unit ,
					'nama_unit' =>$nama_unit,
					'disposisi_wadir' => $this->request->getVar('isi_disposisi'),
				];				
				$query= $this->repoSurat->saveDisposisi($primary_key,$data);
				$token = csrf_hash();
				echo json_encode(['status'=>true,'pesan'=>'Disposisi berhasil disimpan','token'=>$token]);
			}else{
				$data = [					
					'tgl_disposisi_unit' => tgl_db($this->request->getVar('tgl_disposisi')),
					'disposisi_unit' => $this->request->getVar('isi_disposisi'),
				];				
				$query= $this->repoSurat->saveDisposisi($primary_key,$data);
				$token = csrf_hash();
				echo json_encode(['status'=>true,'pesan'=>'Disposisi berhasil disimpan','token'=>$token]);
			}
		}
	}

	function getUnitPegawai()
	{
		if($this->request->isAJAX()){
			$getunit = $this->repoSurat->getUnitPegawai();
			echo json_encode($getunit);
		}
	}

	function disposisiDirektur()
	{
		if($this->request->isAJAX()){
			$kode = $this->request->getVar('kode');
			$getdisposisi = $this->repoSurat->getDisposisiDirektur($kode);
			if($getdisposisi){
				$tgl_disposisi = $getdisposisi['tgl_disposisi']!=null? tgl_indo($getdisposisi['tgl_disposisi']):date('d-m-Y');			
				$result = [
					'status' => true,
					'data'=>[
							'kode_klasifikasi' =>trim($getdisposisi['kode_klasifikasi']),
							'no_agenda' => trim($getdisposisi['nomor_agenda']),
							'tgl_agenda' => tgl_indo($getdisposisi['tanggal_agenda']),
							'tgl_disposisi' => $tgl_disposisi,
							'kode_unit' => $getdisposisi['kode_unit'],
							'disposisi_unit' => $getdisposisi['disposisi_unit'],
							'isi_disposisi' => $getdisposisi['isi_disposisi']
						]
					];
				echo json_encode($result);
			}else{
				echo json_encode(['status'=>false]);
			}
			
		}
	}

	function disposisiWadir()
	{
		if($this->request->isAJAX()){
			$kode = $this->request->getVar('kode');
			$getdisposisi = $this->repoSurat->getDisposisiWadir($kode);
			if($getdisposisi){
				$tgl_disposisi = $getdisposisi['tgl_disposisi']!=null? tgl_indo($getdisposisi['tgl_disposisi']):date('d-m-Y');			
				$result = [
					'status' => true,
					'data'=>[
							'kode_klasifikasi' =>trim($getdisposisi['kode_klasifikasi']),
							'no_agenda' => trim($getdisposisi['nomor_agenda']),
							'tgl_agenda' => tgl_indo($getdisposisi['tanggal_agenda']),
							'tgl_disposisi' => $tgl_disposisi,
							'kode_unit' => $getdisposisi['kode_unit'],
							'disposisi_unit' => $getdisposisi['disposisi_unit'],
							'isi_disposisi' => $getdisposisi['isi_disposisi']
						]
					];
				echo json_encode($result);
			}else{
				echo json_encode(['status'=>false]);
			}
			
		}
	}

	function disposisiUnit()
	{
		if($this->request->isAJAX()){
			$kode = $this->request->getVar('kode');
			$getdisposisi = $this->repoSurat->getDisposisiUnit($kode);
			if($getdisposisi){
				$tgl_disposisi = $getdisposisi['tgl_disposisi']!=null? tgl_indo($getdisposisi['tgl_disposisi']):date('d-m-Y');			
				$result = [
					'status' => true,
					'data'=>[
							'kode_klasifikasi' =>trim($getdisposisi['kode_klasifikasi']),
							'no_agenda' => trim($getdisposisi['nomor_agenda']),
							'tgl_agenda' => tgl_indo($getdisposisi['tanggal_agenda']),
							'tgl_disposisi' => $tgl_disposisi,
							'kode_unit' => $getdisposisi['kode_unit'],
							'disposisi_unit' => $getdisposisi['disposisi_unit'],
							'isi_disposisi' => $getdisposisi['isi_disposisi']
						]
					];
				echo json_encode($result);
			}else{
				echo json_encode(['status'=>false]);
			}
			
		}
	}

	public function getfileSuratMasuk($kode_file)
	{		
		// $getFileLampiran['lampiran']= $this->repoSurat->getFileSuratMasuk($kode_file);			
		// return view('suratmasuk/lampiran',$getFileLampiran);

		$getFileLampiran= $this->repoSurat->getFileSuratMasuk($kode_file);		
		if($getFileLampiran==null){
			return view('errors/error_404');
		}
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

	public function getfileSuratKeluar($kode_file)
	{		
		// $getFileLampiran['lampiran']= $this->repoSurat->getFileSuratMasuk($kode_file);			
		// return view('suratmasuk/lampiran',$getFileLampiran);

		$getFileLampiran= $this->repoSurat->getFileSuratKeluar($kode_file);		
		if($getFileLampiran==null){
			return view('errors/error_404');
		}
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
