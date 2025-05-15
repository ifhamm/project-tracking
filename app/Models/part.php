<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class part extends Model
{
    use HasUuid, HasFactory;

    protected $primaryKey = 'no_iwo';

    protected $fillable = [
        'no_wbs',
        'customer',
        'incoming_date',
        'part_name',
        'part_number',
        'no_seri',
        'description',
        'id_credentials',
    ];
    public $timestamps = false;
    public $created_at = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->no_iwo = (string) Str::uuid();
        });
    }

    public function breakdownPart()
    {
        return $this->hasMany(work_progres::class, 'no_iwo', 'no_iwo');
    }

    public function akunMekanik()
    {
        return $this->belongsTo(akun_mekanik::class, 'id_credentials', 'id_credentials');
    }

    public function workProgres()
    {
        return $this->hasMany(work_progres::class, 'no_iwo', 'no_iwo');
    }
}
