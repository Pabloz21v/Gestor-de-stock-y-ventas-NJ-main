<script>
export default {
    name: "SalesCreate",
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import SalesForm from "@/Components/Sales/Form.vue";

const form = useForm({
    reg: "",
    cliente: "",
    contacto: "",
    vendedor: "",
    producto: "",
    precio: "",
    unidades: "",
    entrada: "",
    pendiente: "",
    sub_total: "",
    estado: "",
    sobreprecio: "",
    observacion: "",
});

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    users: {
        type: Object,
        required: true,
    },
    userPermissions: {
        type: Array,
        required: true,
    },
    currentUser: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">
                Crear Venta
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <SalesForm :form="form" :products="products" :users="users" :user-permissions="userPermissions" :current-user="currentUser" @submit="form.post(route('sales.store'))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
