<?php

namespace App\Models;

use App\Traits\CustomID;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use CustomID;

    protected $table = 'departments';
    protected $primaryKey = 'dept_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'dept_id',
        'dept_name',
    ];

    // Generate Dept ID 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'Dept';
            $lastNumber = $model->getLastNumber($prefix, false);
            $model->dept_id = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    // Relasi: Satu department punya banyak user
    public function users()
    {
        return $this->hasMany(User::class, 'dept_id', 'dept_id');
    }
}
