<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Landing extends BaseController
{
    public function index()
    {
        $first_month = date('Y-m-').'01';
        $now         = date('Y-m-d');
        $total_lahir = 0;
        $total_mati  = 0;
        $total_pindah= 0;
        $total_datang= 0;
        $kecamatan   = $this->kecamatan->list();
        foreach ($kecamatan as $kec) {
            $kc = $kec['idc'];
            $as = $kec['idc'];

            $query_lahir = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_lahir WHERE kecamatan = '$kc' AND tgl_lahir BETWEEN '$first_month' AND '$now'");
            $result_lahir[]   = $query_lahir->getResultArray();

            $query_mati = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_mati WHERE kecamatan = '$kc' AND tgl_mati BETWEEN '$first_month' AND '$now'");
            $result_mati[]   = $query_mati->getResultArray();

            $query_pindah = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_pindah WHERE kecamatan = '$kc' AND tgl_pindah BETWEEN '$first_month' AND '$now'");
            $result_pindah[]   = $query_pindah->getResultArray();

            $query_datang = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_datang WHERE kecamatan = '$kc' AND tgl_datang BETWEEN '$first_month' AND '$now'");
            $result_datang[]   = $query_datang->getResultArray();
        }
        foreach ($result_lahir as $row) {
            $kecamatanName = key($row[0]); // Get the kecamatan name
            $Data_lahir[] = [
                'name' => $kecamatanName,
                'data' => intval($row[0][$kecamatanName])
            ];
            $total_lahir += intval($row[0][$kecamatanName]);
        }
        foreach ($result_mati as $row) {
            $kecamatanName = key($row[0]); // Get the kecamatan name
            $Data_mati[] = [
                'name' => $kecamatanName,
                'data' => intval($row[0][$kecamatanName])
            ];
            $total_mati += intval($row[0][$kecamatanName]);
        }
        foreach ($result_pindah as $row) {
            $kecamatanName = key($row[0]); // Get the kecamatan name
            $Data_pindah[] = [
                'name' => $kecamatanName,
                'data' => intval($row[0][$kecamatanName])
            ];
            $total_pindah += intval($row[0][$kecamatanName]);
        }
        foreach ($result_datang as $row) {
            $kecamatanName = key($row[0]); // Get the kecamatan name
            $Data_datang[] = [
                'name' => $kecamatanName,
                'data' => intval($row[0][$kecamatanName])
            ];
            $total_datang += intval($row[0][$kecamatanName]);
        }
        $lahir  = json_encode($Data_lahir);
        $mati   = json_encode($Data_mati) ;
        $pindah = json_encode($Data_pindah);
        $datang = json_encode($Data_datang) ;
        $data = [
			'title'         => 'Dispendukcapil Kota Mojokerto',
            'first_month'   => $first_month,
            'now'           => $now,
            'total_lahir'   => $total_lahir,
            'total_mati'    => $total_mati,
            'total_pindah'  => $total_pindah,
            'total_datang'  => $total_datang,
            'lahir'         => $lahir,
            'mati'          => $mati,
            'pindah'        => $pindah,
            'datang'        => $datang,
		];
        return view('index', $data);
    }
}
