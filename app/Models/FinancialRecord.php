<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    use HasFactory;

    protected $table = 'financial_records';

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'category_id',
        'date',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Record belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Record belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (🔥 Important for clean code)
    |--------------------------------------------------------------------------
    */

    // Filter by type
    public function scopeType($query, $type)
    {
        if ($type) {
            $query->where('type', $type);
        }
    }

    // Filter by category name
    public function scopeCategory($query, $category)
    {
        if ($category) {
            $query->whereHas('category', function ($q) use ($category) {
                $q->where('name', $category);
            });
        }
    }

    // Filter by date range
    public function scopeDateBetween($query, $start, $end)
    {
        if ($start && $end) {
            $query->whereBetween('date', [$start, $end]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors (Optional but 🔥)
    |--------------------------------------------------------------------------
    */

    public function getFormattedAmountAttribute()
    {
        return '₹'.number_format($this->amount, 2);
    }

    public function getTypeBadgeAttribute()
    {
        return $this->type === 'income'
            ? '<span class="text-green-600">Income</span>'
            : '<span class="text-red-600">Expense</span>';
    }
}
