<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class work_progres extends Model
{
    use HasUuid, HasFactory;

    protected $primaryKey = 'id_progres';

    protected $fillable = [
        'no_iwo',
        'step_order',
        'step_name',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];



    public function part()
    {
        return $this->belongsTo(part::class, 'no_iwo', 'no_iwo');
    }
}
