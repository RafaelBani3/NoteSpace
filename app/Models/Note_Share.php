<?php

namespace App\Models;

use App\Traits\CustomID;
use Illuminate\Database\Eloquent\Model;

class Note_Share extends Model
{
    use CustomID;

    protected $table = 'note_share';
    protected $primaryKey = 'note_share_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'note_share_id',
        'notes_id',
        'shared_with_user_id',
        'note_public',
    ];

    // Generate Note Share ID 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'NS';
            $lastNumber = $model->getLastNumber($prefix, false);
            $model->note_share_id = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        });
    }

    // Relasi: NoteShare terkait ke Note
    public function note()
    {
        return $this->belongsTo(Notes::class, 'notes_id', 'notes_id');
    }

    // Relasi: NoteShare terkait ke User yang menerima share
    public function sharedWith()
    {
        return $this->belongsTo(User::class, 'shared_with_user_id', 'user_id');
    }
}
