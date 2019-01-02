<?php

namespace Cat\Rules;


class Cuit
{

    /**
     * @param $attribute
     * @param $cuit
     * @return bool
     */
    public function validate($attribute, $cuit)
    {
        $digits = array();
        if (strlen($cuit) != 13) {
            return false;
        }
        for ($i = 0; $i < strlen($cuit); $i++) {
            if ($i == 2 or $i == 11) {
                if ($cuit[$i] != '-') {
                    return false;
                }
            } else {
                if (!ctype_digit($cuit[$i])) {
                    return false;
                }
                if ($i < 12) {
                    $digits[] = $cuit[$i];
                }
            }
        }
        $acum = 0;
        foreach (array(5, 4, 3, 2, 7, 6, 5, 4, 3, 2) as $i => $multiplicador) {
            $acum += $digits[$i] * $multiplicador;
        }
        $cmp = 11 - ($acum % 11);
        if ($cmp == 11) {
            $cmp = 0;
        }
        if ($cmp == 10) {
            $cmp = 9;
        }
        
        return ($cuit[12] == $cmp);
    }
    
    public function passesWikipedia($attribute, $value)
    {
        $cuit = preg_replace('/[^\d]/', '', (string)$value);
        if (strlen($cuit) != 11) {
            return false;
        }
        $acumulado = 0;
        $digitos   = str_split($cuit);
        $digito    = array_pop($digitos);
        
        for ($i = 0; $i < count($digitos); $i++) {
            $acumulado += $digitos[9 - $i] * (2 + ($i % 6));
        }
        $verif = 11 - ($acumulado % 11);
        $verif = $verif == 11 ? 0 : $verif;
        
        return $digito === $verif;
    }
    
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El cuit provisto no es v&aacute;lido';
    }
}
