<?php

namespace App\Models;
use App\Models\Categoria;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    // Mapeia para a tabela criada pela migration
    protected $table = 'products';

    protected $fillable = ['category_id','name','price','image_path','description'];

    public function category()
    {
        // Relaciona com o Model EN ou PT (se existir Categoria.php)
       return $this->belongsTo(Categoria::class, 'category_id');

        // ou: return $this->belongsTo(Categoria::class, 'category_id');
    }
}