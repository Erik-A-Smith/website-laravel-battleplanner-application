<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Models
use App\Models\Battleplan;
use App\Models\Floor;
use App\Models\Media;

class Map extends Model
{
  
  protected $fillable = [
    // Properties
    'name', 'thumbnail_id', 'competitive',
  ];

  public Static $printWith = [
    'floors',
    'floors.source',
    'thumbnail'
  ];

  /**
   * Relationships
   */
  
  public function thumbnail() {
    return $this->belongsTo(Media::class);
  }

  public function battleplans() {
    return $this->hasMany('App\Models\Battleplan');
  }

  public function floors() {
    return $this->hasMany('App\Models\Floor', 'map_id');
  }

  /**
   * Create override function (Default Model create method)
   */
  public static function create(array $attributes = [])
  {
      $media = Media::fromFile($attributes['thumbnail'], "maps/{$attributes['name']}", "public");
      $attributes['thumbnail_id'] = $media->id;
      return static::query()->create($attributes);
  }
}
