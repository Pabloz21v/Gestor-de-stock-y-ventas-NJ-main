<script>
export default {
    name: 'SalesIndex',
    data() {
        return {
            showModal: false,
            selectedSale: null,
            isLoading: false,
            timeRange: '',
            vendedorFilter: '',
            sortByReg: false,
        };
    },
    methods: {
        openModal(sale) {
            this.selectedSale = sale;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.selectedSale = null;
        },
        updateSaleEstado(sale) {
            this.isLoading = true;
            Inertia.put(route('sales.updateEstado', { sale: sale.id }), { estado: sale.estado }, {
                onSuccess: () => {
                    this.isLoading = false;
                },
                onError: () => {
                    this.isLoading = false;
                }
            });
        },
        getEstadoClass(estado) {
            switch (estado) {
                case 'ENTREGADO':
                    return 'bg-green-200 font-bold';
                case 'CANCELADO':
                    return 'bg-red-200 font-bold';
                case 'EN_PREPARACION':
                    return 'bg-yellow-200 font-bold';
                case 'VERIFICANDO':
                    return 'bg-blue-200 font-bold';
                case 'PENDIENTE':
                    return 'bg-white font-bold';
                case 'CONSIGNA':
                    return 'bg-purple-200 font-bold';
                default:
                    return '';
            }
        },
        deleteSale(id) {
            this.isLoading = true;
            Inertia.delete(route('sales.destroy', id), {
                onSuccess: () => {
                    this.isLoading = false;
                },
                onError: () => {
                    this.isLoading = false;
                }
            });
        },
        applyFilters() {
            Inertia.get(route('sales.index'), { estado: this.estadoFilter, timeRange: this.timeRange, vendedor: this.vendedorFilter, sortByReg: this.sortByReg }, { preserveState: true });
        },
        clearFilters() {
            this.estadoFilter = '';
            this.timeRange = '';
            this.vendedorFilter = '';
            this.sortByReg = false;
            this.applyFilters();
        },
        toggleSortByReg() {
            this.sortByReg = !this.sortByReg;
            this.applyFilters();
        }
    },
};
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref, computed } from 'vue';
import Spinner from './../../Components/Spinner/Spinner.vue';

const props = defineProps({
    sales: {
        type: Array,
        required: true
    },
    filters: {
        type: Object,
        required: false
    },
    userPermissions: {
        type: Array,
        required: false,
        default: () => []
    },
    currentUser: {
        type: Object,
        required: false,
        default: () => ({})
    },
    users: {
        type: Array,
        required: true
    }
});

const estadoFilter = ref(props.filters.estado || '');
const timeRange = ref(props.filters.timeRange || '');
const vendedorFilter = ref(props.filters.vendedor || '');
const sortByReg = ref(props.filters.sortByReg || false);

const applyFilters = () => {
    Inertia.get(route('sales.index'), { estado: estadoFilter.value, timeRange: timeRange.value, vendedor: vendedorFilter.value, sortByReg: sortByReg.value }, { preserveState: true });
};

const clearFilters = () => {
    estadoFilter.value = '';
    timeRange.value = '';
    vendedorFilter.value = '';
    sortByReg.value = false;
    applyFilters();
};

const toggleSortByReg = () => {
    sortByReg.value = !sortByReg.value;
    applyFilters();
};

