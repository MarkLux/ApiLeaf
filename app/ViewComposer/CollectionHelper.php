<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 17/7/12
 * Time: 下午10:33
 */

namespace App\ViewComposer;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CollectionHelper
{
    public function getAccessCollections()
    {
        $user = Auth::user();

        $collections = [];

        $createdCollections = DB::table('api_collections')
            ->where('owner_id',$user->id)
            ->get(['id','title']);

        foreach ($createdCollections as $created) {
            $collections[] = [
                'title' => $created->title,
                'id' => $created->id
            ];
        }

        $sharedCollections = DB::table('collection_shares')
            ->where('collection_shares.user_id',$user->id)
            ->join('api_collections','api_collections.id','=','collection_shares.collection_id')
            ->select('api_collections.id as id','api_collections.title as title')
            ->get();

        foreach ($sharedCollections as $shared) {
            $collections[] = [
                'title' => $shared->title,
                'id' => $shared->id
            ];
        }

        return $collections;
    }

    public function canUserAccess(int $collectionId)
    {
        if (!Auth::check())
            return false;


        $user = Auth::user();

        $isOwner = DB::table('api_collections')->where(['id' => $collectionId,'owner_id'=>$user->id])->count();

        if ($isOwner != 1) {
            $isShared = DB::table('collection_shares')->where(['collection_id' => $collectionId,'user_id' => $user->id])->count();
            if ($isShared == 1) {
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
}