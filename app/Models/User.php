<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\CustomID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    use Notifiable;
    use CustomID;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'dept_id',
        'username',
        'fullname',
        'password',
        'email',
    ];

    protected $hidden = [
        'Password',
        'remember_token',
    ];

    // Generate User ID 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'User';
            $lastNumber = $model->getLastNumber($prefix, false);
            $model->user_id = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        });
    }


    // Relasi: User milik 1 Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_id');
    }

    // Relasi: User punya banyak notes
    public function notes()
    {
        return $this->hasMany(Notes::class, 'user_id', 'user_id');
    }

    // Relasi: User punya banyak log
    public function logs()
    {
        return $this->hasMany(Logs::class, 'user_id', 'user_id');
    }

    // Relasi: User punya banyak notifikasi
    public function notifications()
    {
        return $this->hasMany(Notifications::class, 'user_id', 'user_id');
    }

    public function receivedNotes()
    {
        return $this->hasMany(Note_Share::class, 'shared_with_user_id', 'user_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
