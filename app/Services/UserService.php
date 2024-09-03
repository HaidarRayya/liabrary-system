<?php

namespace App\Services;

use App\Http\Resources\BorrowRecordsResource;
use App\Http\Resources\UserResource;
use App\Models\BorrowRecords;
use App\Models\User;

class UserService
{
    /**
     *  show all  users
     * @return  UserResource $users    
     * 
     */
    public function allUsers()
    {
        $users = User::customers()->get();
        $users = UserResource::collection($users);
        return  $users;
    }
    /**
     *  show a  user
     * @param  $user    
     * @return  UserResource $user
     */
    public function oneUser($user)
    {
        $data['user'] = UserResource::make($user);

        $borrowsRecords = BorrowRecords::where('user_id', '=', $user->id)->get();

        $data['borrowsRecords'] = BorrowRecordsResource::collection($borrowsRecords);

        return $data;
    }
    /**
     *  delete user
     * @param  $user    
     * 
     */
    public function deleteUser($user)
    {
        $user->delete();
    }
    /**
     *  bloked user
     * @param  $user    
     * 
     */
    public function blockUser($user)
    {
        $user->update([
            'status' => 2
        ]);
    }
    /**
     * un bloked user
     * @param  $user    
     * 
     */
    public function unBlockUser($user)
    {
        $user->update([
            'status' => 1
        ]);
    }

    /**
     * get all bloked user
     * @return  UserResource users   
     * 
     */
    public function allBlockUsers()
    {
        $users = User::allBlockUsers()->get();
        $users = UserResource::collection($users);
        return  $users;
    }

    /**
     * get all un bloked user
     * @return  UserResource users   
     * 
     */
    public function allUnBlockUsers()
    {
        $users = User::allUnBlockUsers()->get();
        $users = UserResource::collection($users);
        return  $users;
    }
}
