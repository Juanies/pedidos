<?php

namespace App\Livewire\Forms;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormCreateOrder extends Form
{
    #[Validate(["required", "min:3", "max:50", "unique:orders,nombre", "string"])]
    public string $nombre = "";
    #[Validate(["required", "in:Procesado,Pendiente"])]
    public string $estado = "";
    #[Validate(["required", "numeric", "between:0,9999.99"])]
    public float $cantidad = 0;

    public function fGuardarPost(){
        $this->validate();
        Order::create([
            "nombre" => $this->nombre,
            "estado" => $this->estado,
            "cantidad" => $this->cantidad,
            "user_id" => Auth::id()
        ]);
    }

    public function fLimpiar()  {
        $this->reset();
    }

}
