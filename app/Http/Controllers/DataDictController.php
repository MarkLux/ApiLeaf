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
use Illuminate\Http\Request;

class DataDictController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getEditView(int $dictId)
    {
        $dict = DataDict::find($dictId);
        if ($dict == null) {
            return view("errors.404");
        }

        $apiCollection = ApiCollection::find($dict->collection_id);

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
        if ($apiCollection == null) {
            return view("errors.404");
        }
        return view("data_dict_edit",[
            'apiCollection' => $apiCollection
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
}