<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Client
 * @package App\Models
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class Client extends Model
{
    use SoftDeletes;

    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_name',
        'client_last_name',
        'insurance_plan',
        'email',
        'other_emails',
        'phone_number',
        'other_phone_numbers',
        'street_address',
        'city',
        'zip_code',
        'state',
        'country',
        'client_notes',
        'previous_gig_history',
        'appliances_owned',
        'maintenance_plan',
        'payee_id',
        'extra_field1',
        'extra_field2',
        'is_active',
    ];
}