<?php

namespace Cat\Helpers;


use Cat\Models\Agente;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    public static $pathAvatar = '/uploads/avatars/';
    
    /**
     * @param Agente|null $agente
     * @param UploadedFile|null $avatar
     * @return string
     */
    public static function storeAvatar(Agente $agente = null, UploadedFile $avatar = null)
    {
        if ($agente && $avatar) {
            
            $filename = $agente->cuit . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            
            Image::make($avatar)
                ->resize(600, 600)
                ->save(public_path(self::$pathAvatar . $filename));
            
            return $filename;
        }
        
        
        return Agente::$avatar;
    }
    
    public static function resetAvatar(Agente $agente = null)
    {
        if ($agente) {
            if ($agente->avatar !== Agente::$avatar) {
                Image::make(public_path(self::$pathAvatar . $agente->avatar))
                    ->destroy();
            }
        }
        
        return Agente::$avatar;
    }
}