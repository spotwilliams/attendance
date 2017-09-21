<?php

namespace Cat\Models;

use Cat\User;
use Illuminate\Database\Eloquent\Model;


class Comentario extends Model
{
    
    public $table = 'comentarios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    
    protected $fillable
        = [
            'id_presentismo',
            'id_user',
            'comentario',
        ];
    
    
    public function presentismo()
    {
        return $this->belongsTo(Presentismo::class, 'id_presentismo');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
