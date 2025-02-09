<x-self.base>
    <div class="flex w-full items-center mb-2 justify-between">
        <div>
            <x-input placeholder="Buscar..." wire:model.live="buscar" /><i class="mr-2 fas fa-search"></i>
        </div>
        <div>
            @livewire('create-order')
        </div>
    </div>
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th  wire:click="ordenar('nombre')" scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th wire:click="ordenar('estado')" scope="col" class="px-6 py-3">
                        Estado
                    </th>
                    <th wire:click="ordenar('cantidad')" scope="col" class="px-6 py-3">
                        Cantidad
                    </th>
                    <th wire:click="ordenar('updated_at')" scope="col" class="px-6 py-3">
                        Fecha
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->nombre }}
                        </th>
                        <td class="px-6 py-4">
                            <button wire:click='cambiarEstado({{ $item->id }})' @class([
                                'p-2 rounded-xl text-white font-bold ',
                                'bg-red-500' => $item->estado == 'Pendiente',
                                'bg-blue-500' => $item->estado == 'Procesado',
                            ])>
                                {{ $item->estado }}
                            </button>
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->cantidad }}
                        </td>
                        <td class="px-6 py-4">
                            {{$item->updated_at->format("d/m/y") }}
                        </td>
                        <td class="px-6  py-4 ">
                            <button wire:click='mostrarAlerta({{$item->id}})' class="mr-2">
                                <i class="fas fa-trash text-red-500"></i>
                            </button>
                            <button wire:click="edit({{$item->id}})">
                                <i class="fas fa-edit text-blue-500"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div>
        {{ $orders->links() }}
    </div>

    @isset($uform->order)
    <x-dialog-modal wire:model="openModalu">
        <x-slot name="title">
            <h2>Crear Order</h2>
        </x-slot>
        <x-slot name="content">
             <!-- Campo Nombre -->
             <div class="mb-6">
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Nombre
                    </span>
                </label>
                <input type="text" id="nombre" wire:model="uform.nombre" name="nombre" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <x-input-error for="uform.nombre"></x-input-error>

            <!-- Campo Estado (Radio Buttons) -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Estado
                    </span>
                </label>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" name="estado" id="" itemid="pendiente" wire:model="uform.estado" value="Pendiente" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-700">Pendiente</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" id="procesado" name="estado" wire:model="uform.estado" value="Procesado" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-700">Procesado</span>
                    </label>
                </div>
            </div>
            <x-input-error for="uform.estado"></x-input-error>

            <!-- Campo Cantidad -->
            <div class="mb-6">
                <label for="cantidad" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Cantidad
                    </span>
                </label>
                <input wire:model="uform.cantidad" type="number" id="cantidad" name="cantidad" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <x-input-error for="uform.cantidad"></x-input-error>

            <!-- Botones -->

        </x-slot>
        <x-slot name="footer">
            <div class="flex justify-end space-x-4">
                <button type="reset" class="flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Reset
                </button>
                <button type="button" class="flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancelar
                </button>
                <button wire:click='update' type="submit" class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Enviar
                </button>
            </div>
        </x-slot>
    </x-dialog-modal>
    @endisset

</x-self.base>
