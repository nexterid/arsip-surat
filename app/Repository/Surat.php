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
        parent::__construct();
        $this->suratModel = new SuratModel();
    }

    //query dengan model
    public function getSuratMasuk($tanggal)
    {
        $role = $_SESSION['role'];   
        $unit = $_SESSION['kode_unit'];      
        $bulan= date('m', strtotime($tanggal));
        $tahun= date('Y', strtotime($tanggal));
        $result= $this->suratModel
                    ->select('kode_klasifikasi,nomor_agenda,tanggal_agenda,asal_surat,nomor_surat,tanggal_surat,isi_surat,sifat_surat,disposisi_direktur,disposisi_direktur_ke,disposisi_wadir,disposisi_wadir_ke,nama_unit')
                    ->where('month(tanggal_agenda)',$bulan)
                    ->where('year(tanggal_agenda)',$tahun)
                    ->orderBy('tanggal_agenda','DESC');
                    if($role=='Direktur'){
                        $result->where('disposisi_direktur is NOT NULL', NULL, FALSE);
                    }else if($role=='Wadir'){
                        $result->where('disposisi_direktur_unit',$unit);
                    }else if($role=='Unit'){                        
                        $result->where('disposisi_wadir_ke', $unit);
                    }                          
        return $result->findAll();
        
    }

    public function getSuratKeluar($tanggal)
    {    
        $bulan= date('m', strtotime($tanggal));
        $tahun= date('Y', strtotime($tanggal));
        $result= $this->db->table('tbl_agendasrtkeluar')
                    ->select('kode_klasifikasi,nomor_agenda,tanggal_agenda,kepada,isi_surat,pengolah,kode_rumpun,tanggal_surat,status_surat')
                    ->where('month(tanggal_agenda)',$bulan)
                    ->where('year(tanggal_agenda)',$tahun)
                    ->orderBy('tanggal_agenda','DESC')->get()->getResultArray();
        return $result;
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

    public function getFileSuratKeluar($kode_file)
    {
        $getkode = explode(",",$kode_file);
		$kode_klasifikasi = $getkode[0];
		$no_agenda = $getkode[1];
		$tgl_agenda = $getkode[2];
        return $this->db->table('file_keluar')
                ->select('file')
                ->where(['kode_klasifikasi'=>$kode_klasifikasi,'nomor_agenda'=>$no_agenda,'tanggal_surat'=>$tgl_agenda])
                ->get()->getFirstRow();
    }

    public function getUnitPegawai()
    {
        return $this->db->table('tbl_unit')->select('kode_unit,nama_unit')->get()->getResultArray();
    }

    public function getDisposisiDirektur($kode)
    {
        $getkode = explode(",",$kode);
		$kode_klasifikasi = $getkode[0];
		$no_agenda = $getkode[1];
		$tgl_agenda = $getkode[2];
        return $this->suratModel
                ->select('kode_klasifikasi, nomor_agenda, tanggal_agenda,disposisi_direktur_unit as kode_unit,disposisi_direktur_ke as disposisi_unit,tgl_disposisi_direktur as tgl_disposisi,disposisi_direktur as isi_disposisi')
                ->where(['kode_klasifikasi'=>$kode_klasifikasi,'nomor_agenda'=>$no_agenda,'tanggal_agenda'=>$tgl_agenda])
                ->first();
    }

    public function getDisposisiWadir($kode)
    {
        $getkode = explode(",",$kode);
		$kode_klasifikasi = $getkode[0];
		$no_agenda = $getkode[1];
		$tgl_agenda = $getkode[2];
        return $this->suratModel
                ->select('kode_klasifikasi, nomor_agenda, tanggal_agenda,disposisi_wadir_ke as kode_unit,nama_unit as disposisi_unit,tgl_disposisi_wadir as tgl_disposisi,disposisi_wadir as isi_disposisi')
                ->where(['kode_klasifikasi'=>$kode_klasifikasi,'nomor_agenda'=>$no_agenda,'tanggal_agenda'=>$tgl_agenda])
                ->first();
    }

    public function getDisposisiUnit($kode)
    {
        $getkode = explode(",",$kode);
		$kode_klasifikasi = $getkode[0];
		$no_agenda = $getkode[1];
		$tgl_agenda = $getkode[2];
        return $this->suratModel
                ->select('kode_klasifikasi, nomor_agenda, tanggal_agenda,disposisi_wadir_ke as kode_unit,nama_unit as disposisi_unit,tgl_disposisi_unit as tgl_disposisi,disposisi_unit as isi_disposisi')
                ->where(['kode_klasifikasi'=>$kode_klasifikasi,'nomor_agenda'=>$no_agenda,'tanggal_agenda'=>$tgl_agenda])
                ->first();
    }

    public function saveDisposisi($primary_key,$data)
    {
       return $this->db->table('tbl_agendasrtmasuk')->where($primary_key)->update($data);
    }
    
}