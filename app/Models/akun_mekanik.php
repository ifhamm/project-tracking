<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class akun_mekanik extends Model
{
    use HasFactory, HasUuid;

    protected $primaryKey = 'id_mekanik';

    protected $fillable = [
        'nama_mekanik',
        'username',
        'email',
        'password',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id_mekanik = (string) Str::uuid();
        });
    }

    public function part()
    {
        return $this->belongsToMany(Part::class);
    }
}
