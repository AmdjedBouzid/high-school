<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'class',
        'code',
        'student_state_id',
        'student_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'student_state_id' => 'integer',
        'student_type_id' => 'integer',
    ];

    public function studentState(): BelongsTo
    {
        return $this->belongsTo(StudentState::class);
    }

    public function studentType(): BelongsTo
    {
        return $this->belongsTo(StudentType::class);
    }
}
