<?php

namespace App\Models;

use App\Traits\CustomID;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use CustomID;
    protected $table = 'notification';
    protected $primaryKey = 'notif_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'notif_id',
        'user_id',
        'type',
        'message',
        'notif_isread',
    ];

    // Generate Notif ID 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'Notif';
            $lastNumber = $model->getLastNumber($prefix, false);
            $model->notif_id = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    // Relasi: Notifikasi dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
