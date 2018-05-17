<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    public function update(User $currentUser, User $user)
    {
        # 第一个参数默认为当前登录用户实例，第二个参数则为要进行授权的用户实例
        # 当两个 id 相同时，则代表两个用户是相同用户，用户通过授权
        return $currentUser->id === $user->id;
    }

    public function destroy(User $currentUser, User $user)
    {
        # 判断返回为真 且被删除ID不能是当前用户ID
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
