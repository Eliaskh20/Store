<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hesMany(User::class);
    }
    public function Roles()
    {
        return $this->hesMany(Role::class);
    }
}
