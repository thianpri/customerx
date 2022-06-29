<?php

namespace thianpri\FilamentSertifikat\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'sertifikat_customers';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'photo',
        'bio',
        'no_hp',
        'no_identitas',
    ];

    /**
     * @var array<string>
     */
    protected $appends = [
        'photo_url',
    ];

    public function photoUrl(): Attribute
    {
        return Attribute::get(fn () => asset(Storage::url($this->photo)));
    }

    public function jawaban(): HasMany
    {
        return $this->hasMany(Jawaban::class, 'sertifikat_customer_id');
    }
}
