<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Link
 * @package App
 */
class Link extends Model
{
    protected $table = 'links';

    protected $fillable = ['name', 'url'];
}
