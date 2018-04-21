<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Foundation\Testing\Constraints\PageConstraint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApiCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCreate(Request $request)
    {
        return view('collect_editor', [
            'action' => 'create'
        ]);
    }

    public function getUpdate(Request $request, int $id)
    {
        $collection = DB::table('api_collections')->where('id', $id)->first();

        if ($collection == null) {
            return view('errors.404');
        }

        if (Auth::user()->id != $collection->owner_id) {
            return view('errors.503');
        }

        return view('collect_editor', [
            'action' => 'udpate',
            'collection' => $collection
        ]);
    }

    public function postUpdate(Request $request, int $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'description' => 'string|max:255'
        ]);

        $collection = DB::table('api_collections')->where('id', $id)->first();

        if ($collection == null) {
            return view('errors.404');
        }

        if (Auth::user()->id != $collection->owner_id) {
            return view('errors.503');
        }

        DB::table('api_collections')->where('id', $id)->update([
            'title' => $request->name,
            'description' => $request->description,
            'updated_at' => new Carbon()
        ]);

        return redirect('/home');
    }

    public function postCreate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:100',
            'description' => 'string|max:255'
        ]);


        $current = new Carbon();

        DB::transaction(function () use ($request, $current) {
            $id = DB::table('api_collections')->insertGetId([
                'title' => $request->name,
                'description' => $request->description,
                'owner_id' => $request->user()->id,
                'created_at' => $current,
                'updated_at' => $current
            ]);
            DB::table('collection_shares')->insert([
                'collection_id' => $id,
                'user_id' => Auth::user()->id
            ]);
        });

        return redirect('/home');
    }

    public function delete(Request $request, int $id)
    {
        $collection = DB::table('api_collections')->where('id', $id)->first();

        if ($collection->owner_id != $request->user()->id) {
            return view('errors.503');
        }

        DB::transaction(function () use ($id) {
            DB::table('api_collections')->where('id', $id)->delete();
            DB::table('api_infos')->where('collection_id', $id)->delete();
            DB::table('collection_shares')->where('collection_id', $id)->delete();
            DB::table('data_dicts')->where('collection_id', $id)->delete();
            DB::table('api_codes')->where('collection_id', $id)->delete();
        });

        return redirect('/home');
    }
}
