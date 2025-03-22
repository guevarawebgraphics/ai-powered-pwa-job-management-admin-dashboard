<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Machine
 * @package App\Models
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class Machine extends Model
{
    use SoftDeletes;

    protected $table = 'machines';
        /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'machine_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_number', 
        'serial_number', 
        'service_manual', 
        'parts_diagram', 
        'service_pointers', 
        'common_repairs', 
        'machine_photo', 
        'brand_name', 
        'machine_type', 
        'machine_notes', 
        'extra_field1',
        'extra_field2',
        'display_type',
        'is_active'
    ];
}