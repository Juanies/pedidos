<?php

namespace App\Livewire;

use App\Livewire\Forms\FormUpdateOrder;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUserOrder extends Component
{
    use WithPagination;


    public string $campo = "id", $orden = "desc";
    public string $buscar = "";

    public FormUpdateOrder $uform;
    public bool $openModalu = false;

    #[On('postcreado')]
    public function render()
    {
        //$orders = Order::where("user_id", FacadesAuth::id())->paginate(5);

            $orders = Order::where("user_id", Auth::user()->id)
                ->where(function ($query) {
                    $query->where('nombre', 'like', "%{$this->buscar}%")
                        ->orWhere('estado', 'like', "%{$this->buscar}%")
                        ->orWhere('cantidad', 'like', "%{$this->buscar}%");

                })
                ->orderBy($this->campo, $this->orden)
                ->paginate(5);



        return view('livewire.show-user-order', compact("orders"));
    }

    // metodo que se ejecuta automaticamente al actualizarse la variable llamada buscar
    public function updatingbuscar(){
        $this->resetPage();
    }

    public function cambiarEstado(Order $order)  {
        $this->authorize('update', $order);
        $estado = $order->estado == "Procesado" ? "Pendiente" : "Procesado";
        $order->update([
            "estado" => $estado
        ]);
    }

    #[On('eBorrarConfirmado')]
    public function destroy(Order $order)  {
        $this->authorize('delete', $order);
        $order->delete();
    }

    public function ordenar(string $campo){
        $this->orden = $this->orden == "asc" ? "desc" : "asc";
        $this->campo = $campo;
    }

    public function edit(Order $order){
        $this->authorize("update", $order);
        $this->uform->setOrder($order);
        $this->openModalu = true;
    }
    public function update(){
        $this->uform->FactualizarPost();
        $this->dispatch('mensaje', 'Post Editado');
        $this->cancelar();
    }

    public function cancelar(){
        $this->reset();
    }

    public function mostrarAlerta(Order $order){
        $this->authorize('delete', $order);
        $this->dispatch('alertaBorrar', $order->id);

    }






}
