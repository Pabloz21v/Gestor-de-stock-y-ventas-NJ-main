<script>
    export default {
        name: 'DishesEdit'
    }
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import DishesForm from '@/Components/Dishes/Form.vue';

    const props = defineProps({
        dishe: {
            type: Object,
            required: true
        },
        subcategories: {
            type: Object,
            required: true
        },
        categories: {
            type: Object,
            required: false
        },
    })
    const form = useForm({
        subcategory_id: props.dishe.subcategory_id,
        name: props.dishe.name,
        price: props.dishe.price,
        ingredients: props.dishe.ingredients,
        visible: props.dishe.visible,
    })
    
</script>


<template >
    <AppLayout title="Edit dishes" >
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">Editar Platos</h1>
        </template>

        <div class="py-12 ">
            
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <DishesForm :updating="true" :form="form" :categories="categories" :subcategories="subcategories" @submit="form.put(route('dishes.update', dishe.id))"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

