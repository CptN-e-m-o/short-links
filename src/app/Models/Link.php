<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'original_url',
    ];

    protected static function booted(): void
    {
        static::creating(function (Link $link): void {
            if ($link->code !== null && $link->code !== '') {
                return;
            }

            do {
                $code = Str::random(6);
            } while (self::query()->where('code', $code)->exists());

            $link->code = $code;
        });
    }

    protected function shortUrl(): Attribute
    {
        return Attribute::get(
            fn (): string => url($this->code)
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clicks(): HasMany
    {
        return $this->hasMany(LinkClick::class);
    }
}
