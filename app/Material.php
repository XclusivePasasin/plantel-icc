<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    public function addLotChangeToHistory($oldValue, $newValue, $user)
    {
        $historial = json_decode($this->lot_changes_history ?? '[]', true);

        $historial[] = [
            'antiguo_valor' => $oldValue,
            'nuevo_valor' => $newValue,
            'usuario' => $user,
            'fecha' => now()->format('Y-m-d H:i:s')
        ];

        $this->lot_changes_history = json_encode($historial);
    }

}
