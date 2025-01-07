<?php

namespace App\Models\clan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clan_tree extends Model
{
  use HasFactory;

  protected $table = 'clan_tree';
  protected $primaryKey = 'id_tree';
  protected $fillable = ['name', 'gender', 'parent_tree_id', 'spouse_tree_id'];

  // Relationships
  public function parent()
  {
      return $this->belongsTo(self::class, 'parent_tree_id');
  }

  public function children()
  {
      return $this->hasMany(self::class, 'parent_tree_id');
  }

  public function spouse()
  {
      return $this->belongsTo(self::class, 'spouse_tree_id');
  }
}
