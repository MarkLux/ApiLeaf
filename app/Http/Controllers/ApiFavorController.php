<?php
/**
 * Created by PhpStorm.
 * User: lumin
 * Date: 2018/4/17
 * Time: 下午7:22
 */

namespace App\Http\Controllers;


use App\ApiCollection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiFavorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function favor(Request $request, int $collectionId)
    {
        $user = Auth::user();
        $apiCollection = ApiCollection::find($collectionId);
        if ($apiCollection == null) {
            return view("errors.404");
        }
        try {
            DB::table('api_favors')->insert([
                'collection_id' => $apiCollection->id,
                'user_id' => $user->id
            ]);
        } catch (QueryException $exception) {
            if ($exception->errorInfo[1] != 1062) {
                // 非重复收藏
                return view("errors.503");
            }
        }
        return redirect('/api/doc/' . $collectionId);
    }

    public function unfavor(Request $request, int $collectionId)
    {
        $user = Auth::user();
        $apiCollection = ApiCollection::find($collectionId);
        if ($apiCollection == null) {
            return view("errors.404");
        }

        DB::table('api_favors')->where([
            'collection_id' => $apiCollection->id,
            'user_id' => $user->id
        ])->delete();

        return redirect('/api/doc/' . $collectionId);
    }
}