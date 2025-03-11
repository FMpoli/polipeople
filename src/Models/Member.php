<?php

namespace Detit\Polipeople\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Detit\Polipeople\Models\PolipeopleTeam;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Awcodes\Curator\Models\Media;
/**
 * @property string $id
* @property string $name
* @property string $last_name
* @property string $slug
* @property string $bio
* @property string $links
* @property string $handle
* @property string $is_published
 */
class Member extends Model
{
    protected $table = 'polipeople_members';
    use HasTranslations;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'last_name',
        'slug',
        'email',
        'phone',
        'position',
        'role',
        'bio',
        'image_id',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'links' => 'array',
        'teams' => 'array',
    ];

    protected $translatable = [
        'bio',
        'links',
        'affiliation',
        'role',
        'prefix',

    ];

    //add has many relation with polipeople_members

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'polipeople_teams_members', 'member_id', 'team_id');
    }

    // Supponendo che i campi si chiamino 'name' e 'last_name'
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->last_name}";
    }

    /**
     * Scope a query to only include published and active news.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query)
    {
        return $query->where('is_published', true);
    }

    public function avatar()
    {
        return $this->belongsTo(Media::class, 'avatar_id');
    }

}
