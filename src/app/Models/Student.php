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
        'record_status_id',
        'student_type_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'record_status_id' => 'integer',
        'student_type_id' => 'integer',
    ];

    public function recordStatus(): BelongsTo
    {
        return $this->belongsTo(RecordStatus::class);
    }

    public function studentType(): BelongsTo
    {
        return $this->belongsTo(StudentType::class);
    }
}
