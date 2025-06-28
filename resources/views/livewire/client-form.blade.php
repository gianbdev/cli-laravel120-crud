<!-- resources/views/livewire/client-form.blade.php -->
<div class="p-4">

    <!-- Botón para abrir el formulario -->
    <div class="flex justify-end mb-4">
        <!--<button
            wire:click="$toggle('showForm')"
            class="bg-orange-600 text-white px-4 py-2 rounded shadow hover:bg-orange-700 transition">
            {{ $showForm ? 'Cerrar formulario' : 'Agregar cliente' }}
        </button>-->
        <button
            wire:click="resetFormAndShow"
            class="bg-orange-600 text-white px-4 py-2 rounded shadow hover:bg-orange-700 transition">
            {{ $showForm ? 'Cerrar formulario' : 'Agregar cliente' }}
        </button>
    </div>

    <!-- Modal del formulario -->
    @if ($showForm)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="relative w-full max-w-lg rounded-xl p-6 shadow-lg bg-white dark:bg-neutral-800 text-gray-900 dark:text-white">
            <!-- Botón cerrar -->
            <!-- <button wire:click="$toggle('showForm')" -->
            <button wire:click="resetFormAndShow"
                class="absolute top-3 right-4 text-gray-500 hover:text-red-500 text-2xl">
                &times;
            </button>

            <form wire:submit.prevent="store" class="space-y-4">
                <h2 class="text-xl font-semibold mb-4">
                    {{ $client_id ? 'Editar cliente' : 'Nuevo cliente' }}
                </h2>

                <input wire:model="name" type="text" placeholder="Nombre"
                    class="w-full border border-orange-500 bg-white dark:bg-neutral-900 text-black dark:text-white px-4 py-2 rounded shadow-sm focus:ring focus:ring-orange-500 focus:outline-none">

                <input wire:model="email" type="email" placeholder="Correo"
                    class="w-full border border-orange-500 bg-white dark:bg-neutral-900 text-black dark:text-white px-4 py-2 rounded shadow-sm focus:ring focus:ring-orange-500 focus:outline-none">

                <input wire:model="phone" type="text" placeholder="Teléfono"
                    class="w-full border border-orange-500 bg-white dark:bg-neutral-900 text-black dark:text-white px-4 py-2 rounded shadow-sm focus:ring focus:ring-orange-500 focus:outline-none">

                <input wire:model="address" type="text" placeholder="Dirección"
                    class="w-full border border-orange-500 bg-white dark:bg-neutral-900 text-black dark:text-white px-4 py-2 rounded shadow-sm focus:ring focus:ring-orange-500 focus:outline-none">

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 transition">
                        {{ $client_id ? 'Actualizar' : 'Crear' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Tabla de clientes centrada -->
    <div class="flex justify-center">
        <div class="w-full max-w-5xl">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-neutral-700 shadow-md">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class="bg-gray-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Correo
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Teléfono
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-neutral-800 bg-white dark:bg-neutral-900">
                                @forelse ($clients as $client)
                                <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $client->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $client->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                        {{ $client->phone }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 text-center">
                                        <div x-data="{ open: false }" class="relative flex justify-center items-center">
                                            <button @click="open = !open"
                                                class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-neutral-700 transition text-xl">
                                                ⋮
                                            </button>
                                            <div x-show="open" @click.outside="open = false"
                                                x-transition
                                                class="absolute right-0 mt-2 w-32 bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-md shadow-lg z-50">
                                                <button wire:click="edit({{ $client->id }})"
                                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                    📝 Editar
                                                </button>
                                                <button wire:click="delete({{ $client->id }})"
                                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                    🗑️ Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-6 text-sm text-gray-500 dark:text-gray-400">
                                        No hay clientes registrados.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>