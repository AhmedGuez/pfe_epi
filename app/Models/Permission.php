<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    // Define the table if it's not the default 'permissions'
    protected $table = 'permissions';

    // Add relationships, fillable fields, etc.
}