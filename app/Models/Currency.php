<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['code', 'value', 'updated_at'];
    public $timestamps = false;
}
