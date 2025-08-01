<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Define the table if it's not the default 'roles'
    protected $table = 'roles';

    // Add relationships, fillable fields, etc.
}
