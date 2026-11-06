<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'name',
        'email',
        'phone',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => RegistrationStatus::class,
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
