<?php

namespace Newpixel\PartnerCRUD\App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Partner extends Model
{
    use CrudTrait;

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($obj) {
            \Storage::disk('public')->delete($obj->image);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'partners';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'image', 'link', 'active'];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getImageImageAttribute()
    {
        ($this->image && \File::exists(public_path('images/storage/partners' . $this->image)))
            ? $url = \URL::asset('images/storage/partners' . $this->image)
            : $url = \URL::asset('images/template/nopic.jpg');

        return $url;
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setImageAttribute($file)
    {
        $attribute_name = "image";
        $disk = "public";
        $destination_path = "partners";

        // if the image was erased
        if ($file == null) {
            \Storage::disk($disk)->delete($this->image);
            $this->attributes[$attribute_name] = null;
        }

        if (starts_with($file, 'data:image')) {
            \Storage::disk($disk)->delete($this->image);
            $filename = str_slug($this->slug_or_name . time()) . '.jpg';

            $img = \Image::make($file)->resize(140, 100, function ($pict) {
                $pict->aspectRatio();
                $pict->upsize();
            });
            $img->resizeCanvas(140, 100, 'center', false, '#fff');
            \Storage::disk($disk)->put($destination_path . '/' . $filename, $img->stream());

            $this->attributes[$attribute_name] = $destination_path . '/' . $filename;
        }
    }
}
