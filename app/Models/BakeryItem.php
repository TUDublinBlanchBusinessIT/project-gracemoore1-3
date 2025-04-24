<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BakeryItem extends Model
{
    protected $fillable = [
      'name',
      'price',
      'image',
      'description',  // ← make sure it’s here
    ];
}



