<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\Constraints\PageConstraint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCreate(Request $request)
    {
        return view('collect_editor',[
            'action' => 'create'
        ]);
    }

    public function postCreate(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:100',
            'description' => 'string|max:255'
        ]);


        $current = new Carbon();

        DB::table('api_collections')->insert([
            'title' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user()->id,
            'created_at' => $current,
            'updated_at' => $current
        ]);

        return redirect('/home');
    }

    public function delete(Request $request,int $id)
    {
        $collection = DB::table('api_collections')->where('id',$id)->first();

        if ($collection->user_id != $request->user()->id) {
            return view('errors.503');
        }

        DB::transaction(function ()use($id) {
            DB::table('api_collections')->where('id',$id)->delete();
            DB::table('api_infos')->where('collection_id',$id)->delete();
            DB::table('collection_shares')->where('collection_id',$id)->delete();
        });

        return redirect('/home');
    }
}
