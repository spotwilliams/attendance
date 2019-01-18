<?php

namespace Cat\Modules\Reportes\Services\Formatters;

use Cat\Models\TipoContrato;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class Agente extends RowDataFormatter
{
    public function format(Model $agente)
    {
        return $this->toExcelRow($agente);
    }
    
    protected function toExcelRow(Model $agente)
    {
        $data = [
            'Apellido'                          => $agente->apellido,
            'Nombre'                            => $agente->nombre,
            'CUIT'                              => $agente->cuit,
            'Email'                             => $agente->email,
            'Email gobierno'                    => $agente->email_gobierno,
            'Sexo'                              => ($agente->sexo === 'F') ? 'Mujer' : ($agente->sexo === 'M' ? 'Hombre' : $agente->sexo),
            'Telefono particular'               => $agente->telefono_particular,
            'Telefono casa'                     => $agente->telefono_casa,
            'Telefono ht'                       => $agente->telefono_ht,
            'Estado Civil'                      => $agente->estado_civil,
            'Base'                              => $this->getIfYouCan($agente->operativo, 'base', 'nombre'),
            'Area'                              => $this->getIfYouCan($agente->operativo, 'area', 'nombre'),
            'Cargo'                             => $this->getIfYouCan($agente->operativo, 'cargo', 'nombre'),
            'Turno'                             => $this->getIfYouCan($agente->operativo, 'turno', 'codigo'),
            'Gerencia'                          => $this->getIfYouCan($agente->operativo, 'gerencia', 'nombre'),
            'Funcion'                           => $this->getIfYouCan($agente->operativo, 'funcion', 'nombre'),
            'Funcion especifica'                => $this->getIfYouCan($agente, 'operativo', 'funcion_especifica'),
            'Fecha de ingreso modalidad actual' => $this->getIfYouCanAsDate($agente, 'contrato', 'fecha_ingreso'),
            'Fecha de ingreso al GCBA'          => $this->getIfYouCanAsDate($agente, 'contrato',
                'fecha_ingreso_gobierno'),
            'ID Sial'                           => $this->getIfYouCan($agente, 'contrato', 'id_sial'),
            'Ficha'                             => $this->getIfYouCan($agente, 'contrato', 'ficha'),
            'Tipo de contrato'                  => $this->cleanAcentos($this->getIfYouCan($agente->contrato,
                'tipoContrato',
                'descripcion')),
            'Tipo de inscripcion'               => $this->getIfYouCan($agente, 'contrato', 'tipo_inscripcion'),
            'Monto factura'                     => 0,
            'Estado'                            => $this->getIfYouCan($agente->contrato, 'estadoContrato',
                'descripcion'),
            'Fecha baja'                        => $this->getIfYouCanAsDate($agente, 'contrato', 'fecha_baja'),
            'Comentario baja'                   => $this->getIfYouCan($agente, 'contrato', 'comentario_baja'),
            'Estudios'                          => $this->tieneEstudios($agente->estudio),
            'Observacion'                       => $agente->observacion,
            'Profesion'                         => $agente->profesion,
        ];
        // Solo los tipo locacion tienen un monto valido de contrato. Los demas los sacamos de la vista
        if(TipoContrato::TIPO_LOCACION === $this->getIfYouCan($agente->contrato, 'tipoContrato', 'codigo')){
            $data['Monto factura'] = $this->getIfYouCan($agente, 'contrato', 'monto');
        }
        $horario = $this->getIfYouCan($agente->operativo, 'horario',
                'hora_entrada') . ' - ' . $this->getIfYouCan($agente->operativo, 'horario', 'hora_entrada');
        
        if ($this->getIfYouCan($agente->operativo, 'horario', 'eximido') === true) {
            $horario .= ' (Eximido)';
        }
        if ($this->getIfYouCan($agente->operativo, 'horario', 'rotativo') === true) {
            $horario .= ' (Rotativo)';
        }
        
        $data['Horario'] = $horario;
        
        $domicilios = $this->tieneDomicilios($agente->domicilios);
        
        return array_merge($data, $domicilios);
        
        
    }
    
    private function getIfYouCan(Model $model = null, $entity = '', $name = '')
    {
        if ($model) {
            if ($model->{$entity}) {
                $v = $model->{$entity}->{$name};
                if ($v !== '-1') {
                    return $model->{$entity}->{$name};
                }
            }
        }
        
        return '';
    }
    
    private function getIfYouCanAsDate(Model $model = null, $entity = '', $name = '', $format = 'd/m/Y')
    {
        $temp = $this->getIfYouCan($model, $entity, $name);
        if ($temp) {
            return (new \DateTime($temp))->format($format);
        } else {
            return '';
        }
    }
    
    protected function tieneDomicilios(Collection $domicilios = null)
    {
        $return = [
            'Domicilio constituido' => '',
            'Domicilio real'        => '',
        ];
        if ($domicilios) {
            
            foreach ($domicilios as $domicilio) {
                $dom = "Calle: {$domicilio->calle} - Nro: {$domicilio->numero} - Dpto: {$domicilio->departamento} - Piso: {$domicilio->piso} - Barrio: {$domicilio->barrio} - Prov: {$domicilio->provincia} - Codigo postal: {$domicilio->codigo_postal} - Otro: {$domicilio->libre}";
                if ($domicilio->constituido === true) {
                    $return['Domicilio constituido'] = $dom;
                } else {
                    $return['Domicilio real'] = $dom;
                }
            }
        }
        
        return $return;
    }
    
    protected function tieneEstudios(Collection $estudios = null)
    {
        
        $return = '';
        if ($estudios) {
            
            foreach ($estudios as $estudio) {
                $return .= "Carrera: {$estudio->carrera} - Institucion: {$estudio->institucion} - Estado : {$estudio->estado}";
            }
        }
        
        return $return;
    }
    
}