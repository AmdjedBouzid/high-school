<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the majors for this grade.
     */
    public function majors()
    {
        return $this->hasMany(Major::class);
    }
}
