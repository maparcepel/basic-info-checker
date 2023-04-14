<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasicInfo extends Model
{
    protected $table = 'basic_info';

    use HasFactory;

    protected $fillable = [
        'reference',
        'management_type',
        'description',
        'principal_image',
        'folder'
    ];
}
