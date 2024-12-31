<script>
	export default {
		name: 'HistoryIndex'
	}
</script>

<script setup>
import { ref } from 'vue';
// import { usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
    histories: Array
});

const histories = ref(props.histories);
const showModal = ref(false);
const modalData = ref({});

const openModal = (history) => {
    modalData.value = history;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    modalData.value = {};
};

// const goToBackups = () => {
//     Inertia.visit(route('backups.index'));
// };
</script>

<template>
    <AppLayout v-if="$page.props.user.permissions.includes('create roles')">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">Historial</h1>
        </template>
		
        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row justify-between items-center mb-4">
                            <span class="text-lg font-semibold">Historial</span>
                            <Link :href="route('backups.index')" class="bg-cyan-500 text-white rounded-lg px-4 py-2 mt-4 md:mt-2  lg:mt-0">
                                Ver Backups
                            </Link>
                    </div>
                </div>
                
        
		<div class="py-12 " v-if="$page.props.user.permissions.includes('create roles')">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="container mx-auto p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="w-1/8 px-4 py-2 hidden sm:table-cell">Fecha</th>
                                        <th class="w-1/8 px-4 py-2 ">Nombre</th>
                                        <th class="w-1/8 px-4 py-2 hidden sm:table-cell">Cargo</th>
                                        <th class="w-1/8 px-4 py-2 ">Acción</th>
                                        <th class="w-1/8 px-4 py-2 hidden sm:table-cell">En</th>
                                        <th class="w-1/8 px-4 py-2 hidden sm:table-cell">Datos</th>
                                        <th class="w-1/8 px-4 py-2">Detalles</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr  v-for="history in histories" :key="history.id">
                                        <td class="border px-4 py-2 hidden sm:table-cell">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">{{ new Date(history.created_at).toLocaleString() }}</p>
                                                    
                                        </td>
                                        <td class="border px-4 py-2 ">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{history.person}}</p>
                                                    
                                        </td>
                                        <td class="border px-4 py-2 hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{history.cargo}}</p>
                                                    
                                        </td>
                                        <td class="border px-4 py-2 ">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">{{history.action }}</p>
                                                    
                                        </td>
                                        <td class="border px-4 py-2 hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{history.entity_type }}</p>
                                                    
                                        </td>
                                        <td class="border px-4 py-2 hidden sm:table-cell">
                                            <div class="mt-1 truncate text-xs leading-5 text-gray-500">
                                                <div v-if="history.action == 'crear' && history.entity_type == 'plato'   ">
                                                    <p>Nombre: {{ history.data.name }}</p>
                                                    <p>Precio: {{ history.data.price }}</p>
                                                    <p>Ingredientes: {{ history.data.ingredients }}</p>
                                                    <p v-if="history.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="history.action == 'eliminar' && history.entity_type == 'plato' ">
                                                    <p>Nombre: {{ history.data.name }}</p>
                                                    <p>Precio: {{ history.data.price }}</p>
                                                    <p>Ingredientes: {{ history.data.ingredients }}</p>
                                                    <p v-if="history.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="history.action == 'actualizar' && history.entity_type == 'plato' ">
                                                        <div v-if="history.data.new.name != history.data.old.name">
                                                            <p class="font-semibold">Cambio de nombre</p>
                                                            <p>{{history.data.old.name}} -> {{history.data.new.name}} </p>
                                                        </div>
                                                        <div v-if="history.data.new.price != history.data.old.price">
                                                            <p class="font-semibold">Cambio de precio</p>
                                                            <p>{{history.data.old.price}} -> {{history.data.new.price}} </p>
                                                        </div>
                                                        <div v-if="history.data.new.ingredients != history.data.old.ingredients">
                                                            <p class="font-semibold">Cambio de ingredientes</p>
                                                            <p>{{history.data.old.ingredients}} -> {{history.data.new.ingredients}} </p>
                                                        </div>
                                                        <div v-if="history.data.new.visible != history.data.old.visible">
                                                            <p class="font-semibold">Ahora es:</p>
                                                            <div v-if="history.data.new.visible == 1">
                                                                <p>Visible</p>
                                                            </div>
                                                            <div v-else>
                                                                <p>Invisible</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                <div v-if="history.action == 'crear' && history.entity_type == 'subcategoria' ">
                                                    <p>Nombre: {{ history.data.name }}</p>
                                                    <p>Comentario: {{ history.data.comment }}</p>
                                                    <p>Orden: {{ history.data.orden }}</p>
                                                    <p v-if="history.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="history.action == 'eliminar' && history.entity_type == 'subcategoria' ">
                                                    <p>Nombre: {{ history.data.name }}</p>
                                                    <p>Comentario: {{ history.data.comment }}</p>
                                                    <p>Orden: {{ history.data.orden }}</p>
                                                    <p v-if="history.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="history.action == 'actualizar' && history.entity_type == 'subcategoria' ">
                                                        <div v-if="history.data.new.name != history.data.old.name">
                                                            <p class="font-semibold">Cambio de nombre</p>
                                                            <p>{{history.data.old.name}} -> {{history.data.new.name}} </p>
                                                        </div>
                                                        <div v-if="history.data.new.orden != history.data.old.orden">
                                                            <p class="font-semibold">Cambio de orden</p>
                                                            <p>{{history.data.old.orden}} -> {{history.data.new.orden}} </p>
                                                        </div>
                                                        <div v-if="history.data.new.comment != history.data.old.comment">
                                                            <p class="font-semibold">Cambio de comentario</p>
                                                            <p>{{history.data.old.comment}} -> {{history.data.new.comment}} </p>
                                                        </div>
                                                        <div v-if="history.data.new.visible != history.data.old.visible">
                                                            <p class="font-semibold">Ahora es:</p>
                                                            <div v-if="history.data.new.visible == 1">
                                                                <p>Visible</p>
                                                            </div>
                                                            <div v-else>
                                                                <p>Invisible</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <div v-if="history.action == 'crear' && history.entity_type == 'categoria' ">
                                                    <p>Nombre: {{ history.data.name }}</p>
                                                    <p>Comentario: {{ history.data.comment }}</p>
                                                    <p>Orden: {{ history.data.orden }}</p>
                                                    <p v-if="history.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="history.action == 'eliminar' && history.entity_type == 'categoria' ">
                                                    <p>Nombre: {{ history.data.name }}</p>
                                                    <p>Comentario: {{ history.data.comment }}</p>
                                                    <p>Orden: {{ history.data.orden }}</p>
                                                    <p v-if="history.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="history.action == 'actualizar' && history.entity_type == 'categoria' ">
                                                        <div v-if="history.data.new.name != history.data.old.name">
                                                            <p class="font-semibold">Cambio de nombre</p>
                                                            <p>{{history.data.old.name}} -> {{history.data.new.name}} </p>
                                                        </div>
                                                        <div v-if="history.data.new.orden != history.data.old.orden">
                                                            <p class="font-semibold">Cambio de orden</p>
                                                            <p>{{history.data.old.orden}} -> {{history.data.new.orden}} </p>
                                                        </div>
                                                        <div v-if="history.data.new.comment != history.data.old.comment">
                                                            <p class="font-semibold">Cambio de comentario</p>
                                                            <p>{{history.data.old.comment}} -> {{history.data.new.comment}} </p>
                                                        </div>
                                                        <div v-if="history.data.new.visible != history.data.old.visible">
                                                            <p class="font-semibold">Ahora es:</p>
                                                            <div v-if="history.data.new.visible == 1">
                                                                <p>Visible</p>
                                                            </div>
                                                            <div v-else>
                                                                <p>Invisible</p>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>  
                                        </td>
                                        <td class="border px-4 py-2 ">
                                            <div class="">
                                                <p class="max-w-9 mx-auto ">
                                                    <button @click="openModal(history)" class="font-semibold bg-lime-200 rounded-lg p-1">Ver</button>
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detalles del Historial</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            <strong>Nombre:</strong> {{ modalData.person }}<br>
                                            <strong>Cargo:</strong> {{ modalData.cargo }}<br>
                                            <strong>Entidad:</strong> {{ modalData.entity_type }}<br>
                                            <strong>Acción:</strong> {{ modalData.action }}<br>
                                            <strong>Datos:</strong>
                                            
                                                <div v-if="modalData.action == 'crear' && modalData.entity_type == 'plato'   ">
                                                    <p>Nombre: {{ modalData.data.name }}</p>
                                                    <p>Precio: {{ modalData.data.price }}</p>
                                                    <p>Ingredientes: {{ modalData.data.ingredients }}</p>
                                                    <p v-if="modalData.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="modalData.action == 'eliminar' && modalData.entity_type == 'plato' ">
                                                    <p>Nombre: {{ modalData.data.name }}</p>
                                                    <p>Precio: {{ modalData.data.price }}</p>
                                                    <p>Ingredientes: {{ modalData.data.ingredients }}</p>
                                                    <p v-if="modalData.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="modalData.action == 'actualizar' && modalData.entity_type == 'plato' ">
                                                        <div v-if="modalData.data.new.name != modalData.data.old.name">
                                                            <p class="font-semibold">Cambio de nombre</p>
                                                            <p>{{modalData.data.old.name}} -> {{modalData.data.new.name}} </p>
                                                        </div>
                                                        <div v-if="modalData.data.new.price != modalData.data.old.price">
                                                            <p class="font-semibold">Cambio de precio</p>
                                                            <p>{{modalData.data.old.price}} -> {{modalData.data.new.price}} </p>
                                                        </div>
                                                        <div v-if="modalData.data.new.ingredients != modalData.data.old.ingredients">
                                                            <p class="font-semibold">Cambio de ingredientes</p>
                                                            <p>{{modalData.data.old.ingredients}} -> {{modalData.data.new.ingredients}} </p>
                                                        </div>
                                                        <div v-if="modalData.data.new.visible != modalData.data.old.visible">
                                                            <p class="font-semibold">Ahora es:</p>
                                                            <div v-if="modalData.data.new.visible == 1">
                                                                <p>Visible</p>
                                                            </div>
                                                            <div v-else>
                                                                <p>Invisible</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                <div v-if="modalData.action == 'crear' && modalData.entity_type == 'subcategoria' ">
                                                    <p>Nombre: {{ modalData.data.name }}</p>
                                                    <p>Comentario: {{ modalData.data.comment }}</p>
                                                    <p>Orden: {{ modalData.data.orden }}</p>
                                                    <p v-if="modalData.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="modalData.action == 'eliminar' && modalData.entity_type == 'subcategoria' ">
                                                    <p>Nombre: {{ modalData.data.name }}</p>
                                                    <p>Comentario: {{ modalData.data.comment }}</p>
                                                    <p>Orden: {{ modalData.data.orden }}</p>
                                                    <p v-if="modalData.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="modalData.action == 'actualizar' && modalData.entity_type == 'subcategoria' ">
                                                        <div v-if="modalData.data.new.name != modalData.data.old.name">
                                                            <p class="font-semibold">Cambio de nombre</p>
                                                            <p>{{modalData.data.old.name}} -> {{modalData.data.new.name}} </p>
                                                        </div>
                                                        <div v-if="modalData.data.new.orden != modalData.data.old.orden">
                                                            <p class="font-semibold">Cambio de orden</p>
                                                            <p>{{modalData.data.old.orden}} -> {{modalData.data.new.orden}} </p>
                                                        </div>
                                                        <div v-if="modalData.data.new.comment != modalData.data.old.comment">
                                                            <p class="font-semibold">Cambio de comentario</p>
                                                            <p>{{modalData.data.old.comment}} -> {{modalData.data.new.comment}} </p>
                                                        </div>
                                                        <div v-if="modalData.data.new.visible != modalData.data.old.visible">
                                                            <p class="font-semibold">Ahora es:</p>
                                                            <div v-if="modalData.data.new.visible == 1">
                                                                <p>Visible</p>
                                                            </div>
                                                            <div v-else>
                                                                <p>Invisible</p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <div v-if="modalData.action == 'crear' && modalData.entity_type == 'categoria' ">
                                                    <p>Nombre: {{ modalData.data.name }}</p>
                                                    <p>Comentario: {{ modalData.data.comment }}</p>
                                                    <p>Orden: {{ modalData.data.orden }}</p>
                                                    <p v-if="modalData.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="modalData.action == 'eliminar' && modalData.entity_type == 'categoria' ">
                                                    <p>Nombre: {{ modalData.data.name }}</p>
                                                    <p>Comentario: {{ modalData.data.comment }}</p>
                                                    <p>Orden: {{ modalData.data.orden }}</p>
                                                    <p v-if="modalData.data.visible == '1'">Visible</p>
                                                    <p v-else>Invisible</p>
                                                </div>

                                                <div v-if="modalData.action == 'actualizar' && modalData.entity_type == 'categoria' ">
                                                        <div v-if="modalData.data.new.name != modalData.data.old.name">
                                                            <p class="font-semibold">Cambio de nombre</p>
                                                            <p>{{modalData.data.old.name}} -> {{modalData.data.new.name}} </p>
                                                        </div>
                                                        <div v-if="modalData.data.new.orden != modalData.data.old.orden">
                                                            <p class="font-semibold">Cambio de orden</p>
                                                            <p>{{modalData.data.old.orden}} -> {{modalData.data.new.orden}} </p>
                                                        </div>
                                                        <div v-if="modalData.data.new.comment != modalData.data.old.comment">
                                                            <p class="font-semibold">Cambio de comentario</p>
                                                            <p>{{modalData.data.old.comment}} -> {{modalData.data.new.comment}} </p>
                                                        </div>
                                                        <div v-if="modalData.data.new.visible != modalData.data.old.visible">
                                                            <p class="font-semibold">Ahora es:</p>
                                                            <div v-if="modalData.data.new.visible == 1">
                                                                <p>Visible</p>
                                                            </div>
                                                            <div v-else>
                                                                <p>Invisible</p>
                                                            </div>
                                                        </div>
                                                </div>
                                            
                                            <strong>Fecha:</strong> {{ new Date(modalData.created_at).toLocaleString() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </AppLayout>
</template>


