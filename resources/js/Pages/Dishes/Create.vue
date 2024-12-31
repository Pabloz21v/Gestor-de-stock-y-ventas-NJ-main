<script>
    export default {
        name: 'DishesCreate'
    }
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import DishesForm from '@/Components/Dishes/Form.vue';

    const form = useForm({
        subcategory_id: '',
        name: '',
        price: '',
        ingredients: '',
        visible: 1
    })

    defineProps({
        subcategories: {
            type: Object,
            required: false
        },
        categories: {
            type: Object,
            required: false
        },
    })
</script>


<template >
    <AppLayout >
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">Crear Plato</h1>
        </template>
        
        <div class="py-12 " >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <DishesForm :form="form" :categories="categories" :subcategories="subcategories" @submit="form.post(route('dishes.store'))"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>