<?php

namespace App\Policies;

use App\Services\PermissionService;

class PostPolicy
{
    protected $permission;

    public function __construct(PermissionService $permission)
    {
        $this->permission = $permission;
    }

    public function viewAny($user)
    {
        return $this->permission->check($user, 'read', 'posts');
    }

    public function view($user, $post)
    {
        return $this->permission->check($user, 'read', 'posts');
    }

    public function create($user)
    {
        return $this->permission->check($user, 'create', 'posts');
    }

    public function update($user, $post)
    {
        return $this->permission->check($user, 'update', 'posts');
    }

    public function delete($user, $post)
    {
        return $this->permission->check($user, 'delete', 'posts');
    }
}
