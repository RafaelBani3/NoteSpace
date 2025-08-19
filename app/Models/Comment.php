<?php

namespace App\Models;

use App\Traits\CustomID;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use CustomID;

    protected $table = 'comment';
    protected $primaryKey = 'comment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'comment_id',
        'notes_id',
        'user_id',
        'comment_text',
    ];

    // Generate Note Comment ID 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'Comment';
            $lastNumber = $model->getLastNumber($prefix, false);
            $model->comment_id = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    // Relasi: Comment milik sebuah Note
    public function note()
    {
        return $this->belongsTo(Notes::class, 'notes_id', 'notes_id');
    }

    // Relasi: Comment dibuat oleh User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
