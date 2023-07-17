<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Landing extends BaseController
{
    public function index()
    {
        $first_month = date('Y-m-').'01';
        $now        = date('Y-m-d');
        $total_lahir = 0;
        $kecamatan  = $this->kecamatan->list();
        foreach ($kecamatan as $kec) {
            $kc = $kec['idc'];
            $as = $kec['idc'];
            $query = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_lahir WHERE kecamatan = '$kc' AND tgl_lahir BETWEEN '$first_month' AND '$now'");
            $result_lahir[]   = $query->getResultArray();
        }
        foreach ($result_lahir as $row) {
            $kecamatanName = key($row[0]); // Get the kecamatan name
            $formattedData[] = [
                'name' => $kecamatanName,
                'data' => intval($row[0][$kecamatanName])
            ];
            $total_lahir += intval($row[0][$kecamatanName]);
        }
        $lahir = json_encode($formattedData);
        // echo($lahir);
        $data = [
			'title'         => 'Dispendukcapil Kota Mojokerto',
            'first_month'   => $first_month,
            'now'           => $now,
            'total_lahir'   => $total_lahir,
            'lahir'         => $lahir
		];
        return view('index', $data);
    }
}
