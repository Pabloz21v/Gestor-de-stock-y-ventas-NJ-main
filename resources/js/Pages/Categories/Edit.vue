<script>
    export default {
        name: 'CategoriesEdit'
    }
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import CategoriesForm from '@/Components/Categories/Form.vue';

    const props = defineProps({
        categories: {
            type: Object,
            required: true
        }
    })
    const form = useForm({
        name: props.categories.name,
        comment: props.categories.comment,
        orden: props.categories.orden,
        visible: props.categories.visible,
    })
    
</script>


<template >
    <AppLayout title="Edit categories" >
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">Editar categorias</h1>
        </template>

        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <CategoriesForm :updating="true" :form="form" @submit="form.put(route('categories.update', categories.id))"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

