@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-3xl shadow-sm border border-slate-200">

    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-slate-900">Add Financial Record</h1>
        <p class="mt-2 text-sm text-slate-500">Create a new income or expense record.</p>
    </div>

    <form method="POST" action="{{ route('records.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="amount" class="block text-sm font-medium text-slate-700 mb-2">Amount (₹)</label>
            <input
                id="amount"
                name="amount"
                type="number"
                step="0.01"
                placeholder="0.00"
                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                required
            >
            @error('amount')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="type" class="block text-sm font-medium text-slate-700 mb-2">Type</label>
            <select
                id="type"
                name="type"
                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                required
            >
                <option value="">Select Type</option>
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
            @error('type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category_id" class="block text-sm font-medium text-slate-700 mb-2">Category</label>
            <select
                id="category_id"
                name="category_id"
                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                required
            >
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }} ({{ ucfirst($category->type) }})</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="date" class="block text-sm font-medium text-slate-700 mb-2">Date</label>
            <input
                id="date"
                name="date"
                type="date"
                value="{{ date('Y-m-d') }}"
                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                required
            >
            @error('date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="notes" class="block text-sm font-medium text-slate-700 mb-2">Notes (Optional)</label>
            <textarea
                id="notes"
                name="notes"
                rows="4"
                placeholder="Add any additional notes..."
                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
            ></textarea>
            @error('notes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4 pt-4">
            <a
                href="{{ route('records.index') }}"
                class="flex-1 px-6 py-3 text-center border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-colors"
            >
                Cancel
            </a>
            <button
                type="submit"
                class="flex-1 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
            >
                Create Record
            </button>
        </div>
    </form>

</div>
@endsection