<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Mati extends BaseController
{
    /*--- FRONT ---*/
	public function index()
	{
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 4 && array_key_exists('bulan', $params) && array_key_exists('tahun', $params) && array_key_exists('kecamatan', $params) && array_key_exists('kelurahan', $params)) {
            $modul           = 'Filter';
            $bulan           = $params['bulan'];
            $tahun           = $params['tahun'];
            $kecamatan       = $params['kecamatan'];
            $kelurahan       = $params['kelurahan'];

            // $list_bulan      = $this->list_bulan('lahir');
            // $list_tahun      = $this->list_tahun('lahir');
            // $list_kecamatan  = $this->kecamatan->list();
            // $list_kelurahan  = $this->kelurahan->list_only_kelurahan();

            // array_unshift($list_bulan, ['month_number' => 'all', 'month_name' => 'all']);
            // array_unshift($list_tahun, ['year' => 'all']);
            // array_unshift($list_kecamatan, ['idc' => 'all']);

            // if (!in_array($bulan, $list_bulan) ||  !in_array($tahun, $list_tahun) || !in_array($kecamatan, $list_kecamatan) || !in_array($kelurahan, $list_kelurahan) ) {
            //     $modul           = '';
            //     $bulan           = NULL;
            //     $tahun           = NULL;
            //     $kecamatan       = NULL;
            //     $kelurahan       = NULL;
            // }
        } else {
            $modul           = '';
            $bulan           = NULL;
            $tahun           = NULL;
            $kecamatan       = NULL;
            $kelurahan       = NULL;
        }

        $list_bulan     = $this->list_bulan('mati');
        $list_tahun     = $this->list_tahun('mati');
        $list_kecamatan = $this->kecamatan->list();
        $list_kelurahan = $this->kelurahan->list();

        $data = [
            'title'         => 'Data Kematian',
            'modul'	        => $modul,
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'kecamatan'     => $kecamatan,
            'kelurahan'     => $kelurahan,
            'list_bulan'    => $list_bulan,
            'list_tahun'    => $list_tahun,
            'list_kecamatan'=> $list_kecamatan,
            'list_kelurahan'=> $list_kelurahan,
        ];
        return view('panel/mati/data/index', $data);
	}

    public function modal()
    {
        if ($this->request->isAJAX()) {

            $id         = $this->request->getVar('id');
            $modal      = $this->request->getVar('modal');
            $mati       = $this->mati->find($id);
            $kecamatan  = $this->kecamatan->list();
            $kelurahan  = $this->kelurahan->list();

            $data = [
                'title'     => 'DATA KEMATIAN '.$mati['nama'],
                'id'        => $id,
                'modal'     => $modal,
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
                'mati'      => $mati,
            ];
            $msg = [
                'sukses' => view('panel/mati/data/modal', $data)
            ];
            echo json_encode($msg);
        }
    }

    /*--- BACK ---*/
    public function filter()
    {
        $bulan      = $this->request->getVar('bulan'); 
        $tahun      = $this->request->getVar('tahun');
        $kecamatan  = $this->request->getVar('kecamatan');
        $kelurahan  = $this->request->getVar('kelurahan');

        $queryParam = 'bulan=' . $bulan . '&tahun=' . $tahun . '&kecamatan=' . $kecamatan . '&kelurahan=' . $kelurahan;

        $newUrl = '/mati?' . $queryParam; 

        return redirect()->to($newUrl);
    }

    public function list()
    {
        if ($this->request->isAJAX()) {
            $bulan      = $this->request->getVar('bulan'); 
            $tahun      = $this->request->getVar('tahun');
            $kecamatan  = $this->request->getVar('kecamatan');
            $kelurahan  = $this->request->getVar('kelurahan');

            if ($bulan == 'all') {
                $teks_bulan = '';
            }else {
                $teks_bulan = 'BULAN '.$bulan;
            }

            if ($tahun == 'all') {
                $teks_tahun = '';
            }else {
                $teks_tahun = 'TAHUN '.$tahun;
            }

            if ($kecamatan == 'all') {
                $teks_kecamatan = '';
            }else {
                $teks_kecamatan = 'KEC. '.$kecamatan;
            }

            if ($kelurahan == 'all') {
                $teks_kelurahan = '';
            }else {
                $teks_kelurahan = 'KEL. '.$kelurahan;
            }

            $data = [
                'title'         => 'Data Kematian',
                'modul'	        => 'Filter',
                'bulan'         => $bulan,
                'tahun'         => $tahun,
                'kecamatan'     => $kecamatan,
                'kelurahan'     => $kelurahan,
                'teks_bulan'    => $teks_bulan,
                'teks_tahun'    => $teks_tahun,
                'teks_kecamatan'=> $teks_kecamatan,
                'teks_kelurahan'=> $teks_kelurahan,
            ];
            $msg = [
                'data' => view('panel/mati/data/list', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function fetch()
    {
        if ($this->request->isAJAX()) {
            $bulan      = $this->request->getVar('bulan'); 
            $tahun      = $this->request->getVar('tahun');
            $kecamatan  = $this->request->getVar('kecamatan');
            $kelurahan  = $this->request->getVar('kelurahan');

            $lists 		= $this->mati->get_datatables($bulan, $tahun, $kecamatan, $kelurahan);
            $data 		= [];
            $no 		= $this->request->getPost('start');

            $role       = session('role');

            foreach ($lists as $list) {
                $no++;

                $btn_info = "<button type=\"button\" class=\"btn btn-sm btn-info mb-2\" onclick=\"info('$list->id')\" ><i class=\" bx bx-info-circle\"></i></button>";
                $btn_edit = "<button type=\"button\" class=\"btn btn-sm btn-warning mb-2\" onclick=\"edit('$list->id')\" ><i class=\" bx bx-edit\"></i></button>";
                $btn_hapus = "<button type=\"button\" class=\"btn btn-sm btn-danger mb-2\" onclick=\"hapus('$list->id','$list->nama')\" ><i class=\" bx bx-trash\"></i></button>";

                if ($role == '707SP') {
                    $row_action = $btn_info.' '.$btn_edit.' '.$btn_hapus;
                } else{
                    $row_action = $btn_info;
                }

                $row = [];

                $row[] = $no;
				$row[] = $list->nik;
                $row[] = $list->nama;
				$row[] = shortdate_indo($list->tgl_mati);
                $row[] = $list->akta;
                // $row[] = $list->kecamatan;
                // $row[] = $list->kelurahan;
                $row[] = $row_action;

                $data[] = $row;
            }
            $output = [
                "recordTotal"     => $this->mati->count_all(),
                "recordsFiltered" => $this->mati->count_filtered(),
                "data"            => $data,
            ];
            echo json_encode($output);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'akta'          => 'required',
                'nik'           => 'required',
                'nama'          => 'required',
                'kelamin'       => 'required',
                'tgl_mati'     => 'required',
                'tgl_aju'     => 'required',
                'kecamatan'     => 'required',
                'kelurahan'     => 'required',
            ];
    
            $errors = [
                'tgl_aju' => [
                    'required'    => 'tgl pengajuan harus diisi.',
                ],
                'kecamatan' => [
                    'required'   => 'kecamatan harus dipilih.',
                ],
                'kelurahan' => [
                    'required'   => 'kelurahan harus dipilih.',
                ],
                'akta' => [
                    'required'   => 'akta harus dipilih.',
                ],
                'nik' => [
                    'required'   => 'nik harus dipilih.',
                ],
                'nama' => [
                    'required'   => 'nama harus dipilih.',
                ],
                'tempat_mati' => [
                    'required'   => 'tempat mati harus dipilih.',
                ],
                'kelamin' => [
                    'required'   => 'kelamin harus dipilih.',
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'tgl_aju'       => $validation->getError('tgl_aju'),
                        'kecamatan'     => $validation->getError('kecamatan'),
                        'kelurahan'     => $validation->getError('kelurahan'),
                        'akta'          => $validation->getError('akta'),
                        'nik'           => $validation->getError('nik'),
                        'nama'          => $validation->getError('nama'),
                        'tgl_mati'      => $validation->getError('tgl_mati'),
                        'kelamin'       => $validation->getError('kelamin'),
                    ]
                ];
            } else {
                $id = $this->request->getVar('id');
                $updateData = [
                    'tgl_aju'           => $this->request->getVar('tgl_aju'),
                    'kecamatan'         => strtoupper($this->request->getVar('kecamatan')),
                    'kelurahan'         => strtoupper($this->request->getVar('kelurahan')),
                    'akta'              => str_replace(' ', '', strtoupper($this->request->getVar('akta'))),
                    'nik'               => str_replace(' ', '', strtoupper($this->request->getVar('nik'))),
                    'nama'              => strtoupper($this->request->getVar('nama')),
                    'tgl_mati'          => $this->request->getVar('tgl_mati'),
                    'kelamin'           => str_replace(' ', '', strtoupper($this->request->getVar('kelamin'))),
                    'edited'            => date('Y-m-d H:i:s'),
                ];
                $this->mati->update($id, $updateData);

                $response = [
                    'success' => true,
                    'icon'    => 'success',
                    'message' => 'Data Berhasil Diupdate.',
                ];
            }
            echo json_encode($response);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $id  = $this->request->getVar('id');
            $this->mati->delete($id);
                $response = [
                    'success' => true,
                    'icon'    => 'success',
                    'message' => 'Data Berhasil Dihapus.',
                ];
            echo json_encode($response);
        }
    }
}