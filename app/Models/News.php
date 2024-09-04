<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class News extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'status',
        'user_id',
    ];

    protected $appends = [
        'thumb',
    ];

    public function getStatusAttribute($value)
    {
        return (int)$value;
    }

    public function getUserIdAttribute($value)
    {
        return (int)$value;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 0);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232)
            ->sharpen(10);
    }

    //get thumb image
    public function getThumbAttribute()
    {
        $media = $this->getFirstMedia('news');
        if ($media) {
            return $media->getUrl('thumb');
        }
        return asset('assets/images/no-image.png');
        
    }


}
