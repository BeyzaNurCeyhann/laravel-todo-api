<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'due_date'
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_todo');
    }

    public function scopeFilter($query, $filters)
    {
        return $query
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['priority'] ?? null, fn($q, $priority) => $q->where('priority', $priority))
            ->when($filters['title'] ?? null, fn($q, $title) => $q->where('title', 'like', "%$title%"))
            ->when($filters['due_date'] ?? null, fn($q, $dueDate) => $q->whereDate('due_date', $dueDate));
    }
}
