<?php

namespace App\Http\Controllers;

use App\Common\Utils;
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

        $responseHeaders = $request->input('response_headers',null);

        if ($responseHeaders != null) {
            $responseHeaders = json_decode($responseHeaders,true);
            $responseHeaders = $this->formatHeader($responseHeaders);
        }

        $responseBody = $request->input('response_body',null);

        if ($responseBody != null) {
            $responseBody = json_decode($responseBody,true);
            $responseBody = $this->formatBody($responseBody);
        }

        $requestParam = $request->input('api_url',null);

        $params = [];
        $url = $requestParam;

        if (is_string($requestParam)) {
            $andIndex = strpos($requestParam,'?');
            if ($andIndex > 0) {
                $url = substr($requestParam,0,$andIndex);
                $requestParam = substr($requestParam,$andIndex+1);
                $requestParam = explode('&',$requestParam);
                foreach ($requestParam as $param) {
                    $key = explode('=',$param)[0];
                    $params[] = [
                        'param_key' => $key,
                        'param_type' => '',
                        'param_description' => ''
                    ];
                }
            }
        }

        $data = [
            'apiUrl' => $url,
            'apiMethod' => $request->input('api_method',null),
            'requestHeaders' => json_encode($requestHeaders),
            'requestBody' => json_encode($requestBody),
            'requestParam' => json_encode($params),
            'responseHeaders' => json_encode($responseHeaders),
            'responseBody' => json_encode($responseBody),
            'requestExample' => $request->input('request_body',null),
            'responseExample' => $request->input('response_body',null),
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

        // 对象数组默认所有数组中的对象全部同构，只保留第一个

        while(!Utils::is_assoc($body)&&!empty($body)) {
            $body = $body[0];
        }

        foreach ($body as $key =>$value) {
            if ($prefix == '') {
                $formatted[] =[
                    'body_key' => $key,
                    'body_type' => '',
                    'body_description' => ''
                ];
            }else {
                $formatted[] =[
                    'body_key' => $prefix.'.'.$key,
                    'body_type' => '',
                    'body_description' => ''
                ];
            }
            if (Utils::is_assoc($value)) {
                $child = $this->formatBody($value,$key);
                $formatted = array_merge($formatted,$child);
            }
        }

        return $formatted;
    }
}
