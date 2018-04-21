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
        $this->middleware('auth')->except('getListView', 'matchDict');
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

        return view("data_dict_edit", [
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
        return view("data_dict_edit", [
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
        $postData = $request->input('data', '');

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

        return redirect('/api/' . $collectionId . '/data-dict');
    }

    public function postUpdate(Request $request, int $dictId)
    {
        $postData = $request->input('data', '');

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

        return redirect('/api/' . $dataDict->collection_id . '/data-dict');
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

        return redirect('/api/' . $dataDict->collection_id . '/data-dict');
    }

    public function matchDict(Request $request, int $collectionId)
    {
        $apiCollection = ApiCollection::find($collectionId);
        if ($apiCollection == null) {
            return response()->json([
                'code' => 404
            ]);
        }

        $dataDicts = DataDict::where(['collection_id' => $collectionId])
            ->get(['id', 'key_index']);
        if (count($dataDicts) == 0) {
            return response()->json([
                'code' => -1
            ]);
        }

        // 输入的key列表
        $inputKeys = json_decode($request->input('dict_keys', '[]'));
        $maxJd = 0;
        $targetDictId = -1;
        foreach ($dataDicts as $dict) {
            $jd = $this->clacJd($inputKeys, json_decode($dict->key_index));
            if ($jd > $maxJd) {
                $maxJd = $jd;
                $targetDictId = $dict->id;
            }
        }
        if ($maxJd <= 0 || $targetDictId == -1) {
            return response()->json([
                'code' => -1
            ]);
        }

        $targetDict = DataDict::find($targetDictId)->toArray();
        $targetDict['key_index'] = json_decode($targetDict['key_index']);
        $targetDict['body'] = json_decode($targetDict['body']);

        $matchedKeys = array_intersect($inputKeys, $targetDict['key_index']);
        $matchedMap = [];
        foreach ($matchedKeys as $key) {
            $matchedMap[$key] = true;
        }
        return response()->json([
            'code' => 0,
            'jd' => $maxJd,
            'dataDict' => $targetDict,
            'matchedKeys' => $matchedMap
        ]);

    }

    private function clacJd(array $a, array $b)
    {
        if (empty($a) || empty($b)) {
            return 0;
        }

        $inner = array_intersect($a, $b);
        $union = array_unique(array_merge($a, $b));

        if (count($union) == 0) {
            return 0;
        }
        return floatval(count($inner)) / count($union);
    }
}