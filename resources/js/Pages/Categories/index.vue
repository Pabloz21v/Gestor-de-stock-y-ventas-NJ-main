<script>
	export default {
		name: 'CategoriesIndex'
	}
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue';
import Spinner from './../../Components/Spinner/Spinner.vue';

const props = defineProps({
	categorias: {
		type: Object,
		required: false
	},
})
const isLoading = ref(false);
const categorias = ref(props.categorias);

const deleteCategories = id => {
    isLoading.value = true;
    Inertia.delete(route('categories.destroy', id),{
        onSuccess: () => {
            isLoading.value = false;
            isModalVisible.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    })
}

const visibleCategories = (category) => {
    isLoading.value = true;
	Inertia.put(`/categories/${category.id}`, category,{
        onSuccess: () => {
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    });
}

const showModal = ref(false);
const modalDataID = ref({});

const openModalDelete = (id) => {
    modalDataID.value = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    modalDataID.value = {};
};

// const deleteCategories = id => {
// 	if(confirm('estas seguro de borrar este elemento?')){
// 		Inertia.delete(route('categories.destroy', id))
// 	}
// }


    // id="visible"
    // type="checkbox"
    // v-model="category.visible"
    // :true-value="1"
    // :false-value="0" 
</script>


<template>
	<AppLayout>
		<template #header>
			<h1 class="font-semibold text-xl text-gray-800 leading-tigth">Categorias</h1>
		</template>
		<div class="py-12 " >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row justify-between items-center mb-4">
                            <span class="text-lg font-semibold">Categorias</span>
                            <Link :href="route('categories.create')" class="bg-cyan-500 text-white rounded-lg px-4 py-2 mt-4 md:mt-2  lg:mt-0">
                                Crear Categoria
                            </Link>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="container mx-auto p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="w-3/6 px-4 py-2">Categoria / Comentario</th>
                                        <th class="w-1/6 px-4 py-2 hidden sm:table-cell">Orden</th>
                                        <th class="w-1/6 px-4 py-2 hidden sm:table-cell">Visible</th>
                                        <th class="w-1/6 px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr  v-for="category in categorias.data" :key="category.id">
                                        <td class="border" >
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <div class="bg-white p-4  divide-y divide-dashed">
                                                    <div class="flex justify-between" v-if="category.name">
                                                        <div class="font-bold text-gray-700">{{category.name}}</div>
                                                    </div>
                                                    <div class="flex justify-between" v-if="category.comment">
                                                        <div  class="font-semibold bg-white text-gray-700">{{category.comment}}</div>
                                                    </div>
                                                    <div v-else>
                                                        <p class="font-semibold bg-black text-white p-4">Sin comentario </p>
                                                    </div>
                                                </div>
                                            </p>
                                        </td>
                                        
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{category.orden}}</p>
                                                    
                                        </td>
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <div>
                                                    <input type="checkbox" 
														:checked="category.visible"
														@change="visibleCategories(category)"
														v-model="category.visible" 
                                                        :true-value="1"
                                                        :false-value="0" 
                                                        />
                                                </div>
                                            </p>  
                                        </td>
                                        <td class=" border  ">
                                            <div class="  px-2 md:py-6  flex flex-col md:flex-row justify-around  items-center md:gap-2 gap-3">
                                                <Link :href="route('categories.edit', category.id)">
                                                    <img src="../../../../storage/app/public/iconos/editar.png" class="max-w-9 mx-auto " alt="editar" srcset="">
                                                </Link>
                                                <button @click="openModalDelete(category.id)">
                                                    <img src="../../../../storage/app/public/iconos/basura.svg" class="max-w-9 mx-auto " alt="eliminar" srcset="">
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>   
        </div>

        <!-- Spinner -->
        <Spinner v-if="isLoading" />
        
        <!-- Modal delete-->
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
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar Categoria</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Al eliminar esta categoria se eliminarán todas las subcategorias y platos relacionados al mismo
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 my-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                        
                            <button @click="deleteCategories(modalDataID)" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 my-2 py-2 bg-red-600 shadow-lg shadow-red-600 hover:bg-red-700 text-base font-medium text-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Eliminar</button>
                        </div>
                    </div>
                </div>
        </div>

        
	</AppLayout>
</template>
