<?php
/**
 * Created by PhpStorm.
 * User: lumin
 * Date: 2018/4/17
 * Time: 下午4:07
 */

namespace App\Http\Controllers;

use App\ApiCollection;
use App\CollectionShare;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * 管理API文档的共享
 */
class ApiShareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getManageView(Request $request, int $collectionId)
    {
        // 检查当前用户是否是文档的创建者
        $user = Auth::user();

        $apiCollection = ApiCollection::find($collectionId);

        $errorCode = intval($request->input('err', 0));
        $error = [];

        if ($errorCode > 0) {
            $error = $this->getError($errorCode);
        }

        $infoCode = intval($request->input('info', 0));
        $info = [];

        if ($infoCode > 0) {
            $info = $this->getInfo($infoCode);
        }

        if ($apiCollection->owner_id != $user->id) {
            return view("errors.503");
        }

        $members = DB::table('collection_shares')
            ->where('collection_id', $collectionId)
            ->leftJoin('users', 'collection_shares.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email')
            ->get();

        foreach ($members as $member) {
            if ($member->id == $user->id) {
                // 如果是创建者
                $member->is_owner = true;
            }
        }

        $data = [
            'collection' => $apiCollection,
            'members' => $members,
            'error' => $error,
            'info' => $info
        ];

        return View("share_edit", $data);
    }

    public function addMember(Request $request, int $collectionId)
    {
        $user = Auth::user();

        $apiCollection = ApiCollection::find($collectionId);

        if ($apiCollection->owner_id != $user->id) {
            return view("errors.503");
        }

        $newMemberEmail = $request->input('new_member_email', '');

        // 判断成员是否存在

        $newMember = User::where('email', $newMemberEmail)->first();

        if ($newMember == null) {
            return redirect("/share/" . $apiCollection->id . "?err=1");
        }

        // 判断成员是否已经加入，插入不实现幂等

        $oldMember = CollectionShare::where([
            'collection_id' => $apiCollection->id,
            'user_id' => $newMember->id
        ])->first();

        if ($oldMember != null) {
            return redirect("/share/" . $apiCollection->id . "?err=2");
        }

        DB::table('collection_shares')->insert([
            'collection_id' => $apiCollection->id,
            'user_id' => $newMember->id
        ]);

        return redirect("/share/" . $apiCollection->id . "?info=1");
    }

    public function deleteMember(Request $request, int $collectionId)
    {
        $user = Auth::user();
        $apiCollection = ApiCollection::find($collectionId);

        if ($apiCollection->owner_id != $user->id) {
            return view("errors.503");
        }

        DB::table('collection_shares')->where([
            'collection_id' => $apiCollection->id,
            'user_id' => $request->input('member_id')
        ])->delete();

        return redirect("/share/" . $apiCollection->id . "?info=2");
    }

    private function getError(int $errorCode)
    {
        switch ($errorCode) {
            case 1:
                return [
                    'message' => '用户不存在'
                ];
            case 2:
                return [
                    'message' => '用户已经加入项目'
                ];
            default:
                return [];
        }
    }

    private function getInfo(int $infoCode)
    {
        switch ($infoCode) {
            case 1:
                return [
                    'message' => '添加成功'
                ];
            case 2:
                return [
                    'message' => '删除成功'
                ];
            default:
                return [];
        }
    }
}