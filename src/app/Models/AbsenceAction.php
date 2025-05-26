<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsenceAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'time',
        'made_by',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];

    public $timestamps = false;

    public function madeBy()
    {
        return $this->belongsTo(User::class, 'made_by');
    }

    public function absencesFrom()
    {
        return $this->hasMany(Absence::class, 'from');
    }

    public function absencesTo()
    {
        return $this->hasMany(Absence::class, 'to');
    }
}
