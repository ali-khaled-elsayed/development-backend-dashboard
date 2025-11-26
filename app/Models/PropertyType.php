<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PropertyType extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'image',
        'type',
        'area_min',
        'area_max',
        'price_min',
        'price_max',
        'no_of_bedrooms_min',
        'no_of_bedrooms_max',
        'no_of_bathrooms_min',
        'no_of_bathrooms_max',
        'project_id',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
