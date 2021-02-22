<?php 

namespace App\Models;

use CodeIgniter\Model;

class SuratModel extends Model
{
    protected $table = 'tbl_agendasrtmasuk';
    protected $allowedFields = ['kode_klasifikasi','nomor_agenda','tanggal_agenda','asal_surat','nomor_surat','tanggal_surat','isi_surat','sifat_surat'];
   
   
}