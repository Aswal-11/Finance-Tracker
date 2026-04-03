<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Subuser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubuserController extends Controller
{
    /**
     * List Subusers
     */
    public function index()
    {
        $subusers = Subuser::with('role')->latest()->get();

        return view('subusers.index', compact('subusers'));
    }

    /**
     * Create Page
     */
    public function create()
    {
        return view('subusers.create', [
            'roles' => Role::orderBy('name')->get()
        ]);
    }

    /**
     * Store Subuser
     */
    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        DB::transaction(function () use ($validated, $request) {

            Subuser::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $validated['role_id'] ?? null,
            ]);
        });

        return redirect()->route('subusers.index')
            ->with('success', 'Subuser created successfully');
    }

    /**
     * Show Subuser
     */
    public function show(Subuser $subuser)
    {
        return view('subusers.show', compact('subuser'));
    }

    /**
     * Edit Page
     */
    public function edit(Subuser $subuser)
    {
        return view('subusers.edit', [
            'subuser' => $subuser,
            'roles' => Role::orderBy('name')->get()
        ]);
    }

    /**
     * Update Subuser
     */
    public function update(Request $request, Subuser $subuser)
    {
        $validated = $this->validateRequest($request, $subuser->id);

        DB::transaction(function () use ($validated, $request, $subuser) {

            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'role_id' => $validated['role_id'] ?? null,
            ];

            // Password update only if provided
            if (!empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }

            $subuser->update($data);
        });

        return redirect()->route('subusers.index')
            ->with('success', 'Subuser updated successfully');
    }

    /**
     * Delete Subuser
     */
    public function destroy(Subuser $subuser)
    {
        $subuser->delete();

        return redirect()->route('subusers.index')
            ->with('success', 'Subuser deleted successfully');
    }


    /**
     * 🔥 Validation (DRY)
     */
    private function validateRequest(Request $request, $id = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:subusers,email,' . $id,
            'password' => $id ? 'nullable|string|min:8' : 'required|string|min:8',
            'role_id' => 'nullable|exists:roles,id',
        ]);
    }
}