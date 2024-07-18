<?php

namespace Detit\Polipeople\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Detit\Polipeople\Models\PolipeopleTeam;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    // use HasTranslations;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'last_name',
        'slug',
        'bio',
        'links',
        'handle',
        'avatar',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'links' => 'array',
        'teams' => 'array',
        'avatar' => 'array',
    ];

    protected $translatable = [
        'bio',
        'links',
    ];

    //add has many relation with polipeople_members
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'polipeople_teams_members', 'member_id', 'team_id')
                    ->withPivot('position')
                    ->withTimestamps();
    }

    // Supponendo che i campi si chiamino 'name' e 'last_name'
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->last_name}";
    }

}
