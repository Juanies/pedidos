<?php

namespace App\Livewire;

use App\Livewire\Forms\FormCreateOrder;
use Livewire\Component;

class CreateOrder extends Component
{
    public bool $openModalCrear = false;
    public FormCreateOrder $form;


    public function store()  {
        $this->form->fGuardarPost();

        $this->dispatch('postcreado')->to(ShowUserOrder::class);
        $this->dispatch('mensaje', 'Post creado');
        $this->cancelar();
    }

    public function cancelar(){
        $this->openModalCrear=false;
        $this->form->fLimpiar();
    }
    public function resetCancelar(){
        $this->form->fLimpiar();
    }

    public function render()
    {
        return view('livewire.create-order');
    }
}
