<script>
    export default {
        name: 'DishesForm'
    }
</script>

<script setup>
import FormSection from '@/Components/FormSection.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Link } from '@inertiajs/vue3'

    defineProps({
        form: {
            type: Object,
            required: false
        },
        updating: {
            type: Boolean,
            required: false,
            default: false
        },
        subcategories: {
            type: Object,
            required: false
        },
        categories: {
            type: Object,
            required: false
        },
    })

    defineEmits(['submit'])
</script>

<template>
    <FormSection @submitted="$emit('submit')">
        <template #title>
            {{ updating ? 'Actualizar Plato' : 'Crear plato' }}
        </template>
        <template #description>
            {{ updating ? 'Actualizar Plato' : 'Crear plato'}}
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-6">
                <InputLabel for="visible" value="Visible" />
                <input id="visible"
                    type="checkbox"
                    v-model="form.visible"
                    :true-value="1"
                    :false-value="0" />
                    
                <InputLabel  value="Categorias y Subcategorias" class="mt-2 block w-full"/>
                <select v-model="form.subcategory_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">
                        {{ subcategory.categories.name }} - {{ subcategory.name }}
                    </option>
                </select>
                <InputError :message="$page.props.errors.subcategory_id" class="mt-0" />

                <InputLabel for="name" value="Plato" class="mt-2 block w-full"/>
                <TextInput id="name" v-model="form.name" type="text"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.name" class="mt-0" />
                
                <InputLabel for="ingredients" value="Ingredientes" class="mt-2 block w-full"/>
                <TextInput id="ingredients" v-model="form.ingredients" type="text"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.ingredients" class="mt-0" />

                <InputLabel for="price" value="Precio" class="mt-2 block w-full"/>
                <TextInput id="price" v-model="form.price" type="text"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.price" class="mt-0" />

            </div>
        </template>
        
        <template #actions>
            <div class="grid gap-4 grid-cols-2 justify-items-center">
                
                <PrimaryButton>
                    {{ updating ? 'Actualizar' : 'Crear' }}    
                </PrimaryButton>

                <Link :href="route('dishes.index') " class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                    <button>CANCELAR</button>
                </Link>
            </div>
        </template>
    </FormSection>
</template>