<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string icon
 * @property string name
 * @property string symbol
 * @property number rank
 * @property float total_volume
 * @property float daily_volume
 */
class Currency extends Model
{
//    use HasFactory;
    protected $table = 'cruds';
    protected $fillable = [ 'id', 'name', 'symbol', 'icon', 'rank', 'total_volume', 'daily_volume'];

    public function banners(){
        return $this->belongsToMany(Banner::class, 'banner_currencies', 'banner_id', 'currency_id', 'id', 'id ');
    }
}
