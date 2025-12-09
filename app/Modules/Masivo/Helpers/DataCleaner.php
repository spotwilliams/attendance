<?php

namespace Cat\Modules\Masivo\Helpers;

class DataCleaner
{
    
    /**
     * @param $exelCell
     * @return string
     */
    public static function cleanPossibleEmptyValue($exelCell, $isAnId = false)
    {
        $emptyInterpretation = [
            'empty',
            '#N/A',
            '#¡REF!',
        ];
        $value               = trim($exelCell);
        $return              = ($isAnId) ? -1 : '';
        
        return (in_array($value, $emptyInterpretation) ? $return : $value);
    }
    
    public static function cleanPossibleEmptyDate($exelCell)
    {
        $value = self::cleanPossibleEmptyValue($exelCell);
        if (empty($value)) {
            $value = '1900-01-01';
        } else {
            
            $delimiter = (strpos('/', $value) === false) ? '-' : '/';
            
            $date = explode($delimiter, $value);
            if (!is_array($date) or count($date) < 3) {
                $value = '1900-01-01';
            } else {
                $value = $date[2] . '-' . $date[1] . '-' . $date[0];
            }
        }
        
        return $value;
    }
    
}
