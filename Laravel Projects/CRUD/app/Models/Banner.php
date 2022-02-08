<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/***
 * @property number id
 * @property string title
 * @property string body
 * @property string image
 * @property int type_id
 */

class Banner extends Model
{
    use HasFactory;

    protected $table = 'Banners';
    protected $fillable = ['id', 'type_id', 'title', 'body', 'image'];

    public function cruds(){
        return $this->belongsToMany(Currency::class, 'banner_currencies', 'banner_id', 'currency_id', 'id', 'id');
    }
    public function type(){
        return $this->belongsTo(BannerType::class, 'type_id', 'id');
    }
}
