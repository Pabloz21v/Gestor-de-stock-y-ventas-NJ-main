<script>
    export default {
        name: 'RoleForm'
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
        }
    })

    defineEmits(['submit'])
</script>

<template>
    <FormSection @submitted="$emit('submit')">
        <template #title>
            {{ updating ? 'Actualizar datos' : 'Crear nuevo miembro' }}
        </template>
        <template #description>
            {{ updating ? 'Actualizar datos' : 'Crear nuevo miembro'}}
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-6">
                
                <InputLabel for="name" value="Name" class=" block w-full"/>
                <TextInput id="name" v-model="form.name" type="text"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.name" class="mt-0" />
                
                <InputLabel for="apellido" value="Apellido" class="mt-2 block w-full"/>
                <TextInput id="apellido" v-model="form.apellido" type="text"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.apellido" class="mt-0" />

                <InputLabel for="cargo" value="Cargo" class="mt-2 block w-full"/>
                <TextInput id="cargo" v-model="form.cargo" type="text"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.cargo" class="mt-0" />

                <InputLabel for="phone" value="Telefono" class="mt-2 block w-full"/>
                <TextInput id="phone" v-model="form.phone" type="text"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.phone" class="mt-0" />

                <InputLabel for="domicilio" value="Domicilio" class="mt-2 block w-full"/>
                <TextInput id="domicilio" v-model="form.domicilio" type="text"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.domicilio" class="mt-0" />

                <InputLabel for="comentarios" value="Comentarios" class="mt-2 block w-full"/>
                <textarea id="comentarios"  v-model="form.comentarios" type="text" class=" border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" rows="4" cols="50">
                </textarea>
                <InputError :message="$page.props.errors.comentarios" class="mt-0" />
                

                <InputLabel for="email" value="Email" class="mt-2 block w-full"/>
                <TextInput id="email" v-model="form.email" type="email"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.email" class="mt-0" />

                <InputLabel for="password" value="Password" class="mt-2 block w-full"/>
                <TextInput id="password" v-model="form.password" type="password"  class="mt-1 block w-full"/>
                <InputError :message="$page.props.errors.password" class="mt-0" />
            </div>
        </template>
        
        <template #actions>
            <div class="grid gap-4 grid-cols-2 justify-items-center">
                <PrimaryButton>
                    {{ updating ? 'Actualizar' : 'Crear' }}    
                </PrimaryButton>
            
                <Link :href="route('role.index') " class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
                    <button>CANCELAR</button>
                </Link>

            </div>
            
        </template>
    </FormSection>
</template>
