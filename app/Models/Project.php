<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Project extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'description_en',
        'description_ar',
        'short_description_en',
        'short_description_ar',
        'title_en',
        'title_ar',
        'meta_title_en',
        'meta_title_ar',
        'meta_description_en',
        'meta_description_ar',
        'location',
        'master_plan',
        'logo',
        'project_area',
        'type',
        'area_id',
        'city_id',
        'delivery_date',
        'video_link',
        'payment_plan',
    ];

    protected $casts = [
        'payment_plan' => 'array',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'project_service');
    }

    public function propertyTypes()
    {
        return $this->hasMany(PropertyType::class);
    }

    public function galleries()
    {
        return $this->morphMany(Gallery::class, 'parent');
    }
}
