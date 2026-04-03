<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * List Roles
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);

        $roles = Role::with('permissions')->latest()->get();

        return view('role.index', compact('roles'));
    }

    /**
     * Create Page
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        return view('role.create', $this->getFormData());
    }

    /**
     * Store Role
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $validated = $this->validateRequest($request);

        DB::transaction(function () use ($validated, $request) {

            $role = Role::create([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            $this->syncRolePermissions($role->id, $request->input('permissions', []));
        });

        return redirect()->route('role.index')
            ->with('success', 'Role created successfully');
    }

    /**
     * Show Role
     */
    public function show(Role $role)
    {
        $this->authorize('view', $role);

        $role->load('permissions');

        return view('role.show', compact('role'));
    }

    /**
     * Edit Page
     */
    public function edit(Role $role)
    {
        $this->authorize('update', $role);

        $data = $this->getFormData();

        // 🔥 Pre-selected permissions (IMPORTANT)
        $selectedPermissions = $role->permissions
            ->groupBy('pivot.table_name')
            ->map(fn ($items) => $items->pluck('id')->toArray())
            ->toArray();

        return view('role.edit', array_merge(
            $data,
            compact('role', 'selectedPermissions')
        ));
    }

    /**
     * Update Role
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('update', $role);

        $validated = $this->validateRequest($request, $role->id);

        DB::transaction(function () use ($validated, $request, $role) {

            $role->update([
                'name' => $validated['name'],
                'description' => $validated['description'] ?? null,
            ]);

            $this->syncRolePermissions($role->id, $request->input('permissions', []));
        });

        return redirect()->route('role.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Delete Role
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete', $role);

        DB::transaction(function () use ($role) {
            DB::table('role_permission')->where('role_id', $role->id)->delete();
            $role->delete();
        });

        return redirect()->route('role.index')
            ->with('success', 'Role deleted successfully');
    }

    /**
     * 🔥 COMMON FORM DATA (DRY)
     */
    private function getFormData(): array
    {
        return [
            'permissions' => Permission::select('id', 'name', 'slug')
                ->orderBy('name')
                ->get(),

            'tableNames' => config('table_access.tables'),
        ];
    }

    /**
     * 🔥 VALIDATION (REUSABLE)
     */
    private function validateRequest(Request $request, $roleId = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $roleId,
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'array',
            'permissions.*.*' => 'exists:permissions,id',
        ]);
    }

    /**
     * 🔥 SYNC PERMISSIONS (OPTIMIZED)
     */
    private function syncRolePermissions(int $roleId, array $permissions): void
    {
        $data = $this->preparePermissionData($permissions, $roleId);

        DB::transaction(function () use ($roleId, $data) {

            // Delete old
            DB::table('role_permission')->where('role_id', $roleId)->delete();

            // Insert new
            if (!empty($data)) {
                DB::table('role_permission')->insert($data);
            }
        });
    }

    /**
     * 🔥 PREPARE DATA
     */
    private function preparePermissionData(array $permissions, int $roleId): array
    {
        $rows = [];
        $now = now();

        foreach ($permissions as $table => $permissionIds) {

            if (!is_array($permissionIds)) continue;

            foreach (array_unique($permissionIds) as $permissionId) {

                $permissionId = (int) $permissionId;

                if ($permissionId <= 0) continue;

                $rows[] = [
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                    'table_name' => $table,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        return $rows;
    }
}