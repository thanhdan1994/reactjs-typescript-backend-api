<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Images\Image;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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

    public function isSuperAdmin()
    {
        return $this->hasRole('Super Admin');
    }

    public function thumbnail()
    {
        return $this->hasOne(Image::class, 'id', 'featured_image');
    }

    public function getThumbnailUrlAttribute()
    {
        $thumbnail = env('APP_URL') . DIRECTORY_SEPARATOR . 'images/none_image.png';
        if ($this->thumbnail !== null) :
            $thumbnail = $this->thumbnail->getUrl('thumb-350');
        endif;
        return $thumbnail;
    }
}
