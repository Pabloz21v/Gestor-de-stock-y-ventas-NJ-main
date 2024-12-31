<script>
    export default {
        name: 'SubcategoriesCreate'
    }
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import SubcategoriesForm from '@/Components/Subcategories/Form.vue';

    const form = useForm({
        name: '',
        comment: '',
        categories_id: '',
        orden: '',
        visible: 1
    })
    
    defineProps({
        categories: {
            type: Object,
            required: false
        },
    })
</script>



<template >
    <AppLayout >
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">Crear subcategorias</h1>
        </template>
        <div class="py-12 " >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        
                        <div class="p-6 bg-white border-b border-gray-200">
                            
                            <SubcategoriesForm :form="form" :categories="categories" @submit="form.post(route('subcategories.store'))"/>
                        
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>