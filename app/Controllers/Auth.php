<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\JWTCI4;
class Auth extends BaseController
{

	public function login()
	{
		if (session('login')) {
            return redirect()->to('/dashboard');
        }
        $data = [
            'site_key' => getenv('recaptchaKey'),
            'title' => 'Login'
        ];
        return view('auth/login', $data);
	}

    private function validateRecaptcha($recaptchaResponse)
    {
        $secret = getenv('recaptchaSecret');
        $credential = array(
            'secret' => $secret,
            'response' => $recaptchaResponse
        );

        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
        curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
        $responseData = json_decode($response, true);
        return $responseData['success'];
    }

	public function dologin()
	{
		if( !$this->validate([
			'user_username' 	=> 'required',
			'user_password' 	=> 'required',
		]))
		{
			return $this->response->setJSON(
                [
                    'success' => false,
                    'code'    => '422',
                    'data'    => null, 
                    'message' => 'Username dan Password Harus Terisi.'
                ]);
		}
		$user       = $this->user->where('username', $this->request->getVar('user_username'))->first();
		if( $user )
		{
            $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));

			if( password_verify($this->request->getVar('user_password'), $user['password']) && $this->validateRecaptcha($recaptchaResponse))
			{
                $simpan_session = [
                    'login'     => true,
                    'uid'       => $user['uid'],
                    'nama'      => $user['nama'],
                    'role'      => $user['role'],
                    'idlc'      => $user['idcl'],
                ];

                $this->session->set($simpan_session);

                return $this->response->setJSON( 
                    [
                        'success' => true,
                        'code'    => '200',
                        'data'    => [
                            'link' => 'dashboard',
                            'icon' => 'success',
                        ], 
                        'message' => 'Berhasil, Redirect...',  
                    ]);
			} else {
                return $this->response->setJSON( 
                    [
                        'success' => true,
                        'code'    => '200',
                        'data'    => [
                            'link' => 'login',
                            'icon' => 'warning',
                        ], 
                        'message' => 'Invalid Authorization and Please Check Captcha.',  
                    ]);
            }
		}else{

			return $this->response->setJSON( 
                [
                    'success' => false,
                    'code'    => '403',
                    'data'    => null, 
                    'message' => 'Invalid Authorization and Please Check Captcha.', 
                    ]);
		}
		
		
	}

    public function logout()
    {
        if ($this->request->isAJAX()) {

            $this->session->destroy();

            $response = [
                'success' => true,
                'code'    => '200',
                'data'    => [
                    'link' => '/login'
                ], 
                'message' => 'Berhasil, Redirect...', 
            ];

            echo json_encode($response);
        }
        
    }
	
}