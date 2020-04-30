<?php

namespace App\Models\Comments;


use \App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Comments\Comment
 *
 * @property int $id
 * @property string $user_id
 * @property int|null $parent_id
 * @property int $limit
 * @property string $body
 * @property string $commentable_id
 * @property string $commentable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comments\Comment[] $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\Users\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comments\Comment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereCommentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereCommentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Comments\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comments\Comment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Comments\Comment withoutTrashed()
 * @mixin \Eloquent
 */
class Comment extends Model
{

    use SoftDeletes;

    public $timestamps = true;

    /**
     * User that wrote the comment
     *
     * @return BelongsTo user who created the comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * All the replies to this comment
     *
     * @return HasMany comments that are replying to this comment
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
