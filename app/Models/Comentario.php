<?php

namespace Cat\Models;

use Illuminate\Database\Eloquent\Model;


class Comentario extends Model
{
    
    public $table = 'comentarios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $fillable
        = [
            'id_presentismo',
            'id_usuario',
            'comentario',
        ];
    
    
    public function presentismo()
    {
        return $this->belongsTo(Presentismo::class, 'id_presentismo');
    }
    public function user()
    {
        return $this->belongsTo(Presentismo::class, 'id_user');
    }
}
