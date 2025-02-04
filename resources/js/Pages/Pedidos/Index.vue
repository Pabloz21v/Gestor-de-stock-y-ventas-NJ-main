<script>
export default {
    name: 'PedidosIndex'
}
</script>

<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    pedidos: {
        type: Array,
        required: true
    },
    products: {
        type: Array,
        required: true
    }
});

const showModalCreate = ref(false);
const showModalEdit = ref(false);
const showModalDelete = ref(false);
const modalProductData = ref(null);
const modalDataID = ref(null);

const openModalCreate = () => {
    modalProductData.value = {
        product_id: '',
        stock_real: 0,
        stock_en_viaje: 0,
        stock_en_viaje_vendido: 0,
        proveedor: '',
        web: ''
    };
    showModalCreate.value = true;
};

const openModalEdit = (pedido) => {
    modalProductData.value = { ...pedido };
    showModalEdit.value = true;
};

const openModalDelete = (id) => {
    modalDataID.value = id;
    showModalDelete.value = true;
};

const closeModal = () => {
    showModalCreate.value = false;
    showModalEdit.value = false;
    showModalDelete.value = false;
    modalProductData.value = null;
    modalDataID.value = null;
};

const createPedido = () => {
    Inertia.post(route('pedidos.store'), modalProductData.value, {
        onSuccess: () => closeModal()
    });
};

const updatePedido = () => {
    Inertia.put(route('pedidos.update', modalProductData.value.id), modalProductData.value, {
        onSuccess: () => closeModal()
    });
};

const deletePedido = () => {
    Inertia.delete(route('pedidos.destroy', modalDataID.value), {
        onSuccess: () => closeModal()
    });
};

// const moveStock = (from, to, amount) => {
//     if (modalProductData.value[from] >= amount) {
//         modalProductData.value[from] -= amount;
//         modalProductData.value[to] += amount;
//     }
// };

// Función para transferencias desde la tabla
const moveStock = async (pedido, action) => {
    if (!action) return;
    
    let amount;

    if (action === 'all_to_real') {
        const total = pedido.stock_en_viaje + pedido.stock_en_viaje_vendido;
        if (total <= 0) {
            alert('No hay stock para transferir');
            return;
        }

        if (!confirm(`¿Transferir todo el stock (${total} unidades) a Real?`)) return;
        amount = total; // Usamos el total como amount
    } else {
        const max = action === 'viaje_to_real' 
            ? pedido.stock_en_viaje 
            : pedido.stock_en_viaje_vendido;

        amount = prompt(`Ingrese la cantidad (máximo: ${max})`);
        if (!amount || amount <= 0 || amount > max) return;
    }

    try {
        await Inertia.patch(route('pedidos.transfer', pedido.id), {
            action,
            amount: parseInt(amount)
        });
    } catch (error) {
        alert('Error al transferir');
    }
    // const amount = prompt(`Ingrese la cantidad a transferir (máximo: ${action === 'viaje_to_real' ? pedido.stock_en_viaje : pedido.stock_en_viaje_vendido
    //     })`);

    // if (amount && amount > 0) {
    //     try {
    //         await Inertia.patch(route('pedidos.transfer', pedido.id), {
    //             action,
    //             amount: parseInt(amount)
    //         });
    //     } catch (error) {
    //         alert('Error al transferir');
    //     }
    // }
};

