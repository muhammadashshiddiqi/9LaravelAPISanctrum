<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posisi extends Model
{
    use HasFactory;

    protected $table = 'posisis';
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'status', 'position'];

}
