<?php

namespace Detit\Polipeople\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

/**
 * @property string $id
* @property string $name
* @property string $slug
* @property string $description
* @property int $position
 */
class Team extends Model
{
    protected $table = 'polipeople_teams';
    use HasTranslations;
    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'position'
    ];

    protected $translatable = [
        'name',
        'slug',
        'description'
    ];


    //add has many relation with polipeople_members

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'polipeople_teams_members', 'team_id', 'member_id');
    }
}
