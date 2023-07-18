<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class MatiLaporan extends BaseController
{
    /*--- FRONT ---*/
	public function index()
	{
        $list_tahun     = $this->list_tahun('mati');

        $data = [
            'title'         => 'Laporan Data Kematian',
            'list_tahun'    => $list_tahun,
        ];
        return view('panel/mati/laporan/index', $data);
	}

    /*--- BACK ---*/
    public function export()
    {
        $tahun                  = $this->request->getVar('tahun');
        $extension              = $this->request->getVar('extension');
        $kecamatan              = $this->kecamatan->list();
        $kelurahan              = $this->kelurahan->list_only_kelurahan();
        foreach ($kecamatan as $kec) {
            for ($i=1; $i <= 12 ; $i++) { 
                $kc = $kec['idc'];
                $as = 'C-'.strtolower($kec['idc']).'-'.$i;
                $query   = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_mati WHERE EXTRACT(YEAR FROM tgl_mati) = $tahun AND EXTRACT(MONTH FROM tgl_mati) = $i AND kecamatan = '$kc'");
                $hasilT1[]      = $query->getResultArray();
            }
        }
        foreach ($kelurahan as $kel) {
            for ($i=1; $i <= 12 ; $i++) { 
                $kl = $kel['idl'];
                $as = 'L-'.strtolower($kel['idl']).'-'.$i;
                $query   = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_mati WHERE EXTRACT(YEAR FROM tgl_mati) = $tahun AND EXTRACT(MONTH FROM tgl_mati) = $i AND kelurahan = '$kl' AND kelamin = 'LAKI-LAKI'");
                $hasilT2L[]      = $query->getResultArray();
            }
        }
        foreach ($kelurahan as $kel) {
            for ($i=1; $i <= 12 ; $i++) { 
                $kl = $kel['idl'];
                $as = 'P-'.strtolower($kel['idl']).'-'.$i;
                $query   = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_mati WHERE EXTRACT(YEAR FROM tgl_mati) = $tahun AND EXTRACT(MONTH FROM tgl_mati) = $i AND kelurahan = '$kl' AND kelamin = 'PEREMPUAN'");
                $hasilT2P[]      = $query->getResultArray();
            }
        }
        $t1 = [];
        foreach ($hasilT1 as $item) {
            $key = key($item[0]);
            $value = reset($item[0]);
            $t1[$key] = $value;
        }
        $t2m = array_merge($hasilT2L,$hasilT2P);
        $t2 = [];
        foreach ($t2m as $item) {
            $key = key($item[0]);
            $value = reset($item[0]);
            $t2[$key] = $value;
        }
		
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $textOnly = [
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ]
        ];

        $style_up = [
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'D9D9D9',
                ],
                'endColor' => [
                    'argb' => 'D9D9D9',
                ],
            ],        
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $isi_tengah = [
            'alignment' => [
                'horizontal'    => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'      => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $judulT1 = "LAPORAN DATA KEMATIAN KOTA MOJOKERTO TAHUN " .$tahun;
        $sheet->setCellValue('A1', $judulT1);
        $sheet->getStyle('A1')->applyFromArray($textOnly);
        $sheet->mergeCells('A1:J1');

        //*---Merge Kesamping ---*/
        $sheet->mergeCells('D3:F3');
        $sheet->mergeCells('G3:I3');
        $sheet->mergeCells('J3:L3');
        $sheet->mergeCells('M3:O3');
        $sheet->mergeCells('P3:R3');
        $sheet->mergeCells('S3:U3');
        $sheet->mergeCells('V3:X3');
        $sheet->mergeCells('Y3:AA3');
        $sheet->mergeCells('AB3:AD3');
        $sheet->mergeCells('AE3:AG3');
        $sheet->mergeCells('AH3:AJ3');
        $sheet->mergeCells('AK3:AM3');
        $sheet->mergeCells('AN3:AP3');

        $sheet->mergeCells('A11:C11');
        $sheet->mergeCells('A18:C18');
        $sheet->mergeCells('A25:C25');
        $sheet->mergeCells('A26:C26');
        //*--- Merge Atas Bawah ---*/
        $sheet->mergeCells('A3:A4');
        $sheet->mergeCells('B3:B4');
        $sheet->mergeCells('C3:C4');

        $sheet->mergeCells('B5:B10');
        $sheet->mergeCells('B12:B17');
        $sheet->mergeCells('B19:B24');
       
        //*--- Border Tabel 1 ---*/
        $sheet->getStyle('A3:AP4')->applyFromArray($style_up);
        $sheet->getStyle('A5:AP26')->applyFromArray($isi_tengah);

        $sheet->getStyle('A11:AP11')->applyFromArray($style_up);
        $sheet->getStyle('A18:AP18')->applyFromArray($style_up);
        $sheet->getStyle('A25:AP25')->applyFromArray($style_up);
        $sheet->getStyle('A26:AP26')->applyFromArray($style_up);

        //*--- Kolom Size---*/
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

        $spreadsheet->setActiveSheetIndex(0)
            //*--- Kolom Atas ---*/
            ->setCellValue('A3', 'NO')
            ->setCellValue('B3', 'KECAMATAN')
            ->setCellValue('C3', 'KELURAHAN')

            ->setCellValue('D3', 'JAN')
            ->setCellValue('G3', 'FEB')
            ->setCellValue('J3', 'MARET')
            ->setCellValue('M3', 'APRIL')
            ->setCellValue('P3', 'MEI')
            ->setCellValue('S3', 'JUNI')
            ->setCellValue('V3', 'JULI')
            ->setCellValue('Y3', 'AGUSTUS')
            ->setCellValue('AB3', 'SEPT')
            ->setCellValue('AE3', 'OKT')
            ->setCellValue('AH3', 'NOV')
            ->setCellValue('AK3', 'DES')
            ->setCellValue('AN3', 'TOTAL')

            //*--- Loop L / P---*/
            ->setCellValue('D4', 'L')
            ->setCellValue('E4', 'P')
            ->setCellValue('F4', 'JML')
            ->setCellValue('G4', 'L')
            ->setCellValue('H4', 'P')
            ->setCellValue('I4', 'JML')
            ->setCellValue('J4', 'L')
            ->setCellValue('K4', 'P')
            ->setCellValue('L4', 'JML')
            ->setCellValue('M4', 'L')
            ->setCellValue('N4', 'P')
            ->setCellValue('O4', 'JML')
            ->setCellValue('P4', 'L')
            ->setCellValue('Q4', 'P')
            ->setCellValue('R4', 'JML')
            ->setCellValue('S4', 'L')
            ->setCellValue('T4', 'P')
            ->setCellValue('U4', 'JML')
            ->setCellValue('V4', 'L')
            ->setCellValue('W4', 'P')
            ->setCellValue('X4', 'JML')
            ->setCellValue('Y4', 'L')
            ->setCellValue('Z4', 'P')
            ->setCellValue('AA4', 'JML')
            ->setCellValue('AB4', 'L')
            ->setCellValue('AC4', 'P')
            ->setCellValue('AD4', 'JML')
            ->setCellValue('AE4', 'L')
            ->setCellValue('AF4', 'P')
            ->setCellValue('AG4', 'JML')
            ->setCellValue('AH4', 'L')
            ->setCellValue('AI4', 'P')
            ->setCellValue('AJ4', 'JML')
            ->setCellValue('AK4', 'L')
            ->setCellValue('AL4', 'P')
            ->setCellValue('AM4', 'JML')
            ->setCellValue('AN4', 'L')
            ->setCellValue('AO4', 'P')
            ->setCellValue('AP4', 'JML')

            //*--- NO---*/
            ->setCellValue('A5', '1')
            ->setCellValue('A6', '2')
            ->setCellValue('A7', '3')
            ->setCellValue('A8', '4')
            ->setCellValue('A9', '5')
            ->setCellValue('A10', '6')
            ->setCellValue('A12', '7')
            ->setCellValue('A13', '8')
            ->setCellValue('A14', '9')
            ->setCellValue('A15', '10')
            ->setCellValue('A16', '11')
            ->setCellValue('A17', '12')
            ->setCellValue('A19', '13')
            ->setCellValue('A20', '14')
            ->setCellValue('A21', '15')
            ->setCellValue('A22', '16')
            ->setCellValue('A23', '17')
            ->setCellValue('A24', '18')

            //*--- KECAMATAN---*/
            ->setCellValue('B5', 'PRAJURITKULON')
            ->setCellValue('A11', 'KEC. PRAJURITKULON')
            ->setCellValue('B12', 'MAGERSARI')
            ->setCellValue('A18', 'KEC. MAGERSARI')
            ->setCellValue('B19', 'KRANGGAN')
            ->setCellValue('A25', 'KEC. KRANGGAN')
            ->setCellValue('A26', 'KOTA MOJOKERTO')

            //Prajurtikulon
            ->setCellValue('C5', 'MENTIKAN')
            ->setCellValue('C6', 'KAUMAN')
            ->setCellValue('C7', 'PULOREJO')
            ->setCellValue('C8', 'PRAJURITKULON')
            ->setCellValue('C9', 'SURODINAWAN')
            ->setCellValue('C10', 'BLOOTO')
            //Magersari
            ->setCellValue('C12', 'GUNUNG GEDANGAN')
            ->setCellValue('C13', 'MAGERSARI')
            ->setCellValue('C14', 'GEDONGAN')
            ->setCellValue('C15', 'BALONGSARI')
            ->setCellValue('C16', 'KEDUNDUNG')
            ->setCellValue('C17', 'WATES')
            //Kranggan
            ->setCellValue('C19', 'KRANGGAN')
            ->setCellValue('C20', 'MIJI')
            ->setCellValue('C21', 'MERI')
            ->setCellValue('C22', 'JAGALAN')
            ->setCellValue('C23', 'SENTANAN')
            ->setCellValue('C24', 'PURWOTENGAH')

            ->setCellValue('D5', $t2['L-mentikan-1'])
            ->setCellValue('E5', $t2['P-mentikan-1'])
            ->setCellValue('G5', $t2['L-mentikan-2'])
            ->setCellValue('H5', $t2['P-mentikan-2'])
            ->setCellValue('J5', $t2['L-mentikan-3'])
            ->setCellValue('K5', $t2['P-mentikan-3'])
            ->setCellValue('M5', $t2['L-mentikan-4'])
            ->setCellValue('N5', $t2['P-mentikan-4'])
            ->setCellValue('P5', $t2['L-mentikan-5'])
            ->setCellValue('Q5', $t2['P-mentikan-5'])
            ->setCellValue('S5', $t2['L-mentikan-6'])
            ->setCellValue('T5', $t2['P-mentikan-6'])
            ->setCellValue('V5', $t2['L-mentikan-7'])
            ->setCellValue('W5', $t2['P-mentikan-7'])
            ->setCellValue('Y5', $t2['L-mentikan-8'])
            ->setCellValue('Z5', $t2['P-mentikan-8'])
            ->setCellValue('AB5', $t2['L-mentikan-9'])
            ->setCellValue('AC5', $t2['P-mentikan-9'])
            ->setCellValue('AE5', $t2['L-mentikan-10'])
            ->setCellValue('AF5', $t2['P-mentikan-10'])
            ->setCellValue('AH5', $t2['L-mentikan-11'])
            ->setCellValue('AI5', $t2['P-mentikan-11'])
            ->setCellValue('AK5', $t2['L-mentikan-12'])
            ->setCellValue('AL5', $t2['P-mentikan-12'])

            ->setCellValue('D6', $t2['L-kauman-1'])
            ->setCellValue('E6', $t2['P-kauman-1'])
            ->setCellValue('G6', $t2['L-kauman-2'])
            ->setCellValue('H6', $t2['P-kauman-2'])
            ->setCellValue('J6', $t2['L-kauman-3'])
            ->setCellValue('K6', $t2['P-kauman-3'])
            ->setCellValue('M6', $t2['L-kauman-4'])
            ->setCellValue('N6', $t2['P-kauman-4'])
            ->setCellValue('P6', $t2['L-kauman-5'])
            ->setCellValue('Q6', $t2['P-kauman-5'])
            ->setCellValue('S6', $t2['L-kauman-6'])
            ->setCellValue('T6', $t2['P-kauman-6'])
            ->setCellValue('V6', $t2['L-kauman-7'])
            ->setCellValue('W6', $t2['P-kauman-7'])
            ->setCellValue('Y6', $t2['L-kauman-8'])
            ->setCellValue('Z6', $t2['P-kauman-8'])
            ->setCellValue('AB6', $t2['L-kauman-9'])
            ->setCellValue('AC6', $t2['P-kauman-9'])
            ->setCellValue('AE6', $t2['L-kauman-10'])
            ->setCellValue('AF6', $t2['P-kauman-10'])
            ->setCellValue('AH6', $t2['L-kauman-11'])
            ->setCellValue('AI6', $t2['P-kauman-11'])
            ->setCellValue('AK6', $t2['L-kauman-12'])
            ->setCellValue('AL6', $t2['P-kauman-12'])

            ->setCellValue('D7', $t2['L-pulorejo-1'])
            ->setCellValue('E7', $t2['P-pulorejo-1'])
            ->setCellValue('G7', $t2['L-pulorejo-2'])
            ->setCellValue('H7', $t2['P-pulorejo-2'])
            ->setCellValue('J7', $t2['L-pulorejo-3'])
            ->setCellValue('K7', $t2['P-pulorejo-3'])
            ->setCellValue('M7', $t2['L-pulorejo-4'])
            ->setCellValue('N7', $t2['P-pulorejo-4'])
            ->setCellValue('P7', $t2['L-pulorejo-5'])
            ->setCellValue('Q7', $t2['P-pulorejo-5'])
            ->setCellValue('S7', $t2['L-pulorejo-6'])
            ->setCellValue('T7', $t2['P-pulorejo-6'])
            ->setCellValue('V7', $t2['L-pulorejo-7'])
            ->setCellValue('W7', $t2['P-pulorejo-7'])
            ->setCellValue('Y7', $t2['L-pulorejo-8'])
            ->setCellValue('Z7', $t2['P-pulorejo-8'])
            ->setCellValue('AB7', $t2['L-pulorejo-9'])
            ->setCellValue('AC7', $t2['P-pulorejo-9'])
            ->setCellValue('AE7', $t2['L-pulorejo-10'])
            ->setCellValue('AF7', $t2['P-pulorejo-10'])
            ->setCellValue('AH7', $t2['L-pulorejo-11'])
            ->setCellValue('AI7', $t2['P-pulorejo-11'])
            ->setCellValue('AK7', $t2['L-pulorejo-12'])
            ->setCellValue('AL7', $t2['P-pulorejo-12'])

            ->setCellValue('D8', $t2['L-prajuritkulon-1'])
            ->setCellValue('E8', $t2['P-prajuritkulon-1'])
            ->setCellValue('G8', $t2['L-prajuritkulon-2'])
            ->setCellValue('H8', $t2['P-prajuritkulon-2'])
            ->setCellValue('J8', $t2['L-prajuritkulon-3'])
            ->setCellValue('K8', $t2['P-prajuritkulon-3'])
            ->setCellValue('M8', $t2['L-prajuritkulon-4'])
            ->setCellValue('N8', $t2['P-prajuritkulon-4'])
            ->setCellValue('P8', $t2['L-prajuritkulon-5'])
            ->setCellValue('Q8', $t2['P-prajuritkulon-5'])
            ->setCellValue('S8', $t2['L-prajuritkulon-6'])
            ->setCellValue('T8', $t2['P-prajuritkulon-6'])
            ->setCellValue('V8', $t2['L-prajuritkulon-7'])
            ->setCellValue('W8', $t2['P-prajuritkulon-7'])
            ->setCellValue('Y8', $t2['L-prajuritkulon-8'])
            ->setCellValue('Z8', $t2['P-prajuritkulon-8'])
            ->setCellValue('AB8', $t2['L-prajuritkulon-9'])
            ->setCellValue('AC8', $t2['P-prajuritkulon-9'])
            ->setCellValue('AE8', $t2['L-prajuritkulon-10'])
            ->setCellValue('AF8', $t2['P-prajuritkulon-10'])
            ->setCellValue('AH8', $t2['L-prajuritkulon-11'])
            ->setCellValue('AI8', $t2['P-prajuritkulon-11'])
            ->setCellValue('AK8', $t2['L-prajuritkulon-12'])
            ->setCellValue('AL8', $t2['P-prajuritkulon-12'])

            ->setCellValue('D9', $t2['L-surodinawan-1'])
            ->setCellValue('E9', $t2['P-surodinawan-1'])
            ->setCellValue('G9', $t2['L-surodinawan-2'])
            ->setCellValue('H9', $t2['P-surodinawan-2'])
            ->setCellValue('J9', $t2['L-surodinawan-3'])
            ->setCellValue('K9', $t2['P-surodinawan-3'])
            ->setCellValue('M9', $t2['L-surodinawan-4'])
            ->setCellValue('N9', $t2['P-surodinawan-4'])
            ->setCellValue('P9', $t2['L-surodinawan-5'])
            ->setCellValue('Q9', $t2['P-surodinawan-5'])
            ->setCellValue('S9', $t2['L-surodinawan-6'])
            ->setCellValue('T9', $t2['P-surodinawan-6'])
            ->setCellValue('V9', $t2['L-surodinawan-7'])
            ->setCellValue('W9', $t2['P-surodinawan-7'])
            ->setCellValue('Y9', $t2['L-surodinawan-8'])
            ->setCellValue('Z9', $t2['P-surodinawan-8'])
            ->setCellValue('AB9', $t2['L-surodinawan-9'])
            ->setCellValue('AC9', $t2['P-surodinawan-9'])
            ->setCellValue('AE9', $t2['L-surodinawan-10'])
            ->setCellValue('AF9', $t2['P-surodinawan-10'])
            ->setCellValue('AH9', $t2['L-surodinawan-11'])
            ->setCellValue('AI9', $t2['P-surodinawan-11'])
            ->setCellValue('AK9', $t2['L-surodinawan-12'])
            ->setCellValue('AL9', $t2['P-surodinawan-12'])

            ->setCellValue('D10', $t2['L-blooto-1'])
            ->setCellValue('E10', $t2['P-blooto-1'])
            ->setCellValue('G10', $t2['L-blooto-2'])
            ->setCellValue('H10', $t2['P-blooto-2'])
            ->setCellValue('J10', $t2['L-blooto-3'])
            ->setCellValue('K10', $t2['P-blooto-3'])
            ->setCellValue('M10', $t2['L-blooto-4'])
            ->setCellValue('N10', $t2['P-blooto-4'])
            ->setCellValue('P10', $t2['L-blooto-5'])
            ->setCellValue('Q10', $t2['P-blooto-5'])
            ->setCellValue('S10', $t2['L-blooto-6'])
            ->setCellValue('T10', $t2['P-blooto-6'])
            ->setCellValue('V10', $t2['L-blooto-7'])
            ->setCellValue('W10', $t2['P-blooto-7'])
            ->setCellValue('Y10', $t2['L-blooto-8'])
            ->setCellValue('Z10', $t2['P-blooto-8'])
            ->setCellValue('AB10', $t2['L-blooto-9'])
            ->setCellValue('AC10', $t2['P-blooto-9'])
            ->setCellValue('AE10', $t2['L-blooto-10'])
            ->setCellValue('AF10', $t2['P-blooto-10'])
            ->setCellValue('AH10', $t2['L-blooto-11'])
            ->setCellValue('AI10', $t2['P-blooto-11'])
            ->setCellValue('AK10', $t2['L-blooto-12'])
            ->setCellValue('AL10', $t2['P-blooto-12'])

            ->setCellValue('D12', $t2['L-gunung gedangan-1'])
            ->setCellValue('E12', $t2['P-gunung gedangan-1'])
            ->setCellValue('G12', $t2['L-gunung gedangan-2'])
            ->setCellValue('H12', $t2['P-gunung gedangan-2'])
            ->setCellValue('J12', $t2['L-gunung gedangan-3'])
            ->setCellValue('K12', $t2['P-gunung gedangan-3'])
            ->setCellValue('M12', $t2['L-gunung gedangan-4'])
            ->setCellValue('N12', $t2['P-gunung gedangan-4'])
            ->setCellValue('P12', $t2['L-gunung gedangan-5'])
            ->setCellValue('Q12', $t2['P-gunung gedangan-5'])
            ->setCellValue('S12', $t2['L-gunung gedangan-6'])
            ->setCellValue('T12', $t2['P-gunung gedangan-6'])
            ->setCellValue('V12', $t2['L-gunung gedangan-7'])
            ->setCellValue('W12', $t2['P-gunung gedangan-7'])
            ->setCellValue('Y12', $t2['L-gunung gedangan-8'])
            ->setCellValue('Z12', $t2['P-gunung gedangan-8'])
            ->setCellValue('AB12', $t2['L-gunung gedangan-9'])
            ->setCellValue('AC12', $t2['P-gunung gedangan-9'])
            ->setCellValue('AE12', $t2['L-gunung gedangan-10'])
            ->setCellValue('AF12', $t2['P-gunung gedangan-10'])
            ->setCellValue('AH12', $t2['L-gunung gedangan-11'])
            ->setCellValue('AI12', $t2['P-gunung gedangan-11'])
            ->setCellValue('AK12', $t2['L-gunung gedangan-12'])
            ->setCellValue('AL12', $t2['P-gunung gedangan-12'])

            ->setCellValue('D13', $t2['L-magersari-1'])
            ->setCellValue('E13', $t2['P-magersari-1'])
            ->setCellValue('G13', $t2['L-magersari-2'])
            ->setCellValue('H13', $t2['P-magersari-2'])
            ->setCellValue('J13', $t2['L-magersari-3'])
            ->setCellValue('K13', $t2['P-magersari-3'])
            ->setCellValue('M13', $t2['L-magersari-4'])
            ->setCellValue('N13', $t2['P-magersari-4'])
            ->setCellValue('P13', $t2['L-magersari-5'])
            ->setCellValue('Q13', $t2['P-magersari-5'])
            ->setCellValue('S13', $t2['L-magersari-6'])
            ->setCellValue('T13', $t2['P-magersari-6'])
            ->setCellValue('V13', $t2['L-magersari-7'])
            ->setCellValue('W13', $t2['P-magersari-7'])
            ->setCellValue('Y13', $t2['L-magersari-8'])
            ->setCellValue('Z13', $t2['P-magersari-8'])
            ->setCellValue('AB13', $t2['L-magersari-9'])
            ->setCellValue('AC13', $t2['P-magersari-9'])
            ->setCellValue('AE13', $t2['L-magersari-10'])
            ->setCellValue('AF13', $t2['P-magersari-10'])
            ->setCellValue('AH13', $t2['L-magersari-11'])
            ->setCellValue('AI13', $t2['P-magersari-11'])
            ->setCellValue('AK13', $t2['L-magersari-12'])
            ->setCellValue('AL13', $t2['P-magersari-12'])

            ->setCellValue('D14', $t2['L-gedongan-1'])
            ->setCellValue('E14', $t2['P-gedongan-1'])
            ->setCellValue('G14', $t2['L-gedongan-2'])
            ->setCellValue('H14', $t2['P-gedongan-2'])
            ->setCellValue('J14', $t2['L-gedongan-3'])
            ->setCellValue('K14', $t2['P-gedongan-3'])
            ->setCellValue('M14', $t2['L-gedongan-4'])
            ->setCellValue('N14', $t2['P-gedongan-4'])
            ->setCellValue('P14', $t2['L-gedongan-5'])
            ->setCellValue('Q14', $t2['P-gedongan-5'])
            ->setCellValue('S14', $t2['L-gedongan-6'])
            ->setCellValue('T14', $t2['P-gedongan-6'])
            ->setCellValue('V14', $t2['L-gedongan-7'])
            ->setCellValue('W14', $t2['P-gedongan-7'])
            ->setCellValue('Y14', $t2['L-gedongan-8'])
            ->setCellValue('Z14', $t2['P-gedongan-8'])
            ->setCellValue('AB14', $t2['L-gedongan-9'])
            ->setCellValue('AC14', $t2['P-gedongan-9'])
            ->setCellValue('AE14', $t2['L-gedongan-10'])
            ->setCellValue('AF14', $t2['P-gedongan-10'])
            ->setCellValue('AH14', $t2['L-gedongan-11'])
            ->setCellValue('AI14', $t2['P-gedongan-11'])
            ->setCellValue('AK14', $t2['L-gedongan-12'])
            ->setCellValue('AL14', $t2['P-gedongan-12'])

            ->setCellValue('D15', $t2['L-balongsari-1'])
            ->setCellValue('E15', $t2['P-balongsari-1'])
            ->setCellValue('G15', $t2['L-balongsari-2'])
            ->setCellValue('H15', $t2['P-balongsari-2'])
            ->setCellValue('J15', $t2['L-balongsari-3'])
            ->setCellValue('K15', $t2['P-balongsari-3'])
            ->setCellValue('M15', $t2['L-balongsari-4'])
            ->setCellValue('N15', $t2['P-balongsari-4'])
            ->setCellValue('P15', $t2['L-balongsari-5'])
            ->setCellValue('Q15', $t2['P-balongsari-5'])
            ->setCellValue('S15', $t2['L-balongsari-6'])
            ->setCellValue('T15', $t2['P-balongsari-6'])
            ->setCellValue('V15', $t2['L-balongsari-7'])
            ->setCellValue('W15', $t2['P-balongsari-7'])
            ->setCellValue('Y15', $t2['L-balongsari-8'])
            ->setCellValue('Z15', $t2['P-balongsari-8'])
            ->setCellValue('AB15', $t2['L-balongsari-9'])
            ->setCellValue('AC15', $t2['P-balongsari-9'])
            ->setCellValue('AE15', $t2['L-balongsari-10'])
            ->setCellValue('AF15', $t2['P-balongsari-10'])
            ->setCellValue('AH15', $t2['L-balongsari-11'])
            ->setCellValue('AI15', $t2['P-balongsari-11'])
            ->setCellValue('AK15', $t2['L-balongsari-12'])
            ->setCellValue('AL15', $t2['P-balongsari-12'])

            ->setCellValue('D16', $t2['L-kedundung-1'])
            ->setCellValue('E16', $t2['P-kedundung-1'])
            ->setCellValue('G16', $t2['L-kedundung-2'])
            ->setCellValue('H16', $t2['P-kedundung-2'])
            ->setCellValue('J16', $t2['L-kedundung-3'])
            ->setCellValue('K16', $t2['P-kedundung-3'])
            ->setCellValue('M16', $t2['L-kedundung-4'])
            ->setCellValue('N16', $t2['P-kedundung-4'])
            ->setCellValue('P16', $t2['L-kedundung-5'])
            ->setCellValue('Q16', $t2['P-kedundung-5'])
            ->setCellValue('S16', $t2['L-kedundung-6'])
            ->setCellValue('T16', $t2['P-kedundung-6'])
            ->setCellValue('V16', $t2['L-kedundung-7'])
            ->setCellValue('W16', $t2['P-kedundung-7'])
            ->setCellValue('Y16', $t2['L-kedundung-8'])
            ->setCellValue('Z16', $t2['P-kedundung-8'])
            ->setCellValue('AB16', $t2['L-kedundung-9'])
            ->setCellValue('AC16', $t2['P-kedundung-9'])
            ->setCellValue('AE16', $t2['L-kedundung-10'])
            ->setCellValue('AF16', $t2['P-kedundung-10'])
            ->setCellValue('AH16', $t2['L-kedundung-11'])
            ->setCellValue('AI16', $t2['P-kedundung-11'])
            ->setCellValue('AK16', $t2['L-kedundung-12'])
            ->setCellValue('AL16', $t2['P-kedundung-12'])

            ->setCellValue('D17', $t2['L-wates-1'])
            ->setCellValue('E17', $t2['P-wates-1'])
            ->setCellValue('G17', $t2['L-wates-2'])
            ->setCellValue('H17', $t2['P-wates-2'])
            ->setCellValue('J17', $t2['L-wates-3'])
            ->setCellValue('K17', $t2['P-wates-3'])
            ->setCellValue('M17', $t2['L-wates-4'])
            ->setCellValue('N17', $t2['P-wates-4'])
            ->setCellValue('P17', $t2['L-wates-5'])
            ->setCellValue('Q17', $t2['P-wates-5'])
            ->setCellValue('S17', $t2['L-wates-6'])
            ->setCellValue('T17', $t2['P-wates-6'])
            ->setCellValue('V17', $t2['L-wates-7'])
            ->setCellValue('W17', $t2['P-wates-7'])
            ->setCellValue('Y17', $t2['L-wates-8'])
            ->setCellValue('Z17', $t2['P-wates-8'])
            ->setCellValue('AB17', $t2['L-wates-9'])
            ->setCellValue('AC17', $t2['P-wates-9'])
            ->setCellValue('AE17', $t2['L-wates-10'])
            ->setCellValue('AF17', $t2['P-wates-10'])
            ->setCellValue('AH17', $t2['L-wates-11'])
            ->setCellValue('AI17', $t2['P-wates-11'])
            ->setCellValue('AK17', $t2['L-wates-12'])
            ->setCellValue('AL17', $t2['P-wates-12'])

            ->setCellValue('D19', $t2['L-kranggan-1'])
            ->setCellValue('E19', $t2['P-kranggan-1'])
            ->setCellValue('G19', $t2['L-kranggan-2'])
            ->setCellValue('H19', $t2['P-kranggan-2'])
            ->setCellValue('J19', $t2['L-kranggan-3'])
            ->setCellValue('K19', $t2['P-kranggan-3'])
            ->setCellValue('M19', $t2['L-kranggan-4'])
            ->setCellValue('N19', $t2['P-kranggan-4'])
            ->setCellValue('P19', $t2['L-kranggan-5'])
            ->setCellValue('Q19', $t2['P-kranggan-5'])
            ->setCellValue('S19', $t2['L-kranggan-6'])
            ->setCellValue('T19', $t2['P-kranggan-6'])
            ->setCellValue('V19', $t2['L-kranggan-7'])
            ->setCellValue('W19', $t2['P-kranggan-7'])
            ->setCellValue('Y19', $t2['L-kranggan-8'])
            ->setCellValue('Z19', $t2['P-kranggan-8'])
            ->setCellValue('AB19', $t2['L-kranggan-9'])
            ->setCellValue('AC19', $t2['P-kranggan-9'])
            ->setCellValue('AE19', $t2['L-kranggan-10'])
            ->setCellValue('AF19', $t2['P-kranggan-10'])
            ->setCellValue('AH19', $t2['L-kranggan-11'])
            ->setCellValue('AI19', $t2['P-kranggan-11'])
            ->setCellValue('AK19', $t2['L-kranggan-12'])
            ->setCellValue('AL19', $t2['P-kranggan-12'])

            ->setCellValue('D20', $t2['L-miji-1'])
            ->setCellValue('E20', $t2['P-miji-1'])
            ->setCellValue('G20', $t2['L-miji-2'])
            ->setCellValue('H20', $t2['P-miji-2'])
            ->setCellValue('J20', $t2['L-miji-3'])
            ->setCellValue('K20', $t2['P-miji-3'])
            ->setCellValue('M20', $t2['L-miji-4'])
            ->setCellValue('N20', $t2['P-miji-4'])
            ->setCellValue('P20', $t2['L-miji-5'])
            ->setCellValue('Q20', $t2['P-miji-5'])
            ->setCellValue('S20', $t2['L-miji-6'])
            ->setCellValue('T20', $t2['P-miji-6'])
            ->setCellValue('V20', $t2['L-miji-7'])
            ->setCellValue('W20', $t2['P-miji-7'])
            ->setCellValue('Y20', $t2['L-miji-8'])
            ->setCellValue('Z20', $t2['P-miji-8'])
            ->setCellValue('AB20', $t2['L-miji-9'])
            ->setCellValue('AC20', $t2['P-miji-9'])
            ->setCellValue('AE20', $t2['L-miji-10'])
            ->setCellValue('AF20', $t2['P-miji-10'])
            ->setCellValue('AH20', $t2['L-miji-11'])
            ->setCellValue('AI20', $t2['P-miji-11'])
            ->setCellValue('AK20', $t2['L-miji-12'])
            ->setCellValue('AL20', $t2['P-miji-12'])

            ->setCellValue('D21', $t2['L-meri-1'])
            ->setCellValue('E21', $t2['P-meri-1'])
            ->setCellValue('G21', $t2['L-meri-2'])
            ->setCellValue('H21', $t2['P-meri-2'])
            ->setCellValue('J21', $t2['L-meri-3'])
            ->setCellValue('K21', $t2['P-meri-3'])
            ->setCellValue('M21', $t2['L-meri-4'])
            ->setCellValue('N21', $t2['P-meri-4'])
            ->setCellValue('P21', $t2['L-meri-5'])
            ->setCellValue('Q21', $t2['P-meri-5'])
            ->setCellValue('S21', $t2['L-meri-6'])
            ->setCellValue('T21', $t2['P-meri-6'])
            ->setCellValue('V21', $t2['L-meri-7'])
            ->setCellValue('W21', $t2['P-meri-7'])
            ->setCellValue('Y21', $t2['L-meri-8'])
            ->setCellValue('Z21', $t2['P-meri-8'])
            ->setCellValue('AB21', $t2['L-meri-9'])
            ->setCellValue('AC21', $t2['P-meri-9'])
            ->setCellValue('AE21', $t2['L-meri-10'])
            ->setCellValue('AF21', $t2['P-meri-10'])
            ->setCellValue('AH21', $t2['L-meri-11'])
            ->setCellValue('AI21', $t2['P-meri-11'])
            ->setCellValue('AK21', $t2['L-meri-12'])
            ->setCellValue('AL21', $t2['P-meri-12'])

            ->setCellValue('D22', $t2['L-jagalan-1'])
            ->setCellValue('E22', $t2['P-jagalan-1'])
            ->setCellValue('G22', $t2['L-jagalan-2'])
            ->setCellValue('H22', $t2['P-jagalan-2'])
            ->setCellValue('J22', $t2['L-jagalan-3'])
            ->setCellValue('K22', $t2['P-jagalan-3'])
            ->setCellValue('M22', $t2['L-jagalan-4'])
            ->setCellValue('N22', $t2['P-jagalan-4'])
            ->setCellValue('P22', $t2['L-jagalan-5'])
            ->setCellValue('Q22', $t2['P-jagalan-5'])
            ->setCellValue('S22', $t2['L-jagalan-6'])
            ->setCellValue('T22', $t2['P-jagalan-6'])
            ->setCellValue('V22', $t2['L-jagalan-7'])
            ->setCellValue('W22', $t2['P-jagalan-7'])
            ->setCellValue('Y22', $t2['L-jagalan-8'])
            ->setCellValue('Z22', $t2['P-jagalan-8'])
            ->setCellValue('AB22', $t2['L-jagalan-9'])
            ->setCellValue('AC22', $t2['P-jagalan-9'])
            ->setCellValue('AE22', $t2['L-jagalan-10'])
            ->setCellValue('AF22', $t2['P-jagalan-10'])
            ->setCellValue('AH22', $t2['L-jagalan-11'])
            ->setCellValue('AI22', $t2['P-jagalan-11'])
            ->setCellValue('AK22', $t2['L-jagalan-12'])
            ->setCellValue('AL22', $t2['P-jagalan-12'])

            ->setCellValue('D23', $t2['L-sentanan-1'])
            ->setCellValue('E23', $t2['P-sentanan-1'])
            ->setCellValue('G23', $t2['L-sentanan-2'])
            ->setCellValue('H23', $t2['P-sentanan-2'])
            ->setCellValue('J23', $t2['L-sentanan-3'])
            ->setCellValue('K23', $t2['P-sentanan-3'])
            ->setCellValue('M23', $t2['L-sentanan-4'])
            ->setCellValue('N23', $t2['P-sentanan-4'])
            ->setCellValue('P23', $t2['L-sentanan-5'])
            ->setCellValue('Q23', $t2['P-sentanan-5'])
            ->setCellValue('S23', $t2['L-sentanan-6'])
            ->setCellValue('T23', $t2['P-sentanan-6'])
            ->setCellValue('V23', $t2['L-sentanan-7'])
            ->setCellValue('W23', $t2['P-sentanan-7'])
            ->setCellValue('Y23', $t2['L-sentanan-8'])
            ->setCellValue('Z23', $t2['P-sentanan-8'])
            ->setCellValue('AB23', $t2['L-sentanan-9'])
            ->setCellValue('AC23', $t2['P-sentanan-9'])
            ->setCellValue('AE23', $t2['L-sentanan-10'])
            ->setCellValue('AF23', $t2['P-sentanan-10'])
            ->setCellValue('AH23', $t2['L-sentanan-11'])
            ->setCellValue('AI23', $t2['P-sentanan-11'])
            ->setCellValue('AK23', $t2['L-sentanan-12'])
            ->setCellValue('AL23', $t2['P-sentanan-12'])

            ->setCellValue('D24', $t2['L-purwotengah-1'])
            ->setCellValue('E24', $t2['P-purwotengah-1'])
            ->setCellValue('G24', $t2['L-purwotengah-2'])
            ->setCellValue('H24', $t2['P-purwotengah-2'])
            ->setCellValue('J24', $t2['L-purwotengah-3'])
            ->setCellValue('K24', $t2['P-purwotengah-3'])
            ->setCellValue('M24', $t2['L-purwotengah-4'])
            ->setCellValue('N24', $t2['P-purwotengah-4'])
            ->setCellValue('P24', $t2['L-purwotengah-5'])
            ->setCellValue('Q24', $t2['P-purwotengah-5'])
            ->setCellValue('S24', $t2['L-purwotengah-6'])
            ->setCellValue('T24', $t2['P-purwotengah-6'])
            ->setCellValue('V24', $t2['L-purwotengah-7'])
            ->setCellValue('W24', $t2['P-purwotengah-7'])
            ->setCellValue('Y24', $t2['L-purwotengah-8'])
            ->setCellValue('Z24', $t2['P-purwotengah-8'])
            ->setCellValue('AB24', $t2['L-purwotengah-9'])
            ->setCellValue('AC24', $t2['P-purwotengah-9'])
            ->setCellValue('AE24', $t2['L-purwotengah-10'])
            ->setCellValue('AF24', $t2['P-purwotengah-10'])
            ->setCellValue('AH24', $t2['L-purwotengah-11'])
            ->setCellValue('AI24', $t2['P-purwotengah-11'])
            ->setCellValue('AK24', $t2['L-purwotengah-12'])
            ->setCellValue('AL24', $t2['P-purwotengah-12'])

            //JAN
            ->setCellValue('F5', '=SUM(D5:E5)')
            ->setCellValue('F6', '=SUM(D6:E6)')
            ->setCellValue('F7', '=SUM(D7:E7)')
            ->setCellValue('F8', '=SUM(D8:E8)')
            ->setCellValue('F9', '=SUM(D9:E9)')
            ->setCellValue('F10', '=SUM(D10:E10)')
            ->setCellValue('F11', '=SUM(F5:F10)')
            ->setCellValue('D11', '=SUM(D5:D10)')
            ->setCellValue('E11', '=SUM(E5:E10)')

            ->setCellValue('F12', '=SUM(D12:E12)')
            ->setCellValue('F13', '=SUM(D13:E13)')
            ->setCellValue('F14', '=SUM(D14:E14)')
            ->setCellValue('F15', '=SUM(D15:E15)')
            ->setCellValue('F16', '=SUM(D16:E16)')
            ->setCellValue('F17', '=SUM(D17:E17)')
            ->setCellValue('F18', '=SUM(F12:F17)')
            ->setCellValue('D18', '=SUM(D12:D17)')
            ->setCellValue('E18', '=SUM(E12:E17)')

            ->setCellValue('F19', '=SUM(D19:E19)')
            ->setCellValue('F20', '=SUM(D20:E20)')
            ->setCellValue('F21', '=SUM(D21:E21)')
            ->setCellValue('F22', '=SUM(D22:E22)')
            ->setCellValue('F23', '=SUM(D23:E23)')
            ->setCellValue('F24', '=SUM(D24:E24)')
            ->setCellValue('F25', '=SUM(F19:F24)')
            ->setCellValue('D25', '=SUM(D19:D24)')
            ->setCellValue('E25', '=SUM(E19:E24)')

            ->setCellValue('D26', '=(D11+D18+D25)')
            ->setCellValue('E26', '=(E11+E18+E25)')
            ->setCellValue('F26', '=(F11+F18+F25)')

            //FEB
            ->setCellValue('I5', '=SUM(G5:H5)')
            ->setCellValue('I6', '=SUM(G6:H6)')
            ->setCellValue('I7', '=SUM(G7:H7)')
            ->setCellValue('I8', '=SUM(G8:H8)')
            ->setCellValue('I9', '=SUM(G9:H9)')
            ->setCellValue('I10', '=SUM(G10:H10)')
            ->setCellValue('I11', '=SUM(I5:I10)')
            ->setCellValue('G11', '=SUM(G5:G10)')
            ->setCellValue('H11', '=SUM(H5:H10)')

            ->setCellValue('I12', '=SUM(G12:H12)')
            ->setCellValue('I13', '=SUM(G13:H13)')
            ->setCellValue('I14', '=SUM(G14:H14)')
            ->setCellValue('I15', '=SUM(G15:H15)')
            ->setCellValue('I16', '=SUM(G16:H16)')
            ->setCellValue('I17', '=SUM(G17:H17)')
            ->setCellValue('I18', '=SUM(I12:I17)')
            ->setCellValue('G18', '=SUM(G12:G17)')
            ->setCellValue('H18', '=SUM(H12:H17)')

            ->setCellValue('I19', '=SUM(G19:H19)')
            ->setCellValue('I20', '=SUM(G20:H20)')
            ->setCellValue('I21', '=SUM(G21:H21)')
            ->setCellValue('I22', '=SUM(G22:H22)')
            ->setCellValue('I23', '=SUM(G23:H23)')
            ->setCellValue('I24', '=SUM(G24:H24)')
            ->setCellValue('I25', '=SUM(I19:I24)')
            ->setCellValue('G25', '=SUM(G19:G24)')
            ->setCellValue('H25', '=SUM(H19:H24)')

            ->setCellValue('G26', '=(G11+G18+G25)')
            ->setCellValue('H26', '=(H11+H18+H25)')
            ->setCellValue('I26', '=(I11+I18+I25)')

            //MARET
            ->setCellValue('L5', '=SUM(J5:K5)')
            ->setCellValue('L6', '=SUM(J6:K6)')
            ->setCellValue('L7', '=SUM(J7:K7)')
            ->setCellValue('L8', '=SUM(J8:K8)')
            ->setCellValue('L9', '=SUM(J9:K9)')
            ->setCellValue('L10', '=SUM(J10:K10)')
            ->setCellValue('L11', '=SUM(L5:L10)')
            ->setCellValue('J11', '=SUM(J5:J10)')
            ->setCellValue('K11', '=SUM(K5:K10)')

            ->setCellValue('L12', '=SUM(J12:K12)')
            ->setCellValue('L13', '=SUM(J13:K13)')
            ->setCellValue('L14', '=SUM(J14:K14)')
            ->setCellValue('L15', '=SUM(J15:K15)')
            ->setCellValue('L16', '=SUM(J16:K16)')
            ->setCellValue('L17', '=SUM(J17:K17)')
            ->setCellValue('L18', '=SUM(L12:L17)')
            ->setCellValue('J18', '=SUM(J12:J17)')
            ->setCellValue('K18', '=SUM(K12:K17)')

            ->setCellValue('L19', '=SUM(J19:K19)')
            ->setCellValue('L20', '=SUM(J20:K20)')
            ->setCellValue('L21', '=SUM(J21:K21)')
            ->setCellValue('L22', '=SUM(J22:K22)')
            ->setCellValue('L23', '=SUM(J23:K23)')
            ->setCellValue('L24', '=SUM(J24:K24)')
            ->setCellValue('L25', '=SUM(L19:L24)')
            ->setCellValue('J25', '=SUM(J19:J24)')
            ->setCellValue('K25', '=SUM(K19:K24)')

            ->setCellValue('J26', '=(J11+J18+J25)')
            ->setCellValue('K26', '=(K11+K18+K25)')
            ->setCellValue('L26', '=(L11+L18+L25)')

            //APRIL
            ->setCellValue('O5', '=SUM(M5:N5)')
            ->setCellValue('O6', '=SUM(M6:N6)')
            ->setCellValue('O7', '=SUM(M7:N7)')
            ->setCellValue('O8', '=SUM(M8:N8)')
            ->setCellValue('O9', '=SUM(M9:N9)')
            ->setCellValue('O10', '=SUM(M10:N10)')
            ->setCellValue('O11', '=SUM(O5:O10)')
            ->setCellValue('M11', '=SUM(M5:M10)')
            ->setCellValue('N11', '=SUM(N5:N10)')

            ->setCellValue('O12', '=SUM(M12:N12)')
            ->setCellValue('O13', '=SUM(M13:N13)')
            ->setCellValue('O14', '=SUM(M14:N14)')
            ->setCellValue('O15', '=SUM(M15:N15)')
            ->setCellValue('O16', '=SUM(M16:N16)')
            ->setCellValue('O17', '=SUM(M17:N17)')
            ->setCellValue('O18', '=SUM(O12:O17)')
            ->setCellValue('M18', '=SUM(M12:M17)')
            ->setCellValue('N18', '=SUM(N12:N17)')

            ->setCellValue('O19', '=SUM(M19:N19)')
            ->setCellValue('O20', '=SUM(M20:N20)')
            ->setCellValue('O21', '=SUM(M21:N21)')
            ->setCellValue('O22', '=SUM(M22:N22)')
            ->setCellValue('O23', '=SUM(M23:N23)')
            ->setCellValue('O24', '=SUM(M24:N24)')
            ->setCellValue('O25', '=SUM(O19:O24)')
            ->setCellValue('M25', '=SUM(M19:M24)')
            ->setCellValue('N25', '=SUM(N19:N24)')

            ->setCellValue('M26', '=(M11+M18+M25)')
            ->setCellValue('N26', '=(N11+N18+N25)')
            ->setCellValue('O26', '=(O11+O18+O25)')

            //MEI
            ->setCellValue('R5', '=SUM(P5:Q5)')
            ->setCellValue('R6', '=SUM(P6:Q6)')
            ->setCellValue('R7', '=SUM(P7:Q7)')
            ->setCellValue('R8', '=SUM(P8:Q8)')
            ->setCellValue('R9', '=SUM(P9:Q9)')
            ->setCellValue('R10', '=SUM(P10:Q10)')
            ->setCellValue('R11', '=SUM(R5:R10)')
            ->setCellValue('P11', '=SUM(P5:P10)')
            ->setCellValue('Q11', '=SUM(Q5:Q10)')

            ->setCellValue('R12', '=SUM(P12:Q12)')
            ->setCellValue('R13', '=SUM(P13:Q13)')
            ->setCellValue('R14', '=SUM(P14:Q14)')
            ->setCellValue('R15', '=SUM(P15:Q15)')
            ->setCellValue('R16', '=SUM(P16:Q16)')
            ->setCellValue('R17', '=SUM(P17:Q17)')
            ->setCellValue('R18', '=SUM(R12:R17)')
            ->setCellValue('P18', '=SUM(P12:P17)')
            ->setCellValue('Q18', '=SUM(Q12:Q17)')

            ->setCellValue('R19', '=SUM(P19:Q19)')
            ->setCellValue('R20', '=SUM(P20:Q20)')
            ->setCellValue('R21', '=SUM(P21:Q21)')
            ->setCellValue('R22', '=SUM(P22:Q22)')
            ->setCellValue('R23', '=SUM(P23:Q23)')
            ->setCellValue('R24', '=SUM(P24:Q24)')
            ->setCellValue('R25', '=SUM(R19:R24)')
            ->setCellValue('P25', '=SUM(P19:P24)')
            ->setCellValue('Q25', '=SUM(Q19:Q24)')

            ->setCellValue('P26', '=(P11+P18+P25)')
            ->setCellValue('Q26', '=(Q11+Q18+Q25)')
            ->setCellValue('R26', '=(R11+R18+R25)')

            //JUNI
            ->setCellValue('U5', '=SUM(S5:T5)')
            ->setCellValue('U6', '=SUM(S6:T6)')
            ->setCellValue('U7', '=SUM(S7:T7)')
            ->setCellValue('U8', '=SUM(S8:T8)')
            ->setCellValue('U9', '=SUM(S9:T9)')
            ->setCellValue('U10', '=SUM(S10:T10)')
            ->setCellValue('U11', '=SUM(U5:U10)')
            ->setCellValue('S11', '=SUM(S5:S10)')
            ->setCellValue('T11', '=SUM(T5:T10)')

            ->setCellValue('U12', '=SUM(S12:T12)')
            ->setCellValue('U13', '=SUM(S13:T13)')
            ->setCellValue('U14', '=SUM(S14:T14)')
            ->setCellValue('U15', '=SUM(S15:T15)')
            ->setCellValue('U16', '=SUM(S16:T16)')
            ->setCellValue('U17', '=SUM(S17:T17)')
            ->setCellValue('U18', '=SUM(U12:U17)')
            ->setCellValue('S18', '=SUM(S12:S17)')
            ->setCellValue('T18', '=SUM(T12:T17)')

            ->setCellValue('U19', '=SUM(S19:T19)')
            ->setCellValue('U20', '=SUM(S20:T20)')
            ->setCellValue('U21', '=SUM(S21:T21)')
            ->setCellValue('U22', '=SUM(S22:T22)')
            ->setCellValue('U23', '=SUM(S23:T23)')
            ->setCellValue('U24', '=SUM(S24:T24)')
            ->setCellValue('U25', '=SUM(U19:U24)')
            ->setCellValue('S25', '=SUM(S19:S24)')
            ->setCellValue('T25', '=SUM(T19:T24)')

            ->setCellValue('S26', '=(S11+S18+S25)')
            ->setCellValue('T26', '=(T11+T18+T25)')
            ->setCellValue('U26', '=(U11+U18+U25)')

            //JULI
            ->setCellValue('X5', '=SUM(V5:W5)')
            ->setCellValue('X6', '=SUM(V6:W6)')
            ->setCellValue('X7', '=SUM(V7:W7)')
            ->setCellValue('X8', '=SUM(V8:W8)')
            ->setCellValue('X9', '=SUM(V9:W9)')
            ->setCellValue('X10', '=SUM(V10:W10)')
            ->setCellValue('X11', '=SUM(X5:X10)')
            ->setCellValue('V11', '=SUM(V5:V10)')
            ->setCellValue('W11', '=SUM(W5:W10)')

            ->setCellValue('X12', '=SUM(V12:W12)')
            ->setCellValue('X13', '=SUM(V13:W13)')
            ->setCellValue('X14', '=SUM(V14:W14)')
            ->setCellValue('X15', '=SUM(V15:W15)')
            ->setCellValue('X16', '=SUM(V16:W16)')
            ->setCellValue('X17', '=SUM(V17:W17)')
            ->setCellValue('X18', '=SUM(X12:X17)')
            ->setCellValue('V18', '=SUM(V12:V17)')
            ->setCellValue('W18', '=SUM(W12:W17)')

            ->setCellValue('X19', '=SUM(V19:W19)')
            ->setCellValue('X20', '=SUM(V20:W20)')
            ->setCellValue('X21', '=SUM(V21:W21)')
            ->setCellValue('X22', '=SUM(V22:W22)')
            ->setCellValue('X23', '=SUM(V23:W23)')
            ->setCellValue('X24', '=SUM(V24:W24)')
            ->setCellValue('X25', '=SUM(X19:X24)')
            ->setCellValue('V25', '=SUM(V19:V24)')
            ->setCellValue('W25', '=SUM(W19:W24)')

            ->setCellValue('V26', '=(V11+V18+V25)')
            ->setCellValue('W26', '=(W11+W18+W25)')
            ->setCellValue('X26', '=(X11+X18+X25)')

            //AGUSTUS
            ->setCellValue('AA5', '=SUM(Y5:Z5)')
            ->setCellValue('AA6', '=SUM(Y6:Z6)')
            ->setCellValue('AA7', '=SUM(Y7:Z7)')
            ->setCellValue('AA8', '=SUM(Y8:Z8)')
            ->setCellValue('AA9', '=SUM(Y9:Z9)')
            ->setCellValue('AA10', '=SUM(Y10:Z10)')
            ->setCellValue('AA11', '=SUM(AA5:AA10)')
            ->setCellValue('Y11', '=SUM(Y5:Y10)')
            ->setCellValue('Z11', '=SUM(Z5:Z10)')

            ->setCellValue('AA12', '=SUM(Y12:Z12)')
            ->setCellValue('AA13', '=SUM(Y13:Z13)')
            ->setCellValue('AA14', '=SUM(Y14:Z14)')
            ->setCellValue('AA15', '=SUM(Y15:Z15)')
            ->setCellValue('AA16', '=SUM(Y16:Z16)')
            ->setCellValue('AA17', '=SUM(Y17:Z17)')
            ->setCellValue('AA18', '=SUM(AA12:AA17)')
            ->setCellValue('Y18', '=SUM(Y12:Y17)')
            ->setCellValue('Z18', '=SUM(Z12:Z17)')

            ->setCellValue('AA19', '=SUM(Y19:Z19)')
            ->setCellValue('AA20', '=SUM(Y20:Z20)')
            ->setCellValue('AA21', '=SUM(Y21:Z21)')
            ->setCellValue('AA22', '=SUM(Y22:Z22)')
            ->setCellValue('AA23', '=SUM(Y23:Z23)')
            ->setCellValue('AA24', '=SUM(Y24:Z24)')
            ->setCellValue('AA25', '=SUM(AA19:AA24)')
            ->setCellValue('Y25', '=SUM(Y19:Y24)')
            ->setCellValue('Z25', '=SUM(Z19:Z24)')

            ->setCellValue('Y26', '=(Y11+Y18+Y25)')
            ->setCellValue('Z26', '=(Z11+Z18+Z25)')
            ->setCellValue('AA26', '=(AA11+AA18+AA25)')

            //SEPTEMBER
            ->setCellValue('AD5', '=SUM(AB5:AC5)')
            ->setCellValue('AD6', '=SUM(AB6:AC6)')
            ->setCellValue('AD7', '=SUM(AB7:AC7)')
            ->setCellValue('AD8', '=SUM(AB8:AC8)')
            ->setCellValue('AD9', '=SUM(AB9:AC9)')
            ->setCellValue('AD10', '=SUM(AB10:AC10)')
            ->setCellValue('AD11', '=SUM(AD5:AD10)')
            ->setCellValue('AB11', '=SUM(AB5:AB10)')
            ->setCellValue('AC11', '=SUM(AC5:AC10)')

            ->setCellValue('AD12', '=SUM(AB12:AC12)')
            ->setCellValue('AD13', '=SUM(AB13:AC13)')
            ->setCellValue('AD14', '=SUM(AB14:AC14)')
            ->setCellValue('AD15', '=SUM(AB15:AC15)')
            ->setCellValue('AD16', '=SUM(AB16:AC16)')
            ->setCellValue('AD17', '=SUM(AB17:AC17)')
            ->setCellValue('AD18', '=SUM(AD12:AD17)')
            ->setCellValue('AB18', '=SUM(AB12:AB17)')
            ->setCellValue('AC18', '=SUM(AC12:AC17)')

            ->setCellValue('AD19', '=SUM(AB19:AC19)')
            ->setCellValue('AD20', '=SUM(AB20:AC20)')
            ->setCellValue('AD21', '=SUM(AB21:AC21)')
            ->setCellValue('AD22', '=SUM(AB22:AC22)')
            ->setCellValue('AD23', '=SUM(AB23:AC23)')
            ->setCellValue('AD24', '=SUM(AB24:AC24)')
            ->setCellValue('AD25', '=SUM(AD19:AD24)')
            ->setCellValue('AB25', '=SUM(AB19:AB24)')
            ->setCellValue('AC25', '=SUM(AC19:AC24)')

            ->setCellValue('AB26', '=(AB11+AB18+AB25)')
            ->setCellValue('AC26', '=(AC11+AC18+AC25)')
            ->setCellValue('AD26', '=(AD11+AD18+AD25)')

            //OKTOBER
            ->setCellValue('AG5', '=SUM(AE5:AF5)')
            ->setCellValue('AG6', '=SUM(AE6:AF6)')
            ->setCellValue('AG7', '=SUM(AE7:AF7)')
            ->setCellValue('AG8', '=SUM(AE8:AF8)')
            ->setCellValue('AG9', '=SUM(AE9:AF9)')
            ->setCellValue('AG10', '=SUM(AE10:AF10)')
            ->setCellValue('AG11', '=SUM(AG5:AG10)')
            ->setCellValue('AE11', '=SUM(AE5:AE10)')
            ->setCellValue('AF11', '=SUM(AF5:AF10)')

            ->setCellValue('AG12', '=SUM(AE12:AF12)')
            ->setCellValue('AG13', '=SUM(AE13:AF13)')
            ->setCellValue('AG14', '=SUM(AE14:AF14)')
            ->setCellValue('AG15', '=SUM(AE15:AF15)')
            ->setCellValue('AG16', '=SUM(AE16:AF16)')
            ->setCellValue('AG17', '=SUM(AE17:AF17)')
            ->setCellValue('AG18', '=SUM(AG12:AG17)')
            ->setCellValue('AE18', '=SUM(AE12:AE17)')
            ->setCellValue('AF18', '=SUM(AF12:AF17)')

            ->setCellValue('AG19', '=SUM(AE19:AF19)')
            ->setCellValue('AG20', '=SUM(AE20:AF20)')
            ->setCellValue('AG21', '=SUM(AE21:AF21)')
            ->setCellValue('AG22', '=SUM(AE22:AF22)')
            ->setCellValue('AG23', '=SUM(AE23:AF23)')
            ->setCellValue('AG24', '=SUM(AE24:AF24)')
            ->setCellValue('AG25', '=SUM(AG19:AG24)')
            ->setCellValue('AE25', '=SUM(AE19:AE24)')
            ->setCellValue('AF25', '=SUM(AF19:AF24)')

            ->setCellValue('AE26', '=(AE11+AE18+AE25)')
            ->setCellValue('AF26', '=(AF11+AF18+AF25)')
            ->setCellValue('AG26', '=(AG11+AG18+AG25)')

            //NOV
            ->setCellValue('AJ5', '=SUM(AH5:AI5)')
            ->setCellValue('AJ6', '=SUM(AH6:AI6)')
            ->setCellValue('AJ7', '=SUM(AH7:AI7)')
            ->setCellValue('AJ8', '=SUM(AH8:AI8)')
            ->setCellValue('AJ9', '=SUM(AH9:AI9)')
            ->setCellValue('AJ10', '=SUM(AH10:AI10)')
            ->setCellValue('AJ11', '=SUM(AJ5:AJ10)')
            ->setCellValue('AH11', '=SUM(AH5:AH10)')
            ->setCellValue('AI11', '=SUM(AI5:AI10)')

            ->setCellValue('AJ12', '=SUM(AH12:AI12)')
            ->setCellValue('AJ13', '=SUM(AH13:AI13)')
            ->setCellValue('AJ14', '=SUM(AH14:AI14)')
            ->setCellValue('AJ15', '=SUM(AH15:AI15)')
            ->setCellValue('AJ16', '=SUM(AH16:AI16)')
            ->setCellValue('AJ17', '=SUM(AH17:AI17)')
            ->setCellValue('AJ18', '=SUM(AJ12:AJ17)')
            ->setCellValue('AH18', '=SUM(AH12:AH17)')
            ->setCellValue('AI18', '=SUM(AI12:AI17)')

            ->setCellValue('AJ19', '=SUM(AH19:AI19)')
            ->setCellValue('AJ20', '=SUM(AH20:AI20)')
            ->setCellValue('AJ21', '=SUM(AH21:AI21)')
            ->setCellValue('AJ22', '=SUM(AH22:AI22)')
            ->setCellValue('AJ23', '=SUM(AH23:AI23)')
            ->setCellValue('AJ24', '=SUM(AH24:AI24)')
            ->setCellValue('AJ25', '=SUM(AJ19:AJ24)')
            ->setCellValue('AH25', '=SUM(AH19:AH24)')
            ->setCellValue('AI25', '=SUM(AI19:AI24)')

            ->setCellValue('AH26', '=(AH11+AH18+AH25)')
            ->setCellValue('AI26', '=(AI11+AI18+AI25)')
            ->setCellValue('AJ26', '=(AJ11+AJ18+AJ25)')

            //DES
            ->setCellValue('AM5', '=SUM(AK5:AL5)')
            ->setCellValue('AM6', '=SUM(AK6:AL6)')
            ->setCellValue('AM7', '=SUM(AK7:AL7)')
            ->setCellValue('AM8', '=SUM(AK8:AL8)')
            ->setCellValue('AM9', '=SUM(AK9:AL9)')
            ->setCellValue('AM10', '=SUM(AK10:AL10)')
            ->setCellValue('AM11', '=SUM(AM5:AM10)')
            ->setCellValue('AK11', '=SUM(AK5:AK10)')
            ->setCellValue('AL11', '=SUM(AL5:AL10)')

            ->setCellValue('AM12', '=SUM(AK12:AL12)')
            ->setCellValue('AM13', '=SUM(AK13:AL13)')
            ->setCellValue('AM14', '=SUM(AK14:AL14)')
            ->setCellValue('AM15', '=SUM(AK15:AL15)')
            ->setCellValue('AM16', '=SUM(AK16:AL16)')
            ->setCellValue('AM17', '=SUM(AK17:AL17)')
            ->setCellValue('AM18', '=SUM(AM12:AM17)')
            ->setCellValue('AK18', '=SUM(AK12:AK17)')
            ->setCellValue('AL18', '=SUM(AL12:AL17)')

            ->setCellValue('AM19', '=SUM(AK19:AL19)')
            ->setCellValue('AM20', '=SUM(AK20:AL20)')
            ->setCellValue('AM21', '=SUM(AK21:AL21)')
            ->setCellValue('AM22', '=SUM(AK22:AL22)')
            ->setCellValue('AM23', '=SUM(AK23:AL23)')
            ->setCellValue('AM24', '=SUM(AK24:AL24)')
            ->setCellValue('AM25', '=SUM(AM19:AM24)')
            ->setCellValue('AK25', '=SUM(AK19:AK24)')
            ->setCellValue('AL25', '=SUM(AL19:AL24)')

            ->setCellValue('AK26', '=(AK11+AK18+AK25)')
            ->setCellValue('AL26', '=(AL11+AL18+AL25)')
            ->setCellValue('AM26', '=(AM11+AM18+AM25)')

            //TOTAL L
            ->setCellValue('AN5', '=(D5+G5+J5+M5+P5+S5+V5+Y5+AB5+AE5+AH5+AK5)')
            ->setCellValue('AN6', '=(D6+G6+J6+M6+P6+S6+V6+Y6+AB6+AE6+AH6+AK6)')
            ->setCellValue('AN7', '=(D7+G7+J7+M7+P7+S7+V7+Y7+AB7+AE7+AH7+AK7)')
            ->setCellValue('AN8', '=(D8+G8+J8+M8+P8+S8+V8+Y8+AB8+AE8+AH8+AK8)')
            ->setCellValue('AN9', '=(D9+G9+J9+M9+P9+S9+V9+Y9+AB9+AE9+AH9+AK9)')
            ->setCellValue('AN10', '=(D10+G10+J10+M10+P10+S10+V10+Y10+AB10+AE10+AH10+AK10)')
            ->setCellValue('AN11', '=(D11+G11+J11+M11+P11+S11+V11+Y11+AB11+AE11+AH11+AK11)')
            ->setCellValue('AN12', '=(D12+G12+J12+M12+P12+S12+V12+Y12+AB12+AE12+AH12+AK12)')
            ->setCellValue('AN13', '=(D13+G13+J13+M13+P13+S13+V13+Y13+AB13+AE13+AH13+AK13)')
            ->setCellValue('AN14', '=(D14+G14+J14+M14+P14+S14+V14+Y14+AB14+AE14+AH14+AK14)')
            ->setCellValue('AN15', '=(D15+G15+J15+M15+P15+S15+V15+Y15+AB15+AE15+AH15+AK15)')
            ->setCellValue('AN16', '=(D16+G16+J16+M16+P16+S16+V16+Y16+AB16+AE16+AH16+AK16)')
            ->setCellValue('AN17', '=(D17+G17+J17+M17+P17+S17+V17+Y17+AB17+AE17+AH17+AK17)')
            ->setCellValue('AN18', '=(D18+G18+J18+M18+P18+S18+V18+Y18+AB18+AE18+AH18+AK18)')
            ->setCellValue('AN19', '=(D19+G19+J19+M19+P19+S19+V19+Y19+AB19+AE19+AH19+AK19)')
            ->setCellValue('AN20', '=(D20+G20+J20+M20+P20+S20+V20+Y20+AB20+AE20+AH20+AK20)')
            ->setCellValue('AN21', '=(D21+G21+J21+M21+P21+S21+V21+Y21+AB21+AE21+AH21+AK21)')
            ->setCellValue('AN22', '=(D22+G22+J22+M22+P22+S22+V22+Y22+AB22+AE22+AH22+AK22)')
            ->setCellValue('AN23', '=(D23+G23+J23+M23+P23+S23+V23+Y23+AB23+AE23+AH23+AK23)')
            ->setCellValue('AN24', '=(D24+G24+J24+M24+P24+S24+V24+Y24+AB24+AE24+AH24+AK24)')
            ->setCellValue('AN25', '=(D25+G25+J25+M25+P25+S25+V25+Y25+AB25+AE25+AH25+AK25)')
            ->setCellValue('AN26', '=(D26+G26+J26+M26+P26+S26+V26+Y26+AB26+AE26+AH26+AK26)')

            //TOTAL P
            ->setCellValue('AO5', '=(E5+H5+K5+N5+Q5+T5+W5+Z5+AC5+AF5+AI5+AL5)')
            ->setCellValue('AO6', '=(E6+H6+K6+N6+Q6+T6+W6+Z6+AC6+AF6+AI6+AL6)')
            ->setCellValue('AO7', '=(E7+H7+K7+N7+Q7+T7+W7+Z7+AC7+AF7+AI7+AL7)')
            ->setCellValue('AO8', '=(E8+H8+K8+N8+Q8+T8+W8+Z8+AC8+AF8+AI8+AL8)')
            ->setCellValue('AO9', '=(E9+H9+K9+N9+Q9+T9+W9+Z9+AC9+AF9+AI9+AL9)')
            ->setCellValue('AO10', '=(E10+H10+K10+N10+Q10+T10+W10+Z10+AC10+AF10+AI10+AL10)')
            ->setCellValue('AO11', '=(E11+H11+K11+N11+Q11+T11+W11+Z11+AC11+AF11+AI11+AL11)')
            ->setCellValue('AO12', '=(E12+H12+K12+N12+Q12+T12+W12+Z12+AC12+AF12+AI12+AL12)')
            ->setCellValue('AO13', '=(E13+H13+K13+N13+Q13+T13+W13+Z13+AC13+AF13+AI13+AL13)')
            ->setCellValue('AO14', '=(E14+H14+K14+N14+Q14+T14+W14+Z14+AC14+AF14+AI14+AL14)')
            ->setCellValue('AO15', '=(E15+H15+K15+N15+Q15+T15+W15+Z15+AC15+AF15+AI15+AL15)')
            ->setCellValue('AO16', '=(E16+H16+K16+N16+Q16+T16+W16+Z16+AC16+AF16+AI16+AL16)')
            ->setCellValue('AO17', '=(E17+H17+K17+N17+Q17+T17+W17+Z17+AC17+AF17+AI17+AL17)')
            ->setCellValue('AO18', '=(E18+H18+K18+N18+Q18+T18+W18+Z18+AC18+AF18+AI18+AL18)')
            ->setCellValue('AO19', '=(E19+H19+K19+N19+Q19+T19+W19+Z19+AC19+AF19+AI19+AL19)')
            ->setCellValue('AO20', '=(E20+H20+K20+N20+Q20+T20+W20+Z20+AC20+AF20+AI20+AL20)')
            ->setCellValue('AO21', '=(E21+H21+K21+N21+Q21+T21+W21+Z21+AC21+AF21+AI21+AL21)')
            ->setCellValue('AO22', '=(E22+H22+K22+N22+Q22+T22+W22+Z22+AC22+AF22+AI22+AL22)')
            ->setCellValue('AO23', '=(E23+H23+K23+N23+Q23+T23+W23+Z23+AC23+AF23+AI23+AL23)')
            ->setCellValue('AO24', '=(E24+H24+K24+N24+Q24+T24+W24+Z24+AC24+AF24+AI24+AL24)')
            ->setCellValue('AO25', '=(E25+H25+K25+N25+Q25+T25+W25+Z25+AC25+AF25+AI25+AL25)')
            ->setCellValue('AO26', '=(E26+H26+K26+N26+Q26+T26+W26+Z26+AC26+AF26+AI26+AL26)')

            //TOTAL JML
            ->setCellValue('AP5', '=(AN5+AO5)')
            ->setCellValue('AP6', '=(AN6+AO6)')
            ->setCellValue('AP7', '=(AN7+AO7)')
            ->setCellValue('AP8', '=(AN8+AO8)')
            ->setCellValue('AP9', '=(AN9+AO9)')
            ->setCellValue('AP10', '=(AN10+AO10)')
            ->setCellValue('AP11', '=(AN11+AO11)')
            ->setCellValue('AP12', '=(AN12+AO12)')
            ->setCellValue('AP13', '=(AN13+AO13)')
            ->setCellValue('AP14', '=(AN14+AO14)')
            ->setCellValue('AP15', '=(AN15+AO15)')
            ->setCellValue('AP16', '=(AN16+AO16)')
            ->setCellValue('AP17', '=(AN17+AO17)')
            ->setCellValue('AP18', '=(AN18+AO18)')
            ->setCellValue('AP19', '=(AN19+AO19)')
            ->setCellValue('AP20', '=(AN20+AO20)')
            ->setCellValue('AP21', '=(AN21+AO21)')
            ->setCellValue('AP22', '=(AN22+AO22)')
            ->setCellValue('AP23', '=(AN23+AO23)')
            ->setCellValue('AP24', '=(AN24+AO24)')
            ->setCellValue('AP25', '=(AN25+AO25)')
            ->setCellValue('AP26', '=(AN26+AO26)')

            ;

        $filename =  'DATA KEMATIAN KOTA MOJOKERTO TAHUN '.$tahun.' - DIUNDUH TGL '. date('Y-m-d');
        if ($extension == 'xlsx') {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }elseif ($extension == 'pdf') {
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($spreadsheet);
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment;filename=' . $filename . '.pdf');
            header('Cache-Control: max-age=0');
            $writer->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            $writer->save('php://output');
        } 
        
    }
}