<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PageType
 * @package App\Models
 * @author Randall Anthony Bondoc
 */
class PageType extends Model
{
    use SoftDeletes;

    protected $table = 'page_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}