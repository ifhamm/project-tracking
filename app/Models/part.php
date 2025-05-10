<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class part extends Model
{
    use HasUuid, HasFactory, Searchable;

    protected $primaryKey = 'no_iwo';

    protected $fillable = [
        'no_wbs',
        'customer',
        'incoming_date',
        'part_name',
        'part_number',
        'no_seri',
        'description',
        'id_mekanik',
    ];
    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id_mekanik = (string) Str::uuid();
        });
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
