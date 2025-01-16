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
    category_id: props.producto.category_id,
    subcategory_id: props.producto.subcategory_id,
    visible: props.producto.visible,
    price: props.producto.price,
    ganancia: props.producto.ganancia,
    descuento: props.producto.descuento,
    oferta: props.producto.oferta,
    name: props.producto.name,
    description: props.producto.description,
    detalles: props.producto.detalles,
    marca: props.producto.marca,
    tamaño: props.producto.tamaño,
    color: props.producto.color,
    peso: props.producto.peso,
    dimensiones: props.producto.dimensiones,
    stock: props.producto.stock,
    contador_ventas: props.producto.contador_ventas,
    stock_real: props.producto.stock_real,
    stock_minimo: props.producto.stock_minimo,
    stock_maximo: props.producto.stock_maximo,
    imagen_principal: props.producto.imagen_principal,
    imagenes: props.producto.imagenes,
    video: props.producto.video,
    proveedores: props.producto.proveedores,
});

const previewImagenPrincipal = ref(props.producto.imagen_principal ? props.producto.imagen_principal_url : null);
const previewImagenes = ref(props.producto.imagenes ? props.producto.imagenes_url : []);
const previewVideo = ref(props.producto.video ? props.producto.video_url : null);
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
                                :preview-imagenes="previewImagenes" :preview-video="previewVideo"
                                @submit="form.put(route('products.update', producto.id))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
