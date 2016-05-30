<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RivalLinkModel extends Model
{
    public $table = 'rivals_links';
    
    public function getPrice()
    {
        return number_format($this->price, 2, ',', ' ');
    }
}
