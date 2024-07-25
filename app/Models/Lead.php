<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'leads';

    protected $fillable = [
        'user_id',
        'company_name',
        'location',
        'sector',
        'discovered_on',
        'via',
        'interview',
        'link',
        'comments',
        'quality',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
