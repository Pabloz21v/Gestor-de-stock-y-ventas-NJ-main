<script>
export default {
    name: "ProductsCreate",
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductsForm from "@/Components/Products/Form.vue";

const form = useForm({
    category_id: "",
    subcategory_id: "",
    visible: 1,
    price: "",
    ganancia: "",
    descuento: "",
    oferta: 0,
    name: "",
    description: "",
    detalles: "",
    marca: "",
    tamaño: "",
    color: "",
    peso: "",
    dimensiones: "",
    stock: "",
    contador_ventas: "",
    stock_real: "",
    stock_en_viaje: "",
    stock_en_viaje_vendido: "",
    stock_minimo: "",
    stock_maximo: "",
    imagen_principal: "",
    imagenes: [],
    video: "",
    proveedores: "",
});

defineProps({
    subcategories: {
        type: Object,
        required: false,
    },
    categories: {
        type: Object,
        required: false,
    },
});
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">
                Creador de Productos
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <ProductsForm :form="form" :categories="categories" :subcategories="subcategories"
                                @submit="form.post(route('products.store'))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
