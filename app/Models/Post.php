<?php

namespace App\Models;

use App\Markdown\CacheableInterface;
use App\Models\Queries\Searchable;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Post.
 *
 * @property int $id
 * @property string $slug
 * @property int $author_id
 * @property string $title
 * @property string $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $published_at
 * @property Carbon|null $deleted_at
 * @property-read \App\Models\User $author
 * @property-read bool $published
 * @property-read Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static Builder|Post newModelQuery()
 * @method static Builder|Post newQuery()
 * @method static \Illuminate\Database\Query\Builder|Post onlyTrashed()
 * @method static Builder|Post query()
 * @method static Builder|Post search($column, $searchTerm)
 * @method static Builder|Post whereAuthorId($value)
 * @method static Builder|Post whereContent($value)
 * @method static Builder|Post whereCreatedAt($value)
 * @method static Builder|Post whereDeletedAt($value)
 * @method static Builder|Post whereDraft()
 * @method static Builder|Post whereId($value)
 * @method static Builder|Post wherePublished()
 * @method static Builder|Post wherePublishedAt($value)
 * @method static Builder|Post whereSlug($value)
 * @method static Builder|Post whereTitle($value)
 * @method static Builder|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Post withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Post withoutTrashed()
 * @mixin Eloquent
 */
class Post extends Model implements CacheableInterface
{
    use SoftDeletes, HasFactory, Searchable;

    /** @var array */
    protected $fillable = [
        'slug', 'title', 'content', 'published_at',
    ];

    /** @var array */
    protected $with = [
        'author', 'tags',
    ];

    /** @var array */
    protected $casts = [
        'published_at' => 'date',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getPublishedAttribute(): bool
    {
        return !empty($this->published_at) && $this->published_at <= now();
    }

    public function scopeWherePublished(Builder $query): Builder
    {
        return $query
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeWhereDraft(Builder $query): Builder
    {
        return $query
            ->whereNull('published_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getCacheKey(): string
    {
        return 'post:'.$this->slug;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
