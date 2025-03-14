<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Payee
 * @package App\Models
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class Payee extends Model
{
    use SoftDeletes;

    protected $table = 'payees';


    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'payee_id';

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
        'payee_name', 'payee_last_name', 'email', 'other_emails', 'phone_number', 'other_phone_numbers', 'address', 'payee_notes', 'payee_relation', 'extra_field1', 'extra_field2',
        'is_active',
    ];
}