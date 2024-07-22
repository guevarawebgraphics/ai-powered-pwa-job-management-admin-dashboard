<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Attachments\HasAttachment;

class Page extends Model
{
    use SoftDeletes, HasAttachment;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'content',
        'is_active',
        'seo_meta_id',
        'page_type_id',
    ];

    /**
     * Generate a url representing this resource.
     *
     * @return string
     */
    public final function getUrlAttribute()
    {
        return url($this->attributes['slug']);
    }

    /**
     * Checks to see if the current request is exactly for this page.
     *
     * @return bool
     */
    public final function getIsCurrentRouteAttribute()
    {
        return request()->is($this->attributes['slug']);
    }

    /**
     * Collects only active pages.
     *
     * @param Builder $query
     * @return Builder
     */
    public final function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public final function seoMeta()
    {
        return $this->belongsTo(SeoMeta::class);
    }

    public final function pageType()
    {
        return $this->hasOne(PageType::class);
    }

    public final function sections()
    {
        return $this->belongsToMany(Section::class)->orderBy('order');
    }
}