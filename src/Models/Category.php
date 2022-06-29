<?php

namespace thianpri\FilamentSertifikat\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'sertifikat_categories';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_visible',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_visible' => 'boolean',
    ];

    public function jawaban(): HasMany
    {
        return $this->hasMany(Jawaban::class, 'sertifikat_category_id', 'id');
    }

    public function scopeIsVisible(Builder $query)
    {
        return $query->whereIsVisible(true);
    }

    public function scopeIsInvisible(Builder $query)
    {
        return $query->whereIsVisible(false);
    }
}
