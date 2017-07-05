<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiDocController extends Controller
{
    public function editApiDoc(Request $request)
    {
//        $this->validate($request->all(), [
//            'api_url' => 'string',
//            'api_method' => 'string',
//            'request_headers' => 'required|json',
//            'request_body' => 'required|json',
//            'response_headers' => 'required|json',
//            'response_body' => 'required|json',
//        ]);

        $requestHeaders = $request->input('request_headers',null);

        if ($requestHeaders != null) {
            $requestHeaders = json_decode($requestHeaders,true);
            $requestHeaders = $this->formatHeader($requestHeaders);
        }

        $requestBody = $request->input('request_body',null);

        if ($requestBody != null) {
            $requestBody = json_decode($requestBody,true);
            $requestBody = $this->formatBody($requestBody);
        }

        $data = [
            'apiUrl' => $request->input('api_url',null),
            'apiMethod' => $request->input('api_method',null),
            'requestHeaders' => json_encode($requestHeaders),
            'requestBody' => json_encode($requestBody),
            'requestParam' => '',
            'responseHeaders' => '',
            'responseBody' => '',
            'requestExample' => '',
            'responseExample' => ''
        ];

        return view('apiEdit',$data);
    }

    //
    public function generate(Request $request)
    {

    }

    private function formatHeader($headers)
    {
        $formatted = [];
        foreach ($headers as $key => $value) {
            $formatted[] = [
                'header_key' => $key,
                'header_type' => '',
                'header_description' => ''
            ];
        }

        return $formatted;
    }

    private function formatBody(array $body,string $prefix='')
    {
        $formatted = [];
        foreach ($body as $key =>$value) {
//            if (is_array($value)) {
//                array_push($formatted,$this->formatBody($body,$key));
//            }
            $formatted[] =[
                'body_key' => $prefix.$key,
                'body_type' => '',
                'body_description' => ''
            ];
        }
        return $formatted;
    }
}
