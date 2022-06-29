<?php

namespace thianpri\FilamentSertifikat\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Spatie\Tags\HasTags;

class Jawaban extends Model
{
    use HasFactory;
    use HasTags;

    /**
     * @var string
     */
    protected $table = 'sertifikat_jawaban';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'file_ sertifikat ',
        'content',
        'published_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'date',
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'file_ sertifikat _url',
    ];

    public function file_ sertifikat Url(): Attribute
    {
        return Attribute::get(fn () => asset(Storage::url($this->file_ sertifikat )));
    }

    public function scopePublished(Builder $query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeDraft(Builder $query)
    {
        return $query->whereNull('published_at');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'sertifikat_customer_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'sertifikat_category_id');
    }
}
