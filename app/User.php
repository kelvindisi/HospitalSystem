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
                $adminRoleId = User::FindAdminRole();
                $user->roles()->attach([$adminRoleId]);
            }
        });
    }

    public static function FindAdminRole()
    {

        User::createRoles();

        $role = Role::where('name', 'admin')->first();
        return $role->id;
    }

    public static function createRoles()
    {
        // admin
        if (!User::findRole('admin'))
        {
            User::addRole('admin');
        }
        // receptionist
        if (!User::findRole('receptionist'))
        {
            User::addRole('receptionist');
        }
        // pharmacy
        if (!User::findRole('pharmacy'))
        {
            User::addRole('pharmacy');
        }
        // doctor
        if (!User::findRole('doctor'))
        {
            User::addRole('doctor');
        }
        // finance
        if (!User::findRole('finance'))
        {
            User::addRole('finance');
        }
        // laboratory
        if (!User::findRole('laboratory'))
        {
            User::addRole('laboratory');
        }
    }
    public static function findRole($role)
    {
        $role = Role::where('name', $role)->first();

        if (!$role)
            return false;
        else
            return true;

    }
    public static function addRole($role)
    {
        Role::create(['name' => $role]);
    }
}
