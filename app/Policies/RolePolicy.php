<?php

namespace App\Policies;

use App\Models\Role;
use App\Services\PermissionService;

class RolePolicy
{
    protected PermissionService $permission;

    public function __construct(PermissionService $permission)
    {
        $this->permission = $permission;
    }

    public function viewAny($user): bool
    {
        return $this->permission->check($user, 'read', 'roles');
    }

    public function view($user, Role $role): bool
    {
        return $this->permission->check($user, 'read', 'roles');
    }

    public function create($user): bool
    {
        return $this->permission->check($user, 'create', 'roles');
    }

    public function update($user, Role $role): bool
    {
        return $this->permission->check($user, 'update', 'roles');
    }

    public function delete($user, Role $role): bool
    {
        return $this->permission->check($user, 'delete', 'roles');
    }
}
