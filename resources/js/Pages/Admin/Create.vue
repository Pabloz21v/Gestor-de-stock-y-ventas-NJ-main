<script>
    export default {
        name: 'RoleCreate'
    }
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import RoleForm from '@/Components/Role/Form.vue';

    const form = useForm({
        name: '',
        email: '',
        apellido: '',
        phone: '',
        domicilio: '',
        comentarios: '',
        password: '',
        cargo: '',
    })
</script>

<template >
    <AppLayout v-if="$page.props.user.permissions.includes('create roles')">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">Crear member team</h1>
        </template>

        <div class="py-12 "  v-if="$page.props.user.permissions.includes('create roles')">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <RoleForm :form="form" @submit="form.post(route('role.store'))"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>