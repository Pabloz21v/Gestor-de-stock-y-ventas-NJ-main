<template>
    <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Detalles del Producto</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500"><strong>Nombre:</strong> {{
                                    modalProductData?.data?.name }}</p>
                                <p class="text-sm text-gray-500"><strong>Descripción:</strong> {{
                                    modalProductData?.data?.description }}</p>
                                <p class="text-sm text-gray-500"><strong>Costo:</strong> {{
                                    modalProductData?.data?.price
                                    }}</p>
                                <p class="text-sm text-gray-500"><strong>Mark Up (valor se lleva a %):</strong> {{
                                    modalProductData?.data?.ganancia }}%</p>
                                <p class="text-sm text-gray-500"><strong>Descuento:</strong> {{
                                    modalProductData?.data?.descuento }}</p>
                                <p class="text-sm text-gray-500"><strong>Oferta:</strong> {{
                                    modalProductData?.data?.oferta
                                        ? 'Sí' : 'No' }}</p>
                                <p class="text-sm text-gray-500"><strong>Detalles:</strong> {{
                                    modalProductData?.data?.detalles }}</p>
                                <p class="text-sm text-gray-500"><strong>Marca:</strong> {{
                                    modalProductData?.data?.marca }}
                                </p>
                                <p class="text-sm text-gray-500"><strong>Tamaño:</strong> {{
                                    modalProductData?.data?.tamaño
                                    }}</p>
                                <p class="text-sm text-gray-500"><strong>Color:</strong> {{
                                    modalProductData?.data?.color }}
                                </p>
                                <p class="text-sm text-gray-500"><strong>Peso:</strong> {{
                                    modalProductData?.data?.peso }}
                                </p>
                                <p class="text-sm text-gray-500"><strong>Dimensiones:</strong> {{
                                    modalProductData?.data?.dimensiones }}</p>
                                <p class="text-sm text-gray-500"><strong>Stock:</strong> {{
                                    modalProductData?.data?.stock }}
                                </p>
                                <p class="text-sm text-gray-500"><strong>Contador de Ventas:</strong> {{
                                    modalProductData?.data?.contador_ventas }}</p>
                                <p class="text-sm text-gray-500"><strong>Stock Real:</strong> {{
                                    modalProductData?.data?.stock_real }}</p>
                                <p class="text-sm text-gray-500"><strong>Stock en Viaje:</strong> {{
                                    modalProductData?.data?.stock_en_viaje }}</p>
                                <p class="text-sm text-gray-500"><strong>Stock en Viaje Vendido:</strong> {{
                                    modalProductData?.data?.stock_en_viaje_vendido }}</p>
                                <p class="text-sm text-gray-500"><strong>Stock Total:</strong> {{
                                    totalStock }}</p>
                                <p class="text-sm text-gray-500"><strong>Stock Mínimo:</strong> {{
                                    modalProductData?.data?.stock_minimo }}</p>
                                <p class="text-sm text-gray-500"><strong>Stock Máximo:</strong> {{
                                    modalProductData?.data?.stock_maximo }}</p>
                                <p class="text-sm text-gray-500"><strong>Visible:</strong> {{
                                    modalProductData?.data?.visible ? 'Sí' : 'No' }}</p>
                                <p class="text-sm text-gray-500"><strong>Proveedores:</strong></p>
                                <ul class="list-disc list-inside pl-4">
                                    <li v-for="(proveedor, index) in JSON.parse(modalProductData?.data?.proveedores || '[]')"
                                        :key="index" class="mb-1">
                                        <a :href="proveedor" target="_blank" class="text-blue-500 hover:underline">{{
                                            proveedor }}</a>
                                    </li>
                                </ul>
                                <p class="text-sm text-gray-500"><strong>Imagen Principal:</strong> <img
                                        :src="`/storage/${modalProductData?.data?.imagen_principal}`"
                                        alt="Imagen Principal" /></p>
                                <p v-if="modalProductData?.data?.imagenes" class="text-sm text-gray-500">
                                    <strong>Imágenes:</strong></p>
                                <div v-if="modalProductData?.data?.imagenes"
                                    v-for="(img, index) in JSON.parse(modalProductData?.data?.imagenes || '[]')"
                                    :key="index">
                                    <img :src="`/storage/${img}`" alt="Imagen" />
                                </div>
                                <p v-if="modalProductData?.data?.video" class="text-sm text-gray-500">
                                    <strong>Video:</strong> <video :src="`/storage/${modalProductData?.data?.video}`"
                                        controls></video></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="closeModal" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 my-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    closeModal: Function,
    modalProductData: Object,
    totalStock: Number
});
</script>
