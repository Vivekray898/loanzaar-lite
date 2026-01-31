<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
        'type',
        'title',
        'content',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
