<?php
/**
 * Created by PhpStorm.
 * User: lumin
 * Date: 2018/4/20
 * Time: 下午2:01
 */

namespace App\Http\Controllers;


use App\ApiCollection;
use App\DataDict;
use App\ViewComposer\CollectionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataDictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('getListView');
    }

    public function getEditView(int $dictId)
    {
        $dict = DataDict::find($dictId);
        if ($dict == null) {
            return view("errors.404");
        }

        $apiCollection = ApiCollection::find($dict->collection_id);

        $helper = new CollectionHelper();

        // 权限检查
        if (!$helper->canUserAccess($apiCollection->id)) {
            return view("errors.503");
        }

        return view("data_dict_edit",[
            'apiCollection' => $apiCollection,
            'dictName' => $dict->name,
            'dictDescription' => $dict->description,
            'dictItems' => json_decode($dict->body),
            'dictId' => $dict->id,
            'update' => true
        ]);
    }

    public function getCreateView(int $collectionId)
    {
        $apiCollection = ApiCollection::find($collectionId);

        $helper = new CollectionHelper();

        // 权限检查
        if (!$helper->canUserAccess($apiCollection->id)) {
            return view("errors.503");
        }

        if ($apiCollection == null) {
            return view("errors.404");
        }
        return view("data_dict_edit",[
            'apiCollection' => $apiCollection
        ]);
    }

    public function getListView(int $collectionId)
    {
        $apiCollection = ApiCollection::find($collectionId);

        if ($apiCollection == null) {
            return view("errors.404");
        }

        $helper = new CollectionHelper();

        $dataDicts = DataDict::where(['collection_id' => $collectionId])->get()->toArray();

        foreach ($dataDicts as &$dict) {
            $dict['body'] = json_decode($dict['body']);
        }

        $access = Auth::check();

        if ($access) {
            $access = $helper->canUserAccess($collectionId);
        }

        return view("data_dict", [
            'apiCollection' => $apiCollection,
            'dataDict' => $dataDicts,
            'isDoc' => true,
            'access' => $access
        ]);
    }

    public function postCreate(Request $request, int $collectionId)
    {
        $postData = $request->input('data','');

        $postData = json_decode($postData);

        if (empty($postData)) {
            return view("errors.503");
        }

        $apiCollection = ApiCollection::find($collectionId);

        $helper = new CollectionHelper();

        // 权限检查
        if (!$helper->canUserAccess($collectionId)) {
            return view("errors.503");
        }

        if ($apiCollection == null) {
            return view("errors.404");
        }

        $items = $postData->items;
        $keyIndexes = [];
        foreach ($items as $item) {
            $keyIndexes[] = $item->key;
        }

        $dataDict = new DataDict();
        $dataDict->collection_id = $collectionId;
        $dataDict->name = $postData->name;
        $dataDict->description = $postData->description;
        $dataDict->key_index = json_encode($keyIndexes);
        $dataDict->body = json_encode($items);

        $dataDict->save();

        dd($dataDict);
    }

    public function postUpdate(Request $request, int $dictId)
    {
        $postData = $request->input('data','');

        $postData = json_decode($postData);

        if (empty($postData)) {
            return view("errors.503");
        }

        $dataDict = DataDict::find($dictId);

        if ($dataDict == null) {
            return view("errors.404");
        }

        $helper = new CollectionHelper();

        // 权限检查
        if (!$helper->canUserAccess($dataDict->collection_id)) {
            return view("errors.503");
        }

        $items = $postData->items;
        $keyIndexes = [];
        foreach ($items as $item) {
            $keyIndexes[] = $item->key;
        }

        $dataDict->name = $postData->name;
        $dataDict->description = $postData->description;
        $dataDict->key_index = json_encode($keyIndexes);
        $dataDict->body = json_encode($items);

        $dataDict->save();

        return redirect('/');
    }

    public function deleteDict(int $dictId)
    {
        $dataDict = DataDict::find($dictId);

        if ($dictId == null) {
            return view("errors.404");
        }

        $helper = new CollectionHelper();

        // 权限检查
        if (!$helper->canUserAccess($dataDict->collection_id)) {
            return view("errors.503");
        }

        $dataDict->delete();

        return redirect('/');
    }
}