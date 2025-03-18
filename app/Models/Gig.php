<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Gig
 * @package App\Models
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class Gig extends Model
{
    use SoftDeletes;

    protected $table = 'gigs';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'gig_id';

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
        'gig_cryptic', 
        'customer_input',
        'machine_brand', 
        'appliance_type', 
        'model_number',
        'serial_number', 
        'initial_issue', 
        'top_recommended_repairs', 
        'gig_price',
        'gig_price_detail', 
        'gig_discount', 
        'is_discount',
        'client_id',
        'trainee_included', 
        'assigned_tech_id', 
        'resolution', 
        'start_datetime', 
        'repair_notes', 
        'qb_invoice_num', 
        'child_of_gig', 
        'invoice_paid', 
        'gig_complete', 
        'parts_used', 
        'time_started', 
        'time_ended', 
        'extra_field1', 
        'extra_field2',
        'is_active',
        'customer_input'
    ];

    public function machine()
    {
        return $this->hasOne('App\Models\Machine', 'model_number','model_number');
    }

    public function client()
    {
        return $this->hasOne('App\Models\Client', 'client_id','client_id');
    }
    public function technician()
    {
        return $this->hasOne('App\Models\User', 'id','assigned_tech_id');
    }
}