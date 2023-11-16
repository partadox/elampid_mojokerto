<?php
namespace App\Controllers;

use App\Controllers\BaseController;

class Datang extends BaseController
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

        $list_bulan     = $this->list_bulan('datang');
        $list_tahun     = $this->list_tahun('datang');
        $list_kecamatan = $this->kecamatan->list();
        $list_kelurahan = $this->kelurahan->list();

        $kec_select     = NULL;

        if (session('role') == '303AL') {
            $kec        = $this->kelurahan->find_kec(session('idcl'));
            $kec_select = $kec->kec; 
        }

        $data = [
            'title'         => 'Data Kedatangan',
            'modul'	        => $modul,
            'bulan'         => $bulan,
            'tahun'         => $tahun,
            'kecamatan'     => $kecamatan,
            'kelurahan'     => $kelurahan,
            'list_bulan'    => $list_bulan,
            'list_tahun'    => $list_tahun,
            'list_kecamatan'=> $list_kecamatan,
            'list_kelurahan'=> $list_kelurahan,
            'kec_select'    => $kec_select,
        ];
        return view('panel/datang/data/index', $data);
	}

    public function modal()
    {
        if ($this->request->isAJAX()) {

            $id         = $this->request->getVar('id');
            $modal      = $this->request->getVar('modal');
            $datang     = $this->datang->find($id);
            $kecamatan  = $this->kecamatan->list();
            $kelurahan  = $this->kelurahan->list();

            $data = [
                'title'     => 'DATA KEDATANGAN '.$datang['nama'],
                'id'        => $id,
                'modal'     => $modal,
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
                'datang'    => $datang,
            ];
            $msg = [
                'sukses' => view('panel/datang/data/modal', $data)
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

        if (session('role') == '202AC') {
            $kecamatan  = session('idcl');
        }
        if (session('role') == '303AL') {
            $kelurahan  = session('idcl');
            $kec        = $this->kelurahan->find_kec(session('idcl'));
            $kecamatan = $kec->kec; 
        }

        $queryParam = 'bulan=' . $bulan . '&tahun=' . $tahun . '&kecamatan=' . $kecamatan . '&kelurahan=' . $kelurahan;

        $newUrl = '/datang?' . $queryParam; 

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
                'title'         => 'Data Kedatangan',
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
                'data' => view('panel/datang/data/list', $data)
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

            if (session('role') == '202AC') {
                $kecamatan  = session('idcl');
            }
            if (session('role') == '303AL') {
                $kelurahan  = session('idcl');
                $kec        = $this->kelurahan->find_kec(session('idcl'));
                $kecamatan = $kec->kec; 
            }

            $lists 		= $this->datang->get_datatables($bulan, $tahun, $kecamatan, $kelurahan);
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

                $row[] = "<input type=\"checkbox\" name=\"id[]\" class=\"pilihDatang\" value=\"$list->id\">" ." ".$no;
				$row[] = $list->nik;
                $row[] = $list->nama;
                $row[] = $list->alamat;
				$row[] = shortdate_indo($list->tgl_datang);
                $row[] = $list->kecamatan;
                $row[] = $list->kelurahan;
                $row[] = $row_action;

                $data[] = $row;
            }
            $output = [
                "recordTotal"     => $this->datang->count_all(),
                "recordsFiltered" => $this->datang->count_filtered(),
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
                'tgl_datang'=> 'required',
                'no_datang' => 'required',
                'kecamatan' => 'required',
                'kelurahan' => 'required',
                'alamat'    => 'required',
                'kk'        => 'required',
                'asal'      => 'required',
                'no'        => 'required',
                'nik'       => 'required',
                'nama'      => 'required',
                'shbkel'    => 'required',
                'kelamin'   => 'required',
            ];
    
            $errors = [
                'tgl_datang' => [
                    'required'    => 'tgl datang harus diisi.',
                ],
                'no_datang' => [
                    'required'   => 'no datang harus dipilih.',
                ],
                'kecamatan' => [
                    'required'   => 'kecamatan harus dipilih.',
                ],
                'kelurahan' => [
                    'required'   => 'kelurahan harus dipilih.',
                ],
                'alamat' => [
                    'required'   => 'alamat harus dipilih.',
                ],
                'kk' => [
                    'required'   => 'kk harus dipilih.',
                ],
                'asal' => [
                    'required'   => 'asal harus dipilih.',
                ],
                'no' => [
                    'required'   => 'no harus dipilih.',
                ],
                'nik' => [
                    'required'   => 'nik harus dipilih.',
                ],
                'nama' => [
                    'required'   => 'nama harus dipilih.',
                ],
                'shbkel' => [
                    'required'   => 'shbkel harus dipilih.',
                ],
                'kelamin' => [
                    'required'   => 'kelamin harus dipilih.',
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'tgl_datang'    => $validation->getError('tgl_datang'),
                        'no_datang'     => $validation->getError('no_datang'),
                        'kecamatan'     => $validation->getError('kecamatan'),
                        'kelurahan'     => $validation->getError('kelurahan'),
                        'alamat'        => $validation->getError('alamat'),
                        'kk'            => $validation->getError('kk'),
                        'asal'          => $validation->getError('asal'),
                        'no'            => $validation->getError('no'),
                        'nik'           => $validation->getError('nik'),
                        'nama'          => $validation->getError('nama'),
                        'shbkel'        => $validation->getError('shbkel'),
                        'kelamin'       => $validation->getError('kelamin'),
                    ]
                ];
            } else {
                $id = $this->request->getVar('id');
                $updateData = [
                    'tgl_datang'        => $this->request->getVar('tgl_datang'),
                    'no_datang'         => str_replace(' ', '', strtoupper($this->request->getVar('no_datang'))),
                    'kecamatan'         => strtoupper($this->request->getVar('kecamatan')),
                    'kelurahan'         => strtoupper($this->request->getVar('kelurahan')),
                    'alamat'            => strtoupper($this->request->getVar('alamat')),
                    'kk'                => str_replace(' ', '', strtoupper($this->request->getVar('kk'))),
                    'asal'              => strtoupper($this->request->getVar('asal')),
                    'no'                => $this->request->getVar('no'),
                    'nik'               => str_replace(' ', '', strtoupper($this->request->getVar('nik'))),
                    'nama'              => strtoupper($this->request->getVar('nama')),
                    'shbkel'            => strtoupper($this->request->getVar('shbkel')),
                    'kelamin'           => str_replace(' ', '', strtoupper($this->request->getVar('kelamin'))),
                    'edited'            => date('Y-m-d H:i:s'),
                ];
                $this->datang->update($id, $updateData);

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
            $this->datang->delete($id);
                $response = [
                    'success' => true,
                    'icon'    => 'success',
                    'message' => 'Data Berhasil Dihapus.',
                ];
            echo json_encode($response);
        }
    }

    public function deleteSelect()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            try {
                $this->db->transStart(); // Start transaction
    
                if (count($id) != NULL) {
                    foreach ($id as $item) {
                        $this->datang->delete($item);
                    }
                }
    
                $this->db->transCommit(); // Commit transaction if all deletions are successful
    
                $msg = [
                    'success' => "Data berhasil terhapus",
                ];
            } catch (\Exception $e) {
                $this->db->transRollback(); // Rollback transaction on error
    
                $msg = [
                    'error' => 'Terdapat data yang gagal dihapus. Coba lagi...',
                ];
            }
            echo json_encode($msg);
        }
    }
}