<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDocController extends Controller
{
    public function editApiDoc(Request $request)
    {
        $this->validate($request->all(), [
            'api_url' => 'required|string',
            'api_method' => 'required|string',
            'request_headers' => 'required|json',
            'request_body' => 'required|json',
            'response_headers' => 'required|json',
            'response_body' => 'required|json',
        ]);

        return view('apiEdit');
    }

    //
    public function generate(Request $request)
    {

    }

}
