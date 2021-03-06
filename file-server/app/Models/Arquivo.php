<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillabled = [
        'file', 'extension', 'url'  
    ];

    public function getData($value) 
    {
        return Carbon::parse($value)->format('d/m/Y H:i');
    }

}
