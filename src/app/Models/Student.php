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
    public static function generateCode($id, $date) {
        // Parse the date
        $timestamp = strtotime($date);
        if (!$timestamp) {
            return "Invalid date";
        }
    
        // x = day (2 digits) + month (2 digits) + last digit of year
        $day = date('d', $timestamp);
        $month = date('m', $timestamp);
        $yearLastDigit = substr(date('Y', $timestamp), -1);
        $x = $day . $month . $yearLastDigit;
    
        // z = ["A", "M", "B"]
        $z = ["A", "M", "B"];
        $zIndex = strlen($x) % count($z); // To prevent index out of bounds
        $zChar = $z[$zIndex];
    
        // Random component: last 3 digits of current milliseconds
        $micro = microtime(true);
        $millis = (int)($micro * 1000);
        $randomPart = substr($millis, -3); // last 3 digits
    
        // Combine to create the final code
        return $x . $id . $zChar . $randomPart;
    }
    
}
