<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
	public function index()
	{

		if (session('role') == '707SP') {
            $banner = 'Kota Mojokerto'; 
			$Ylahir = $this->lahir->total_tahun(date('Y'));
			$Tlahir = $this->lahir->total();

			$Ymati = $this->mati->total_tahun(date('Y'));
			$Tmati = $this->mati->total();

			$Ypindah = $this->pindah->total_tahun(date('Y'));
			$Tpindah = $this->pindah->total();

			$Ydatang = $this->datang->total_tahun(date('Y'));
			$Tdatang = $this->datang->total();

        } elseif (session('role') == '202AC') {
			$banner = 'Kecamatan '. session('idcl'); 
			$Ylahir = $this->lahir->total_kec_tahun(date('Y'),session('idcl'));
			$Tlahir = $this->lahir->total_kec(session('idcl'));

			$Ymati = $this->mati->total_kec_tahun(date('Y'),session('idcl'));
			$Tmati = $this->mati->total_kec(session('idcl'));

			$Ypindah = $this->pindah->total_kec_tahun(date('Y'),session('idcl'));
			$Tpindah = $this->pindah->total_kec(session('idcl'));

			$Ydatang = $this->datang->total_kec_tahun(date('Y'),session('idcl'));
			$Tdatang = $this->datang->total_kec(session('idcl'));
		} elseif (session('role') == '303AL') {
			$banner = 'Kelurahan '. session('idcl');
			$Ylahir = $this->lahir->total_kel_tahun(date('Y'),session('idcl'));
			$Tlahir = $this->lahir->total_kel(session('idcl')); 

			$Ymati = $this->mati->total_kel_tahun(date('Y'),session('idcl'));
			$Tmati = $this->mati->total_kel(session('idcl')); 

			$Ypindah = $this->pindah->total_kel_tahun(date('Y'),session('idcl'));
			$Tpindah = $this->pindah->total_kel(session('idcl')); 

			$Ydatang = $this->datang->total_kel_tahun(date('Y'),session('idcl'));
			$Tdatang = $this->datang->total_kel(session('idcl')); 
		}

		$data = [
			'title' 	=> 'Dashboard',
			'banner' 	=> $banner,
			'Ylahir'	=> $Ylahir,
			'Tlahir'	=> $Tlahir,
			'Ymati'		=> $Ymati,
			'Tmati'		=> $Tmati,
			'Ypindah'	=> $Ypindah,
			'Tpindah'	=> $Tpindah,
			'Ydatang'	=> $Ydatang,
			'Tdatang'	=> $Tdatang,
		];
		return view('panel/dashboard', $data);
	}
}