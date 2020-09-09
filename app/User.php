<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use \App\Role;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'gender', 'id_number', 'account_status', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

    public function Roles()
    {
        return $this->belongsToMany('App\Role');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            if (User::count() == 1)
            {
                $adminRoleId = '\App\User'::FindAdminRole();
                $user->roles()->attach([1]);
            }
        });
    }

    public static function FindAdminRole()
    {
        $role = Role::where('name', 'admin')->first();

        if (!$role)
        {
            $role = new Role();
            $role->name = 'admin';
            
            $role->save();
        }

        return $role->id;
    }
}
