<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class akun_mekanik extends Model
{
    use HasFactory, HasUuid, Searchable;

    protected $primaryKey = 'id_mekanik';

    protected $fillable = [
        'nama_mekanik',
        'username',
        'email',
        'password',
    ];

    public function toSearchableArray(): array
    {
        return [
            'nama_mekanik' => $this['nama_mekanik'],
            'username' => $this['username'],
            'email' => $this['email'],
            'password' => $this['password'],
            
        ];
    }

   public function part()
   {
       return $this->belongsToMany(part::class);
   }
}

