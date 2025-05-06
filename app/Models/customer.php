<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class customer extends Model
{
    use HasFactory, HasUuid, Searchable;

    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'nama_customer',
        'agency',
        'country',
    ];

    public function toSearchableArray(): array
    {
        return [
            'nama_customer' => $this['nama_customer'],
            'agency' => $this['agency'],
            'country' => $this['country'],
        ];
    }

    public function part()
    {
        return $this->belongsToMany(part::class);
    }
}
