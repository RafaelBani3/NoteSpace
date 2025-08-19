<?php

namespace App\Models;

use App\Traits\CustomID;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use CustomID;
    protected $table = 'logs';
    protected $primaryKey = 'logs_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'logs_id',
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent',
    ];

    // Generate Logs ID 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'Logs';
            $lastNumber = $model->getLastNumber($prefix, false);
            $model->logs_id = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    // Relasi: Log dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
