<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Requests;

class RequestTestController extends Controller
{
    public function getIndex(Request $request)
    {
        return view('request');
    }

    public function sendTestRequest(Request $request)
    {
        $this->validate($request,[
            'url' => 'required|string',
            'method' => 'required|string',
            'headers' => 'required',
//            'body' => 'required'
        ]);

        // 封装请求

        $testRequest = [
            'url' => $request->input('url'),
            'method' => $request->input('method'),
            'headers' => $request->input('headers'),
            'body' => $request->input('body')
        ];

        $testResponse = Requests::request($testRequest['url'],$testRequest['headers'],$testRequest['body'],$testRequest['method']);

//        dd(1);

        dd($testResponse);
    }
}
