<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'user_id',
        'assigned_to',
        'status',
        'source',
        'notes',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function values(): HasMany
    {
        return $this->hasMany(LeadValue::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(LeadStatusLog::class)->orderBy('created_at', 'desc');
    }

    public function getFieldValue(string $fieldName): ?string
    {
        $value = $this->values()
            ->whereHas('formField', function ($query) use ($fieldName) {
                $query->where('name', $fieldName);
            })
            ->first();

        return $value?->value;
    }
}
