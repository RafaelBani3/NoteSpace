<?php

namespace App\Models;

use App\Traits\CustomID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    use CustomID;

    protected $table = 'attachment';
    protected $primaryKey = 'attachment_id'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'attachment_id',
        'notes_id',
        'attachment_filename',
        'attachment_realname',
        'file_type',
    ];

    // Relasi ke Note
    public function note()
    {
        return $this->belongsTo(Notes::class, 'notes_id', 'notes_id');
    }

    // Generate Note Attacment ID 
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'ATT';
            $lastNumber = $model->getLastNumber($prefix, false);
            $model->attachment_id = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        });
    }
}
