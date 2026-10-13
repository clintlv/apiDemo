<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Http\Resources\UserInfoResource;


class UserInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //查询列表
        $list = UserInfo::all();
        return UserInfoResource::collection($list);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //新增
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user_infos,email',
            'phone' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
        ]);

        $userInfo = UserInfo::create($validated);
        return new UserInfoResource($userInfo);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //显示指定资源
        $userInfo = UserInfo::findOrFail($id);
        return new UserInfoResource($userInfo);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //更新指定资源
        $userInfo = UserInfo::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:user_infos,email,' . $id,
            'phone' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
        ]);

        $userInfo->update($validated);
        return new UserInfoResource($userInfo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //删除指定资源
        $userInfo = UserInfo::findOrFail($id);
        $userInfo->delete();
        return response()->json(null, 204);
    }
}
