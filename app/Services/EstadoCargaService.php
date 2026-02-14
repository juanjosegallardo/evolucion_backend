<?php
class CargaEstadoService
{
    public function cambiarEstado(Carga $carga, string $nuevoEstado)
    {
        $permitidos = [
            'BORRADOR' => ['ENVIADO'],
            'ENVIADO' => ['VALIDADO', 'RECHAZADO'],
            'VALIDADO' => [],
        ];

        if (!in_array($nuevoEstado, $permitidos[$carga->estado] ?? [])) {
            throw new \Exception("Transición de estado no permitida");
        }

        $carga->estado = $nuevoEstado;
        $carga->save();
    }
}