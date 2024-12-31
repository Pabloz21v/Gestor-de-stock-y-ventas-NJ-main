<script>
    export default {
    name: 'SubcategoriesIndex'
    }
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref, computed } from 'vue';
import Spinner from './../../Components/Spinner/Spinner.vue';

const props = defineProps({
    subcategories: {
        type: Object,
        required: false
    },
    categories: {
        type: Object,
        required: false
        
    },
    filters: {
        type: Object,
        required: false
        
    },
    
})
const categories = ref(props.categories);
const subcategories = ref(props.subcategories);
const showModal = ref(false);
const modalDataID = ref({});
const isLoading = ref(false);
const filters = ref({
    
    category_id: props.filters.category_id || '',
});

const applyFilters = () => {
    Inertia.get(route('subcategories.index'), filters.value, {
        preserveState: true,
        replace: true,
    });
};


const filteredCategories = computed(() => {
    if (!filters.value.category_id) {
        return categories.value;
    }
    return categories.value.filter(category => category.id === parseInt(filters.value.category_id));
});

const visibleSubcategories = (subcategories) => {
    isLoading.value = true;
	Inertia.put(`/subcategories/${subcategories.id}`, subcategories,{
        onSuccess: () => {
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    });
}

const deleteSubcategories = id => {
    isLoading.value = true;
    Inertia.delete(route('subcategories.destroy', id),{
        onSuccess: () => {
            isLoading.value = false;
            isModalVisible.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    })
    
}

const openModalDelete = (id) => {
    modalDataID.value = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    modalDataID.value = {};
};
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Subcategorias</h1>
        </template>
        
        <div class="py-12 " >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row justify-between items-center mb-4">
                            <span class="text-lg font-semibold">Subcategorias</span>
                                <form @submit.prevent="applyFilters" class="w-full md:w-auto flex flex-col md:flex-row items-start md:items-center gap-2 mt-4 md:mt-0">
                                        <select v-model="filters.category_id"  class="border rounded px-3 pr-8 py-1 w-full md:w-auto">
                                            <option value="">Categoria</option>
                                            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                        </select>
                                </form>
                            <Link :href="route('subcategories.create')" class="bg-cyan-500 text-white rounded-lg px-4 py-2 mt-4 md:mt-2  lg:mt-0">
                                Crear Subcategoria
                            </Link>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="container mx-auto p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="w-3/7 px-4 py-2">Subcategoria / Comentario</th>
                                        <th class="w-1/7 px-4 py-2 hidden sm:table-cell">Orden</th>
                                        <th class="w-1/7 px-4 py-2 hidden sm:table-cell">Categoria</th>
                                        <th class="w-1/7 px-4 py-2 hidden sm:table-cell">Visible</th>
                                        <th class="w-1/7 px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody v-for="category in filteredCategories" :key="category.id">
                                    <tr  v-for="subcategory in category.subcategories" :key="subcategory.id">
                                        <td class="border" >
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <div class="bg-white p-4  divide-y divide-dashed">
                                                    <div class="flex justify-between" v-if="subcategory.name">
                                                        <div class="font-bold text-gray-700">{{subcategory.name}}</div>
                                                    </div>
                                                    <div v-else>
                                                        <p class="font-semibold bg-black text-white p-4">Sin subcategoria </p>
                                                    </div>
                                                    <div class="flex justify-between" v-if="subcategory.comment">
                                                        <div  class="font-semibold bg-white text-gray-700">{{subcategory.comment}}</div>
                                                    </div>
                                                    <div v-else>
                                                        <p class="font-semibold bg-black text-white p-4">Sin comentario </p>
                                                    </div>
                                                </div>
                                            </p>
                                        </td>
                                        
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{subcategory.orden}}</p>
                                                    
                                        </td>
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{category.name}}</p>
                                                    
                                        </td>
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <div>
                                                    
                                                    <input type="checkbox" 
                                                        :checked="subcategory.visible"
                                                        @change="visibleSubcategories(subcategory)"
                                                        v-model="subcategory.visible" 
                                                        :true-value="1"
                                                        :false-value="0" 
                                                        />
                                                </div>
                                            </p>  
                                        </td>
                                        <td class=" border  ">
                                            <div class="  px-2 md:py-6  flex flex-col md:flex-row justify-around  items-center md:gap-2 gap-3">
                                                <Link :href="route('subcategories.edit', subcategory.id)">
                                                    <img src="../../../../storage/app/public/iconos/editar.png" class="max-w-9 mx-auto " alt="editar" srcset="">
                                                </Link>
                                                <button @click="openModalDelete(subcategory.id)">
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

        <!-- Modal Delete -->
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
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar Subcategoria</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Al eliminar esta subcategoria se eliminarán todos platos relacionados al mismo
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 my-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                        
                            <button @click="deleteSubcategories(modalDataID)" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 my-2 py-2 bg-red-600 shadow-lg shadow-red-600 hover:bg-red-700 text-base font-medium text-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Eliminar</button>
                        </div>
                    </div>
                </div>
        </div>
    </AppLayout>
</template>
