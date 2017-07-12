<?php

namespace Cat\Masivo\Helpers;

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
        
        return (empty($value) ? '1900-01-01' : $value);
    }
    
}