const isAdmin = computed(() => props.userPermissions.includes('create roles'));
const isEditor = computed(() => props.userPermissions.includes('update products'));
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Ventas</h1>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-semibold">Ventas</span>
                        <Link :href="route('sales.create')" class="bg-cyan-500 text-white rounded-lg px-4 py-2">
                        Crear Venta
                        </Link>
                    </div>
                    <div class="mb-4 flex space-x-4">
                        <select v-model="estadoFilter" @change="applyFilters" class="border rounded px-3 pr-8 py-1">
                            <option value="">Estado</option>
                            <option value="ENTREGADO">ENTREGADO</option>
                            <option value="PENDIENTE">PENDIENTE</option>
                            <option value="CANCELADO">CANCELADO</option>
                            <option value="EN_PREPARACION">EN PREPARACION</option>
                            <option value="VERIFICANDO">VERIFICANDO</option>
                            <option value="CONSIGNA">CONSIGNA</option>
                        </select>
                        <select v-model="timeRange" @change="applyFilters" class="border rounded px-3 pr-8 py-1">
                            <option value="">Rango Horario</option>
                            <option value="morning">Mañana (00:00 - 12:00)</option>
                            <option value="afternoon">Tarde (12:00 - 18:00)</option>
                            <option value="evening">Noche (18:00 - 00:00)</option>
                        </select>
                        <select v-if="$page.props.user.permissions.includes('create roles')" v-model="vendedorFilter" @change="applyFilters" class="border rounded px-3 pr-8 py-1">
                            <option value="">Vendedor</option>
                            <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
                        </select>
                        <button @click="toggleSortByReg" class="bg-blue-500 text-white rounded-lg px-4 py-2">
                            Ordenar por Registro
                        </button>
                        <button @click="clearFilters" class="bg-red-500 text-white rounded-lg px-4 py-2">
                            Limpiar Filtros
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2">Reg</th>
                                    <th class="px-4 py-2">Fecha</th>
                                    <th class="px-4 py-2">Cliente</th>
                                    <th class="px-4 py-2">Vendedor</th>
                                    <th class="px-4 py-2">Producto</th>
                                    <th class="px-4 py-2">Estado</th>
                                    <th class="px-4 py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="sale in props.sales" :key="sale.id">
                                    <td class="border px-4 py-2">{{ sale.reg }}</td>
                                    <td class="border px-4 py-2">{{ new Date(sale.created_at).toLocaleDateString() }}</td>
                                    <td class="border px-4 py-2">{{ sale.cliente }}</td>
                                    <td class="border px-4 py-2">{{ sale.user?.name || 'N/A' }}</td>
                                    <td class="border px-4 py-2">{{ sale.product?.name || 'N/A' }}</td>
                                    <td :class="getEstadoClass(sale.estado)" class="border px-4 py-2">
                                        <template v-if="$page.props.user.permissions.includes('create roles')">
                                            <select v-model="sale.estado" @change="updateSaleEstado(sale)"
                                                class="border rounded px-3 pr-8 py-1">
                                                <option value="ENTREGADO">ENTREGADO</option>
                                                <option value="PENDIENTE">PENDIENTE</option>
                                                <option value="CANCELADO">CANCELADO</option>
                                                <option value="EN_PREPARACION">EN PREPARACION</option>
                                                <option value="VERIFICANDO">VERIFICANDO</option>
                                                <option value="CONSIGNA">CONSIGNA</option>
                                            </select>
                                        </template>
                                        <template v-else>
                                            {{ sale.estado }}
                                        </template>
                                    </td>

                                    <td class="border px-4 py-2">
                                        <Link v-if="sale.estado === 'PENDIENTE'" :href="route('sales.edit', sale.id)" class="text-blue-500">Editar</Link>
                                        <button v-if="sale.estado === 'PENDIENTE'" @click="deleteSale(sale.id)" class="text-red-500 ml-2">Eliminar</button>
                                        <button @click="openModal(sale)" class="text-green-500 ml-2">Ver</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
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
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Detalles de la Venta
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Reg: {{ selectedSale.reg }}</p>
                                    <p class="text-sm text-gray-500">Fecha: {{ new
                                        Date(selectedSale.created_at).toLocaleDateString() }}</p>
                                    <p class="text-sm text-gray-500">Cliente: {{ selectedSale.cliente }}</p>
                                    <p class="text-sm text-gray-500">Contacto: {{ selectedSale.contacto }}</p>
                                    <p class="text-sm text-gray-500">Vendedor: {{ selectedSale.user?.name || 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">Producto: {{ selectedSale.product?.name || 'N/A' }}</p>
                                    <p class="text-sm text-gray-500">Precio: {{ selectedSale.precio }}</p>
                                    <p class="text-sm text-gray-500">Unidades: {{ selectedSale.unidades }}</p>
                                    <p class="text-sm text-gray-500">Entrada: {{ selectedSale.entrada }}</p>
                                    <p class="text-sm text-gray-500">Pendiente: {{ selectedSale.pendiente }}</p>
                                    <p class="text-sm text-gray-500">Sub Total: {{ selectedSale.sub_total }}</p>
                                    <p class="text-sm text-gray-500">Estado: {{ selectedSale.estado }}</p>
                                    <p class="text-sm text-gray-500">Sobreprecio: {{ selectedSale.sobreprecio }}</p>
                                    <p class="text-sm text-gray-500">Observación: {{ selectedSale.observacion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="closeModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <Spinner v-if="isLoading" />
    </AppLayout>
</template>
