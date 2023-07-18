<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MatiImport extends BaseController
{
	public function index()
	{
        $data = [
            'title'         => 'Data Kematian Import',
        ];
        return view('panel/mati/import/index', $data);
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
            'title'         => 'Data Kematian Import',
            'preview_data'  => $dataFile
        ];
        // Display the preview view
        return view('panel/mati/import/preview', $data);
    }

    public function save()
    {
        $requestData = $this->request->getPost('data');
        $data = json_decode($requestData, true);
        foreach ($data as $row) {
            $akta       = $row['column_1'];
            $nik        = $row['column_2'];
            $nama       = $row['column_3'];
            $kelamin    = $row['column_4'];
            $tgl_mati   = $row['column_5'];
            $tgl_aju    = $row['column_6'];
            $kecamatan  = $row['column_7'];
            $kelurahan  = $row['column_8'];
            $this->mati->insert([
                'tgl_aju'       => $tgl_aju,
                'kecamatan'     => strtoupper($kecamatan),
                'kelurahan'     => strtoupper($kelurahan),
                'akta'          => str_replace(' ', '', strtoupper($akta)),
                'nik'           => str_replace(' ', '', strtoupper($nik)),
                'nama'          => strtoupper($nama),
                'tgl_mati'      => $tgl_mati,
                'kelamin'       => str_replace(' ', '', strtoupper($kelamin)),
                'created'       => date('Y-m-d H:i:s')
            ]);
        }
        $response = [
            'success' => true,
            'code'    => '200',
            'message' => 'Data Berhasil Diimport Berjumlah '.count($data),
            'redirect' => '/mati-import'
        ];
        return $this->response->setJSON($response);
    }
}