<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    products: {
        type: Array,
        required: true
    }
});

const ofertas = computed(() => {
    return props.products.filter(product => product.oferta);
});

const showModalView = ref(false);
const modalProductData = ref(null);

const openModalView = (product) => {
    modalProductData.value = product;
    showModalView.value = true;
};

const closeModal = () => {
    showModalView.value = false;
    modalProductData.value = null;
};

const handleKeydown = (event) => {
    if (event.key === 'Escape') {
        closeModal();
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleKeydown);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeydown);
});
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Ofertas</h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <div v-for="product in ofertas" :key="product.id" class="bg-white shadow-md rounded-lg overflow-hidden cursor-pointer" @click="openModalView(product)">
                        <img :src="`/storage/${product.imagen_principal}`" alt="Imagen Principal" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h2 class="text-lg font-semibold text-gray-800">{{ product.name }}</h2>
                            <p class="text-gray-600">${{ product.price }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal view product-->
        <div v-if="showModalView" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detalles del Producto</h3>
                                    <button @click="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500"><strong>Nombre:</strong> {{ modalProductData?.name }}</p>
                                    <p class="text-sm text-gray-500"><strong>Descripción:</strong> {{ modalProductData?.description }}</p>
                                    <p class="text-sm text-gray-500"><strong>Costo:</strong> ${{ modalProductData?.price }}</p>
                                    <p class="text-sm text-gray-500"><strong>Mark Up (valor se lleva a %):</strong> {{ modalProductData?.ganancia }}%</p>
                                    <p class="text-sm text-gray-500"><strong>Descuento:</strong> ${{ modalProductData?.descuento }}</p>
                                    <p class="text-sm text-gray-500"><strong>Oferta:</strong> {{ modalProductData?.oferta ? 'Sí' : 'No' }}</p>
                                    <p class="text-sm text-gray-500"><strong>Detalles:</strong> {{ modalProductData?.detalles }}</p>
                                    <p class="text-sm text-gray-500"><strong>Marca:</strong> {{ modalProductData?.marca }}</p>
                                    <p class="text-sm text-gray-500"><strong>Tamaño:</strong> {{ modalProductData?.tamaño }}</p>
                                    <p class="text-sm text-gray-500"><strong>Color:</strong> {{ modalProductData?.color }}</p>
                                    <p class="text-sm text-gray-500"><strong>Peso:</strong> {{ modalProductData?.peso }}</p>
                                    <p class="text-sm text-gray-500"><strong>Dimensiones:</strong> {{ modalProductData?.dimensiones }}</p>
                                    <p class="text-sm text-gray-500"><strong>Stock:</strong> {{ modalProductData?.stock }}</p>
                                    <p class="text-sm text-gray-500"><strong>Contador de Ventas:</strong> {{ modalProductData?.contador_ventas }}</p>
                                    <p class="text-sm text-gray-500"><strong>Stock Real:</strong> {{ modalProductData?.stock_real }}</p>
                                    <p class="text-sm text-gray-500"><strong>Stock Mínimo:</strong> {{ modalProductData?.stock_minimo }}</p>
                                    <p class="text-sm text-gray-500"><strong>Stock Máximo:</strong> {{ modalProductData?.stock_maximo }}</p>
                                    <p class="text-sm text-gray-500"><strong>Visible:</strong> {{ modalProductData?.visible ? 'Sí' : 'No' }}</p>
                                    <p class="text-sm text-gray-500"><strong>Proveedores:</strong></p>
                                    <ul class="list-disc list-inside pl-4">
                                        <li v-for="(proveedor, index) in JSON.parse(modalProductData?.proveedores || '[]')" :key="index" class="mb-1">
                                            <a :href="proveedor" target="_blank" class="text-blue-500 hover:underline">{{ proveedor }}</a>
                                        </li>
                                    </ul>
                                    <p class="text-sm text-gray-500"><strong>Imagen Principal:</strong> <img :src="`/storage/${modalProductData?.imagen_principal}`" alt="Imagen Principal" /></p>
                                    <p class="text-sm text-gray-500"><strong>Imágenes:</strong></p>
                                    <div v-for="(img, index) in JSON.parse(modalProductData?.imagenes || '[]')" :key="index">
                                        <img :src="`/storage/${img}`" alt="Imagen" />
                                    </div>
                                    <p class="text-sm text-gray-500"><strong>Video:</strong> <video :src="`/storage/${modalProductData?.video}`" controls></video></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 my-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
