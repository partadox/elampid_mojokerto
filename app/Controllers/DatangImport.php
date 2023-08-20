<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DatangImport extends BaseController
{
	public function index()
	{
        $data = [
            'title'         => 'Data Datang Import',
        ];
        return view('panel/datang/import/index', $data);
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
            'title'         => 'Data Datang Import',
            'preview_data'  => $dataFile
        ];
        // Display the preview view
        return view('panel/datang/import/preview', $data);
    }

    public function save()
    {
        $this->db->transBegin();

        $requestData = $this->request->getPost('data');
        $data = json_decode($requestData, true);

        $errors = [];

        foreach ($data as $row) {

            $tgl_datang = $row['column_1'];
            $no_datang  = $row['column_2'];
            $kecamatan  = $row['column_3'];
            $kelurahan  = $row['column_4'];
            $alamat     = $row['column_5'];
            $kk         = $row['column_6'];
            $asal       = $row['column_7'];
            $no         = $row['column_8'];
            $nik        = $row['column_9'];
            $nama       = $row['column_10'];
            $shbkel     = $row['column_11'];
            $kelamin    = $row['column_12'];
            
            $store = $this->datang->insert([
                'tgl_datang'    => $tgl_datang,
                'no_datang'     => str_replace(' ', '', strtoupper($no_datang)),
                'kecamatan'     => strtoupper($kecamatan),
                'kelurahan'     => strtoupper($kelurahan),
                'alamat'        => strtoupper($alamat),
                'kk'            => str_replace(' ', '', strtoupper($kk)),
                'asal'          => strtoupper($asal),
                'no'            => strtoupper($no),
                'nik'           => str_replace(' ', '', strtoupper($nik)),
                'nama'          => strtoupper($nama),
                'shbkel'        => strtoupper($shbkel),
                'kelamin'       => str_replace(' ', '', strtoupper($kelamin)),
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
                'redirect' => '/datang-import'
            ];
        } else {
            $this->db->transCommit();
            $response = [
                'success' => true,
                'code'    => '200',
                'message' => 'Data Berhasil Diimport Berjumlah ' . count($data),
                'redirect' => '/datang-import'
            ];
        }

        return $this->response->setJSON($response);
    }
}