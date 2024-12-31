<script>
    export default {
        name: 'RoleEdit'
    }
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import RoleForm from '@/Components/Role/Form.vue';

    const props = defineProps({
        role: {
            type: Object,
            required: true
        }
    })
    const form = useForm({
        name: props.role.name,
        email: props.role.email,
        apellido: props.role.apellido,
        password: props.role.password,
        phone: props.role.phone,
        domicilio: props.role.domicilio,
        comentarios: props.role.comentarios,
        cargo: props.role.cargo,
    })
    
</script>


<template >
    <AppLayout title="Edit Role Member" v-if="$page.props.user.permissions.includes('create roles')">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">Editar miembro del equipo</h1>
        </template>

        <div class="py-12 " v-if="$page.props.user.permissions.includes('create roles')">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <RoleForm :updating="true" :form="form" @submit="form.put(route('role.update', role.id))"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

