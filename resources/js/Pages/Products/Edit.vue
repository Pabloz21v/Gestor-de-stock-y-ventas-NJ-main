<script>
export default {
    name: "ProductsEdit",
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import ProductsForm from "@/Components/Products/Form.vue";
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    producto: {
        type: Object,
        required: true,
    },
    subcategories: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: false,
    },
});
const form = useForm({
    id: props.producto.id,
    category_id: String(props.producto.category_id),
    subcategory_id: String(props.producto.subcategory_id),
    visible: props.producto.visible,
    price: String(props.producto.price),
    ganancia: String(props.producto.ganancia),
    descuento: String(props.producto.descuento),
    oferta: props.producto.oferta,
    name: props.producto.name,
    description: props.producto.description,
    detalles: props.producto.detalles,
    marca: props.producto.marca,
    tamaño: props.producto.tamaño,
    color: props.producto.color,
    peso: props.producto.peso,
    dimensiones: props.producto.dimensiones,
    stock: String(props.producto.stock),
    contador_ventas: String(props.producto.contador_ventas),
    stock_real: String(props.producto.stock_real),
    stock_en_viaje: String(props.producto.stock_en_viaje),
    stock_en_viaje_vendido: String(props.producto.stock_en_viaje_vendido),
    stock_minimo: String(props.producto.stock_minimo),
    stock_maximo: String(props.producto.stock_maximo),
    imagen_principal: props.producto.imagen_principal,
    imagenes: props.producto.imagenes,
    video: props.producto.video,
    proveedores: props.producto.proveedores,
});

const previewImagenPrincipal = ref(props.producto.imagen_principal ? `/storage/${props.producto.imagen_principal}` : null);
const previewImagenes = ref(Array.isArray(props.producto.imagenes) ? JSON.parse(props.producto.imagenes).map(img => `/storage/${img}`) : []);
const previewVideo = ref(props.producto.video ? `/storage/${props.producto.video}` : null);
</script>

<template>
    <AppLayout title="Edit products">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">
                Editor de Productos
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <ProductsForm :updating="true" :form="form" :categories="categories"
                                :subcategories="subcategories" :preview-imagen-principal="previewImagenPrincipal"
                                :preview-imagenes="previewImagenes" :preview-video="previewVideo" @submit="form.put(route('products.update', producto.id), )" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
