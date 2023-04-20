<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_User extends Model
{
    use HasFactory;
    //setting table name
    protected $table = 'project_users';
    //cast array <=> json
    protected $casts = [
        'team_members_id' => 'array'
    ];
}
