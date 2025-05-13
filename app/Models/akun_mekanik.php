<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class akun_mekanik extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'credentials';
    protected $primaryKey = 'id_credentials';

    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'role',
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
