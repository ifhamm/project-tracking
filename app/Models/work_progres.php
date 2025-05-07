<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class work_progres extends Model
{
    use HasUuid, HasFactory, Searchable;

    protected $primaryKey = 'id_progres';

    protected $fillable = [
        'step_order',
        'step_name',
        'is_complete',
    ];

    public function toSearchableArray(): array
    {
        return [
            'step_order' => $this['step_order'],
            'step_name' => $this['step_name'],
            'is_complete' => $this['is_complete'],
        ];
    }

    public function part()
    {
        return $this->belongsTo(part::class);
    }
}
