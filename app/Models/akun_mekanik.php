<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function part()
    {
        return $this->belongsToMany(Part::class);
    }
}
