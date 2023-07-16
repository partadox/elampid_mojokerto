<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Landing extends BaseController
{
    public function index()
    {
        $data = [
			'title' => 'Dispendukcapil Kota Mojokerto',
		];
        return view('index', $data);
    }
}
