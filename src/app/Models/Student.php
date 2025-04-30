<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\StudentState;
use App\Models\StudentType;
use App\Models\Section;
use App\Models\User;


class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'code',
        'section_id',
        'student_state_id',
        'student_type_id',
        'inserted_by',
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'id' => 'integer',
        'student_state_id' => 'integer',
        'student_type_id' => 'integer',
    ];
    
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function studentState(): BelongsTo
    {
        return $this->belongsTo(StudentState::class);
    }

    public function studentType(): BelongsTo
    {
        return $this->belongsTo(StudentType::class);
    }

    public function supervisors()
    {
        return $this->belongsToMany(User::class, 'student_supervisors');
    }

    public function insertedBy()
    {
        return $this->belongsTo(User::class, 'inserted_by');
    }
}
