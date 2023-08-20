<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PindahImport extends BaseController
{
	public function index()
	{
        $data = [
            'title'         => 'Data Pindah Import',
        ];
        return view('panel/pindah/import/index', $data);
	}

    public function import()
    {
        // Get the uploaded Excel file
        $file = $this->request->getFile('excel_file');
        // Load the spreadsheet from the file
        $spreadsheet = IOFactory::load($file->getTempName());
        // Get the first worksheet
        $worksheet = $spreadsheet->getActiveSheet();
        // Get all data rows from the worksheet
        $dataFile = [];
        $startRow = 2; // Start from row 2
        foreach ($worksheet->getRowIterator($startRow) as $row) {
            $rowData = [];
            foreach ($row->getCellIterator() as $cell) {
                $rowData[] = $cell->getValue();
            }
            $dataFile[] = $rowData;
        }
        // Pass the data to the view
        $data = [
            'title'         => 'Data Pindah Import',
            'preview_data'  => $dataFile
        ];
        // Display the preview view
        return view('panel/pindah/import/preview', $data);
    }

    public function save()
    {
        $this->db->transBegin();

        $requestData = $this->request->getPost('data');
        $data = json_decode($requestData, true);

        $errors = [];

        foreach ($data as $row) {
            $tgl_pindah = $row['column_1'];
            $skpwni     = $row['column_2'];
            $kk         = $row['column_3'];
            $nik        = $row['column_4'];
            $nama       = $row['column_5'];
            $kecamatan  = $row['column_6'];
            $kelurahan  = $row['column_7'];
            $kelamin    = $row['column_8'];
            $alamat     = $row['column_9'];
            $tujuan     = $row['column_10'];

            $store = $this->pindah->insert([
                'skpwni'        => str_replace(' ', '', strtoupper($skpwni)),
                'kecamatan'     => strtoupper($kecamatan),
                'kelurahan'     => strtoupper($kelurahan),
                'kk'            => str_replace(' ', '', strtoupper($kk)),
                'nik'           => str_replace(' ', '', strtoupper($nik)),
                'nama'          => strtoupper($nama),
                'tgl_pindah'    => $tgl_pindah,
                'kelamin'       => str_replace(' ', '', strtoupper($kelamin)),
                'alamat'        => strtoupper($alamat),
                'tujuan'        => strtoupper($tujuan),
                'created'       => date('Y-m-d H:i:s')
            ]);

            if ($store === false) {
                $errors[] = $row['column_0'] . ', ';
            }
        }
        
        if (!empty($errors)) {
            $this->db->transRollback();
            $response = [
                'success' => false,
                'code'    => '400',
                'message' => 'File Gagal Diimport, Error pada Baris: '.$errors,
                'redirect' => '/pindah-import'
            ];
        } else {
            $this->db->transCommit();
            $response = [
                'success' => true,
                'code'    => '200',
                'message' => 'Data Berhasil Diimport Berjumlah ' . count($data),
                'redirect' => '/pindah-import'
            ];
        }
        
        return $this->response->setJSON($response);
    }
}