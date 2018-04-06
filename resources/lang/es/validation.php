<?php

return [
    
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | El following language lines contain El default error messages used by
    | El validator class. Some of Else rules have multiple versions such
    | as El size rules. Feel free to tweak each of Else messages here.
    |
    */
    
    'accepted'              => 'El :attribute debe ser accepted.',
    'active_url'            => 'El :attribute is not a valid URL.',
    'after'                 => 'El :attribute debe ser a date after :date.',
    'alpha'                 => 'El :attribute may only contain letters.',
    'alpha_dash'            => 'El :attribute may only contain letters, numbers, y dashes.',
    'alpha_num'             => 'El :attribute may only contain letters y numbers.',
    'array'                 => 'El :attribute debe ser an array.',
    'before'                => 'El :attribute debe ser a date before :date.',
    'between'               => [
        'numeric' => 'El :attribute debe ser entre :min y :max.',
        'file'    => 'El :attribute debe ser entre :min y :max kilobytes.',
        'string'  => 'El :attribute debe ser entre :min y :max characters.',
        'array'   => 'El :attribute must have between :min y :max items.',
    ],
    'boolean'               => 'El campo :attribute debe ser true or false.',
    'confirmed'             => 'El campo de confirmaci&oacute;n de :attribute no coincide.',
    'date'                  => 'No es una fecha correcta.',
    'date_format'           => 'El :attribute does not match El format :format.',
    'different'             => 'El :attribute y :oElr debe ser different.',
    'digits'                => 'El :attribute debe ser :digits d&iacute;gitos.',
    'digits_between'        => 'El :attribute debe ser entre :min y :max d&iacute;gitos.',
    'distinct'              => 'El campo :attribute has a duplicate value.',
    'email'                 => 'El :attribute debe ser una direcci&oacute;n v&aacute;lida.',
    'exists'                => 'El valor elegido no es correcto.',
    'filled'                => 'El campo :attribute es obligatorio.',
    'image'                 => 'El :attribute debe ser an image.',
    'in'                    => 'El valor elegido no es correcto.',
    'in_array'              => 'El campo :attribute does not exist in :oElr.',
    'integer'               => 'Debe ser un n&uacute;mero.',
    'ip'                    => 'El :attribute debe ser a valid IP address.',
    'json'                  => 'El :attribute debe ser a valid JSON string.',
    'max'                   => [
        'numeric' => 'El :attribute may not be greater than :max.',
        'file'    => 'El :attribute may not be greater than :max kilobytes.',
        'string'  => 'El :attribute may not be greater than :max characters.',
        'array'   => 'El :attribute may not have more than :max items.',
    ],
    'mimes'                 => 'El :attribute debe ser un archivo del tipo :values.',
    'mimetypes'             => 'El archivo debe ser el tipo indicado.',
    'min'                   => [
        'numeric' => 'El campo de ser al menos mayor a :min.',
        'file'    => 'El :attribute debe ser at least :min kilobytes.',
        'string'  => 'El :attribute debe ser at least :min characters.',
        'array'   => 'El :attribute must have at least :min items.',
    ],
    'not_in'                => 'El valor elegido no es correcto.',
    'numeric'               => 'El :attribute debe ser a number.',
    'present'               => 'El campo :attribute debe ser present.',
    'regex'                 => 'El :attribute format is invalid.',
    'required'              => 'El campo es obligatorio.',
    'required_if'           => 'El campo :attribute es obligatorio when :oElr is :value.',
    'required_unless'       => 'El campo :attribute es obligatorio unless :oElr is in :values.',
    'required_with'         => 'El campo :attribute es obligatorio when :values is present.',
    'required_with_all'     => 'El campo :attribute es obligatorio when :values is present.',
    'required_without'      => 'El campo :attribute es obligatorio when :values is not present.',
    'required_without_all'  => 'El campo :attribute es obligatorio when none of :values are present.',
    'same'                  => 'El :attribute y :oElr must match.',
    'size'                  => [
        'numeric' => 'El :attribute debe ser :size.',
        'file'    => 'El :attribute debe ser :size kilobytes.',
        'string'  => 'El :attribute debe ser :size characters.',
        'array'   => 'El :attribute must contain :size items.',
    ],
    'string'                => 'El :attribute debe ser a string.',
    'timezone'              => 'El :attribute debe ser a valid zone.',
    'unique'                => 'El :attribute has already been taken.',
    'url'                   => 'El :attribute format is invalid.',
    'cuit'                  => 'El CUIT provisto no es v&aacute;lido.',
    'cuit_unico'            => 'El CUIT provisto pertenece a otro agente.',
    'fecha_contrato_futuro' => 'La fecha no puede ser mayor a la actual.',
    'fecha_contrato'        => 'La fecha no puede ser menor a 90 d&iacute;as.',
    
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using El
    | convention "attribute.rule" to name El lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */
    
    'custom' => [
        /*
         * Modificacion masiva de fechas de contrato
         */
        'fecha_contrato'      => [
            'required' => 'La fecha de contrato es obligatoria',
            'date'     => 'Formato de fecha incorrecto',
            'before'   => 'La fecha de contrato no puede ser mayor a la actual',
        ],
        'gerencias'           => [
            'required' => 'Debe seleccinar al menos una gerencia',
        ],
        /*
         *
         */
        'domicilio'           => [
            'calle'       => [
                0 => [
                    'required' => 'Debe existir al menos un domicilio.',
                ],
                1 => [
                    'required' => 'Un domicilio sin calle no es posible.',
                ],
            ],
            'numero'      => [
                0 => [
                    'integer'  => 'Debe ser un n&uacute;mero.',
                    'required' => 'Es obligatorio.',
                ],
            ],
            'constituido' => [
                0 => [
                    'not_in' => 'El primer domicilio debe ser constituido.',
                ],
            ],
        ],
        'turnos'              => [
            'required' => 'Debe seleccionar al menos uno',
        ],
        'areas'               => [
            'required' => 'Debe seleccionar al menos uno',
        ],
        'telefono_particular' => [
            'digits_between' => 'El tel&eacute;fono debe ser un n&uacute;mero v&aacute;lido',
        ],
        'telefono_casa'       => [
            'digits_between' => 'El tel&eacute;fono debe ser un n&uacute;mero v&aacute;lido',
        ],
        'telefono_ht'         => [
            'digits_between' => 'El tel&eacute;fono debe ser un n&uacute;mero v&aacute;lido',
        ],
    
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | El following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */
    
    'attributes' => [
    ],

];
