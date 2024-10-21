<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'email', 'address_id'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