// Función para transferencias dentro del modal
const moveStockInModal = (destination, source) => {
    if (!source) return;

    if (source === 'all') {
        // Calcular total de stock en viaje y vendido para transferirlo a stock real
        const total = modalProductData.value.stock_en_viaje + modalProductData.value.stock_en_viaje_vendido;

        if (total > 0 && confirm(`¿Transferir todo el stock (${total} unidades) a Real?`)) {
            modalProductData.value.stock_real += total;
            modalProductData.value.stock_en_viaje = 0;
            modalProductData.value.stock_en_viaje_vendido = 0;
        }
        return;
    }

    const maxAmount = modalProductData.value[`stock_en_viaje${source === 'vendido' ? '_vendido' : ''}`];
    const amount = prompt(`Cantidad a transferir a Real (máximo: ${maxAmount})`);

    if (amount && amount > 0 && amount <= maxAmount) {
        modalProductData.value[`stock_en_viaje${source === 'vendido' ? '_vendido' : ''}`] -= parseInt(amount);
        modalProductData.value.stock_real += parseInt(amount);
    }
};
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Pedidos</h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <button @click="openModalCreate" class="bg-blue-500 text-white px-4 py-2 rounded">Crear
                            Pedido</button>
                        <table class="min-w-full mt-4">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Producto</th>
                                    <th class="px-4 py-2">Stock Real</th>
                                    <th class="px-4 py-2">Stock en Viaje</th>
                                    <th class="px-4 py-2">Stock en Viaje Vendido</th>
                                    <th class="px-4 py-2">Acciones Stock</th>
                                    <th class="px-4 py-2">Proveedor</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="pedido in pedidos" :key="pedido.id">
                                    <td class="border px-4 py-2">{{ pedido.product?.name }}</td>
                                    <td class="border px-4 py-2">{{ pedido.stock_real }}</td>
                                    <td class="border px-4 py-2">{{ pedido.stock_en_viaje }}</td>
                                    <td class="border px-4 py-2">{{ pedido.stock_en_viaje_vendido }}</td>
                                    <td class="border px-4 py-2">
                                        <select @change="moveStock(pedido, $event.target.value)"
                                            class="border rounded px-2 py-1">
                                            <option value="">Transferir stock</option>
                                            <option value="viaje_to_real">Mover de Viaje a Real</option>
                                            <option value="vendido_to_real">Mover de Vendido a Real</option>
                                            <option value="all_to_real">Mover Todo a Real</option>
                                        </select>
                                    </td>
                                    <td class="border px-4 py-2">{{ pedido.proveedor }}</td>
                                    <td class="border px-4 py-2">
                                        <button @click="openModalEdit(pedido)"
                                            class="bg-yellow-500 text-white px-4 py-2 rounded">Editar</button>
                                        <button @click="openModalDelete(pedido.id)"
                                            class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Create -->
        <div v-if="showModalCreate" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Crear Pedido</h3>

                                <div class="mt-2">
                                    <div class="grid grid-cols-2 gap-4">
                                        <!-- Tranferir de stock en viaje o vendido a real -->
                                        <div>
                                            <select v-if="showModalEdit"
                                                @change="moveStockInModal('real', $event.target.value)"
                                                class="mt-2 border rounded px-2 py-1">
                                                <option value="">Transferir a Real</option>
                                                <option value="viaje">Desde Viaje ({{ modalProductData.stock_en_viaje
                                                    }})
                                                </option>
                                                <option value="vendido">Desde Vendido ({{
                                                    modalProductData.stock_en_viaje_vendido }})</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700">Producto</label>
                                    <select v-model="modalProductData.product_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option v-for="product in products" :key="product.id" :value="product.id">{{
                                            product.name }}</option>
                                    </select>
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Stock Real</label>
                                    <input v-model="modalProductData.stock_real" type="number" min="0"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Stock en Viaje</label>
                                    <input v-model="modalProductData.stock_en_viaje" type="number" min="0"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Stock en Viaje
                                        Vendido</label>
                                    <input v-model="modalProductData.stock_en_viaje_vendido" type="number" min="0"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Proveedor</label>
                                    <input v-model="modalProductData.proveedor" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Web</label>
                                    <input v-model="modalProductData.web" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="createPedido" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Crear</button>
                        <button @click="closeModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div v-if="showModalEdit" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Editar Pedido</h3>
                                <div class="mt-2">
                                    <!-- En el modal (tanto create como edit) -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <!-- Stock Real -->
                                        <div>
                                            <select v-if="showModalEdit"
                                                @change="moveStockInModal('real', $event.target.value)"
                                                class="mt-2 border rounded px-2 py-1">
                                                <option value="">Transferir a Real</option>
                                                <option value="all">Todo el Stock Disponible</option>
                                                <option value="viaje">Desde Viaje ({{ modalProductData.stock_en_viaje
                                                    }})
                                                </option>
                                                <option value="vendido">Desde Vendido ({{
                                                    modalProductData.stock_en_viaje_vendido }})</option>
                                            </select>
                                        </div>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700">Producto</label>
                                    <select v-model="modalProductData.product_id"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        <option v-for="product in products" :key="product.id" :value="product.id">
                                            {{ product.name }}
                                        </option>
                                    </select>
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Stock Real</label>
                                    <input v-model="modalProductData.stock_real" type="number"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Stock en Viaje</label>
                                    <input v-model="modalProductData.stock_en_viaje" type="number"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Stock en Viaje
                                        Vendido</label>
                                    <input v-model="modalProductData.stock_en_viaje_vendido" type="number"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Proveedor</label>
                                    <input v-model="modalProductData.proveedor" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                    <label class="block text-sm font-medium text-gray-700 mt-4">Web</label>
                                    <input v-model="modalProductData.web" type="text"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="updatePedido" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-yellow-600 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm">Actualizar</button>
                        <button @click="closeModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div v-if="showModalDelete" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar Pedido</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">¿Estás seguro de que deseas eliminar este pedido?
                                        Esta
                                        acción no se puede deshacer.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="deletePedido" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Eliminar</button>
                        <button @click="closeModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
