<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class LahirLaporan extends BaseController
{
    /*--- FRONT ---*/
	public function index()
	{
        $list_tahun     = $this->list_tahun('lahir');

        $data = [
            'title'         => 'Laporan Data Kelahiran',
            'list_tahun'    => $list_tahun,
        ];
        return view('panel/lahir/laporan/index', $data);
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
                $query   = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_lahir WHERE EXTRACT(YEAR FROM tgl_lahir) = $tahun AND EXTRACT(MONTH FROM tgl_lahir) = $i AND kecamatan = '$kc'");
                $hasilT1[]      = $query->getResultArray();
            }
        }
        foreach ($kelurahan as $kel) {
            for ($i=1; $i <= 12 ; $i++) { 
                $kl = $kel['idl'];
                $as = 'L-'.strtolower($kel['idl']).'-'.$i;
                $query   = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_lahir WHERE EXTRACT(YEAR FROM tgl_lahir) = $tahun AND EXTRACT(MONTH FROM tgl_lahir) = $i AND kelurahan = '$kl' AND kelamin = 'LAKI-LAKI'");
                $hasilT2L[]      = $query->getResultArray();
            }
        }
        foreach ($kelurahan as $kel) {
            for ($i=1; $i <= 12 ; $i++) { 
                $kl = $kel['idl'];
                $as = 'P-'.strtolower($kel['idl']).'-'.$i;
                $query   = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_lahir WHERE EXTRACT(YEAR FROM tgl_lahir) = $tahun AND EXTRACT(MONTH FROM tgl_lahir) = $i AND kelurahan = '$kl' AND kelamin = 'PEREMPUAN'");
                $hasilT2P[]      = $query->getResultArray();
            }
        }
        foreach ($kelurahan as $kel) {
            for ($i=1; $i <= 12 ; $i++) { 
                $kl = $kel['idl'];
                $as = 'LT-'.strtolower($kel['idl']).'-'.$i;
                $query   = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_lahir WHERE EXTRACT(YEAR FROM tgl_lahir) = $tahun AND EXTRACT(MONTH FROM tgl_lahir) = $i AND kelurahan = '$kl' AND kategori = 'LT'");
                $hasilT3LT[]      = $query->getResultArray();
            }
        }
        foreach ($kelurahan as $kel) {
            for ($i=1; $i <= 12 ; $i++) { 
                $kl = $kel['idl'];
                $as = 'LU-'.strtolower($kel['idl']).'-'.$i;
                $query   = $this->db->query("SELECT COUNT(*) AS '$as' FROM tb_data_lahir WHERE EXTRACT(YEAR FROM tgl_lahir) = $tahun AND EXTRACT(MONTH FROM tgl_lahir) = $i AND kelurahan = '$kl' AND kategori = 'LU'");
                $hasilT3LU[]      = $query->getResultArray();
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
        $t3m = array_merge($hasilT3LT,$hasilT3LU);
        $t3 = [];
        foreach ($t3m as $item) {
            $key = key($item[0]);
            $value = reset($item[0]);
            $t3[$key] = $value;
        }
        //var_dump($t2);
		

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

        $judulT1 = "LAPORAN DATA KELAHIRAN KOTA MOJOKERTO TAHUN " .$tahun;
        $sheet->setCellValue('A1', $judulT1);
        $sheet->getStyle('A1')->applyFromArray($textOnly);
        $sheet->mergeCells('A1:Z1');
        $sheet->mergeCells('A2:A6');

        $judulT2 = "BERDASARKAN JENIS KELAMIN";
        $sheet->setCellValue('A7', $judulT2);
        $sheet->getStyle('A7')->applyFromArray($textOnly);
        $sheet->mergeCells('A7:Z10');

        $judulT3 = "BERDASARKAN KATEGORI";
        $sheet->setCellValue('A33', $judulT3);
        $sheet->getStyle('A33')->applyFromArray($textOnly);
        $sheet->mergeCells('A33:Z35');

        $sheet->getPageSetup()->setOrientation(PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT);


        //*--- For Merge Tabel 1 ---*/
        for ($i=2; $i <= 6 ; $i++) { 
            $sheet->mergeCells('C'.$i.':D'.$i);
            $sheet->mergeCells('E'.$i.':F'.$i);
            $sheet->mergeCells('G'.$i.':H'.$i);
            $sheet->mergeCells('I'.$i.':J'.$i);
            $sheet->mergeCells('K'.$i.':L'.$i);
            $sheet->mergeCells('M'.$i.':N'.$i);
            $sheet->mergeCells('O'.$i.':P'.$i);
            $sheet->mergeCells('Q'.$i.':R'.$i);
            $sheet->mergeCells('S'.$i.':T'.$i);
            $sheet->mergeCells('U'.$i.':V'.$i);
            $sheet->mergeCells('W'.$i.':X'.$i);
            $sheet->mergeCells('Y'.$i.':Z'.$i);
        }
        //*--- For Merge Tabel 2 ---*/
        $sheet->mergeCells('C11:D11');
        $sheet->mergeCells('E11:F11');
        $sheet->mergeCells('G11:H11');
        $sheet->mergeCells('I11:J11');
        $sheet->mergeCells('K11:L11');
        $sheet->mergeCells('M11:N11');
        $sheet->mergeCells('O11:P11');
        $sheet->mergeCells('Q11:R11');
        $sheet->mergeCells('S11:T11');
        $sheet->mergeCells('U11:V11');
        $sheet->mergeCells('W11:X11');
        $sheet->mergeCells('Y11:Z11');

        $sheet->mergeCells('C32:D32');
        $sheet->mergeCells('E32:F32');
        $sheet->mergeCells('G32:H32');
        $sheet->mergeCells('I32:J32');
        $sheet->mergeCells('K32:L32');
        $sheet->mergeCells('M32:N32');
        $sheet->mergeCells('O32:P32');
        $sheet->mergeCells('Q32:R32');
        $sheet->mergeCells('S32:T32');
        $sheet->mergeCells('U32:V32');
        $sheet->mergeCells('W32:X32');
        $sheet->mergeCells('Y32:Z32');
        //*--- For Merge Tabel 3 ---*/
        $sheet->mergeCells('C36:D36');
        $sheet->mergeCells('E36:F36');
        $sheet->mergeCells('G36:H36');
        $sheet->mergeCells('I36:J36');
        $sheet->mergeCells('K36:L36');
        $sheet->mergeCells('M36:N36');
        $sheet->mergeCells('O36:P36');
        $sheet->mergeCells('Q36:R36');
        $sheet->mergeCells('S36:T36');
        $sheet->mergeCells('U36:V36');
        $sheet->mergeCells('W36:X36');
        $sheet->mergeCells('Y36:Z36');

        $sheet->mergeCells('C57:D57');
        $sheet->mergeCells('E57:F57');
        $sheet->mergeCells('G57:H57');
        $sheet->mergeCells('I57:J57');
        $sheet->mergeCells('K57:L57');
        $sheet->mergeCells('M57:N57');
        $sheet->mergeCells('O57:P57');
        $sheet->mergeCells('Q57:R57');
        $sheet->mergeCells('S57:T57');
        $sheet->mergeCells('U57:V57');
        $sheet->mergeCells('W57:X57');
        $sheet->mergeCells('Y57:Z57');

        //*--- For Merge Tabel 2 (Atas Bawah)---*/
        $sheet->mergeCells('A11:A12');
        $sheet->mergeCells('B11:B12');
        $sheet->mergeCells('A13:A18');
        $sheet->mergeCells('A19:A24');
        $sheet->mergeCells('A25:A30');
        $sheet->mergeCells('A31:B31'); //Jumlah
        $sheet->mergeCells('A32:B32');//Total
        //*--- For Merge Tabel 3 (Atas Bawah)---*/
        $sheet->mergeCells('A36:A37');
        $sheet->mergeCells('B36:B37');
        $sheet->mergeCells('A38:A43');
        $sheet->mergeCells('A44:A49');
        $sheet->mergeCells('A50:A55');
        $sheet->mergeCells('A56:B56'); //Jumlah
        $sheet->mergeCells('A57:B57');//Total
        //*--- Border Tabel 1 ---*/
        $sheet->getStyle('B2:Z2')->applyFromArray($style_up);
        $sheet->getStyle('B3:Z6')->applyFromArray($isi_tengah);
        //*--- Border Tabel 2---*/
        $sheet->getStyle('A11:Z12')->applyFromArray($style_up);
        $sheet->getStyle('A13:Z32')->applyFromArray($isi_tengah);
        //*--- Border Tabel 3---*/
        $sheet->getStyle('A36:Z37')->applyFromArray($style_up);
        $sheet->getStyle('A38:Z57')->applyFromArray($isi_tengah);
        //*--- Kolom Size---*/
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

        $spreadsheet->setActiveSheetIndex(0)
            //*--- TABEL  1---*/
            ->setCellValue('B2', 'KECAMATAN')
            ->setCellValue('B3', 'PRAJURITKULON')
            ->setCellValue('B4', 'MAGERSARI')
            ->setCellValue('B5', 'KRANGGAN')
            ->setCellValue('B6', 'TOTAL')

            ->setCellValue('C2', 'JAN')
            ->setCellValue('E2', 'FEB')
            ->setCellValue('G2', 'MARET')
            ->setCellValue('I2', 'APRIL')
            ->setCellValue('K2', 'MEI')
            ->setCellValue('M2', 'JUNI')
            ->setCellValue('O2', 'JULI')
            ->setCellValue('Q2', 'AGUSTUS')
            ->setCellValue('S2', 'SEPT')
            ->setCellValue('U2', 'OKT')
            ->setCellValue('W2', 'NOV')
            ->setCellValue('Y2', 'DES')

            ->setCellValue('C3', $t1['C-prajuritkulon-1'])
            ->setCellValue('E3', $t1['C-prajuritkulon-2'])
            ->setCellValue('G3', $t1['C-prajuritkulon-3'])
            ->setCellValue('I3', $t1['C-prajuritkulon-4'])
            ->setCellValue('K3', $t1['C-prajuritkulon-5'])
            ->setCellValue('M3', $t1['C-prajuritkulon-6'])
            ->setCellValue('O3', $t1['C-prajuritkulon-7'])
            ->setCellValue('Q3', $t1['C-prajuritkulon-8'])
            ->setCellValue('S3', $t1['C-prajuritkulon-9'])
            ->setCellValue('U3', $t1['C-prajuritkulon-10'])
            ->setCellValue('W3', $t1['C-prajuritkulon-11'])
            ->setCellValue('Y3', $t1['C-prajuritkulon-12'])

            ->setCellValue('C4', $t1['C-magersari-1'])
            ->setCellValue('E4', $t1['C-magersari-2'])
            ->setCellValue('G4', $t1['C-magersari-3'])
            ->setCellValue('I4', $t1['C-magersari-4'])
            ->setCellValue('K4', $t1['C-magersari-5'])
            ->setCellValue('M4', $t1['C-magersari-6'])
            ->setCellValue('O4', $t1['C-magersari-7'])
            ->setCellValue('Q4', $t1['C-magersari-8'])
            ->setCellValue('S4', $t1['C-magersari-9'])
            ->setCellValue('U4', $t1['C-magersari-10'])
            ->setCellValue('W4', $t1['C-magersari-11'])
            ->setCellValue('Y4', $t1['C-magersari-12'])

            ->setCellValue('C5', $t1['C-kranggan-1'])
            ->setCellValue('E5', $t1['C-kranggan-2'])
            ->setCellValue('G5', $t1['C-kranggan-3'])
            ->setCellValue('I5', $t1['C-kranggan-4'])
            ->setCellValue('K5', $t1['C-kranggan-5'])
            ->setCellValue('M5', $t1['C-kranggan-6'])
            ->setCellValue('O5', $t1['C-kranggan-7'])
            ->setCellValue('Q5', $t1['C-kranggan-8'])
            ->setCellValue('S5', $t1['C-kranggan-9'])
            ->setCellValue('U5', $t1['C-kranggan-10'])
            ->setCellValue('W5', $t1['C-kranggan-11'])
            ->setCellValue('Y5', $t1['C-kranggan-12'])

            ->setCellValue('C6', '=SUM(C3:C5)')
            ->setCellValue('E6', '=SUM(E3:E5)')
            ->setCellValue('G6', '=SUM(G3:G5)')
            ->setCellValue('I6', '=SUM(I3:I5)')
            ->setCellValue('K6', '=SUM(K3:K5)')
            ->setCellValue('M6', '=SUM(M3:M5)')
            ->setCellValue('O6', '=SUM(O3:O5)')
            ->setCellValue('Q6', '=SUM(Q3:Q5)')
            ->setCellValue('S6', '=SUM(S3:S5)')
            ->setCellValue('U6', '=SUM(U3:U5)')
            ->setCellValue('W6', '=SUM(W3:W5)')
            ->setCellValue('Y6', '=SUM(Y3:Y5)')

            //*--- TABEL 2 ---*/
            ->setCellValue('A11', 'KECAMATAN')
            ->setCellValue('A13', 'PRAJURITKULON')
            ->setCellValue('A19', 'MAGERSARI')
            ->setCellValue('A25', 'KRANGGAN')
            ->setCellValue('A31', 'JUMLAH')
            ->setCellValue('A32', 'TOTAL')
            ->setCellValue('B11', 'KELURAHAN')
              //Prajurtikulon
            ->setCellValue('B13', 'MENTIKAN')
            ->setCellValue('B14', 'KAUMAN')
            ->setCellValue('B15', 'PULOREJO')
            ->setCellValue('B16', 'PRAJURITKULON')
            ->setCellValue('B17', 'SURODINAWAN')
            ->setCellValue('B18', 'BLOOTO')
             //Magersari
            ->setCellValue('B19', 'GUNUNG GEDANGAN')
            ->setCellValue('B20', 'MAGERSARI')
            ->setCellValue('B21', 'GEDONGAN')
            ->setCellValue('B22', 'BALONGSARI')
            ->setCellValue('B23', 'KEDUNDUNG')
            ->setCellValue('B24', 'WATES')
             //Kranggan
            ->setCellValue('B25', 'KRANGGAN')
            ->setCellValue('B26', 'MIJI')
            ->setCellValue('B27', 'MERI')
            ->setCellValue('B28', 'JAGALAN')
            ->setCellValue('B29', 'SENTANAN')
            ->setCellValue('B30', 'PURWOTENGAH')

            ->setCellValue('C11', 'JAN')
            ->setCellValue('E11', 'FEB')
            ->setCellValue('G11', 'MARET')
            ->setCellValue('I11', 'APRIL')
            ->setCellValue('K11', 'MEI')
            ->setCellValue('M11', 'JUNI')
            ->setCellValue('O11', 'JULI')
            ->setCellValue('Q11', 'AGUSTUS')
            ->setCellValue('S11', 'SEPT')
            ->setCellValue('U11', 'OKT')
            ->setCellValue('W11', 'NOV')
            ->setCellValue('Y11', 'DES')

            //*--- Loop L / P---*/
            ->setCellValue('C12', 'L')
            ->setCellValue('D12', 'P')
            ->setCellValue('E12', 'L')
            ->setCellValue('F12', 'P')
            ->setCellValue('G12', 'L')
            ->setCellValue('H12', 'P')
            ->setCellValue('I12', 'L')
            ->setCellValue('J12', 'P')
            ->setCellValue('K12', 'L')
            ->setCellValue('L12', 'P')
            ->setCellValue('M12', 'L')
            ->setCellValue('N12', 'P')
            ->setCellValue('O12', 'L')
            ->setCellValue('P12', 'P')
            ->setCellValue('Q12', 'L')
            ->setCellValue('R12', 'P')
            ->setCellValue('S12', 'L')
            ->setCellValue('T12', 'P')
            ->setCellValue('U12', 'L')
            ->setCellValue('V12', 'P')
            ->setCellValue('W12', 'L')
            ->setCellValue('X12', 'P')
            ->setCellValue('Y12', 'L')
            ->setCellValue('Z12', 'P')

            ->setCellValue('C13', $t2['L-mentikan-1'])
            ->setCellValue('D13', $t2['P-mentikan-1'])
            ->setCellValue('E13', $t2['L-mentikan-2'])
            ->setCellValue('F13', $t2['P-mentikan-2'])
            ->setCellValue('G13', $t2['L-mentikan-3'])
            ->setCellValue('H13', $t2['P-mentikan-3'])
            ->setCellValue('I13', $t2['L-mentikan-4'])
            ->setCellValue('J13', $t2['P-mentikan-4'])
            ->setCellValue('K13', $t2['L-mentikan-5'])
            ->setCellValue('L13', $t2['P-mentikan-5'])
            ->setCellValue('M13', $t2['L-mentikan-6'])
            ->setCellValue('N13', $t2['P-mentikan-6'])
            ->setCellValue('O13', $t2['L-mentikan-7'])
            ->setCellValue('P13', $t2['P-mentikan-7'])
            ->setCellValue('Q13', $t2['L-mentikan-8'])
            ->setCellValue('R13', $t2['P-mentikan-8'])
            ->setCellValue('S13', $t2['L-mentikan-9'])
            ->setCellValue('T13', $t2['P-mentikan-9'])
            ->setCellValue('U13', $t2['L-mentikan-10'])
            ->setCellValue('V13', $t2['P-mentikan-10'])
            ->setCellValue('W13', $t2['L-mentikan-11'])
            ->setCellValue('X13', $t2['P-mentikan-11'])
            ->setCellValue('Y13', $t2['L-mentikan-12'])
            ->setCellValue('Z13', $t2['P-mentikan-12'])

            ->setCellValue('C14', $t2['L-kauman-1'])
            ->setCellValue('D14', $t2['P-kauman-1'])
            ->setCellValue('E14', $t2['L-kauman-2'])
            ->setCellValue('F14', $t2['P-kauman-2'])
            ->setCellValue('G14', $t2['L-kauman-3'])
            ->setCellValue('H14', $t2['P-kauman-3'])
            ->setCellValue('I14', $t2['L-kauman-4'])
            ->setCellValue('J14', $t2['P-kauman-4'])
            ->setCellValue('K14', $t2['L-kauman-5'])
            ->setCellValue('L14', $t2['P-kauman-5'])
            ->setCellValue('M14', $t2['L-kauman-6'])
            ->setCellValue('N14', $t2['P-kauman-6'])
            ->setCellValue('O14', $t2['L-kauman-7'])
            ->setCellValue('P14', $t2['P-kauman-7'])
            ->setCellValue('Q14', $t2['L-kauman-8'])
            ->setCellValue('R14', $t2['P-kauman-8'])
            ->setCellValue('S14', $t2['L-kauman-9'])
            ->setCellValue('T14', $t2['P-kauman-9'])
            ->setCellValue('U14', $t2['L-kauman-10'])
            ->setCellValue('V14', $t2['P-kauman-10'])
            ->setCellValue('W14', $t2['L-kauman-11'])
            ->setCellValue('X14', $t2['P-kauman-11'])
            ->setCellValue('Y14', $t2['L-kauman-12'])
            ->setCellValue('Z14', $t2['P-kauman-12'])

            ->setCellValue('C15', $t2['L-pulorejo-1'])
            ->setCellValue('D15', $t2['P-pulorejo-1'])
            ->setCellValue('E15', $t2['L-pulorejo-2'])
            ->setCellValue('F15', $t2['P-pulorejo-2'])
            ->setCellValue('G15', $t2['L-pulorejo-3'])
            ->setCellValue('H15', $t2['P-pulorejo-3'])
            ->setCellValue('I15', $t2['L-pulorejo-4'])
            ->setCellValue('J15', $t2['P-pulorejo-4'])
            ->setCellValue('K15', $t2['L-pulorejo-5'])
            ->setCellValue('L15', $t2['P-pulorejo-5'])
            ->setCellValue('M15', $t2['L-pulorejo-6'])
            ->setCellValue('N15', $t2['P-pulorejo-6'])
            ->setCellValue('O15', $t2['L-pulorejo-7'])
            ->setCellValue('P15', $t2['P-pulorejo-7'])
            ->setCellValue('Q15', $t2['L-pulorejo-8'])
            ->setCellValue('R15', $t2['P-pulorejo-8'])
            ->setCellValue('S15', $t2['L-pulorejo-9'])
            ->setCellValue('T15', $t2['P-pulorejo-9'])
            ->setCellValue('U15', $t2['L-pulorejo-10'])
            ->setCellValue('V15', $t2['P-pulorejo-10'])
            ->setCellValue('W15', $t2['L-pulorejo-11'])
            ->setCellValue('X15', $t2['P-pulorejo-11'])
            ->setCellValue('Y15', $t2['L-pulorejo-12'])
            ->setCellValue('Z15', $t2['P-pulorejo-12'])

            ->setCellValue('C16', $t2['L-prajuritkulon-1'])
            ->setCellValue('D16', $t2['P-prajuritkulon-1'])
            ->setCellValue('E16', $t2['L-prajuritkulon-2'])
            ->setCellValue('F16', $t2['P-prajuritkulon-2'])
            ->setCellValue('G16', $t2['L-prajuritkulon-3'])
            ->setCellValue('H16', $t2['P-prajuritkulon-3'])
            ->setCellValue('I16', $t2['L-prajuritkulon-4'])
            ->setCellValue('J16', $t2['P-prajuritkulon-4'])
            ->setCellValue('K16', $t2['L-prajuritkulon-5'])
            ->setCellValue('L16', $t2['P-prajuritkulon-5'])
            ->setCellValue('M16', $t2['L-prajuritkulon-6'])
            ->setCellValue('N16', $t2['P-prajuritkulon-6'])
            ->setCellValue('O16', $t2['L-prajuritkulon-7'])
            ->setCellValue('P16', $t2['P-prajuritkulon-7'])
            ->setCellValue('Q16', $t2['L-prajuritkulon-8'])
            ->setCellValue('R16', $t2['P-prajuritkulon-8'])
            ->setCellValue('S16', $t2['L-prajuritkulon-9'])
            ->setCellValue('T16', $t2['P-prajuritkulon-9'])
            ->setCellValue('U16', $t2['L-prajuritkulon-10'])
            ->setCellValue('V16', $t2['P-prajuritkulon-10'])
            ->setCellValue('W16', $t2['L-prajuritkulon-11'])
            ->setCellValue('X16', $t2['P-prajuritkulon-11'])
            ->setCellValue('Y16', $t2['L-prajuritkulon-12'])
            ->setCellValue('Z16', $t2['P-prajuritkulon-12'])

            ->setCellValue('C17', $t2['L-surodinawan-1'])
            ->setCellValue('D17', $t2['P-surodinawan-1'])
            ->setCellValue('E17', $t2['L-surodinawan-2'])
            ->setCellValue('F17', $t2['P-surodinawan-2'])
            ->setCellValue('G17', $t2['L-surodinawan-3'])
            ->setCellValue('H17', $t2['P-surodinawan-3'])
            ->setCellValue('I17', $t2['L-surodinawan-4'])
            ->setCellValue('J17', $t2['P-surodinawan-4'])
            ->setCellValue('K17', $t2['L-surodinawan-5'])
            ->setCellValue('L17', $t2['P-surodinawan-5'])
            ->setCellValue('M17', $t2['L-surodinawan-6'])
            ->setCellValue('N17', $t2['P-surodinawan-6'])
            ->setCellValue('O17', $t2['L-surodinawan-7'])
            ->setCellValue('P17', $t2['P-surodinawan-7'])
            ->setCellValue('Q17', $t2['L-surodinawan-8'])
            ->setCellValue('R17', $t2['P-surodinawan-8'])
            ->setCellValue('S17', $t2['L-surodinawan-9'])
            ->setCellValue('T17', $t2['P-surodinawan-9'])
            ->setCellValue('U17', $t2['L-surodinawan-10'])
            ->setCellValue('V17', $t2['P-surodinawan-10'])
            ->setCellValue('W17', $t2['L-surodinawan-11'])
            ->setCellValue('X17', $t2['P-surodinawan-11'])
            ->setCellValue('Y17', $t2['L-surodinawan-12'])
            ->setCellValue('Z17', $t2['P-surodinawan-12'])

            ->setCellValue('C18', $t2['L-blooto-1'])
            ->setCellValue('D18', $t2['P-blooto-1'])
            ->setCellValue('E18', $t2['L-blooto-2'])
            ->setCellValue('F18', $t2['P-blooto-2'])
            ->setCellValue('G18', $t2['L-blooto-3'])
            ->setCellValue('H18', $t2['P-blooto-3'])
            ->setCellValue('I18', $t2['L-blooto-4'])
            ->setCellValue('J18', $t2['P-blooto-4'])
            ->setCellValue('K18', $t2['L-blooto-5'])
            ->setCellValue('L18', $t2['P-blooto-5'])
            ->setCellValue('M18', $t2['L-blooto-6'])
            ->setCellValue('N18', $t2['P-blooto-6'])
            ->setCellValue('O18', $t2['L-blooto-7'])
            ->setCellValue('P18', $t2['P-blooto-7'])
            ->setCellValue('Q18', $t2['L-blooto-8'])
            ->setCellValue('R18', $t2['P-blooto-8'])
            ->setCellValue('S18', $t2['L-blooto-9'])
            ->setCellValue('T18', $t2['P-blooto-9'])
            ->setCellValue('U18', $t2['L-blooto-10'])
            ->setCellValue('V18', $t2['P-blooto-10'])
            ->setCellValue('W18', $t2['L-blooto-11'])
            ->setCellValue('X18', $t2['P-blooto-11'])
            ->setCellValue('Y18', $t2['L-blooto-12'])
            ->setCellValue('Z18', $t2['P-blooto-12'])

            ->setCellValue('C19', $t2['L-gunung gedangan-1'])
            ->setCellValue('D19', $t2['P-gunung gedangan-1'])
            ->setCellValue('E19', $t2['L-gunung gedangan-2'])
            ->setCellValue('F19', $t2['P-gunung gedangan-2'])
            ->setCellValue('G19', $t2['L-gunung gedangan-3'])
            ->setCellValue('H19', $t2['P-gunung gedangan-3'])
            ->setCellValue('I19', $t2['L-gunung gedangan-4'])
            ->setCellValue('J19', $t2['P-gunung gedangan-4'])
            ->setCellValue('K19', $t2['L-gunung gedangan-5'])
            ->setCellValue('L19', $t2['P-gunung gedangan-5'])
            ->setCellValue('M19', $t2['L-gunung gedangan-6'])
            ->setCellValue('N19', $t2['P-gunung gedangan-6'])
            ->setCellValue('O19', $t2['L-gunung gedangan-7'])
            ->setCellValue('P19', $t2['P-gunung gedangan-7'])
            ->setCellValue('Q19', $t2['L-gunung gedangan-8'])
            ->setCellValue('R19', $t2['P-gunung gedangan-8'])
            ->setCellValue('S19', $t2['L-gunung gedangan-9'])
            ->setCellValue('T19', $t2['P-gunung gedangan-9'])
            ->setCellValue('U19', $t2['L-gunung gedangan-10'])
            ->setCellValue('V19', $t2['P-gunung gedangan-10'])
            ->setCellValue('W19', $t2['L-gunung gedangan-11'])
            ->setCellValue('X19', $t2['P-gunung gedangan-11'])
            ->setCellValue('Y19', $t2['L-gunung gedangan-12'])
            ->setCellValue('Z19', $t2['P-gunung gedangan-12'])

            ->setCellValue('C20', $t2['L-magersari-1'])
            ->setCellValue('D20', $t2['P-magersari-1'])
            ->setCellValue('E20', $t2['L-magersari-2'])
            ->setCellValue('F20', $t2['P-magersari-2'])
            ->setCellValue('G20', $t2['L-magersari-3'])
            ->setCellValue('H20', $t2['P-magersari-3'])
            ->setCellValue('I20', $t2['L-magersari-4'])
            ->setCellValue('J20', $t2['P-magersari-4'])
            ->setCellValue('K20', $t2['L-magersari-5'])
            ->setCellValue('L20', $t2['P-magersari-5'])
            ->setCellValue('M20', $t2['L-magersari-6'])
            ->setCellValue('N20', $t2['P-magersari-6'])
            ->setCellValue('O20', $t2['L-magersari-7'])
            ->setCellValue('P20', $t2['P-magersari-7'])
            ->setCellValue('Q20', $t2['L-magersari-8'])
            ->setCellValue('R20', $t2['P-magersari-8'])
            ->setCellValue('S20', $t2['L-magersari-9'])
            ->setCellValue('T20', $t2['P-magersari-9'])
            ->setCellValue('U20', $t2['L-magersari-10'])
            ->setCellValue('V20', $t2['P-magersari-10'])
            ->setCellValue('W20', $t2['L-magersari-11'])
            ->setCellValue('X20', $t2['P-magersari-11'])
            ->setCellValue('Y20', $t2['L-magersari-12'])
            ->setCellValue('Z20', $t2['P-magersari-12'])

            ->setCellValue('C21', $t2['L-gedongan-1'])
            ->setCellValue('D21', $t2['P-gedongan-1'])
            ->setCellValue('E21', $t2['L-gedongan-2'])
            ->setCellValue('F21', $t2['P-gedongan-2'])
            ->setCellValue('G21', $t2['L-gedongan-3'])
            ->setCellValue('H21', $t2['P-gedongan-3'])
            ->setCellValue('I21', $t2['L-gedongan-4'])
            ->setCellValue('J21', $t2['P-gedongan-4'])
            ->setCellValue('K21', $t2['L-gedongan-5'])
            ->setCellValue('L21', $t2['P-gedongan-5'])
            ->setCellValue('M21', $t2['L-gedongan-6'])
            ->setCellValue('N21', $t2['P-gedongan-6'])
            ->setCellValue('O21', $t2['L-gedongan-7'])
            ->setCellValue('P21', $t2['P-gedongan-7'])
            ->setCellValue('Q21', $t2['L-gedongan-8'])
            ->setCellValue('R21', $t2['P-gedongan-8'])
            ->setCellValue('S21', $t2['L-gedongan-9'])
            ->setCellValue('T21', $t2['P-gedongan-9'])
            ->setCellValue('U21', $t2['L-gedongan-10'])
            ->setCellValue('V21', $t2['P-gedongan-10'])
            ->setCellValue('W21', $t2['L-gedongan-11'])
            ->setCellValue('X21', $t2['P-gedongan-11'])
            ->setCellValue('Y21', $t2['L-gedongan-12'])
            ->setCellValue('Z21', $t2['P-gedongan-12'])

            ->setCellValue('C22', $t2['L-balongsari-1'])
            ->setCellValue('D22', $t2['P-balongsari-1'])
            ->setCellValue('E22', $t2['L-balongsari-2'])
            ->setCellValue('F22', $t2['P-balongsari-2'])
            ->setCellValue('G22', $t2['L-balongsari-3'])
            ->setCellValue('H22', $t2['P-balongsari-3'])
            ->setCellValue('I22', $t2['L-balongsari-4'])
            ->setCellValue('J22', $t2['P-balongsari-4'])
            ->setCellValue('K22', $t2['L-balongsari-5'])
            ->setCellValue('L22', $t2['P-balongsari-5'])
            ->setCellValue('M22', $t2['L-balongsari-6'])
            ->setCellValue('N22', $t2['P-balongsari-6'])
            ->setCellValue('O22', $t2['L-balongsari-7'])
            ->setCellValue('P22', $t2['P-balongsari-7'])
            ->setCellValue('Q22', $t2['L-balongsari-8'])
            ->setCellValue('R22', $t2['P-balongsari-8'])
            ->setCellValue('S22', $t2['L-balongsari-9'])
            ->setCellValue('T22', $t2['P-balongsari-9'])
            ->setCellValue('U22', $t2['L-balongsari-10'])
            ->setCellValue('V22', $t2['P-balongsari-10'])
            ->setCellValue('W22', $t2['L-balongsari-11'])
            ->setCellValue('X22', $t2['P-balongsari-11'])
            ->setCellValue('Y22', $t2['L-balongsari-12'])
            ->setCellValue('Z22', $t2['P-balongsari-12'])

            ->setCellValue('C23', $t2['L-kedundung-1'])
            ->setCellValue('D23', $t2['P-kedundung-1'])
            ->setCellValue('E23', $t2['L-kedundung-2'])
            ->setCellValue('F23', $t2['P-kedundung-2'])
            ->setCellValue('G23', $t2['L-kedundung-3'])
            ->setCellValue('H23', $t2['P-kedundung-3'])
            ->setCellValue('I23', $t2['L-kedundung-4'])
            ->setCellValue('J23', $t2['P-kedundung-4'])
            ->setCellValue('K23', $t2['L-kedundung-5'])
            ->setCellValue('L23', $t2['P-kedundung-5'])
            ->setCellValue('M23', $t2['L-kedundung-6'])
            ->setCellValue('N23', $t2['P-kedundung-6'])
            ->setCellValue('O23', $t2['L-kedundung-7'])
            ->setCellValue('P23', $t2['P-kedundung-7'])
            ->setCellValue('Q23', $t2['L-kedundung-8'])
            ->setCellValue('R23', $t2['P-kedundung-8'])
            ->setCellValue('S23', $t2['L-kedundung-9'])
            ->setCellValue('T23', $t2['P-kedundung-9'])
            ->setCellValue('U23', $t2['L-kedundung-10'])
            ->setCellValue('V23', $t2['P-kedundung-10'])
            ->setCellValue('W23', $t2['L-kedundung-11'])
            ->setCellValue('X23', $t2['P-kedundung-11'])
            ->setCellValue('Y23', $t2['L-kedundung-12'])
            ->setCellValue('Z23', $t2['P-kedundung-12'])

            ->setCellValue('C24', $t2['L-wates-1'])
            ->setCellValue('D24', $t2['P-wates-1'])
            ->setCellValue('E24', $t2['L-wates-2'])
            ->setCellValue('F24', $t2['P-wates-2'])
            ->setCellValue('G24', $t2['L-wates-3'])
            ->setCellValue('H24', $t2['P-wates-3'])
            ->setCellValue('I24', $t2['L-wates-4'])
            ->setCellValue('J24', $t2['P-wates-4'])
            ->setCellValue('K24', $t2['L-wates-5'])
            ->setCellValue('L24', $t2['P-wates-5'])
            ->setCellValue('M24', $t2['L-wates-6'])
            ->setCellValue('N24', $t2['P-wates-6'])
            ->setCellValue('O24', $t2['L-wates-7'])
            ->setCellValue('P24', $t2['P-wates-7'])
            ->setCellValue('Q24', $t2['L-wates-8'])
            ->setCellValue('R24', $t2['P-wates-8'])
            ->setCellValue('S24', $t2['L-wates-9'])
            ->setCellValue('T24', $t2['P-wates-9'])
            ->setCellValue('U24', $t2['L-wates-10'])
            ->setCellValue('V24', $t2['P-wates-10'])
            ->setCellValue('W24', $t2['L-wates-11'])
            ->setCellValue('X24', $t2['P-wates-11'])
            ->setCellValue('Y24', $t2['L-wates-12'])
            ->setCellValue('Z24', $t2['P-wates-12'])

            ->setCellValue('C25', $t2['L-kranggan-1'])
            ->setCellValue('D25', $t2['P-kranggan-1'])
            ->setCellValue('E25', $t2['L-kranggan-2'])
            ->setCellValue('F25', $t2['P-kranggan-2'])
            ->setCellValue('G25', $t2['L-kranggan-3'])
            ->setCellValue('H25', $t2['P-kranggan-3'])
            ->setCellValue('I25', $t2['L-kranggan-4'])
            ->setCellValue('J25', $t2['P-kranggan-4'])
            ->setCellValue('K25', $t2['L-kranggan-5'])
            ->setCellValue('L25', $t2['P-kranggan-5'])
            ->setCellValue('M25', $t2['L-kranggan-6'])
            ->setCellValue('N25', $t2['P-kranggan-6'])
            ->setCellValue('O25', $t2['L-kranggan-7'])
            ->setCellValue('P25', $t2['P-kranggan-7'])
            ->setCellValue('Q25', $t2['L-kranggan-8'])
            ->setCellValue('R25', $t2['P-kranggan-8'])
            ->setCellValue('S25', $t2['L-kranggan-9'])
            ->setCellValue('T25', $t2['P-kranggan-9'])
            ->setCellValue('U25', $t2['L-kranggan-10'])
            ->setCellValue('V25', $t2['P-kranggan-10'])
            ->setCellValue('W25', $t2['L-kranggan-11'])
            ->setCellValue('X25', $t2['P-kranggan-11'])
            ->setCellValue('Y25', $t2['L-kranggan-12'])
            ->setCellValue('Z25', $t2['P-kranggan-12'])

            ->setCellValue('C26', $t2['L-miji-1'])
            ->setCellValue('D26', $t2['P-miji-1'])
            ->setCellValue('E26', $t2['L-miji-2'])
            ->setCellValue('F26', $t2['P-miji-2'])
            ->setCellValue('G26', $t2['L-miji-3'])
            ->setCellValue('H26', $t2['P-miji-3'])
            ->setCellValue('I26', $t2['L-miji-4'])
            ->setCellValue('J26', $t2['P-miji-4'])
            ->setCellValue('K26', $t2['L-miji-5'])
            ->setCellValue('L26', $t2['P-miji-5'])
            ->setCellValue('M26', $t2['L-miji-6'])
            ->setCellValue('N26', $t2['P-miji-6'])
            ->setCellValue('O26', $t2['L-miji-7'])
            ->setCellValue('P26', $t2['P-miji-7'])
            ->setCellValue('Q26', $t2['L-miji-8'])
            ->setCellValue('R26', $t2['P-miji-8'])
            ->setCellValue('S26', $t2['L-miji-9'])
            ->setCellValue('T26', $t2['P-miji-9'])
            ->setCellValue('U26', $t2['L-miji-10'])
            ->setCellValue('V26', $t2['P-miji-10'])
            ->setCellValue('W26', $t2['L-miji-11'])
            ->setCellValue('X26', $t2['P-miji-11'])
            ->setCellValue('Y26', $t2['L-miji-12'])
            ->setCellValue('Z26', $t2['P-miji-12'])

            ->setCellValue('C27', $t2['L-meri-1'])
            ->setCellValue('D27', $t2['P-meri-1'])
            ->setCellValue('E27', $t2['L-meri-2'])
            ->setCellValue('F27', $t2['P-meri-2'])
            ->setCellValue('G27', $t2['L-meri-3'])
            ->setCellValue('H27', $t2['P-meri-3'])
            ->setCellValue('I27', $t2['L-meri-4'])
            ->setCellValue('J27', $t2['P-meri-4'])
            ->setCellValue('K27', $t2['L-meri-5'])
            ->setCellValue('L27', $t2['P-meri-5'])
            ->setCellValue('M27', $t2['L-meri-6'])
            ->setCellValue('N27', $t2['P-meri-6'])
            ->setCellValue('O27', $t2['L-meri-7'])
            ->setCellValue('P27', $t2['P-meri-7'])
            ->setCellValue('Q27', $t2['L-meri-8'])
            ->setCellValue('R27', $t2['P-meri-8'])
            ->setCellValue('S27', $t2['L-meri-9'])
            ->setCellValue('T27', $t2['P-meri-9'])
            ->setCellValue('U27', $t2['L-meri-10'])
            ->setCellValue('V27', $t2['P-meri-10'])
            ->setCellValue('W27', $t2['L-meri-11'])
            ->setCellValue('X27', $t2['P-meri-11'])
            ->setCellValue('Y27', $t2['L-meri-12'])
            ->setCellValue('Z27', $t2['P-meri-12'])

            ->setCellValue('C28', $t2['L-jagalan-1'])
            ->setCellValue('D28', $t2['P-jagalan-1'])
            ->setCellValue('E28', $t2['L-jagalan-2'])
            ->setCellValue('F28', $t2['P-jagalan-2'])
            ->setCellValue('G28', $t2['L-jagalan-3'])
            ->setCellValue('H28', $t2['P-jagalan-3'])
            ->setCellValue('I28', $t2['L-jagalan-4'])
            ->setCellValue('J28', $t2['P-jagalan-4'])
            ->setCellValue('K28', $t2['L-jagalan-5'])
            ->setCellValue('L28', $t2['P-jagalan-5'])
            ->setCellValue('M28', $t2['L-jagalan-6'])
            ->setCellValue('N28', $t2['P-jagalan-6'])
            ->setCellValue('O28', $t2['L-jagalan-7'])
            ->setCellValue('P28', $t2['P-jagalan-7'])
            ->setCellValue('Q28', $t2['L-jagalan-8'])
            ->setCellValue('R28', $t2['P-jagalan-8'])
            ->setCellValue('S28', $t2['L-jagalan-9'])
            ->setCellValue('T28', $t2['P-jagalan-9'])
            ->setCellValue('U28', $t2['L-jagalan-10'])
            ->setCellValue('V28', $t2['P-jagalan-10'])
            ->setCellValue('W28', $t2['L-jagalan-11'])
            ->setCellValue('X28', $t2['P-jagalan-11'])
            ->setCellValue('Y28', $t2['L-jagalan-12'])
            ->setCellValue('Z28', $t2['P-jagalan-12'])

            ->setCellValue('C29', $t2['L-sentanan-1'])
            ->setCellValue('D29', $t2['P-sentanan-1'])
            ->setCellValue('E29', $t2['L-sentanan-2'])
            ->setCellValue('F29', $t2['P-sentanan-2'])
            ->setCellValue('G29', $t2['L-sentanan-3'])
            ->setCellValue('H29', $t2['P-sentanan-3'])
            ->setCellValue('I29', $t2['L-sentanan-4'])
            ->setCellValue('J29', $t2['P-sentanan-4'])
            ->setCellValue('K29', $t2['L-sentanan-5'])
            ->setCellValue('L29', $t2['P-sentanan-5'])
            ->setCellValue('M29', $t2['L-sentanan-6'])
            ->setCellValue('N29', $t2['P-sentanan-6'])
            ->setCellValue('O29', $t2['L-sentanan-7'])
            ->setCellValue('P29', $t2['P-sentanan-7'])
            ->setCellValue('Q29', $t2['L-sentanan-8'])
            ->setCellValue('R29', $t2['P-sentanan-8'])
            ->setCellValue('S29', $t2['L-sentanan-9'])
            ->setCellValue('T29', $t2['P-sentanan-9'])
            ->setCellValue('U29', $t2['L-sentanan-10'])
            ->setCellValue('V29', $t2['P-sentanan-10'])
            ->setCellValue('W29', $t2['L-sentanan-11'])
            ->setCellValue('X29', $t2['P-sentanan-11'])
            ->setCellValue('Y29', $t2['L-sentanan-12'])
            ->setCellValue('Z29', $t2['P-sentanan-12'])

            ->setCellValue('C30', $t2['L-purwotengah-1'])
            ->setCellValue('D30', $t2['P-purwotengah-1'])
            ->setCellValue('E30', $t2['L-purwotengah-2'])
            ->setCellValue('F30', $t2['P-purwotengah-2'])
            ->setCellValue('G30', $t2['L-purwotengah-3'])
            ->setCellValue('H30', $t2['P-purwotengah-3'])
            ->setCellValue('I30', $t2['L-purwotengah-4'])
            ->setCellValue('J30', $t2['P-purwotengah-4'])
            ->setCellValue('K30', $t2['L-purwotengah-5'])
            ->setCellValue('L30', $t2['P-purwotengah-5'])
            ->setCellValue('M30', $t2['L-purwotengah-6'])
            ->setCellValue('N30', $t2['P-purwotengah-6'])
            ->setCellValue('O30', $t2['L-purwotengah-7'])
            ->setCellValue('P30', $t2['P-purwotengah-7'])
            ->setCellValue('Q30', $t2['L-purwotengah-8'])
            ->setCellValue('R30', $t2['P-purwotengah-8'])
            ->setCellValue('S30', $t2['L-purwotengah-9'])
            ->setCellValue('T30', $t2['P-purwotengah-9'])
            ->setCellValue('U30', $t2['L-purwotengah-10'])
            ->setCellValue('V30', $t2['P-purwotengah-10'])
            ->setCellValue('W30', $t2['L-purwotengah-11'])
            ->setCellValue('X30', $t2['P-purwotengah-11'])
            ->setCellValue('Y30', $t2['L-purwotengah-12'])
            ->setCellValue('Z30', $t2['P-purwotengah-12'])

            ->setCellValue('C31', '=SUM(C13:C30)')
            ->setCellValue('D31', '=SUM(D13:D30)')
            ->setCellValue('E31', '=SUM(E13:E30)')
            ->setCellValue('F31', '=SUM(F13:F30)')
            ->setCellValue('G31', '=SUM(G13:G30)')
            ->setCellValue('H31', '=SUM(H13:H30)')
            ->setCellValue('I31', '=SUM(I13:I30)')
            ->setCellValue('J31', '=SUM(J13:J30)')
            ->setCellValue('K31', '=SUM(K13:K30)')
            ->setCellValue('L31', '=SUM(L13:L30)')
            ->setCellValue('M31', '=SUM(M13:M30)')
            ->setCellValue('N31', '=SUM(N13:N30)')
            ->setCellValue('O31', '=SUM(O13:O30)')
            ->setCellValue('P31', '=SUM(P13:P30)')
            ->setCellValue('Q31', '=SUM(Q13:Q30)')
            ->setCellValue('R31', '=SUM(R13:R30)')
            ->setCellValue('S31', '=SUM(S13:S30)')
            ->setCellValue('T31', '=SUM(T13:T30)')
            ->setCellValue('U31', '=SUM(U13:U30)')
            ->setCellValue('V31', '=SUM(V13:V30)')
            ->setCellValue('W31', '=SUM(W13:W30)')
            ->setCellValue('X31', '=SUM(X13:X30)')
            ->setCellValue('Y31', '=SUM(Y13:Y30)')
            ->setCellValue('Z31', '=SUM(Z13:Z30)')

            ->setCellValue('C32', '=SUM(C13:D30)')
            ->setCellValue('E32', '=SUM(E13:F30)')
            ->setCellValue('G32', '=SUM(G13:H30)')
            ->setCellValue('I32', '=SUM(I13:J30)')
            ->setCellValue('K32', '=SUM(K13:L30)')
            ->setCellValue('M32', '=SUM(M13:N30)')
            ->setCellValue('O32', '=SUM(O13:P30)')
            ->setCellValue('Q32', '=SUM(Q13:R30)')
            ->setCellValue('S32', '=SUM(S13:T30)')
            ->setCellValue('U32', '=SUM(U13:V30)')
            ->setCellValue('W32', '=SUM(W13:X30)')
            ->setCellValue('Y32', '=SUM(Y13:Z30)')

            //*--- TABEL 3---*/
            ->setCellValue('A36', 'KECAMATAN')
            ->setCellValue('A38', 'PRAJURITKULON')
            ->setCellValue('A44', 'MAGERSARI')
            ->setCellValue('A50', 'KRANGGAN')
            ->setCellValue('A56', 'JUMLAH')
            ->setCellValue('A57', 'TOTAL')
            ->setCellValue('B36', 'KELURAHAN')
              //Prajurtikulon
            ->setCellValue('B38', 'MENTIKAN')
            ->setCellValue('B39', 'KAUMAN')
            ->setCellValue('B40', 'PULOREJO')
            ->setCellValue('B41', 'PRAJURITKULON')
            ->setCellValue('B42', 'SURODINAWAN')
            ->setCellValue('B43', 'BLOOTO')
               //Magersari
            ->setCellValue('B44', 'GUNUNG GEDANGAN')
            ->setCellValue('B45', 'MAGERSARI')
            ->setCellValue('B46', 'GEDONGAN')
            ->setCellValue('B47', 'BALONGSARI')
            ->setCellValue('B48', 'KEDUNDUNG')
            ->setCellValue('B49', 'WATES')
               //Kranggan
            ->setCellValue('B50', 'KRANGGAN')
            ->setCellValue('B51', 'MIJI')
            ->setCellValue('B52', 'MERI')
            ->setCellValue('B53', 'JAGALAN')
            ->setCellValue('B54', 'SENTANAN')
            ->setCellValue('B55', 'PURWOTENGAH')

            ->setCellValue('C36', 'JAN')
            ->setCellValue('E36', 'FEB')
            ->setCellValue('G36', 'MARET')
            ->setCellValue('I36', 'APRIL')
            ->setCellValue('K36', 'MEI')
            ->setCellValue('M36', 'JUNI')
            ->setCellValue('O36', 'JULI')
            ->setCellValue('Q36', 'AGUSTUS')
            ->setCellValue('S36', 'SEPT')
            ->setCellValue('U36', 'OKT')
            ->setCellValue('W36', 'NOV')
            ->setCellValue('Y36', 'DES')

             //*--- Loop L / P---*/
            ->setCellValue('C37', 'LU')
            ->setCellValue('D37', 'LT')
            ->setCellValue('E37', 'LU')
            ->setCellValue('F37', 'LT')
            ->setCellValue('G37', 'LU')
            ->setCellValue('H37', 'LT')
            ->setCellValue('I37', 'LU')
            ->setCellValue('J37', 'LT')
            ->setCellValue('K37', 'LU')
            ->setCellValue('L37', 'LT')
            ->setCellValue('M37', 'LU')
            ->setCellValue('N37', 'LT')
            ->setCellValue('O37', 'LU')
            ->setCellValue('P37', 'LT')
            ->setCellValue('Q37', 'LU')
            ->setCellValue('R37', 'LT')
            ->setCellValue('S37', 'LU')
            ->setCellValue('T37', 'LT')
            ->setCellValue('U37', 'LU')
            ->setCellValue('V37', 'LT')
            ->setCellValue('W37', 'LU')
            ->setCellValue('X37', 'LT')
            ->setCellValue('Y37', 'LU')
            ->setCellValue('Z37', 'LT')

            ->setCellValue('C38', $t3['LU-mentikan-1'])
            ->setCellValue('D38', $t3['LT-mentikan-1'])
            ->setCellValue('E38', $t3['LU-mentikan-2'])
            ->setCellValue('F38', $t3['LT-mentikan-2'])
            ->setCellValue('G38', $t3['LU-mentikan-3'])
            ->setCellValue('H38', $t3['LT-mentikan-3'])
            ->setCellValue('I38', $t3['LU-mentikan-4'])
            ->setCellValue('J38', $t3['LT-mentikan-4'])
            ->setCellValue('K38', $t3['LU-mentikan-5'])
            ->setCellValue('L38', $t3['LT-mentikan-5'])
            ->setCellValue('M38', $t3['LU-mentikan-6'])
            ->setCellValue('N38', $t3['LT-mentikan-6'])
            ->setCellValue('O38', $t3['LU-mentikan-7'])
            ->setCellValue('P38', $t3['LT-mentikan-7'])
            ->setCellValue('Q38', $t3['LU-mentikan-8'])
            ->setCellValue('R38', $t3['LT-mentikan-8'])
            ->setCellValue('S38', $t3['LU-mentikan-9'])
            ->setCellValue('T38', $t3['LT-mentikan-9'])
            ->setCellValue('U38', $t3['LU-mentikan-10'])
            ->setCellValue('V38', $t3['LT-mentikan-10'])
            ->setCellValue('W38', $t3['LU-mentikan-11'])
            ->setCellValue('X38', $t3['LT-mentikan-11'])
            ->setCellValue('Y38', $t3['LU-mentikan-12'])
            ->setCellValue('Z38', $t3['LT-mentikan-12'])

            ->setCellValue('C39', $t3['LU-kauman-1'])
            ->setCellValue('D39', $t3['LT-kauman-1'])
            ->setCellValue('E39', $t3['LU-kauman-2'])
            ->setCellValue('F39', $t3['LT-kauman-2'])
            ->setCellValue('G39', $t3['LU-kauman-3'])
            ->setCellValue('H39', $t3['LT-kauman-3'])
            ->setCellValue('I39', $t3['LU-kauman-4'])
            ->setCellValue('J39', $t3['LT-kauman-4'])
            ->setCellValue('K39', $t3['LU-kauman-5'])
            ->setCellValue('L39', $t3['LT-kauman-5'])
            ->setCellValue('M39', $t3['LU-kauman-6'])
            ->setCellValue('N39', $t3['LT-kauman-6'])
            ->setCellValue('O39', $t3['LU-kauman-7'])
            ->setCellValue('P39', $t3['LT-kauman-7'])
            ->setCellValue('Q39', $t3['LU-kauman-8'])
            ->setCellValue('R39', $t3['LT-kauman-8'])
            ->setCellValue('S39', $t3['LU-kauman-9'])
            ->setCellValue('T39', $t3['LT-kauman-9'])
            ->setCellValue('U39', $t3['LU-kauman-10'])
            ->setCellValue('V39', $t3['LT-kauman-10'])
            ->setCellValue('W39', $t3['LU-kauman-11'])
            ->setCellValue('X39', $t3['LT-kauman-11'])
            ->setCellValue('Y39', $t3['LU-kauman-12'])
            ->setCellValue('Z39', $t3['LT-kauman-12'])

            ->setCellValue('C40', $t3['LU-pulorejo-1'])
            ->setCellValue('D40', $t3['LT-pulorejo-1'])
            ->setCellValue('E40', $t3['LU-pulorejo-2'])
            ->setCellValue('F40', $t3['LT-pulorejo-2'])
            ->setCellValue('G40', $t3['LU-pulorejo-3'])
            ->setCellValue('H40', $t3['LT-pulorejo-3'])
            ->setCellValue('I40', $t3['LU-pulorejo-4'])
            ->setCellValue('J40', $t3['LT-pulorejo-4'])
            ->setCellValue('K40', $t3['LU-pulorejo-5'])
            ->setCellValue('L40', $t3['LT-pulorejo-5'])
            ->setCellValue('M40', $t3['LU-pulorejo-6'])
            ->setCellValue('N40', $t3['LT-pulorejo-6'])
            ->setCellValue('O40', $t3['LU-pulorejo-7'])
            ->setCellValue('P40', $t3['LT-pulorejo-7'])
            ->setCellValue('Q40', $t3['LU-pulorejo-8'])
            ->setCellValue('R40', $t3['LT-pulorejo-8'])
            ->setCellValue('S40', $t3['LU-pulorejo-9'])
            ->setCellValue('T40', $t3['LT-pulorejo-9'])
            ->setCellValue('U40', $t3['LU-pulorejo-10'])
            ->setCellValue('V40', $t3['LT-pulorejo-10'])
            ->setCellValue('W40', $t3['LU-pulorejo-11'])
            ->setCellValue('X40', $t3['LT-pulorejo-11'])
            ->setCellValue('Y40', $t3['LU-pulorejo-12'])
            ->setCellValue('Z40', $t3['LT-pulorejo-12'])

            ->setCellValue('C41', $t3['LU-prajuritkulon-1'])
            ->setCellValue('D41', $t3['LT-prajuritkulon-1'])
            ->setCellValue('E41', $t3['LU-prajuritkulon-2'])
            ->setCellValue('F41', $t3['LT-prajuritkulon-2'])
            ->setCellValue('G41', $t3['LU-prajuritkulon-3'])
            ->setCellValue('H41', $t3['LT-prajuritkulon-3'])
            ->setCellValue('I41', $t3['LU-prajuritkulon-4'])
            ->setCellValue('J41', $t3['LT-prajuritkulon-4'])
            ->setCellValue('K41', $t3['LU-prajuritkulon-5'])
            ->setCellValue('L41', $t3['LT-prajuritkulon-5'])
            ->setCellValue('M41', $t3['LU-prajuritkulon-6'])
            ->setCellValue('N41', $t3['LT-prajuritkulon-6'])
            ->setCellValue('O41', $t3['LU-prajuritkulon-7'])
            ->setCellValue('P41', $t3['LT-prajuritkulon-7'])
            ->setCellValue('Q41', $t3['LU-prajuritkulon-8'])
            ->setCellValue('R41', $t3['LT-prajuritkulon-8'])
            ->setCellValue('S41', $t3['LU-prajuritkulon-9'])
            ->setCellValue('T41', $t3['LT-prajuritkulon-9'])
            ->setCellValue('U41', $t3['LU-prajuritkulon-10'])
            ->setCellValue('V41', $t3['LT-prajuritkulon-10'])
            ->setCellValue('W41', $t3['LU-prajuritkulon-11'])
            ->setCellValue('X41', $t3['LT-prajuritkulon-11'])
            ->setCellValue('Y41', $t3['LU-prajuritkulon-12'])
            ->setCellValue('Z41', $t3['LT-prajuritkulon-12'])

            ->setCellValue('C42', $t3['LU-surodinawan-1'])
            ->setCellValue('D42', $t3['LT-surodinawan-1'])
            ->setCellValue('E42', $t3['LU-surodinawan-2'])
            ->setCellValue('F42', $t3['LT-surodinawan-2'])
            ->setCellValue('G42', $t3['LU-surodinawan-3'])
            ->setCellValue('H42', $t3['LT-surodinawan-3'])
            ->setCellValue('I42', $t3['LU-surodinawan-4'])
            ->setCellValue('J42', $t3['LT-surodinawan-4'])
            ->setCellValue('K42', $t3['LU-surodinawan-5'])
            ->setCellValue('L42', $t3['LT-surodinawan-5'])
            ->setCellValue('M42', $t3['LU-surodinawan-6'])
            ->setCellValue('N42', $t3['LT-surodinawan-6'])
            ->setCellValue('O42', $t3['LU-surodinawan-7'])
            ->setCellValue('P42', $t3['LT-surodinawan-7'])
            ->setCellValue('Q42', $t3['LU-surodinawan-8'])
            ->setCellValue('R42', $t3['LT-surodinawan-8'])
            ->setCellValue('S42', $t3['LU-surodinawan-9'])
            ->setCellValue('T42', $t3['LT-surodinawan-9'])
            ->setCellValue('U42', $t3['LU-surodinawan-10'])
            ->setCellValue('V42', $t3['LT-surodinawan-10'])
            ->setCellValue('W42', $t3['LU-surodinawan-11'])
            ->setCellValue('X42', $t3['LT-surodinawan-11'])
            ->setCellValue('Y42', $t3['LU-surodinawan-12'])
            ->setCellValue('Z42', $t3['LT-surodinawan-12'])

            ->setCellValue('C43', $t3['LU-blooto-1'])
            ->setCellValue('D43', $t3['LT-blooto-1'])
            ->setCellValue('E43', $t3['LU-blooto-2'])
            ->setCellValue('F43', $t3['LT-blooto-2'])
            ->setCellValue('G43', $t3['LU-blooto-3'])
            ->setCellValue('H43', $t3['LT-blooto-3'])
            ->setCellValue('I43', $t3['LU-blooto-4'])
            ->setCellValue('J43', $t3['LT-blooto-4'])
            ->setCellValue('K43', $t3['LU-blooto-5'])
            ->setCellValue('L43', $t3['LT-blooto-5'])
            ->setCellValue('M43', $t3['LU-blooto-6'])
            ->setCellValue('N43', $t3['LT-blooto-6'])
            ->setCellValue('O43', $t3['LU-blooto-7'])
            ->setCellValue('P43', $t3['LT-blooto-7'])
            ->setCellValue('Q43', $t3['LU-blooto-8'])
            ->setCellValue('R43', $t3['LT-blooto-8'])
            ->setCellValue('S43', $t3['LU-blooto-9'])
            ->setCellValue('T43', $t3['LT-blooto-9'])
            ->setCellValue('U43', $t3['LU-blooto-10'])
            ->setCellValue('V43', $t3['LT-blooto-10'])
            ->setCellValue('W43', $t3['LU-blooto-11'])
            ->setCellValue('X43', $t3['LT-blooto-11'])
            ->setCellValue('Y43', $t3['LU-blooto-12'])
            ->setCellValue('Z43', $t3['LT-blooto-12'])

            ->setCellValue('C44', $t3['LU-gunung gedangan-1'])
            ->setCellValue('D44', $t3['LT-gunung gedangan-1'])
            ->setCellValue('E44', $t3['LU-gunung gedangan-2'])
            ->setCellValue('F44', $t3['LT-gunung gedangan-2'])
            ->setCellValue('G44', $t3['LU-gunung gedangan-3'])
            ->setCellValue('H44', $t3['LT-gunung gedangan-3'])
            ->setCellValue('I44', $t3['LU-gunung gedangan-4'])
            ->setCellValue('J44', $t3['LT-gunung gedangan-4'])
            ->setCellValue('K44', $t3['LU-gunung gedangan-5'])
            ->setCellValue('L44', $t3['LT-gunung gedangan-5'])
            ->setCellValue('M44', $t3['LU-gunung gedangan-6'])
            ->setCellValue('N44', $t3['LT-gunung gedangan-6'])
            ->setCellValue('O44', $t3['LU-gunung gedangan-7'])
            ->setCellValue('P44', $t3['LT-gunung gedangan-7'])
            ->setCellValue('Q44', $t3['LU-gunung gedangan-8'])
            ->setCellValue('R44', $t3['LT-gunung gedangan-8'])
            ->setCellValue('S44', $t3['LU-gunung gedangan-9'])
            ->setCellValue('T44', $t3['LT-gunung gedangan-9'])
            ->setCellValue('U44', $t3['LU-gunung gedangan-10'])
            ->setCellValue('V44', $t3['LT-gunung gedangan-10'])
            ->setCellValue('W44', $t3['LU-gunung gedangan-11'])
            ->setCellValue('X44', $t3['LT-gunung gedangan-11'])
            ->setCellValue('Y44', $t3['LU-gunung gedangan-12'])
            ->setCellValue('Z44', $t3['LT-gunung gedangan-12'])

            ->setCellValue('C45', $t3['LU-magersari-1'])
            ->setCellValue('D45', $t3['LT-magersari-1'])
            ->setCellValue('E45', $t3['LU-magersari-2'])
            ->setCellValue('F45', $t3['LT-magersari-2'])
            ->setCellValue('G45', $t3['LU-magersari-3'])
            ->setCellValue('H45', $t3['LT-magersari-3'])
            ->setCellValue('I45', $t3['LU-magersari-4'])
            ->setCellValue('J45', $t3['LT-magersari-4'])
            ->setCellValue('K45', $t3['LU-magersari-5'])
            ->setCellValue('L45', $t3['LT-magersari-5'])
            ->setCellValue('M45', $t3['LU-magersari-6'])
            ->setCellValue('N45', $t3['LT-magersari-6'])
            ->setCellValue('O45', $t3['LU-magersari-7'])
            ->setCellValue('P45', $t3['LT-magersari-7'])
            ->setCellValue('Q45', $t3['LU-magersari-8'])
            ->setCellValue('R45', $t3['LT-magersari-8'])
            ->setCellValue('S45', $t3['LU-magersari-9'])
            ->setCellValue('T45', $t3['LT-magersari-9'])
            ->setCellValue('U45', $t3['LU-magersari-10'])
            ->setCellValue('V45', $t3['LT-magersari-10'])
            ->setCellValue('W45', $t3['LU-magersari-11'])
            ->setCellValue('X45', $t3['LT-magersari-11'])
            ->setCellValue('Y45', $t3['LU-magersari-12'])
            ->setCellValue('Z45', $t3['LT-magersari-12'])

            ->setCellValue('C46', $t3['LU-gedongan-1'])
            ->setCellValue('D46', $t3['LT-gedongan-1'])
            ->setCellValue('E46', $t3['LU-gedongan-2'])
            ->setCellValue('F46', $t3['LT-gedongan-2'])
            ->setCellValue('G46', $t3['LU-gedongan-3'])
            ->setCellValue('H46', $t3['LT-gedongan-3'])
            ->setCellValue('I46', $t3['LU-gedongan-4'])
            ->setCellValue('J46', $t3['LT-gedongan-4'])
            ->setCellValue('K46', $t3['LU-gedongan-5'])
            ->setCellValue('L46', $t3['LT-gedongan-5'])
            ->setCellValue('M46', $t3['LU-gedongan-6'])
            ->setCellValue('N46', $t3['LT-gedongan-6'])
            ->setCellValue('O46', $t3['LU-gedongan-7'])
            ->setCellValue('P46', $t3['LT-gedongan-7'])
            ->setCellValue('Q46', $t3['LU-gedongan-8'])
            ->setCellValue('R46', $t3['LT-gedongan-8'])
            ->setCellValue('S46', $t3['LU-gedongan-9'])
            ->setCellValue('T46', $t3['LT-gedongan-9'])
            ->setCellValue('U46', $t3['LU-gedongan-10'])
            ->setCellValue('V46', $t3['LT-gedongan-10'])
            ->setCellValue('W46', $t3['LU-gedongan-11'])
            ->setCellValue('X46', $t3['LT-gedongan-11'])
            ->setCellValue('Y46', $t3['LU-gedongan-12'])
            ->setCellValue('Z46', $t3['LT-gedongan-12'])

            ->setCellValue('C47', $t3['LU-balongsari-1'])
            ->setCellValue('D47', $t3['LT-balongsari-1'])
            ->setCellValue('E47', $t3['LU-balongsari-2'])
            ->setCellValue('F47', $t3['LT-balongsari-2'])
            ->setCellValue('G47', $t3['LU-balongsari-3'])
            ->setCellValue('H47', $t3['LT-balongsari-3'])
            ->setCellValue('I47', $t3['LU-balongsari-4'])
            ->setCellValue('J47', $t3['LT-balongsari-4'])
            ->setCellValue('K47', $t3['LU-balongsari-5'])
            ->setCellValue('L47', $t3['LT-balongsari-5'])
            ->setCellValue('M47', $t3['LU-balongsari-6'])
            ->setCellValue('N47', $t3['LT-balongsari-6'])
            ->setCellValue('O47', $t3['LU-balongsari-7'])
            ->setCellValue('P47', $t3['LT-balongsari-7'])
            ->setCellValue('Q47', $t3['LU-balongsari-8'])
            ->setCellValue('R47', $t3['LT-balongsari-8'])
            ->setCellValue('S47', $t3['LU-balongsari-9'])
            ->setCellValue('T47', $t3['LT-balongsari-9'])
            ->setCellValue('U47', $t3['LU-balongsari-10'])
            ->setCellValue('V47', $t3['LT-balongsari-10'])
            ->setCellValue('W47', $t3['LU-balongsari-11'])
            ->setCellValue('X47', $t3['LT-balongsari-11'])
            ->setCellValue('Y47', $t3['LU-balongsari-12'])
            ->setCellValue('Z47', $t3['LT-balongsari-12'])

            ->setCellValue('C48', $t3['LU-kedundung-1'])
            ->setCellValue('D48', $t3['LT-kedundung-1'])
            ->setCellValue('E48', $t3['LU-kedundung-2'])
            ->setCellValue('F48', $t3['LT-kedundung-2'])
            ->setCellValue('G48', $t3['LU-kedundung-3'])
            ->setCellValue('H48', $t3['LT-kedundung-3'])
            ->setCellValue('I48', $t3['LU-kedundung-4'])
            ->setCellValue('J48', $t3['LT-kedundung-4'])
            ->setCellValue('K48', $t3['LU-kedundung-5'])
            ->setCellValue('L48', $t3['LT-kedundung-5'])
            ->setCellValue('M48', $t3['LU-kedundung-6'])
            ->setCellValue('N48', $t3['LT-kedundung-6'])
            ->setCellValue('O48', $t3['LU-kedundung-7'])
            ->setCellValue('P48', $t3['LT-kedundung-7'])
            ->setCellValue('Q48', $t3['LU-kedundung-8'])
            ->setCellValue('R48', $t3['LT-kedundung-8'])
            ->setCellValue('S48', $t3['LU-kedundung-9'])
            ->setCellValue('T48', $t3['LT-kedundung-9'])
            ->setCellValue('U48', $t3['LU-kedundung-10'])
            ->setCellValue('V48', $t3['LT-kedundung-10'])
            ->setCellValue('W48', $t3['LU-kedundung-11'])
            ->setCellValue('X48', $t3['LT-kedundung-11'])
            ->setCellValue('Y48', $t3['LU-kedundung-12'])
            ->setCellValue('Z48', $t3['LT-kedundung-12'])

            ->setCellValue('C49', $t3['LU-wates-1'])
            ->setCellValue('D49', $t3['LT-wates-1'])
            ->setCellValue('E49', $t3['LU-wates-2'])
            ->setCellValue('F49', $t3['LT-wates-2'])
            ->setCellValue('G49', $t3['LU-wates-3'])
            ->setCellValue('H49', $t3['LT-wates-3'])
            ->setCellValue('I49', $t3['LU-wates-4'])
            ->setCellValue('J49', $t3['LT-wates-4'])
            ->setCellValue('K49', $t3['LU-wates-5'])
            ->setCellValue('L49', $t3['LT-wates-5'])
            ->setCellValue('M49', $t3['LU-wates-6'])
            ->setCellValue('N49', $t3['LT-wates-6'])
            ->setCellValue('O49', $t3['LU-wates-7'])
            ->setCellValue('P49', $t3['LT-wates-7'])
            ->setCellValue('Q49', $t3['LU-wates-8'])
            ->setCellValue('R49', $t3['LT-wates-8'])
            ->setCellValue('S49', $t3['LU-wates-9'])
            ->setCellValue('T49', $t3['LT-wates-9'])
            ->setCellValue('U49', $t3['LU-wates-10'])
            ->setCellValue('V49', $t3['LT-wates-10'])
            ->setCellValue('W49', $t3['LU-wates-11'])
            ->setCellValue('X49', $t3['LT-wates-11'])
            ->setCellValue('Y49', $t3['LU-wates-12'])
            ->setCellValue('Z49', $t3['LT-wates-12'])

            ->setCellValue('C50', $t3['LU-kranggan-1'])
            ->setCellValue('D50', $t3['LT-kranggan-1'])
            ->setCellValue('E50', $t3['LU-kranggan-2'])
            ->setCellValue('F50', $t3['LT-kranggan-2'])
            ->setCellValue('G50', $t3['LU-kranggan-3'])
            ->setCellValue('H50', $t3['LT-kranggan-3'])
            ->setCellValue('I50', $t3['LU-kranggan-4'])
            ->setCellValue('J50', $t3['LT-kranggan-4'])
            ->setCellValue('K50', $t3['LU-kranggan-5'])
            ->setCellValue('L50', $t3['LT-kranggan-5'])
            ->setCellValue('M50', $t3['LU-kranggan-6'])
            ->setCellValue('N50', $t3['LT-kranggan-6'])
            ->setCellValue('O50', $t3['LU-kranggan-7'])
            ->setCellValue('P50', $t3['LT-kranggan-7'])
            ->setCellValue('Q50', $t3['LU-kranggan-8'])
            ->setCellValue('R50', $t3['LT-kranggan-8'])
            ->setCellValue('S50', $t3['LU-kranggan-9'])
            ->setCellValue('T50', $t3['LT-kranggan-9'])
            ->setCellValue('U50', $t3['LU-kranggan-10'])
            ->setCellValue('V50', $t3['LT-kranggan-10'])
            ->setCellValue('W50', $t3['LU-kranggan-11'])
            ->setCellValue('X50', $t3['LT-kranggan-11'])
            ->setCellValue('Y50', $t3['LU-kranggan-12'])
            ->setCellValue('Z50', $t3['LT-kranggan-12'])

            ->setCellValue('C51', $t3['LU-miji-1'])
            ->setCellValue('D51', $t3['LT-miji-1'])
            ->setCellValue('E51', $t3['LU-miji-2'])
            ->setCellValue('F51', $t3['LT-miji-2'])
            ->setCellValue('G51', $t3['LU-miji-3'])
            ->setCellValue('H51', $t3['LT-miji-3'])
            ->setCellValue('I51', $t3['LU-miji-4'])
            ->setCellValue('J51', $t3['LT-miji-4'])
            ->setCellValue('K51', $t3['LU-miji-5'])
            ->setCellValue('L51', $t3['LT-miji-5'])
            ->setCellValue('M51', $t3['LU-miji-6'])
            ->setCellValue('N51', $t3['LT-miji-6'])
            ->setCellValue('O51', $t3['LU-miji-7'])
            ->setCellValue('P51', $t3['LT-miji-7'])
            ->setCellValue('Q51', $t3['LU-miji-8'])
            ->setCellValue('R51', $t3['LT-miji-8'])
            ->setCellValue('S51', $t3['LU-miji-9'])
            ->setCellValue('T51', $t3['LT-miji-9'])
            ->setCellValue('U51', $t3['LU-miji-10'])
            ->setCellValue('V51', $t3['LT-miji-10'])
            ->setCellValue('W51', $t3['LU-miji-11'])
            ->setCellValue('X51', $t3['LT-miji-11'])
            ->setCellValue('Y51', $t3['LU-miji-12'])
            ->setCellValue('Z51', $t3['LT-miji-12'])

            ->setCellValue('C52', $t3['LU-meri-1'])
            ->setCellValue('D52', $t3['LT-meri-1'])
            ->setCellValue('E52', $t3['LU-meri-2'])
            ->setCellValue('F52', $t3['LT-meri-2'])
            ->setCellValue('G52', $t3['LU-meri-3'])
            ->setCellValue('H52', $t3['LT-meri-3'])
            ->setCellValue('I52', $t3['LU-meri-4'])
            ->setCellValue('J52', $t3['LT-meri-4'])
            ->setCellValue('K52', $t3['LU-meri-5'])
            ->setCellValue('L52', $t3['LT-meri-5'])
            ->setCellValue('M52', $t3['LU-meri-6'])
            ->setCellValue('N52', $t3['LT-meri-6'])
            ->setCellValue('O52', $t3['LU-meri-7'])
            ->setCellValue('P52', $t3['LT-meri-7'])
            ->setCellValue('Q52', $t3['LU-meri-8'])
            ->setCellValue('R52', $t3['LT-meri-8'])
            ->setCellValue('S52', $t3['LU-meri-9'])
            ->setCellValue('T52', $t3['LT-meri-9'])
            ->setCellValue('U52', $t3['LU-meri-10'])
            ->setCellValue('V52', $t3['LT-meri-10'])
            ->setCellValue('W52', $t3['LU-meri-11'])
            ->setCellValue('X52', $t3['LT-meri-11'])
            ->setCellValue('Y52', $t3['LU-meri-12'])
            ->setCellValue('Z52', $t3['LT-meri-12'])

            ->setCellValue('C53', $t3['LU-jagalan-1'])
            ->setCellValue('D53', $t3['LT-jagalan-1'])
            ->setCellValue('E53', $t3['LU-jagalan-2'])
            ->setCellValue('F53', $t3['LT-jagalan-2'])
            ->setCellValue('G53', $t3['LU-jagalan-3'])
            ->setCellValue('H53', $t3['LT-jagalan-3'])
            ->setCellValue('I53', $t3['LU-jagalan-4'])
            ->setCellValue('J53', $t3['LT-jagalan-4'])
            ->setCellValue('K53', $t3['LU-jagalan-5'])
            ->setCellValue('L53', $t3['LT-jagalan-5'])
            ->setCellValue('M53', $t3['LU-jagalan-6'])
            ->setCellValue('N53', $t3['LT-jagalan-6'])
            ->setCellValue('O53', $t3['LU-jagalan-7'])
            ->setCellValue('P53', $t3['LT-jagalan-7'])
            ->setCellValue('Q53', $t3['LU-jagalan-8'])
            ->setCellValue('R53', $t3['LT-jagalan-8'])
            ->setCellValue('S53', $t3['LU-jagalan-9'])
            ->setCellValue('T53', $t3['LT-jagalan-9'])
            ->setCellValue('U53', $t3['LU-jagalan-10'])
            ->setCellValue('V53', $t3['LT-jagalan-10'])
            ->setCellValue('W53', $t3['LU-jagalan-11'])
            ->setCellValue('X53', $t3['LT-jagalan-11'])
            ->setCellValue('Y53', $t3['LU-jagalan-12'])
            ->setCellValue('Z53', $t3['LT-jagalan-12'])

            ->setCellValue('C54', $t3['LU-sentanan-1'])
            ->setCellValue('D54', $t3['LT-sentanan-1'])
            ->setCellValue('E54', $t3['LU-sentanan-2'])
            ->setCellValue('F54', $t3['LT-sentanan-2'])
            ->setCellValue('G54', $t3['LU-sentanan-3'])
            ->setCellValue('H54', $t3['LT-sentanan-3'])
            ->setCellValue('I54', $t3['LU-sentanan-4'])
            ->setCellValue('J54', $t3['LT-sentanan-4'])
            ->setCellValue('K54', $t3['LU-sentanan-5'])
            ->setCellValue('L54', $t3['LT-sentanan-5'])
            ->setCellValue('M54', $t3['LU-sentanan-6'])
            ->setCellValue('N54', $t3['LT-sentanan-6'])
            ->setCellValue('O54', $t3['LU-sentanan-7'])
            ->setCellValue('P54', $t3['LT-sentanan-7'])
            ->setCellValue('Q54', $t3['LU-sentanan-8'])
            ->setCellValue('R54', $t3['LT-sentanan-8'])
            ->setCellValue('S54', $t3['LU-sentanan-9'])
            ->setCellValue('T54', $t3['LT-sentanan-9'])
            ->setCellValue('U54', $t3['LU-sentanan-10'])
            ->setCellValue('V54', $t3['LT-sentanan-10'])
            ->setCellValue('W54', $t3['LU-sentanan-11'])
            ->setCellValue('X54', $t3['LT-sentanan-11'])
            ->setCellValue('Y54', $t3['LU-sentanan-12'])
            ->setCellValue('Z54', $t3['LT-sentanan-12'])

            ->setCellValue('C55', $t3['LU-purwotengah-1'])
            ->setCellValue('D55', $t3['LT-purwotengah-1'])
            ->setCellValue('E55', $t3['LU-purwotengah-2'])
            ->setCellValue('F55', $t3['LT-purwotengah-2'])
            ->setCellValue('G55', $t3['LU-purwotengah-3'])
            ->setCellValue('H55', $t3['LT-purwotengah-3'])
            ->setCellValue('I55', $t3['LU-purwotengah-4'])
            ->setCellValue('J55', $t3['LT-purwotengah-4'])
            ->setCellValue('K55', $t3['LU-purwotengah-5'])
            ->setCellValue('L55', $t3['LT-purwotengah-5'])
            ->setCellValue('M55', $t3['LU-purwotengah-6'])
            ->setCellValue('N55', $t3['LT-purwotengah-6'])
            ->setCellValue('O55', $t3['LU-purwotengah-7'])
            ->setCellValue('P55', $t3['LT-purwotengah-7'])
            ->setCellValue('Q55', $t3['LU-purwotengah-8'])
            ->setCellValue('R55', $t3['LT-purwotengah-8'])
            ->setCellValue('S55', $t3['LU-purwotengah-9'])
            ->setCellValue('T55', $t3['LT-purwotengah-9'])
            ->setCellValue('U55', $t3['LU-purwotengah-10'])
            ->setCellValue('V55', $t3['LT-purwotengah-10'])
            ->setCellValue('W55', $t3['LU-purwotengah-11'])
            ->setCellValue('X55', $t3['LT-purwotengah-11'])
            ->setCellValue('Y55', $t3['LU-purwotengah-12'])
            ->setCellValue('Z55', $t3['LT-purwotengah-12'])

            ->setCellValue('C56', '=SUM(C38:C55)')
            ->setCellValue('D56', '=SUM(D38:D55)')
            ->setCellValue('E56', '=SUM(E38:E55)')
            ->setCellValue('F56', '=SUM(F38:F55)')
            ->setCellValue('G56', '=SUM(G38:G55)')
            ->setCellValue('H56', '=SUM(H38:H55)')
            ->setCellValue('I56', '=SUM(I38:I55)')
            ->setCellValue('J56', '=SUM(J38:J55)')
            ->setCellValue('K56', '=SUM(K38:K55)')
            ->setCellValue('L56', '=SUM(L38:L55)')
            ->setCellValue('M56', '=SUM(M38:M55)')
            ->setCellValue('N56', '=SUM(N38:N55)')
            ->setCellValue('O56', '=SUM(O38:O55)')
            ->setCellValue('P56', '=SUM(P38:P55)')
            ->setCellValue('Q56', '=SUM(Q38:Q55)')
            ->setCellValue('R56', '=SUM(R38:R55)')
            ->setCellValue('S56', '=SUM(S38:S55)')
            ->setCellValue('T56', '=SUM(T38:T55)')
            ->setCellValue('U56', '=SUM(U38:U55)')
            ->setCellValue('V56', '=SUM(V38:V55)')
            ->setCellValue('W56', '=SUM(W38:W55)')
            ->setCellValue('X56', '=SUM(X38:X55)')
            ->setCellValue('Y56', '=SUM(Y38:Y55)')
            ->setCellValue('Z56', '=SUM(Z38:Z55)')

            ->setCellValue('C57', '=SUM(C38:D55)')
            ->setCellValue('E57', '=SUM(E38:F55)')
            ->setCellValue('G57', '=SUM(G38:H55)')
            ->setCellValue('I57', '=SUM(I38:J55)')
            ->setCellValue('K57', '=SUM(K38:L55)')
            ->setCellValue('M57', '=SUM(M38:N55)')
            ->setCellValue('O57', '=SUM(O38:P55)')
            ->setCellValue('Q57', '=SUM(Q38:R55)')
            ->setCellValue('S57', '=SUM(S38:T55)')
            ->setCellValue('U57', '=SUM(U38:V55)')
            ->setCellValue('W57', '=SUM(W38:X55)')
            ->setCellValue('Y57', '=SUM(Y38:Z55)')
            ;

        $filename =  'DATA KELAHIRAN KOTA MOJOKERTO TAHUN '.$tahun.' - DIUNDUH TGL '. date('Y-m-d');
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