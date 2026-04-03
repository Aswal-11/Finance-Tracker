<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FinancialRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', FinancialRecord::class);

        $categories = Category::select('id', 'name')->get();

        $records = FinancialRecord::where('user_id', Auth::id())
            ->with('category:id,name')
            ->type($request->type)
            ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
            ->dateBetween($request->start_date, $request->end_date)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('financial.index', compact('records', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', FinancialRecord::class);

        $categories = Category::select('id', 'name', 'type')->get();

        return view('financial.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', FinancialRecord::class);

        $validated = $request->validate([
            'amount' => 'required|numeric|max:999999999.99',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();

        FinancialRecord::create($validated);

        return redirect()->route('records.index')->with('success', 'Record created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialRecord $record)
    {
        $this->authorize('update', $record);

        $categories = Category::select('id', 'name', 'type')->get();

        return view('financial.edit', compact('record', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialRecord $record)
    {
        $this->authorize('update', $record);

        $validated = $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $record->update($validated);

        return redirect()->route('records.index')->with('success', 'Record updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialRecord $record)
    {
        $this->authorize('delete', $record);

        $record->delete();

        return redirect()->route('records.index')->with('success', 'Record deleted successfully');
    }

    /**
     * 📊 Dashboard Summary API
     */
    public function dashboard()
    {
        $userId = Auth::id();

        // Load all user records (with category)
        $records = FinancialRecord::with('category:id,name')
            ->where('user_id', $userId)
            ->get();

        // Totals
        $totalIncome = $records->where('type', 'income')->sum('amount');
        $totalExpenses = $records->where('type', 'expense')->sum('amount');
        $netBalance = $totalIncome - $totalExpenses;

        // Category Wise
        $categoryTotals = $records
            ->groupBy(fn($r) => $r->category->name)
            ->map(function ($group) {
                $income = $group->where('type', 'income')->sum('amount');
                $expense = $group->where('type', 'expense')->sum('amount');

                return [
                    'income' => $income,
                    'expense' => $expense,
                    'net' => $income - $expense,
                ];
            });

        // Recent Activity
        $recentActivity = $records
            ->sortByDesc('date')
            ->take(10)
            ->values()
            ->map(function ($record) {
                return [
                    'id' => $record->id,
                    'amount' => $record->amount,
                    'type' => $record->type,
                    'category' => $record->category->name,
                    'date' => $record->date,
                    'notes' => $record->notes,
                ];
            });

        // Monthly Trends
        $monthlyTrends = $records
            ->groupBy(fn($r) => $r->date->format('Y-m'))
            ->map(function ($group) {
                $income = $group->where('type', 'income')->sum('amount');
                $expense = $group->where('type', 'expense')->sum('amount');

                return [
                    'income' => $income,
                    'expense' => $expense,
                    'net' => $income - $expense,
                ];
            });

        // Weekly Trends
        $weeklyTrends = $records
            ->groupBy(fn($r) => $r->date->format('o-W'))
            ->map(function ($group) {
                $income = $group->where('type', 'income')->sum('amount');
                $expense = $group->where('type', 'expense')->sum('amount');

                return [
                    'income' => $income,
                    'expense' => $expense,
                    'net' => $income - $expense,
                ];
            });

        return response()->json([
            'total_income' => $totalIncome,
            'total_expenses' => $totalExpenses,
            'net_balance' => $netBalance,
            'category_totals' => $categoryTotals,
            'recent_activity' => $recentActivity,
            'monthly_trends' => $monthlyTrends,
            'weekly_trends' => $weeklyTrends,
        ]);
    }
}