<?php

namespace App\Repository;
use App\Repository\Conn;

class Master extends Conn
{   

    //function query unit
    public function getMasterUnit()
    {       
        return $this->db->table('tbl_unit')->select('kode_unit,nama_unit')->get()->getResultArray();
    }

    public function saveMasterUnit($data)
    {        
        return $this->db->table('tbl_unit')->insert($data);
    }

    public function updateMasterUnit($data)
    {
        $kode = $data['kode_unit'];
        return $this->db->table('tbl_unit')->where('kode_unit',$kode)->update(['nama_unit'=>$data['nama_unit']]);
    }

    //function query Klasifikasi
    public function getMasterKlasifikasi()
    {       
        return $this->db->table('tbl_klasifikasi_arsip as k')
                    ->select('k.kode_klasifikasi,k.keterangan as nama,k.kode_rumpun,r.keterangan as rumpun')
                    ->join('tbl_rumpun as r','k.kode_rumpun=r.kode_rumpun')
                    ->get()->getResultArray();
    }

    public function getRumpun()
    {
        return $this->db->table('tbl_rumpun')->select('kode_rumpun,keterangan as rumpun')->get()->getResultArray();
    }  
    
    public function saveMasterKlasifikasi($data)
    {    
        $idx = $this->db->query("SELECT max(idx) AS idx FROM tbl_klasifikasi_arsip")->getRowArray(); 
        $datainsert =[
            'kode_klasifikasi' =>$data['kode_klasifikasi'],
            'keterangan' => $data['keterangan'],
            'kode_rumpun' => $data['kode_rumpun'],
            'idx' => (int)$idx['idx']+1
        ];
        return $this->db->table('tbl_klasifikasi_arsip')->insert($datainsert);
    }

    public function updateMasterKlasifikasi($data)
    {
        $kode = $data['kode_klasifikasi'];
        return $this->db->table('tbl_klasifikasi_arsip')->where('kode_klasifikasi',$kode)->update(['keterangan'=>$data['keterangan'],'kode_rumpun'=>$data['kode_rumpun']]);
    }

   
}