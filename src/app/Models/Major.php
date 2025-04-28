<?php

// app/Models/Major.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['name', 'grade_id'];
    /**
     * Get the sections for this major.
     */
    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
