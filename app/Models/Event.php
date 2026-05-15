<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'category',
        'prodi',
        'event_type',
        'event_date',
        'location',
        'price_type',
        'price',
        'target_participants',
        'registration_link',
        'organizer_name',
        'contact_person',
        'poster',
        'is_tak',
        'status',
        'submitted_by',
        'submitted_email',
        'approved_by',
        'approved_at'
    ];
}
