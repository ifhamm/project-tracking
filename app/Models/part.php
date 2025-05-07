<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class part extends Model
{
    use HasUuid, HasFactory, Searchable;

    protected $primaryKey = 'no_iwo';

    protected $fillable = [
        'no_wbs',
        'incoming_date',
        'part_name',
        'part_number',
        'no_seri',
        'description',
    ];

    public function toSearchableArray(): array
    {
        return [
            'no_wbs' => $this['no_wbs'],
            'incoming_date' => $this['incoming_date'],
            'part_name' => $this['part_name'],
            'part_number' => $this['part_number'],
            'no_seri' => $this['no_seri'],
            'description' => $this['description'],
        ];
    }

    public function breakdownPart()
    {
        return $this->hasMany(breakdown_part::class);
    }

    public function akunMekanik()
    {
        return $this->belongsToMany(akun_mekanik::class);
    }

    public function workProgres()
    {
        return $this->hasMany(work_progres::class);
    }
}
