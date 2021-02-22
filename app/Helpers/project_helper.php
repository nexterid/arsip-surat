<?php

function cek_menu() {
    $ci = & get_instance();
    $gid = $ci->session->userdata('gid');
    $link = $ci->uri->segment(1);
    $cek_menu = $ci->db->get_where('tb_menu_access', array('gid' => $gid, 'allow' => 1, 'link' => $link));
    if ($cek_menu->num_rows() == 0) {
        redirect('dashboard');
    }
}

function chek_administrator() {
    $ci = & get_instance();
    if ($ci->session->userdata('role') !== 'Administrator') {
        redirect('dashboard');
    }
}

function cek_menu_admin(){
    $ci = & get_instance();
    $usergroup =$ci->session->userdata('usergroup');
    if ($usergroup == 'Kasir') {
        redirect('error403');
    }
}

if (!function_exists('active_link')) {

    function active_menu($controller) {
        $CI = get_instance();
        $class = $CI->router->fetch_class();
        return ($class == $controller) ? 'active' : '';
    }

    function active_treeview($controller) {
        $CI = get_instance();
        $class = $CI->router->fetch_class();
        return ($class == $controller) ? 'active treeview' : '';
    }

}


function npwp_format($npwp){
    return substr($npwp,0,2).'.'.substr($npwp,2,3).'.'.substr($npwp,5,3).'.'.substr($npwp,8,1).'-'.substr($npwp,9,3).'.'.substr($npwp,12,3);
}

function tgl_balik($tanggal) {
    if (empty($tanggal)) {
        return '';
    } elseif ($tanggal == '0000-00-00') {
        return '';
    } else {
        return date('d-m-Y', strtotime($tanggal));
    }
}

function tgl_db($tanggal) {
    return date('Y-m-d', strtotime($tanggal));
}

function waktu_24($waktu) {
    return date('H:i', strtotime($waktu));
}

function tanggal() {
    return date('Y-m-d');
}

function tanggal_indo() {
    return date('d-m-Y H:i:s');
}

function tanggal_db() {
    return date("Y-m-d H:i:s");
}

function kode_tanggal() {
    return date('dmY');
}

function tanggal_new() {
    /* script menentukan hari */
    $array_hr = array(1 => "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu");
    $hr = $array_hr[date('N')];

    /* script menentukan tanggal */
    $tgl = date('j');
    /* script menentukan bulan */
    $array_bln = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $bln = $array_bln[date('n')];
    /* script menentukan tahun */
    $thn = date('Y');
    /* script perintah keluaran */
    return $hr . ", " . $tgl . " " . $bln . " " . $thn . " " . date('H:i:s');
}

function rupiah($angka) {
    $rupiah = "Rp ". number_format($angka, 2, ',', '.');
    return $rupiah;
}

function ribuan($angka) {
    $rupiah = number_format($angka, 0, ',', '.');
    return $rupiah;
}

function persen($angka) {
    $persen = $angka. " %";
    return $persen;
}

function desimal2($angka) {
    $desimal = number_format($angka, 2, ',', '.');
    return $desimal;
}

function desimal($angka) {
    $desimal = number_format($angka, 2);
    return $desimal;
}

function tgl_indo($tgl) {
    $tanggal = substr($tgl, 8, 2);
    $bulan = substr($tgl, 5, 2);
    $tahun = substr($tgl, 0, 4);
    $time = substr($tgl, 11, 5);
    return $tanggal . '-' . $bulan . '-' . $tahun;
}

function tgl_indotime($tgl) {
    $tanggal = substr($tgl, 8, 2);
    $bulan = substr($tgl, 5, 2);
    $tahun = substr($tgl, 0, 4);
    $time = substr($tgl, 11, 5);
    return $tanggal . '-' . $bulan . '-' . $tahun . ' ' . $time;
}

function tgl_lengkap($tanggals) {

    $tanggal = substr($tanggals, 8, 2);
    $bulan = substr($tanggals, 5, 2);
    $tahun = substr($tanggals, 0, 4);
    $time = substr($tanggals, 11, 5);

    return $tanggal . ' ' . bulan($bulan) . ' ' . $tahun;
}

function bulan($bln) {
    switch ($bln) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februai";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agtustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}

function bulan_romawi($bln) {
    switch ($bln) {
        case '01':
            return "I";
            break;
        case '02':
            return "II";
            break;
        case '03':
            return "III";
            break;
        case '04':
            return "IV";
            break;
        case '05':
            return "V";
            break;
        case '06':
            return "VI";
            break;
        case '07':
            return "VII";
            break;
        case '08':
            return "VIII";
            break;
        case '09':
            return "IX";
            break;
        case 10:
            return "X";
            break;
        case 11:
            return "XI";
            break;
        case 12:
            return "XII";
            break;
    }
}

function nama_hari($tanggal) {
    $ubah = gmdate($tanggal, time() + 60 * 60 * 8);
    $pecah = explode("-", $ubah);
    $tgl = $pecah[2];
    $bln = $pecah[1];
    $thn = $pecah[0];

    $nama = date("l", mktime(0, 0, 0, $bln, $tgl, $thn));
    $nama_hari = "";
    if ($nama == "Sunday") {
        $nama_hari = "Minggu";
    } else if ($nama == "Monday") {
        $nama_hari = "Senin";
    } else if ($nama == "Tuesday") {
        $nama_hari = "Selasa";
    } else if ($nama == "Wednesday") {
        $nama_hari = "Rabu";
    } else if ($nama == "Thursday") {
        $nama_hari = "Kamis";
    } else if ($nama == "Friday") {
        $nama_hari = "Jumat";
    } else if ($nama == "Saturday") {
        $nama_hari = "Sabtu";
    }
    return $nama_hari;
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai) {
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return ucwords($hasil . ' Rupiah');
}

function round_up($value, $places) {
    $mult = 100;
    return $places < 0 ?
        ceil($value / $mult) * $mult :
        ceil($value * $mult) / $mult;
}

