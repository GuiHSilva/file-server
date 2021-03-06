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

    /**
     * Valida se a extensao é uma imagem para a pre-visualizacao no show
     */
    public function isImage($value)
    {   
        $formatos = [
            'jpg', 'jpeg', 'png', 'gif', 'svg'
        ];
        return in_array($value, $formatos);
    }

    /**
     * Formata a data
     */
    public function getData($value) 
    {
        return Carbon::parse($value)->format('d/m/Y H:i');
    }


}
