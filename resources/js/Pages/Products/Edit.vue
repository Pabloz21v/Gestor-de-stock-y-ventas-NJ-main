<script>
export default {
    name: "ProductsEdit",
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";
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
    subcategory_id: props.producto.subcategory_id,
    name: props.producto.name,
    price: props.producto.price,
    description: props.producto.description,
    visible: props.producto.visible,
});
</script>

<template>
    <AppLayout title="Edit products">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">
                Editar Productos
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div
                        class="bg-white overflow-hidden shadow-xl sm:rounded-lg"
                    >
                        <div class="p-6 bg-white border-b border-gray-200">
                            <ProductsForm
                                :updating="true"
                                :form="form"
                                :categories="categories"
                                :subcategories="subcategories"
                                @submit="
                                    form.put(route('products.update', producto.id))
                                "
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
