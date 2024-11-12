<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Item extends Model
{
    public $name;
    public $content;
    public $created_at;

    public function __construct($name, $content)
    {
        $this->name = $name;
        $this->content = $content;
        $this->created_at = Carbon::now();
    }
}
