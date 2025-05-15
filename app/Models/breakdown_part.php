<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class breakdown_part extends Model
{
    use HasFactory, HasUuid;

    protected $primaryKey = 'bdp_number';

    protected $fillable = [
        'no_iwo',
        'bdp_name',
        'bdp_number_eqv',
        'quantity',
        'unit',
        'op_number',
        'op_date',
        'defect',
        'mt_number',
        'mt_quantity',
        'mt_date',
    ];

    public function toSearchableArray(): array
    {
        return [
            'bdp_name' => $this['bdp_name'],
            'bdp_number_eqv' => $this['bdp_number_eqv'],
            'quantity' => $this['quantity'],
            'unit' => $this['unit'],
            'op_number' => $this['op_number'],
            'op_date' => $this['op_date'],
            'defect' => $this['defect'],
            'mt_number' => $this['mt_number'],
            'mt_quantity' => $this['mt_quantity'],
            'mt_date' => $this['mt_date'],
        ];
    }

    public function part()
    {
        return $this->belongsTo(part::class, 'no_iwo', 'no_iwo');
    }

    public $timestamps = false;
    public $created_at = false;
}
