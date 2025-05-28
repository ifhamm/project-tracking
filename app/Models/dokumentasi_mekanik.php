<?php

// app/Models/MechanicDocumentation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumentasi_mekanik extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_iwo',
        'no_wbs',
        'step_name',
        'komponen',
        'tanggal',
        'foto',
    ];

    protected $table = 'dokumentasi_mekaniks';
}
