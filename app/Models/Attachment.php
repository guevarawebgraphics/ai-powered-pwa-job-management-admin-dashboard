<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mime',
        'alias',
        'folder',
        'extension',
        'identifier'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['url'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Generate a url that represents this resource.
     *
     * @return string
     */
    public final function getUrlAttribute() : string
    {
        $path = $this->attributes['folder'] . '/' . $this->attributes['alias'];

        return url("public/storage/$path");
    }

    /**
     * Return the url when serialized.
     *
     * @return string
     */
    public final function __toString() : string
    {
        return $this->getUrlAttribute();
    }
}
