<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';


const props = defineProps({
	categories: {
		type: Boolean,
	},
});


</script>

<template>
    <AppLayout title="Has logueado">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Vista del Menú
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome :categories="categories" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
