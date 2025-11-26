<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;


class Gallery extends Model
{
    protected $table = "gallerys";
    protected $fillable = [
        'url',
        'type',
        'parent_id',
        'parent_type'
    ];

    public function parent(): MorphTo
    {

        return $this->morphTo();
    }

    protected $casts = [
        'urls' => 'array',
    ];
}
