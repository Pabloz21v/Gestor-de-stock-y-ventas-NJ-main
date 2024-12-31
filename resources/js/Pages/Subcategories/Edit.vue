<script>
    export default {
        name: 'SubcategoriesEdit'
    }
</script>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import SubcategoriesForm from '@/Components/Subcategories/Form.vue';

    const props = defineProps({
        categories: {
            type: Object,
            required: true
        },
        subcategory: {
            type: Object,
            required: true
        }
    })
    const form = useForm({
        name: props.subcategory.name,
        comment: props.subcategory.comment,
        categories_id: props.subcategory.categories_id,
        orden: props.subcategory.orden,
        visible: props.subcategory.visible,
    })
    
</script>


<template >
    <AppLayout title="Edit subcategories" >
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">Editar subcategorias</h1>
        </template>

        <div class="py-12 ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <SubcategoriesForm :updating="true" :form="form" :categories="categories"  @submit="form.put(route('subcategories.update', subcategory.id))"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

