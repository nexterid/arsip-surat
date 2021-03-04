<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user_access';
    protected $allowedFields = ['id','username','password','nama','role','kode_unit'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => 'required',
        // 'username' => 'required|is_unique[user_access.username,id,{id}]',
        // 'password' => 'required|min_length[6]'
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Maaf, Username sudah terdaftar silahkan buat user lain'
        ]
    ];

    protected $skipValidation = false;
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (! isset($data['data']['password'])) {
            return $data;
        }
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        return $data;
    }
   
    public function PilihUnit()
    {              
        $result = $this->db->table('tbl_unit')->select('kode_unit,nama_unit')->get()->getResultArray(); 
        $data[''] = '- Pilih Unit -';
        foreach ($result as $row) {
            $data[$row['kode_unit']] = $row['nama_unit'].' ('.$row['kode_unit'].')';
        }
        return $data;
    }
    
}