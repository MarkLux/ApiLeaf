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
//        $this->validate($request,[
//            'url' => 'required|string',
//            'method' => 'required|string',
//            'headers' => 'required|JSON',
//            'body' => 'JSON'
//        ]);

        // 封装请求

        $testRequest = [
            'url' => $request->input('url'),
            'method' => $request->input('method'),
            'headers' => json_decode($request->input('headers'),true),
            'body' => $request->input('body')
        ];

        $testResponse = Requests::request($testRequest['url'],$testRequest['headers'],$testRequest['body'],$testRequest['method']);

        // Requests返回的headers不能直接当数组返回，只得拆一下包

        $headers = [];
        foreach ($testResponse->headers as $key => $value) {
            $headers[$key] = $value;
        }

        return response()->json([
            'code' => 0,
            'response' => [
                'status_code' => $testResponse->status_code,
                'headers' => $headers,
                'body' => json_decode($testResponse->body)
            ]
        ]);
    }
}
