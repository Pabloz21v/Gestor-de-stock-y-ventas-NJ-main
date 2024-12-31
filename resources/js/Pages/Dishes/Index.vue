<script>
    export default {
    name: 'DishesIndex'
    }
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref, computed, watch } from 'vue';
import Spinner from './../../Components/Spinner/Spinner.vue';
// import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    dishes: {
        type: Object,
        required: false
        
    },
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

// const dishes = ref(props.dishes);
// const {  inertia } = usePage();
const dishes = computed(() => props.dishes);
const categories = computed(() => props.categories);
const subcategories = computed(() => props.subcategories);
const showModal = ref(false);
const modalDataID = ref({});
const isLoading = ref(false);

const openModalDelete = (id) => {
    modalDataID.value = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    modalDataID.value = {};
};

const filters = ref({
    category_id: props.filters.categories_id || '',
    subcategory_id: props.filters.subcategory_id || '',
    search: props.filters.search || '',
});

const clearFilters = () => {
    filters.value.category_id = '';
    filters.value.subcategory_id = '';
    filters.value.search = '';
    applyFilters();
};

const filteredSubcategories = computed(() => {
    if (!filters.value.category_id) {
        return subcategories.value;
    }
    return subcategories.value.filter(subcategory => subcategory.category_id === parseInt(filters.value.category_id));
});

const applyFilters = () => {
    isLoading.value = true;
    Inertia.get(route('dishes.index'), filters.value, {
        onSuccess: () => {
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        },
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

watch(filters, () => {
    applyFilters();   
});

// const filteredDishes = computed(() => {
//     return dishes.value.filter(dish => {
//         const matchesCategory = !filters.value.category_id || dish.category_id === parseInt(filters.value.category_id);
//         const matchesSubcategory = !filters.value.subcategory_id || dish.data.subcategory_id === parseInt(filters.value.subcategory_id);
//         const matchesSearch = !filters.value.search || dish.data.name.toLowerCase().includes(filters.value.search.toLowerCase());
//         return matchesCategory && matchesSubcategory && matchesSearch;
//     });
// });

// elimina los acentos del buscador
const removeAccents = (str) => {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
};

const filteredDishes = computed(() => {
    return dishes.value.filter(dish => {
        const matchesCategory = !filters.value.category_id || dish.category_id === parseInt(filters.value.category_id);
        const matchesSubcategory = !filters.value.subcategory_id || dish.data.subcategory_id === parseInt(filters.value.subcategory_id);
        const search = filters.value.search ? removeAccents(filters.value.search.toLowerCase()) : '';
        const dishName = removeAccents(dish.data.name.toLowerCase());
        const matchesSearch = !search || dishName.includes(search);
        return matchesCategory && matchesSubcategory && matchesSearch;
    });
});

const visibleDishes = (dishes) => {
    isLoading.value = true;
	Inertia.put(`/dishes/${dishes.id}`, dishes,{
        onSuccess: () => {
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    });
}

const deleteDishes = id => {
    isLoading.value = true;
    Inertia.delete(route('dishes.destroy', id),{
        onSuccess: () => {
            isLoading.value = false;
            isModalVisible.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    })
}
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Platos</h1>
        </template>
        <div class="py-12 " >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row justify-between items-center mb-4">
                            <span class="text-lg font-semibold">Platos</span>
                            <form @submit.prevent="applyFilters" class="w-full md:w-auto flex flex-col md:flex-row items-start md:items-center gap-2 mt-4 md:mt-0">
                                    <select v-model="filters.category_id" @change="applyFilters" class="border rounded px-3 pr-8 py-1 w-full md:w-auto">
                                        <option value="">Categoria</option>
                                        <option v-for="category in filteredCategories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
                                    <select v-model="filters.subcategory_id" class="border rounded px-3 pr-8 py-1 w-full md:w-auto">
                                        <option value="">Subcategoria</option>
                                        <option v-for="subcategory in filteredSubcategories" :key="subcategory.id" :value="subcategory.id">{{ subcategory.name }}</option>
                                    </select>
                                    <input type="text" v-model="filters.search" placeholder="Buscar plato" class="border rounded px-2 py-1 w-full md:w-auto">
                                    <button type="button" @click="clearFilters" class="bg-gray-500 text-white px-4 py-2 rounded">Limpiar filtros</button>
                            </form>
                            <Link :href="route('dishes.create')" class="bg-cyan-500 text-white rounded-lg px-4 py-2 mt-4 md:mt-2  lg:mt-0">
                                Crear Platos
                            </Link>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="container mx-auto p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="w-2/6 px-4 py-2">Plato</th>
                                        <th class="w-1/6 px-4 py-2 hidden sm:table-cell">Subcategoria</th>
                                        <th class="w-1/6 px-4 py-2 hidden sm:table-cell">Categoria</th>
                                        <th class="w-1/6 px-4 py-2 hidden sm:table-cell">Visible</th>
                                        <th class="w-1/6 px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  v-for="dishe in filteredDishes" :key="dishe.id">
                                        <td class="border  ">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <div class="bg-white p-4  divide-y divide-dashed">
                                                    <div class="flex justify-between">
                                                        <div class="font-bold text-gray-700">{{dishe.data.name}}</div>
                                                        <div class="text-gray-700">${{dishe.data.price}}</div>
                                                    </div>
                                                    <div class="text-gray-600">{{dishe.data.ingredients}}</div>
                                                </div>
                                            </p>
                                        </td>
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{dishe.subcategory}}</p>
                                                    
                                        </td>
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{dishe.category}}</p>
                                                    
                                        </td>
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                <div>
                                                    <input type="checkbox" 
                                                        :checked="dishe.data.visible"
                                                        @change="visibleDishes(dishe.data)"
                                                        v-model="dishe.data.visible" 
                                                        :true-value="1"
                                                        :false-value="0" 
                                                        />
                                                </div>
                                            </p>  
                                        </td>
                                        <td class=" border  ">
                                            <div class="  px-2 md:py-6  flex flex-col md:flex-row justify-around  items-center md:gap-2 gap-3">
                                                <Link :href="route('dishes.edit', dishe.id)">
                                                    <img src="../../../../storage/app/public/iconos/editar.png" class="max-w-9 mx-auto " alt="editar" srcset="">
                                                </Link>
                                                <button @click="openModalDelete(dishe.id)">
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
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Eliminar Plato</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Se eliminará el plato seleccionado
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 my-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                        
                            <button @click="deleteDishes(modalDataID)" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 my-2 py-2 bg-red-600 shadow-lg shadow-red-600 hover:bg-red-700 text-base font-medium text-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">Eliminar</button>
                        </div>
                    </div>
                </div>
        </div>
    </AppLayout>
</template>
