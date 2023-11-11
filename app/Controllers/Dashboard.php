<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
	public function index()
	{
		$uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('tahun', $params)) {
            $tahun  = $params['tahun'];
        } else {
			$tahun 	= date('Y');
        }

		$tahun_lahir    = $this->list_tahun('lahir');
		$tahun_mati     = $this->list_tahun('mati');
		$tahun_pindah   = $this->list_tahun('pindah');
		$tahun_datang   = $this->list_tahun('datang');

		$list_tahun 	= [];
		$list_kelamin   = ['LAKI-LAKI', 'PEREMPUAN'];
		$list_kecamatan = $this->kecamatan->list();
		$list_bulan		= range(1, 12);
		

		foreach ($tahun_lahir as $item) {
			if (!in_array($item, $list_tahun, true)) {
				$list_tahun[] = $item;
			}
		}

		foreach ($tahun_mati as $item) {
			if (!in_array($item, $list_tahun, true)) {
				$list_tahun[] = $item;
			}
		}

		foreach ($tahun_pindah as $item) {
			if (!in_array($item, $list_tahun, true)) {
				$list_tahun[] = $item;
			}
		}

		foreach ($tahun_datang as $item) {
			if (!in_array($item, $list_tahun, true)) {
				$list_tahun[] = $item;
			}
		}

		if (session('role') == '707SP' || session('role') == '101DL') {
            $banner = 'Kota Mojokerto'; 
			$Ylahir = $this->lahir->total_tahun($tahun);
			$Tlahir = $this->lahir->total();

			$Ymati = $this->mati->total_tahun($tahun);
			$Tmati = $this->mati->total();

			$Ypindah = $this->pindah->total_tahun($tahun);
			$Tpindah = $this->pindah->total();

			$Ydatang = $this->datang->total_tahun($tahun);
			$Tdatang = $this->datang->total();

			/*--- Chart Lahir Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_kecamatan as $kc) {
					$kec = $kc['idc'];
					foreach ($list_bulan as $month) {
						$result_lahir = $this->lahir->chart_lahir($tahun, $month, $kec, $kelamin);
						$Result_Data[] = [
							'month' 	=> $month,
							'kec' 		=> $kec,
							'kelamin'	=> $kelamin,
							'total'		=> $result_lahir	
						];
					}
				}
			}

			$transformChartLahir = [];

			foreach ($Result_Data as $item) {
				$name = $item['kec'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartLahir as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartLahir[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kec'],
					];
				}
			}
			$lahirChart = json_encode($transformChartLahir);

			/*--- Chart Mati Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_kecamatan as $kc) {
					$kec = $kc['idc'];
					foreach ($list_bulan as $month) {
						$result_mati  = $this->mati->chart_mati($tahun, $month, $kec, $kelamin);
						$Result_Data_Mati[] = [
							'month' 	=> $month,
							'kec' 		=> $kec,
							'kelamin'	=> $kelamin,
							'total'		=> $result_mati	
						];
					}
				}
			}

			$transformChartMati = [];

			foreach ($Result_Data_Mati as $item) {
				$name = $item['kec'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartMati as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartMati[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kec'],
					];
				}
			}
			$matiChart = json_encode($transformChartMati);

			/*--- Chart Pindah Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_kecamatan as $kc) {
					$kec = $kc['idc'];
					foreach ($list_bulan as $month) {
						$result_pindah  = $this->pindah->chart_pindah($tahun, $month, $kec, $kelamin);
						$Result_Data_Pindah[] = [
							'month' 	=> $month,
							'kec' 		=> $kec,
							'kelamin'	=> $kelamin,
							'total'		=> $result_pindah	
						];
					}
				}
			}

			$transformChartPindah = [];

			foreach ($Result_Data_Pindah as $item) {
				$name = $item['kec'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartPindah as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartPindah[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kec'],
					];
				}
			}
			$pindahChart = json_encode($transformChartPindah);

			/*--- Chart Datang Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_kecamatan as $kc) {
					$kec = $kc['idc'];
					foreach ($list_bulan as $month) {
						$result_datang  = $this->datang->chart_datang($tahun, $month, $kec, $kelamin);
						$Result_Data_Datang[] = [
							'month' 	=> $month,
							'kec' 		=> $kec,
							'kelamin'	=> $kelamin,
							'total'		=> $result_datang	
						];
					}
				}
			}

			$transformChartDatang = [];

			foreach ($Result_Data_Datang as $item) {
				$name = $item['kec'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartDatang as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartDatang[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kec'],
					];
				}
			}
			$datangChart = json_encode($transformChartDatang);

        } elseif (session('role') == '202AC') {
			$banner = 'Kecamatan '. session('idcl'); 
			$Ylahir = $this->lahir->total_kec_tahun($tahun,session('idcl'));
			$Tlahir = $this->lahir->total_kec(session('idcl'));

			$Ymati = $this->mati->total_kec_tahun($tahun,session('idcl'));
			$Tmati = $this->mati->total_kec(session('idcl'));

			$Ypindah = $this->pindah->total_kec_tahun($tahun,session('idcl'));
			$Tpindah = $this->pindah->total_kec(session('idcl'));

			$Ydatang = $this->datang->total_kec_tahun($tahun,session('idcl'));
			$Tdatang = $this->datang->total_kec(session('idcl'));

			/*--- Chart Lahir Admin ---*/
			$kec = session('idcl');
			foreach ($list_kelamin as $kelamin) {
				foreach ($list_bulan as $month) {
					$result_lahir = $this->lahir->chart_lahir($tahun, $month, $kec, $kelamin);
					$Result_Data[] = [
						'month' 	=> $month,
						'kec' 		=> $kec,
						'kelamin'	=> $kelamin,
						'total'		=> $result_lahir	
					];
				}
			}

			$transformChartLahir = [];

			foreach ($Result_Data as $item) {
				$name = $item['kec'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartLahir as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartLahir[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kec'],
					];
				}
			}
			$lahirChart = json_encode($transformChartLahir);

			/*--- Chart Mati Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_bulan as $month) {
					$result_mati  = $this->mati->chart_mati($tahun, $month, $kec, $kelamin);
					$Result_Data_Mati[] = [
						'month' 	=> $month,
						'kec' 		=> $kec,
						'kelamin'	=> $kelamin,
						'total'		=> $result_mati	
					];
				}
			}

			$transformChartMati = [];

			foreach ($Result_Data_Mati as $item) {
				$name = $item['kec'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartMati as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartMati[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kec'],
					];
				}
			}
			$matiChart = json_encode($transformChartMati);

			/*--- Chart Pindah Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_bulan as $month) {
					$result_pindah  = $this->pindah->chart_pindah($tahun, $month, $kec, $kelamin);
					$Result_Data_Pindah[] = [
						'month' 	=> $month,
						'kec' 		=> $kec,
						'kelamin'	=> $kelamin,
						'total'		=> $result_pindah	
					];
				}
			}

			$transformChartPindah = [];

			foreach ($Result_Data_Pindah as $item) {
				$name = $item['kec'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartPindah as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartPindah[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kec'],
					];
				}
			}
			$pindahChart = json_encode($transformChartPindah);

			/*--- Chart Datang Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_bulan as $month) {
					$result_datang  = $this->datang->chart_datang($tahun, $month, $kec, $kelamin);
					$Result_Data_Datang[] = [
						'month' 	=> $month,
						'kec' 		=> $kec,
						'kelamin'	=> $kelamin,
						'total'		=> $result_datang	
					];
				}
			}

			$transformChartDatang = [];

			foreach ($Result_Data_Datang as $item) {
				$name = $item['kec'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartDatang as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartDatang[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kec'],
					];
				}
			}
			$datangChart = json_encode($transformChartDatang);
		} elseif (session('role') == '303AL') {
			$banner = 'Kelurahan '. session('idcl');
			$Ylahir = $this->lahir->total_kel_tahun($tahun,session('idcl'));
			$Tlahir = $this->lahir->total_kel(session('idcl')); 

			$Ymati = $this->mati->total_kel_tahun($tahun,session('idcl'));
			$Tmati = $this->mati->total_kel(session('idcl')); 

			$Ypindah = $this->pindah->total_kel_tahun($tahun,session('idcl'));
			$Tpindah = $this->pindah->total_kel(session('idcl')); 

			$Ydatang = $this->datang->total_kel_tahun($tahun,session('idcl'));
			$Tdatang = $this->datang->total_kel(session('idcl')); 

			/*--- Chart Lahir Admin ---*/
			$kel = session('idcl');
			foreach ($list_kelamin as $kelamin) {
				foreach ($list_bulan as $month) {
					$result_lahir = $this->lahir->chart_kel_lahir($tahun, $month, $kel, $kelamin);
					$Result_Data[] = [
						'month' 	=> $month,
						'kel' 		=> $kel,
						'kelamin'	=> $kelamin,
						'total'		=> $result_lahir	
					];
				}
			}

			$transformChartLahir = [];

			foreach ($Result_Data as $item) {
				$name = $item['kel'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartLahir as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartLahir[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kel'],
					];
				}
			}
			$lahirChart = json_encode($transformChartLahir);

			/*--- Chart Mati Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_bulan as $month) {
					$result_mati  = $this->mati->chart_kel_mati($tahun, $month, $kel, $kelamin);
					$Result_Data_Mati[] = [
						'month' 	=> $month,
						'kel' 		=> $kel,
						'kelamin'	=> $kelamin,
						'total'		=> $result_mati	
					];
				}
			}

			$transformChartMati = [];

			foreach ($Result_Data_Mati as $item) {
				$name = $item['kel'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartMati as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartMati[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kel'],
					];
				}
			}
			$matiChart = json_encode($transformChartMati);

			/*--- Chart Pindah Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_bulan as $month) {
					$result_pindah  = $this->pindah->chart_kel_pindah($tahun, $month, $kel, $kelamin);
					$Result_Data_Pindah[] = [
						'month' 	=> $month,
						'kel' 		=> $kel,
						'kelamin'	=> $kelamin,
						'total'		=> $result_pindah	
					];
				}
			}

			$transformChartPindah = [];

			foreach ($Result_Data_Pindah as $item) {
				$name = $item['kel'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartPindah as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartPindah[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kel'],
					];
				}
			}
			$pindahChart = json_encode($transformChartPindah);

			/*--- Chart Datang Admin ---*/

			foreach ($list_kelamin as $kelamin) {
				foreach ($list_bulan as $month) {
					$result_datang  = $this->datang->chart_kel_datang($tahun, $month, $kel, $kelamin);
					$Result_Data_Datang[] = [
						'month' 	=> $month,
						'kel' 		=> $kel,
						'kelamin'	=> $kelamin,
						'total'		=> $result_datang	
					];
				}
			}

			$transformChartDatang = [];

			foreach ($Result_Data_Datang as $item) {
				$name = $item['kel'] . ' (' . $item['kelamin'] . ')';
				$data = $item['total'];

				$found = false;
				foreach ($transformChartDatang as &$entry) {
					if ($entry['name'] === $name) {
						$entry['data'][] = $data;
						$found = true;
						break;
					}
				}

				if (!$found) {
					$transformChartDatang[] = [
						'name' => $name,
						'data' => [$data],
						'stack' => $item['kel'],
					];
				}
			}
			$datangChart = json_encode($transformChartDatang);
		}
		// var_dump($matiChart);
		$data = [
			'title' 	=> 'Dashboard',
			'banner' 	=> $banner,
			'tahun'		=> $tahun,
			'list_tahun'=> $list_tahun,
			'Ylahir'	=> $Ylahir,
			'Tlahir'	=> $Tlahir,
			'Ymati'		=> $Ymati,
			'Tmati'		=> $Tmati,
			'Ypindah'	=> $Ypindah,
			'Tpindah'	=> $Tpindah,
			'Ydatang'	=> $Ydatang,
			'Tdatang'	=> $Tdatang,
			'lahirChart'=> $lahirChart,
			'matiChart' => $matiChart,
			'pindahChart'=> $pindahChart,
			'datangChart'=> $datangChart,
		];
		return view('panel/dashboard', $data);
	}

	public function filter()
    {
        $tahun      = $this->request->getVar('tahun');

        $queryParam = '&tahun=' . $tahun;

        $newUrl = '/dashboard?' . $queryParam; 

        return redirect()->to($newUrl);
    }
}