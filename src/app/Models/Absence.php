<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'from',
        'to',
    ];

    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function fromAction()
    {
        return $this->belongsTo(AbsenceAction::class, 'from');
    }

    public function toAction()
    {
        return $this->belongsTo(AbsenceAction::class, 'to');
    }
}
