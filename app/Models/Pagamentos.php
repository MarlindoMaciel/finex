<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamentos extends Model
{
    use HasFactory;
    protected $table      = 'pagamentos';
    protected $primaryKey = 'id';
    protected $guarded    = ['id'];
}
