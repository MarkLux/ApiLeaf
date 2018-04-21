<?php
/**
 * Created by PhpStorm.
 * User: lumin
 * Date: 2018/4/18
 * Time: 下午4:19
 */

namespace App\Http\Controllers;


use App\ApiCode;
use App\ApiCollection;
use App\ViewComposer\CollectionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiCodesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getView']);
    }

    public function getView(Request $request, int $collectionId)
    {
        $apiCollection = ApiCollection::find($collectionId);
        if ($apiCollection == null) {
            return view("errors.404");
        }

        $apiCodes = ApiCode::where(['collection_id' => $collectionId])->get()->toArray();

        usort($apiCodes, function($a, $b) {
            return intval($a['code']) > intval($b['code']);
        });

        $data = [
            'apiCodes' => $apiCodes,
            'apiCollection' => $apiCollection,
            'isDoc' => true,
            'access' => false
        ];

        if (Auth::check()) {
            $helper = new CollectionHelper();
            $data['access'] = $helper->canUserAccess($collectionId);
        }

        return view("api_codes",$data);
    }

    public function getEditView(Request $request, int $collectionId)
    {
        $apiCollection = ApiCollection::find($collectionId);
        if ($apiCollection == null) {
            return view("errors.404");
        }

        $apiCodes = ApiCode::where(['collection_id' => $collectionId])->get()->toArray();

        usort($apiCodes, function($a, $b) {
            return intval($a['code']) > intval($b['code']);
        });

        $data = [
            'apiCodes' => $apiCodes,
            'apiCollection' => $apiCollection
        ];

        if ($request->info == 1) {
            $data['info'] = 1;
        }

        return view("api_codes_edit",$data);
    }

    public function updateCodes(Request $request, int $collectionId)
    {
        $apiCollection = ApiCollection::find($collectionId);
        if ($apiCollection == null) {
            return view("errors.404");
        }

        $updateCodes = $request->input('api_codes',null);

        if ($updateCodes != null) {
            $updateCodes = json_decode($updateCodes, true);
        }else {
            $updateCodes = [];
        }

        // 做一下兜底的验空

        foreach ($updateCodes as &$updateCode) {
            $updateCode['collection_id'] = $apiCollection->id;
            if (!is_numeric($updateCode['code'])) {
                return view('errors.503');
            }else if($updateCode['description'] == null|| $updateCode['description'] == '') {
                return view('errors.503');
            }
        }

        DB::transaction(function () use ($updateCodes, $apiCollection) {
           DB::table('api_codes')->where(['collection_id' => $apiCollection->id])->delete();
           DB::table('api_codes')->insert($updateCodes);
        });

        return redirect('/api/codes/'.$apiCollection->id.'/edit?info=1');
    }
}