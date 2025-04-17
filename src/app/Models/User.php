<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Student;


class User extends Model
{
    use SoftDeletes, HasApiTokens, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'role_id' => 'integer',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function supervisorInfo()
    {
        return $this->hasOne(SupervisorInfo::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_supervisors');
    }
    
    public function setPasswordAttribute($value)
    {
        if ($value !== null) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function($user) {
            if ($user->isForceDeleting()) {
                $user->supervisorInfo()->forceDelete();
            } else {
                $user->supervisorInfo()->delete();
            }
        });
        
        static::restoring(function($user) {
            $user->supervisorInfo()->withTrashed()->restore();
        });
    }
}
