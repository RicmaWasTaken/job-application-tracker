<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'applications';

    protected $fillable = [
        'user_id',
        'company_name',
        'location',
        'sector',
        'discovered_on',
        'first_contact',
        'last_contact',
        'via',
        'interview',
        'status',
        'link',
        'comments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
