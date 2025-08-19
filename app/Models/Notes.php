<?php

namespace App\Models;

use App\Traits\CustomID;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{

    use CustomID;

    protected $table = 'notes';
    protected $primaryKey = 'notes_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'notes_id',
        'user_id',
        'note_title',
        'note_content',
        'note_public',
    ];

    // Generate Notes ID 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'Notes';
            $lastNumber = $model->getLastNumber($prefix, false);
            $model->notes_id = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    // Relasi: Note dimiliki oleh 1 user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Relasi: Note punya banyak comment
    public function comments()
    {
        return $this->hasMany(Comment::class, 'notes_id', 'notes_id');
    }

    // Relasi: Note bisa di-share ke banyak user
    public function shares()
    {
        return $this->hasMany(Note_Share::class, 'notes_id', 'notes_id');
    }

    // Relasi: Note bisa punya banyak attachment
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'notes_id', 'notes_id');
    }
}
