<script>
	export default {
		name: 'BackupsIndex'
	}
</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue';
import Spinner from './../../Components/Spinner/Spinner.vue';

const props = defineProps({
    backups: Array
});
const showModal = ref(false);
const modalDataID = ref({});
const isLoading = ref(false);


const openModalRestore = (id) => {
    modalDataID.value = id;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    modalDataID.value = {};
};

const restoreBackup = (id) => {
    isLoading.value = true;
    Inertia.post(route('backups.restore', id), {}, {
        onSuccess: () => {
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    });
};

const createBackup = () => {
    isLoading.value = true;
    Inertia.post(route('backups.createBackup'), {}, {
        onSuccess: () => {
            isLoading.value = false;
        },
        onError: () => {
            isLoading.value = false;
        }
    });
}

</script>



<template>
    <AppLayout v-if="$page.props.user.permissions.includes('create roles')">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tigth">Backups</h1>
        </template>

        


        <div class="py-12 " >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row justify-between items-center mb-4">
                            <span class="text-lg font-semibold">Backups</span>
                           
                            <Link @click="createBackup" class="bg-cyan-500 text-white rounded-lg px-4 py-2 mt-4 md:mt-2  lg:mt-0">
                                Crear punto de restauracion
                            </Link>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="container mx-auto p-4">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr>
                                        <th class="w-1/3 px-4 py-2">ID</th>
                                        <th class="w-1/3 px-4 py-2 ">Fecha del BackUp</th>
                                        <th class="w-1/3 px-4 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <tr  v-for="backup in backups" :key="backup.id" >
                                        <td class="border  px-2 ">
                                            <p class="flex justify-around mt-1  py-1 font-semibold   leading-5 text-gray-500">{{ backup.id }}</p>
                                                    
                                        </td>
                                        <td class="border px-2">
                                            <p class="mt-1 py-1 font-semibold flex justify-around  leading-5 text-gray-500">{{ new Date(backup.created_at).toLocaleString() }}</p>
                                                    
                                        </td>
                                        <td class=" border  ">
                                            <div class="md:py-2 py-1 flex flex-col md:flex-row justify-around items-center">
                                                <button @click="openModalRestore(backup.id)" class="font-semibold bg-lime-200 rounded-lg p-1 ">
                                                        <button  >Restaurar</button>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>   
        </div>

        <!-- Spinner -->
        <Spinner v-if="isLoading" />

        <!-- Modal Restore-->
        <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Restaurar Menú</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Se restaurará el estado del menú al de la fecha seleccionada
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button @click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 my-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                        
                            <button @click="restoreBackup(modalDataID)" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 my-2 py-2 bg-green-600 shadow-lg shadow-green-600 hover:bg-green-700 text-base font-medium text-white  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">Aceptar</button>
                        </div>
                    </div>
                </div>
        </div>
    </AppLayout>
</template>


