<script>
export default {
    name: 'ProductsIndex'
}
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'
import { Inertia } from '@inertiajs/inertia'
import { ref, computed, watch } from 'vue';
import Spinner from './../../Components/Spinner/Spinner.vue';
import ModalDelete from './Modals/ModalDelete.vue';
import ModalView from './Modals/ModalView.vue';

const props = defineProps({
    products: {
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

const totalStock = computed(() => {
    return (
        parseInt(modalProductData.value?.data?.stock_real || 0) +
        parseInt(modalProductData.value?.data?.stock_en_viaje || 0) +
        parseInt(modalProductData.value?.data?.stock_en_viaje_vendido || 0)
    );
});

const products = computed(() => props.products);
const categories = computed(() => props.categories);
const subcategories = computed(() => props.subcategories);
const showModalDelete = ref(false);
const showModalView = ref(false);
const modalDataID = ref({});
const modalProductData = ref(null);

const openModalDelete = (id) => {
    modalDataID.value = id;
    showModalDelete.value = true;
};

const openModalView = (product) => {
    modalProductData.value = product;
    showModalView.value = true;
};

const closeModal = () => {
    showModalDelete.value = false;
    showModalView.value = false;
    modalDataID.value = {};
    modalProductData.value = null;
};

const handleKeydown = (event) => {
    if (event.key === 'Escape') {
        closeModal();
    }
};

watch(showModalDelete, (newVal) => {
    if (newVal) {
        window.addEventListener('keydown', handleKeydown);
    } else {
        window.removeEventListener('keydown', handleKeydown);
    }
});

watch(showModalView, (newVal) => {
    if (newVal) {
        window.addEventListener('keydown', handleKeydown);
    } else {
        window.removeEventListener('keydown', handleKeydown);
    }
});

// Eliminar lógica de filtros
// const filters = ref({
//     category_id: props.filters.categories_id || '',
//     subcategory_id: props.filters.subcategory_id || '',
//     search: props.filters.search || '',
// });

// const clearFilters = () => {
//     filters.value.category_id = '';
//     filters.value.subcategory_id = '';
//     filters.value.search = '';
//     applyFilters();
// };

// const filteredSubcategories = computed(() => {
//     if (!filters.value.category_id) {
//         return subcategories.value;
//     }
//     return subcategories.value.filter(subcategory => subcategory.category_id === parseInt(filters.value.category_id));
// });

// const applyFilters = () => {
//     isLoading.value = true;
//     Inertia.get(route('products.index'), filters.value, {
//         onSuccess: () => {
//             isLoading.value = false;
//         },
//         onError: () => {
//             isLoading.value = false;
//         },
//         preserveState: true,
//         replace: true,
//     });
// };

// const filteredCategories = computed(() => {
//     if (!filters.value.category_id) {
//         return categories.value;
//     }
//     return categories.value.filter(category => category.id === parseInt(filters.value.category_id));
// });

// watch(filters, () => {
//     applyFilters();
// });

const removeAccents = (str) => {
    return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
};

const filteredProducts = computed(() => {
    return products.value.filter(product => {
        // Eliminar lógica de filtros
        // const matchesCategory = !filters.value.category_id || product.category_id === parseInt(filters.value.category_id);
        // const matchesSubcategory = !filters.value.subcategory_id || product.data.subcategory_id === parseInt(filters.value.subcategory_id);
        // const search = filters.value.search ? removeAccents(filters.value.search.toLowerCase()) : '';
        // const productName = removeAccents(product.data.name.toLowerCase());
        // const matchesSearch = !search || productName.includes(search);
        // return matchesCategory && matchesSubcategory && matchesSearch;
        return true;
    });
});

const visibleProducts = (products) => {
    isLoading.value = true;
    Inertia.put(`/products/${products.id}`, products, {
        onSuccess: () => {
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    });
}

const deleteProducts = id => {
    isLoading.value = true;
    Inertia.delete(route('products.destroy', id), {
        onSuccess: () => {
            isLoading.value = false;
            isModalVisible.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    });
}

const isLoading = ref(false);
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Productos</h1>
        </template>

        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row justify-between items-center mb-4">
                        <span class="text-lg font-semibold">Productos</span>
                        <!-- Eliminar formulario de filtros -->
                        <!-- <form @submit.prevent="applyFilters"
                            class="w-full md:w-auto flex flex-col md:flex-row items-start md:items-center gap-2 mt-4 md:mt-0">
                            <select v-model="filters.category_id" @change="applyFilters"
                                class="border rounded px-3 pr-8 py-1 w-full md:w-auto">
                                <option value="">Categoria</option>
                                <option v-for="category in filteredCategories" :key="category.id" :value="category.id">
                                    {{
                                        category.name }}</option>
                            </select>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Buscar</button>
                            <select v-model="filters.subcategory_id"
                                class="border rounded px-3 pr-8 py-1 w-full md:w-auto">
                                <option value="">Subcategoria</option>
                                <option v-for="subcategory in filteredSubcategories" :key="subcategory.id"
                                    :value="subcategory.id">{{ subcategory.name }}</option>
                            </select>
                            <input type="text" v-model="filters.search" placeholder="Buscar producto"
                                class="border rounded px-2 py-1 w-full md:w-auto">
                            <button type="button" @click="clearFilters"
                                class="bg-gray-500 text-white px-4 py-2 rounded">Limpiar
                                filtros</button>
                        </form> -->
                        <Link v-if="$page.props.user.permissions.includes(
                            'create roles'
                        )" :href="route('products.create')"
                            class="bg-cyan-500 text-white rounded-lg px-4 py-2 mt-4 md:mt-2  lg:mt-0">
                        Crear Productos
                        </Link>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="container mx-auto p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="w-1/6 px-4 py-2">Imagen</th>
                                        <th class="w-2/6 px-4 py-2">Producto</th>
                                        <th class="w-1/6 px-4 py-2 hidden sm:table-cell">Subcategoria</th>
                                        <th class="w-1/6 px-4 py-2 hidden sm:table-cell">Categoria</th>
                                        <th class="w-1/6 px-4 py-2 hidden sm:table-cell">Marca</th>
                                        <th v-if="$page.props.user.permissions.includes('create roles')"
                                            class="w-1/6 px-4 py-2 hidden sm:table-cell">Visible</th>
                                        <th class="w-1/6 px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="producto in filteredProducts" :key="producto.id">
                                        <td class="border px-4 py-2">
                                            <img :src="`/storage/${producto.data.imagen_principal}`"
                                                alt="Imagen Principal" class="w-16 h-16 object-cover" />
                                        </td>
                                        <td class="border">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                            <div class="bg-white p-4 divide-y divide-dashed">
                                                <div class="flex justify-between">
                                                    <div class="font-bold text-gray-700">{{ producto.data.name }}</div>
                                                    <div class="text-gray-700">${{ producto.data.price }}</div>
                                                </div>
                                                <div class="text-gray-600">{{ producto.data.description }}</div>
                                            </div>
                                            </p>
                                        </td>
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                                {{ producto.subcategory }}
                                            </p>

                                        </td>
                                        <td class="border px-4  hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">
                                                {{ producto.category }}</p>

                                        </td>
                                        <td class="border px-4 hidden sm:table-cell">
                                            <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{
                                                producto.data.marca }}
                                            </p>
                                        </td>
                                        <td v-if="$page.props.user.permissions.includes('create roles')"
                                            class="border px-4  hidden sm:table-cell">
                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                            <div>
                                                <input type="checkbox" :checked="producto.data.visible"
                                                    @change="visibleProducts(producto.data)"
                                                    v-model="producto.data.visible" :true-value="1" :false-value="0" />
                                            </div>
                                            </p>

                                        </td>


                                        <td class=" border  ">
                                            <div
                                                class="px-2 md:py-6  flex flex-col md:flex-row justify-around  items-center md:gap-2 gap-3">
                                                <button @click="openModalView(producto)">
                                                    <img src="../../../../storage/app/public/iconos/ver.png"
                                                        class="max-w-9 mx-auto " alt="ver" srcset="">
                                                </button>
                                                <Link v-if="$page.props.user.permissions.includes(
                                                    'create roles'
                                                )" :href="route('products.edit', producto.id)">
                                                <img src="../../../../storage/app/public/iconos/editar.png"
                                                    class="max-w-9 mx-auto " alt="editar" srcset="">
                                                </Link>
                                                <button v-if="$page.props.user.permissions.includes(
                                                    'create roles'
                                                )" @click="openModalDelete(producto.id)">
                                                    <img src="../../../../storage/app/public/iconos/basura.svg"
                                                        class="max-w-9 mx-auto " alt="eliminar" srcset="">
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
        <ModalDelete v-if="showModalDelete" :closeModal="closeModal" :deleteProducts="deleteProducts"
            :modalDataID="modalDataID" />

        <!-- Modal view product-->
        <ModalView v-if="showModalView" :closeModal="closeModal" :modalProductData="modalProductData"
            :totalStock="totalStock" />
    </AppLayout>
</template>
