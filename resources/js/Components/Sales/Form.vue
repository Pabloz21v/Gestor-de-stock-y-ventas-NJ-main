<script>
export default {
    name: "SalesForm",
};
</script>

<script setup>
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link } from "@inertiajs/vue3";
import { watch, computed } from 'vue';

const props = defineProps({
    form: {
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

defineEmits(["submit"]);

const isAdmin = computed(() => props.userPermissions.includes('create roles'));
const isEditor = computed(() => props.userPermissions.includes('update products'));

watch(() => props.form.producto, (newVal) => {
    const selectedProduct = props.products.find(product => product.id === newVal);
    if (selectedProduct) {
        props.form.precio = selectedProduct.price;
    }
});

watch([() => props.form.unidades, () => props.form.precio], ([newUnidades, newPrecio]) => {
    props.form.sub_total = newUnidades * newPrecio;
});

watch([() => props.form.sub_total, () => props.form.entrada], ([newSubTotal, newEntrada]) => {
    props.form.pendiente = parseFloat((newSubTotal - newEntrada).toFixed(2));
});

if (isEditor.value) {
    props.form.vendedor = props.currentUser.id;
}
</script>

<template>
    <FormSection @submitted="$emit('submit')">
        <template #title>
            {{ form.id ? "Editar Venta" : "Crear Venta" }}
        </template>
        <template #description>
            {{ form.id ? "ID Venta: " + form.id : "" }}
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="reg" value="Registro" />
                <TextInput id="reg" v-model="form.reg" type="text" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.reg" class="mt-0" />

                <InputLabel for="cliente" value="Cliente" class="mt-2 block w-full" />
                <TextInput id="cliente" v-model="form.cliente" type="text" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.cliente" class="mt-0" />

                <InputLabel for="contacto" value="Contacto" class="mt-2 block w-full" />
                <TextInput id="contacto" v-model="form.contacto" type="text" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.contacto" class="mt-0" />

                <InputLabel for="vendedor" value="Vendedor" class="mt-2 block w-full" />
                <select v-model="form.vendedor" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" :disabled="isEditor">
                    <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                </select>
                <InputError :message="$page.props.errors.vendedor" class="mt-0" />
                <TextInput v-if="isEditor" v-model="form.vendedor" type="hidden" :value="currentUser.id" />

                <InputLabel for="producto" value="Producto" class="mt-2 block w-full" />
                <select v-model="form.producto" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                    <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
                </select>
                <InputError :message="$page.props.errors.producto" class="mt-0" />

                <InputLabel for="precio" value="Precio" class="mt-2 block w-full" />
                <TextInput id="precio" v-model="form.precio" type="number" step="0.01" class="mt-1 block w-full" disabled />
                <InputError :message="$page.props.errors.precio" class="mt-0" />

                <InputLabel for="unidades" value="Unidades" class="mt-2 block w-full" />
                <TextInput id="unidades" v-model="form.unidades" type="number" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.unidades" class="mt-0" />

                <InputLabel for="sub_total" value="Sub Total" class="mt-2 block w-full" />
                <TextInput id="sub_total" v-model="form.sub_total" type="number" step="0.01" class="mt-1 block w-full" disabled />
                <InputError :message="$page.props.errors.sub_total" class="mt-0" />

                <InputLabel for="entrada" value="Entrada" class="mt-2 block w-full" />
                <TextInput id="entrada" v-model="form.entrada" type="number" step="0.01" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.entrada" class="mt-0" />

                <InputLabel for="pendiente" value="Pendiente" class="mt-2 block w-full" />
                <TextInput id="pendiente" v-model="form.pendiente" type="number" step="0.01" class="mt-1 block w-full" disabled />
                <InputError :message="$page.props.errors.pendiente" class="mt-0" />

                <InputLabel for="estado" value="Estado" class="mt-2 block w-full" />
                <select v-model="form.estado" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" :disabled="!isAdmin && !isEditor">
                    <option value="ENTREGADO" v-if="isAdmin">ENTREGADO</option>
                    <option value="PENDIENTE">PENDIENTE</option>
                    <option value="CANCELADO" v-if="isAdmin">CANCELADO</option>
                    <option value="EN_PREPARACION" v-if="isAdmin">EN PREPARACION</option>
                    <option value="VERIFICANDO" v-if="isAdmin">VERIFICANDO</option>
                    <option value="CONSIGNA" v-if="isAdmin">CONSIGNA</option>
                </select>
                <InputError :message="$page.props.errors.estado" class="mt-0" />

                <InputLabel for="sobreprecio" value="Sobreprecio" class="mt-2 block w-full" />
                <TextInput id="sobreprecio" v-model="form.sobreprecio" type="number" step="0.01" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.sobreprecio" class="mt-0" />

                <InputLabel for="observacion" value="Observación" class="mt-2 block w-full" />
                <TextInput id="observacion" v-model="form.observacion" type="text" class="mt-1 block w-full" />
                <InputError :message="$page.props.errors.observacion" class="mt-0" />
            </div>
        </template>

        <template #actions>
            <div class="grid gap-4 grid-cols-2 justify-items-center">
                <PrimaryButton>
                    {{ form.id ? "Actualizar" : "Crear" }}
                </PrimaryButton>

                <Link :href="route('sales.index')"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                <button>CANCELAR</button>
                </Link>
            </div>
        </template>
    </FormSection>
</template>
