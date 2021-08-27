<?php
namespace App\Models\Images;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'ext',
        'store_path',
    ];

    public function getUrlAttribute()
    {
        return asset($this->store_path . DIRECTORY_SEPARATOR . $this->name . '.' . $this->ext);
    }

    public function getUrl50x50Attribute()
    {
        return asset($this->store_path . DIRECTORY_SEPARATOR . $this->name . '-50x50' . '.' . $this->ext);
    }

    public function getUrl100x100Attribute()
    {
        return asset($this->store_path . DIRECTORY_SEPARATOR . $this->name . '-100x100' . '.' . $this->ext);
    }
}