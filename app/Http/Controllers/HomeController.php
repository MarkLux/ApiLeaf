<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $createdCollections = DB::table('api_collections')
            ->where('owner_id', $user->id)
            ->get(['id', 'title']);

        $sharedCollections = DB::table('collection_shares')
            ->where('collection_shares.user_id', $user->id)
            ->join('api_collections', 'api_collections.id', '=', 'collection_shares.collection_id')
            ->select('api_collections.id as id', 'api_collections.title as title')
            ->get();

        $favoredCollections = DB::table('api_favors')
            ->where('api_favors.user_id', $user->id)
            ->join('api_collections', 'api_collections.id', '=', 'api_favors.collection_id')
            ->select('api_collections.id as id', 'api_collections.title as title')
            ->get();

        return view('home', [
            'createdCollections' => $createdCollections,
            'sharedCollections' => $sharedCollections,
            'favoredCollections' => $favoredCollections
        ]);
    }
}
