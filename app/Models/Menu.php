<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Menu extends Model
{
    protected $fillable = [
        'kitchen_id',
        'image',
        'title',
        'slug',
        'description',
        'date',
        'portion',
        'status',
        'receiver_id',
        'distributed_at',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = self::generateUniqueSlug($model->title);
        });

        static::updating(function ($model) {
            $model->slug = self::generateUniqueSlug($model->title, $model->id);
        });
    }

    public static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {

            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    // public function getStatusAttribute()
    // {
    //     if ($this->distributed_at) {
    //         return 'Distributed';
    //     }
    //     $time = now()->format('H:i');

    //     if ($time >= '21:30' || $time <= '00:59') {
    //         return 'Draft';
    //     }

    //     if ($time >= '01:00' && $time < '04:30') {
    //         return 'Cooking';
    //     }

    //     if ($time >= '04:30' && $time < '06:00') {
    //         return 'Packing';
    //     }

    //     if ($time >= '06:00' && $time <= '08:00') {
    //         return 'Delivered';
    //     }

    //     return 'Draft';
    // }

    public function receiver()
    {
        return $this->belongsTo(Receiver::class, 'receiver_id');
    }
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class, 'kitchen_id');
    }
    public function nutrition()
    {
        return $this->hasOne(Nutrition::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function logs()
    {
        return $this->hasMany(MenuStatusLog::class);
    }
}
