<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find($id)
 */
class Student extends Model
{
    use HasFactory;

    protected $table='students';
    protected $fillable=[
        'name',
        'email',
        'phone',
        'course'
    ];
}
