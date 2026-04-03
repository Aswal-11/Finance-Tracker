<?php

namespace App\Policies;

use App\Models\FinancialRecord;
use App\Services\PermissionService;

class FinancialRecordPolicy
{
    /**
     * Create a new policy instance.
     */
    protected PermissionService $permission;

    public function __construct(PermissionService $permission)
    {
        $this->permission = $permission;
    }

    public function viewAny($user): bool
    {
        return $this->permission->check($user, 'read', 'financial_records');
    }

    public function view($user, FinancialRecord $record): bool
    {
        return $this->permission->check($user, 'read', 'financial_records');
    }

    public function create($user): bool
    {
        return $this->permission->check($user, 'create', 'financial_records');
    }

    public function update($user, FinancialRecord $record): bool
    {
        return $this->permission->check($user, 'update', 'financial_records');
    }

    public function delete($user, FinancialRecord $record): bool
    {
        return $this->permission->check($user, 'delete', 'financial_records');
    }
}
