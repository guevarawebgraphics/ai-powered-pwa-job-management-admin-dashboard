<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Machine
 * @package App\Models
 * @author Richard Guevara | Monte Carlo Web Graphics
 */
class OpenAIFiles extends Model
{
    use SoftDeletes;

    protected $table = 'openai_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_number',
        'file_id',
        'image',
        'json_response'
    ];
}