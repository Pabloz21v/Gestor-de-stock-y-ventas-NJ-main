<script>
export default {
    name: "SalesEdit",
};
</script>

<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import SalesForm from "@/Components/Sales/Form.vue";

const props = defineProps({
    sale: {
        type: Object,
        required: true,
    },
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

const form = useForm({
    reg: props.sale.reg,
    cliente: props.sale.cliente,
    contacto: props.sale.contacto,
    vendedor: props.sale.vendedor,
    producto: props.sale.producto,
    precio: props.sale.precio,
    unidades: props.sale.unidades,
    entrada: props.sale.entrada,
    pendiente: props.sale.pendiente,
    sub_total: props.sale.sub_total,
    estado: props.sale.estado,
    sobreprecio: props.sale.sobreprecio,
    observacion: props.sale.observacion,
});
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">
                Editar Venta
            </h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <SalesForm :form="form" :products="products" :users="users" :user-permissions="userPermissions" :current-user="currentUser" @submit="form.put(route('sales.update', sale.id))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
