<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $connection = 'mongodb';

    protected $collection = 'users';

    protected $primaryKey = '_id';

    protected $dates = ['created_at', 'updated_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'email', 'password', 'avatar', 'user_id', 'last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the avatar .
     *
     *
     * @return string
     */
    public function getAvatarLinkAttribute ()
    {
        if (empty($this->attributes['avatar'])) {
            return '/imgs/default_user.png';
        }
        return '/uploads/users/' . $this->attributes['avatar'];
    }
    /**
     * Set the image.
     *
     * @param  file  value
     * @return void
     */
    public function setAvatarAttribute ($value)
    {
        $disk = Storage::disk('user_avatar');

        if (!empty($this->attributes['avatar']) && $disk->exists($this->attributes['avatar'])) {
            $disk->delete($this->attributes['avatar']);
        }

        $name = uniqid(). '.' .$value->getClientOriginalExtension();
        $disk->put($name, File::get($value));
        $this->attributes['avatar'] = $name;
    }
}
