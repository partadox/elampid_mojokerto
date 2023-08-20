<?php

namespace App\Controllers;

use App\Models\Model_dt_Datang;
use App\Models\Model_dt_Lahir;
use App\Models\Model_dt_Mati;
use App\Models\Model_dt_Pindah;
use App\Models\Model_Kecamatan;
use App\Models\Model_Kelurahan;
use App\Models\Model_Log;
use App\Models\Model_User;
use App\Models\Model_Visitor;
use CodeIgniter\Controller;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url', 'Tgl_indo', 'reCaptcha'];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		$this->session 		= \Config\Services::session();
		$this->db 			= \Config\Database::connect();
		$this->user 		= new Model_User();
		$this->log 			= new Model_Log();
		$this->visitor		= new Model_Visitor();
		$this->kecamatan	= new Model_Kecamatan();
		$this->kelurahan	= new Model_Kelurahan();
		$this->datang 		= new Model_dt_Datang($request);
		$this->lahir		= new Model_dt_Lahir($request);
		$this->mati 		= new Model_dt_Mati($request);
		$this->pindah 		= new Model_dt_Pindah($request);
	}

	public function list_bulan($modul){
		$tb = 'tb_data_'.$modul;
		$column = 'tgl_'.$modul;
		$query_month = $this->db->query("SELECT DISTINCT EXTRACT(MONTH FROM $tb.$column) AS month_number, DATE_FORMAT($tb.$column, '%M') AS month_name FROM $tb ORDER BY month_number ASC");
		$unique_month = $query_month->getResultArray();
		return $unique_month;
	}

	public function list_tahun($modul){
		$tb = 'tb_data_'.$modul;
		$column = 'tgl_'.$modul;
		$query_year = $this->db->query("SELECT DISTINCT EXTRACT(YEAR FROM $tb.$column) AS year FROM $tb ORDER BY year DESC");
		$unique_year = $query_year->getResultArray();
		return $unique_year;
	}

	public function list_bulan_entri_lahir(){
		$tb = 'tb_data_lahir';
		$column = 'tgl_entri';
		$query_month = $this->db->query("SELECT DISTINCT EXTRACT(MONTH FROM $tb.$column) AS month_number, DATE_FORMAT($tb.$column, '%M') AS month_name FROM $tb ORDER BY month_number ASC");
		$unique_month = $query_month->getResultArray();
		return $unique_month;
	}

	public function list_tahun_entri_lahir(){
		$tb = 'tb_data_lahir';
		$column = 'tgl_entri';
		$query_year = $this->db->query("SELECT DISTINCT EXTRACT(YEAR FROM $tb.$column) AS year FROM $tb ORDER BY year DESC");
		$unique_year = $query_year->getResultArray();
		return $unique_year;
	}
	
}
