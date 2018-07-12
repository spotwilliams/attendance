<?php


namespace Cat\Helpers;


use Illuminate\Support\Facades\Log;

class ErrorLogger
{
    
    protected $map;
    
    protected $uniqueId;
    
    public function __construct()
    {
        $this->uniqueId = $this->uuid();
        
        $this->map = [
            'general' => function (\Exception $e) {
                
                $e->uuid = $this->uniqueId;
                Log::error($e);
                
                return 'Se ha detectado un error inesperado.  Consulte con el nro. de seguimiento: ' . $this->uniqueId;
            },
        ];
        
    }
    
    /**
     * @param \Exception $exception
     * @return string
     */
    public function track(\Exception $exception)
    {
        return $this->specifyng($exception);
    }
    
    protected function specifyng(\Exception $exception)
    {
        $method = $this->map[get_class($exception)] ?? 'general';
        
        return call_user_func($this->map[$method], $exception);
    }
    
    protected function uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0C2f) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0x2Aff), mt_rand(0, 0xffD3), mt_rand(0, 0xff4B)
        );
        
    }
}