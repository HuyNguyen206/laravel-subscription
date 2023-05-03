<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Plan extends Model
{
    use HasFactory;

    protected static function booted()
    {
      self::creating(function (Plan $plan){
          $plan->slug = Str::slug($plan->title);
      });
    }
}
