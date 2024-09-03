<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    /**
     *  show all users 
     *
     * @return response  of the status of operation :  users
     */
    public function index()
    {
        $users = $this->userService->allUsers();
        return response()->json([
            'status' => 'success',
            'data' => [
                'users' =>  $users
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    /**
     *  show a user
     *
     * @return response  of the status of operation :  users
     */
    public function show(User $user)
    {
        $data = $this->userService->oneUser($user);
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $data['user'],
                'borrowsRecords' => $data['borrowsRecords']
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->userService->deleteUser($user);
        return response()->json([
            'status' => 'success',
            "message" => 'تم حذف المستخدم بنجاح',
        ], 204);
    }
    /**
     *   block  a user
     * @param User $user
     *
     * @return response  of the status of operation :  message
     */
    public function blockUser(User $user)
    {
        $this->userService->blockUser($user);
        return response()->json([
            'status' => 'success',
            "message" => 'تم حظر المستخدم بنجاح',
        ], 200);
    }
    /**
     *   unBlock  a user
     * @param User $user
     *
     * @return response  of the status of operation :  message
     */
    public function unBlockUser(User $user)
    {
        $this->userService->unBlockUser($user);
        return response()->json([
            'status' => 'success',
            "message" => 'تم فك الحظر بنجاح',
        ], 200);
    }

    /**
     *  show all blocked users  
     *
     *
     * @return response  of the status of operation :  users
     */
    public function blockUsers()
    {
        $users = $this->userService->allBlockUsers();
        return response()->json([
            'status' => 'success',
            'data' => [
                'users' =>  $users
            ]
        ], 200);
    }

    /**
     *  show all un blocked users 
     *
     *
     * @return response  of the status of operation :  users
     */
    public function unBlockUsers()
    {
        $users = $this->userService->allUnBlockUsers();
        return response()->json([
            'status' => 'success',
            'data' => [
                'users' =>  $users
            ]
        ], 200);
    }
}