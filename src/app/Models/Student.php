<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'code',
        'section_id',
        'record_status_id',
        'student_type_id',
        'inserted_by',
    ];

    // Relationships
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function recordStatus()
    {
        return $this->belongsTo(RecordStatus::class);
    }

    public function studentType()
    {
        return $this->belongsTo(StudentType::class);
    }

    public function insertedBy()
    {
        return $this->belongsTo(User::class, 'inserted_by');
    }
}
