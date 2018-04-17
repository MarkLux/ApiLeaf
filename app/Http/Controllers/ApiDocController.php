<?php

namespace App\Http\Controllers;

use App\Common\Utils;
use App\ViewComposer\CollectionHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiDocController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('renderDoc');
    }

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

        $requestHeaders = $request->input('request_headers', null);

        if ($requestHeaders != null) {
            $requestHeaders = json_decode($requestHeaders, true);
            $requestHeaders = $this->formatHeader($requestHeaders);
        }

        $requestBody = $request->input('request_body', null);

        if ($requestBody != null) {
            $requestBody = json_decode($requestBody, true);
            $requestBody = $this->formatBody($requestBody);
        }

        $responseHeaders = $request->input('response_headers', null);

        if ($responseHeaders != null) {
            $responseHeaders = json_decode($responseHeaders, true);
            $responseHeaders = $this->formatHeader($responseHeaders);
        }

        $responseBody = $request->input('response_body', null);

        if ($responseBody != null) {
            $responseBody = json_decode($responseBody, true);
            $responseBody = $this->formatBody($responseBody);
        }

        $requestParam = $request->input('api_url', null);

        $params = [];
        $url = $requestParam;

        if (is_string($requestParam)) {
            $andIndex = strpos($requestParam, '?');
            if ($andIndex > 0) {
                $url = substr($requestParam, 0, $andIndex);
                $requestParam = substr($requestParam, $andIndex + 1);
                $requestParam = explode('&', $requestParam);
                foreach ($requestParam as $param) {
                    $key = explode('=', $param)[0];
                    $params[] = [
                        'param_key' => $key,
                        'param_type' => $this->getValueType($key),
                        'param_description' => ''
                    ];
                }
            }
        }

        $data = [
            'apiUrl' => $url,
            'apiMethod' => $request->input('api_method', null),
            'requestHeaders' => json_encode($requestHeaders),
            'requestBody' => json_encode($requestBody),
            'requestParam' => json_encode($params),
            'responseHeaders' => json_encode($responseHeaders),
            'responseBody' => json_encode($responseBody),
            'requestExample' => $request->input('request_body', null),
            'responseExample' => $request->input('response_body', null),
            'apiTag' => '',
        ];

        return view('api_edit', $data);
    }

    /*
     * 将数据保存到数据库
     */

    public function generate(Request $request, CollectionHelper $helper)
    {
        $this->validate($request, [
            'api_url' => 'required',
            'api_name' => 'required',
            'api_method' => 'required',
            'api_request_headers' => 'json',
            'api_request_body' => 'json',
            'api_request_params' => 'json',
            'api_response_headers' => 'json',
            'api_response_body' => 'json',
            'api_response_example' => 'json',
            'api_request_example' => 'json',
            'collection_id' => 'required|integer',
            'api_tag' => 'string'
        ]);

        if (!$helper->canUserAccess($request['collection_id'])) {
            return view('errors.503');
        }

        $apiInfo = $request->all();
        $apiInfo['user_id'] = $request->user()->id;
        $apiInfo['created_at'] = $request['updated_at'] = Carbon::now();

        $apiId = DB::table('api_infos')->insertGetId($apiInfo);

        $api = DB::table('api_infos')->where('id', $apiId)->get(['*'])->first();

        $data = [
            'apiId' => $api->id,
            'apiName' => $api->api_name,
            'apiUrl' => $api->api_url,
            'apiDescription' => $api->api_description,
            'apiMethod' => $api->api_method,
            'apiTag' => $api->api_tag,
            'requestHeaders' => json_decode($api->request_headers, true),
            'requestBody' => json_decode($api->request_body, true),
            'requestParams' => json_decode($api->request_params, true),
            'requestExample' => $api->request_example,
            'responseHeaders' => json_decode($api->response_headers, true),
            'responseBody' => json_decode($api->response_body, true),
            'responseExample' => $api->response_example,
            'collectionId' => $api->collection_id,
            'message' => '文档已生成'
        ];

        return view('item_preview', $data);

    }

    public function renderDoc(Request $request, int $collectionId, CollectionHelper $helper)
    {
        $validator = Validator::make($request->all(), [
            'order_by' => 'string',
            'order' => 'string',
            'tag' => 'string'
        ]);

        if ($validator->fails()) {
            return view('errors.503');
        }

        $collectionInfo = DB::table('api_collections')
            ->where('id', $collectionId)
            ->first();

        if ($collectionInfo == null) {
            return view('errors.404');
        }

        if (Auth::check()) {
            // 检查是否已经收藏
            $favor = DB::table('api_favors')->where([
                'collection_id' => $collectionId,
                'user_id' => Auth::user()->id
            ])->first();
            if ($favor != null) {
                $collectionInfo->isFavor = true;
            }
        }

        // 组织生成目录
        $tags = DB::table('api_infos')->where('collection_id', $collectionId)->select(DB::raw('distinct api_tag'))->get();

//        dd(array_values($tags->toArray()));

        $builder = DB::table('api_infos')
            ->where('collection_id', $collectionId);

        if (isset($request->tag)) {
            if ($request->tag == 'null') {
                $builder = $builder->where('api_tag', null);
            } else {
                $builder = $builder->where('api_tag', $request->tag);
            }
        }

        $orderBy = $request->input('order_by', 'api_tag');
        $order = $request->input('order', 'asc');

        $builder->orderBy($orderBy, $order);

        $apiInfos = $builder->get();

        foreach ($apiInfos as $api) {
            $api->request_params = json_decode($api->request_params, true);
            $api->request_headers = json_decode($api->request_headers, true);
            $api->request_body = json_decode($api->request_body, true);
            $api->response_headers = json_decode($api->response_headers, true);
            $api->response_body = json_decode($api->response_body, true);

        }

        return view('apidoc', [
            'collectionInfo' => $collectionInfo,
            'apiInfos' => $apiInfos,
            'tags' => array_values($tags->toArray()),
            'editMenuOn' => $helper->canUserAccess($collectionId),
            'nav' => true,
        ]);
    }

    public function getUpdate(Request $request, CollectionHelper $helper, int $id)
    {
        $api = DB::table('api_infos')->where('id', $id)->first();

        if ($api == null) {
            return view('errors.404');
        }

        if (!$helper->canUserAccess($api->collection_id)) {
            return view('errors.503');
        }

        $data = [
            'apiId' => $api->id,
            'apiName' => $api->api_name,
            'apiUrl' => $api->api_url,
            'apiDescription' => $api->api_description,
            'apiMethod' => $api->api_method,
            'requestHeaders' => $api->request_headers,
            'requestBody' => $api->request_body,
            'requestParam' => $api->request_params,
            'requestExample' => $api->request_example,
            'responseHeaders' => $api->response_headers,
            'responseBody' => $api->response_body,
            'responseExample' => $api->response_example,
            'collectionId' => $api->collection_id,
            'apiTag' => $api->api_tag,
        ];

        return view('api_update', $data);
    }

    public function postUpdate(Request $request, CollectionHelper $helper, int $id)
    {
        $this->validate($request, [
            'api_url' => 'required',
            'api_name' => 'required',
            'api_method' => 'required',
            'api_request_headers' => 'json',
            'api_request_body' => 'json',
            'api_request_params' => 'json',
            'api_response_headers' => 'json',
            'api_response_body' => 'json',
            'api_response_example' => 'json',
            'api_request_example' => 'json',
            'collection_id' => 'required|integer'
        ]);

        $api = DB::table('api_infos')->where('id', $id)->get(['collection_id', 'id'])->first();

        if ($api == null) {
            return view('errors.404');
        }

        if (!$helper->canUserAccess($api->collection_id)) {
            return view('errors.503');
        }

        $apiInfo = $request->all();
        $apiInfo['user_id'] = $request->user()->id;
        $apiInfo['updated_at'] = Carbon::now();

        DB::table('api_infos')->where('id', $id)->update($apiInfo);

        $api = DB::table('api_infos')->where('id', $id)->get(['*'])->first();

        $data = [
            'apiId' => $api->id,
            'apiName' => $api->api_name,
            'apiUrl' => $api->api_url,
            'apiDescription' => $api->api_description,
            'apiMethod' => $api->api_method,
            'apiTag' => $api->api_tag,
            'requestHeaders' => json_decode($api->request_headers, true),
            'requestBody' => json_decode($api->request_body, true),
            'requestParams' => json_decode($api->request_params, true),
            'requestExample' => $api->request_example,
            'responseHeaders' => json_decode($api->response_headers, true),
            'responseBody' => json_decode($api->response_body, true),
            'responseExample' => $api->response_example,
            'collectionId' => $api->collection_id,
            'message' => '文档已重新生成'
        ];

        return view('item_preview', $data);

    }

    public function delete(CollectionHelper $helper, int $id)
    {
        $api = DB::table('api_infos')->where('id', $id)->get(['collection_id', 'id'])->first();

        if ($api == null) {
            return view('errors.404');
        }

        if (!$helper->canUserAccess($api->collection_id)) {
            return view('errors.503');
        }

        DB::table('api_infos')->where('id', $id)->delete();

        return redirect('/api/doc/' . $api->collection_id);

    }

    private function formatHeader($headers)
    {
        $formatted = [];
        foreach ($headers as $key => $value) {
            $formatted[] = [
                'header_key' => $key,
                'header_type' => $this->getValueType($value),
                'header_description' => ''
            ];
        }

        return $formatted;
    }

    private function formatBody(array $body, string $prefix = '')
    {
        $formatted = [];

        // 对象数组默认所有数组中的对象全部同构，只保留第一个
        while (!Utils::is_assoc($body) && is_array($body) && !empty($body)) {
            $body = $body[0];
        }

        if (is_array($body)) {
            foreach ($body as $key => $value) {
                if ($prefix == '') {
                    $formatted[] = [
                        'body_key' => $key,
                        'body_type' => $this->getValueType($value),
                        'body_description' => ''
                    ];
                } else {
                    $formatted[] = [
                        'body_key' => $prefix . '.' . $key,
                        'body_type' => $this->getValueType($value),
                        'body_description' => ''
                    ];
                }
                if (is_array($value)) {
                    $child = $this->formatBody($value, $key);
                    $formatted = array_merge($formatted, $child);
                }
            }
        }


        return $formatted;
    }

    private function getValueType($value)
    {
        $type = gettype($value);
        if ($type == 'array') {
            if (Utils::is_assoc($value)) {
                $type = 'object';
            }
        }

        return $type;
    }
}
