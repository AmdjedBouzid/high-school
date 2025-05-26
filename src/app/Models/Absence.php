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
        'absent_type',
        'absent_description',
        'presence_type',
        'presence_description',

    ];

    public $timestamps = false;

    protected static function booted()
    {
        static::created(fn () => cache()->put('absences_last_updated', now()));
        static::updated(fn () => cache()->put('absences_last_updated', now()));
        static::deleted(fn () => cache()->put('absences_last_updated', now()));
    }

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
