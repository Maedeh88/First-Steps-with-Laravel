<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/***
 * @property int id
 * @property string name
 */

class BannerType extends Model
{
//    use HasFactory;
    protected $table = 'banner_types';
    protected $fillable=['id', 'name'];

    public function banners(){
        return $this->hasMany(Banner::class);
    }
}
