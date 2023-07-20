<?php

namespace App\Controllers;

use Config\Services;

class User extends BaseController
{

    public function index()
    {
        $data = [
            'title' => 'Halaman User Management'
        ];
        return view('panel/user/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'IKM',
                'list'  => $this->user->list()


            ];
            $msg = [
                'data' => view('panel/user/list', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'title'     => 'Form Input User Baru',
                'kecamatan' => $this->kecamatan->list(),
            ];
            $msg = [
                'data' => view('panel/user/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required|is_unique[tb_user.username]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => 'sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'password' => [
                    'label' => 'Password',
                    'rules' => 'trim|required|min_length[8]|regex_match[/^((?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20})$/]',
                    'errors' => [
                        'required'                      => '{field} tidak boleh kosong',
                        'min_length'                    => '{field} minimal harus 8 karakter',
                        'regex_match'                   => '{field} password harus kombinasi dari huruf kecil, huruf kapital, angka, dan simbol'
                    ]
                ],
                'role' => [
                    'label' => 'role',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'username'  => $validation->getError('username'),
                        'nama'      => $validation->getError('nama'),
                        'password'  => $validation->getError('password'),
                        'role'      => $validation->getError('role'),   
                    ]
                ];
            } else {
                $password = $this->request->getVar('password');
                $kecamatan= NULL;
                if ($this->request->getVar('role') == "202AC") {
                    $kecamatan = $this->request->getVar('kecamatan');
                    $uid_code  = 'C';
                } elseif ($this->request->getVar('role') == "707SP") {
                    $uid_code  = 'S';
                }
                $last_user= $this->user->orderBy('uid', 'desc')->first();
                $last_num = substr($last_user['uid'], -4); // get last 4 char
                $num      = $last_num + 1; // add 1
                $uid_num  = str_pad($num,4,"0",STR_PAD_LEFT); // get 0000X, -> x is result from summary
                $uid      = $uid_code.$uid_num; // join prefix with result
                $nama     = strtoupper($this->request->getVar('nama'));
                $username = $this->request->getVar('username');
                $password = (password_hash($password,PASSWORD_BCRYPT));
                $role     = $this->request->getVar('role');
                $idcl     = $kecamatan;
                $sql = "INSERT INTO tb_user (uid, nama, username, password, role, idcl) VALUES ('$uid', '$nama', '$username', '$password', '$role', '$idcl')";
                $this->db->query($sql);

                $msg = [
                    'sukses' => [
                        'link' => '/auth-user'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $uid = $this->request->getVar('uid');
            $user =  $this->user->find($uid);
            $data = [
                'title'      => 'Form Edit User',
                'uid'        => $user['uid'],
                'username'   => $user['username'],
                'nama'       => $user['nama'],
            ];
            $msg = [
                'sukses' => view('panel/user/edit', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function formedit_pass()
    {
        if ($this->request->isAJAX()) {
            $uid = $this->request->getVar('uid');
            $user =  $this->user->find($uid);
            $data = [
                'title'      => 'Form Edit Password',
                'uid'    => $user['uid'],
            ];
            $msg = [
                'sukses' => view('panel/user/edit_pass', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'username' => [
                    'label' => 'Username',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => 'sudah ada yang menggunakan {field} ini',
                    ]
                ],
                'nama' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                    $msg = [
                        'error' => [
                            'username'  => $validation->getError('username'),
                            'nama'      => $validation->getError('nama'),   
                        ]
                    ];
            } else {

                $update_data = [
                    'username'     => $this->request->getVar('username'),
                    'nama'         => strtoupper($this->request->getVar('nama')),
                ];

                $uid = $this->request->getVar('uid');
                $this->user->update($uid, $update_data);

                $msg = [
                    'sukses' => [
                        'link' => '/auth-user'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function update_pass()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'password' => [
                    'label' => 'Password',
                    'rules' => 'trim|required|min_length[8]|regex_match[/^((?=.*\\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20})$/]',
                    'errors' => [
                        'required'                      => '{field} tidak boleh kosong',
                        'min_length'                    => '{field} minimal harus 8 karakter',
                        'regex_match'                   => '{field} password harus kombinasi dari huruf kecil, huruf kapital, angka, dan simbol'
                    ]
                ]
            ]);
            if (!$valid) {
                    $msg = [
                        'error' => [
                            'password'  => $validation->getError('password'),
                        ]
                    ];
            } else {

                $password = $this->request->getVar('password');
                $update_data = [
                    'password'     => (password_hash($password, PASSWORD_BCRYPT)),
                ];

                $uid = $this->request->getVar('uid');
                $this->user->update($uid, $update_data);

                $msg = [
                    'sukses' => [
                        'link' => '/auth-user'
                    ]
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $uid = $this->request->getVar('uid');

            $this->user->delete($uid);

            $msg = [
                'sukses' => [
                    'link' => '/auth-user'
                ]
            ];
            echo json_encode($msg);
        }
    }

}
