<?php

namespace App\Repository;
use App\Models\SuratModel;
use App\Repository\Conn;

class Surat extends Conn
{
    protected $suratModal ;

    protected $table = 'file_masuk';
    
    public function __construct()
    {
        $this->suratModel = new SuratModel();
        parent::__construct();
    }

    //query dengan model
    public function getSuratMasuk($tanggal)
    {
        $role = $_SESSION['role'];
        if($role=='Admin'){
            return $this->getAllSuratMasuk($tanggal);
        }else if($role=='Direktur'){
            return $this->getSuratMasukDirektur($tanggal);
        }else if($role=="Wadir"){
            return $this->getSuratMasukWadir($tanggal);
        }else{
            return $this->getSuratMasukUnit($tanggal);
        }
        
    }

    public function getAllSuratMasuk($tanggal)
    {
        $bulan= date('m', strtotime($tanggal));
        $tahun= date('Y', strtotime($tanggal));
        return $this->suratModel
                    ->select('kode_klasifikasi,nomor_agenda,tanggal_agenda,asal_surat,nomor_surat,tanggal_surat,isi_surat,sifat_surat,disposisi_direktur,disposisi_direktur_ke,disposisi_wadir,disposisi_wadir_ke,nama_unit')
                    ->where('month(tanggal_surat)',$bulan)
                    ->where('year(tanggal_surat)',$tahun)
                    ->findAll();
    }

    public function getAllSuratDirektur($tanggal)
    {
        $bulan= date('m', strtotime($tanggal));
        $tahun= date('Y', strtotime($tanggal));
        return $this->suratModel
                    ->select('kode_klasifikasi,nomor_agenda,tanggal_agenda,asal_surat,nomor_surat,tanggal_surat,isi_surat,sifat_surat,disposisi_direktur,disposisi_direktur_ke,disposisi_wadir,disposisi_wadir_ke,nama_unit')
                    ->where('month(tanggal_surat)',$bulan)
                    ->where('year(tanggal_surat)',$tahun)
                    ->where('disposisi_direktur is NOT NULL', NULL, FALSE)
                    ->findAll();
    }

    //query tanpa model 
    public function getFileSuratMasuk($kode_file)
    {
        $getkode = explode(",",$kode_file);
		$kode_klasifikasi = $getkode[0];
		$no_agenda = $getkode[1];
		$tgl_agenda = $getkode[2];
        return $this->db->table('file_masuk')
                ->select('file')
                ->where(['kode_klasifikasi'=>$kode_klasifikasi,'nomor_agenda'=>$no_agenda,'tanggal_agenda'=>$tgl_agenda])
                ->get()->getFirstRow();
    }
    
}