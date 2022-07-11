<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $name
 * @property int $id
 * @property string $uuid
 *
 * @mixin Illuminate\Database\Eloquent\Builder
 */
class Car extends Model
{
    use HasFactory;

    protected static $unguarded = true;

    /** @var string[] */
    public $casts = [
        'data' => 'array',
        'broken' => 'boolean',
    ];

    protected static function newFactory(): CarFactory
    {
        return new CarFactory();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trailable(): MorphTo
    {
        return $this->morphTo();
    }
}
