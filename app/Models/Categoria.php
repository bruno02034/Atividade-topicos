<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name','description'];

    public function products()
    {
        // Se o seu outro Model for Produto (PT):
        return $this->hasMany(Produto::class, 'category_id');
        // ou, se estiver usando Product (EN):
        // return $this->hasMany(Product::class, 'category_id');
    }
}
