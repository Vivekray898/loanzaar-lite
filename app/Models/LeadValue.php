<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'form_field_id',
        'value',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function formField(): BelongsTo
    {
        return $this->belongsTo(FormField::class);
    }
}
