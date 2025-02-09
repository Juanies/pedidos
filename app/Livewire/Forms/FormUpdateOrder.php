<?php

namespace App\Livewire\Forms;

use App\Models\Order;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormUpdateOrder extends Form
{

    public string $nombre = "";
    #[Validate(["required", "in:Procesado,Pendiente"])]
    public string $estado = "";
    #[Validate(["required", "numeric", "between:0,9999.99"])]
    public float $cantidad = 0;
    public ?Order $order = null;


    public function rules()  {
        return [
            "nombre" => ["required", "min:3", "max:50","string", "unique:orders,nombre".$this->order->id, ]
        ];
    }

    public function setOrder(Order $order){
        $this->order = $order;
        $this->nombre = $order->nombre;
        $this->estado = $order->estado;
        $this->cantidad = $order->cantidad;
    }

    public function FactualizarPost(){
            $this->validate();
            $this->order->update([
                "nombre" => $this->nombre,
                "estado" => $this->estado,
                "cantidad" => $this->cantidad
            ]);
    }

    public function fCancelar(){
        $this->reset();
    }



}
