<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'cost',
        'start_date',
        'renewal_date',
        'frequency',
        'description',
        'website_url',
        'auto_renewal'
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'start_date' => 'date',
        'renewal_date' => 'date',
        'auto_renewal' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function notificationSetting(): HasOne
    {
        return $this->hasOne(NotificationSetting::class);
    }
}
