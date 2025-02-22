<script>
export default {
	name: "ProductsForm",
};
</script>

<script setup>
import FormSection from "@/Components/FormSection.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref, computed } from 'vue';

const props = defineProps({
	form: {
		type: Object,
		required: false,
	},
	updating: {
		type: Boolean,
		required: false,
		default: false,
	},
	subcategories: {
		type: Object,
		required: false,
	},
	categories: {
		type: Object,
		required: false,
	},
	previewImagenPrincipal: {
		type: String,
		required: false,
	},
	previewImagenes: {
		type: Array,
		required: false,
	},
	previewVideo: {
		type: String,
		required: false,
	},
});

const previewImagenPrincipal = ref('/storage/photos/default-avatar.jpg');
const previewImagenes = ref([]);
const previewVideo = ref(null);
const proveedoresList = ref(props.form.proveedores ? JSON.parse(props.form.proveedores) : []);

if (props.form.category_id != null) {
	previewImagenPrincipal.value = '/storage/' + props.form.imagen_principal;
	if (props.form.video != null)
		previewVideo.value = '/storage/' + props.form.video;
	if (props.form.imagenes && typeof props.form.imagenes === 'string') {
		previewImagenes.value = JSON.parse(props.form.imagenes || '[]').map(img => `/storage/${img}`);
	}
}

defineEmits(["submit"]);

const handleImagenPrincipal = (event) => {
	const file = event.target.files[0];
	props.form.imagen_principal = file;
	previewImagenPrincipal.value = URL.createObjectURL(file);
};

const handleVideo = (event) => {
	const file = event.target.files[0];
	props.form.video = file;
	previewVideo.value = URL.createObjectURL(file);
};

const handleImagenes = (event) => {
	props.form.imagenes = event.target.files;
	previewImagenes.value = Array.from(event.target.files).map(file => URL.createObjectURL(file));
};

const deleteImagenPrincipal = () => {
	router.delete(route('products.deleteImagenPrincipal', { producto: props.form.id }));
};

const deleteVideo = () => {
	router.delete(route('products.deleteVideo', { producto: props.form.id }));
};

const deleteImagenes = (index) => {
	router.delete(route('products.deleteImagenes', { producto: props.form.id, index }));
};

const addProveedor = () => {
	proveedoresList.value.push('');
	updateProveedores();
};

const removeProveedor = (index) => {
	proveedoresList.value.splice(index, 1);
	updateProveedores();
};

const updateProveedores = () => {
	props.form.proveedores = JSON.stringify(proveedoresList.value);
};

const totalStock = computed(() => {
	return (
		parseInt(props.form.stock_real || 0) +
		parseInt(props.form.stock_en_viaje || 0) +
		parseInt(props.form.stock_en_viaje_vendido || 0)
	).toString();
});
</script>

<template>
	<FormSection @submitted="$emit('submit')">
		<template #title>
			{{ updating ? " Editar Producto" : " Crear Producto" }}
		</template>
		<template #description>
			{{ updating ? "ID Producto: " : "" }}
			{{ updating ? form.id : "" }}
		</template>
		<template #form>
			<!-- <img :src="'/storage/' + props.form.imagen_principal" alt="" srcset="">
			<img src="../../../../storage/app/public/photos/7493Rq1hgGphZYnT9FTDmD86Vwoqq6MHPO5rzW7i.jpg" alt=""
				srcset="">
			{{ props.form.imagen_principal }} -->

			<div class="col-span-6 sm:col-span-6">
				<InputLabel for="visible" value="Visible" />
				<input id="visible" type="checkbox" v-model="props.form.visible" :true-value="1" :false-value="0" />

				<InputLabel value="Categorias y Subcategorias" class="mt-2 block w-full" />
				<select v-model="props.form.subcategory_id"
					class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
					<option v-for="subcategory in subcategories" :key="subcategory.id" :value="subcategory.id">
						{{ subcategory.categories.name }} -
						{{ subcategory.name }}
					</option>
				</select>
				<InputError :message="$page.props.errors.subcategory_id" class="mt-0" />

				<InputLabel for="name" value="Producto" class="mt-2 block w-full" />
				<TextInput id="name" v-model="props.form.name" type="text" class="mt-1 block " />
				<InputError :message="$page.props.errors.name" class="mt-0" />

				<InputLabel for="description" value="Comentarios" class="mt-2 block w-full" />
				<TextInput id="description" v-model="props.form.description" type="text" class="mt-1 block " />
				<InputError :message="$page.props.errors.description" class="mt-0" />

				<InputLabel for="price" value="Precio" class="mt-2 block w-full" />
				<TextInput id="price" v-model="props.form.price" type="number" step="0.01" class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.price" class="mt-0" />

				<InputLabel for="ganancia" value="Ganancia" class="mt-2 block w-full" />
				<TextInput id="ganancia" v-model="props.form.ganancia" type="number" step="0.01"
					class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.ganancia" class="mt-0" />

				<InputLabel for="descuento" value="Descuento" class="mt-2 block w-full" />
				<TextInput id="descuento" v-model="props.form.descuento" type="number" step="0.01"
					class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.descuento" class="mt-0" />

				<InputLabel for="oferta" value="Oferta" class="mt-2 block w-full" />
				<input id="oferta" type="checkbox" v-model="props.form.oferta" :true-value="1" :false-value="0" />
				<InputError :message="$page.props.errors.oferta" class="mt-0" />

				<InputLabel for="detalles" value="Detalles" class="mt-2 block w-full" />
				<TextInput id="detalles" v-model="props.form.detalles" type="text" class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.detalles" class="mt-0" />

				<InputLabel for="marca" value="Marca" class="mt-2 block w-full" />
				<TextInput id="marca" v-model="props.form.marca" type="text" class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.marca" class="mt-0" />

				<InputLabel for="tamaño" value="Tamaño" class="mt-2 block w-full" />
				<TextInput id="tamaño" v-model="props.form.tamaño" type="text" class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.tamaño" class="mt-0" />

				<InputLabel for="color" value="Color" class="mt-2 block w-full" />
				<TextInput id="color" v-model="props.form.color" type="text" class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.color" class="mt-0" />

				<InputLabel for="peso" value="Peso" class="mt-2 block w-full" />
				<TextInput id="peso" v-model="props.form.peso" type="text" class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.peso" class="mt-0" />

				<InputLabel for="dimensiones" value="Dimensiones" class="mt-2 block w-full" />
				<TextInput id="dimensiones" v-model="props.form.dimensiones" type="text" class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.dimensiones" class="mt-0" />

				<InputLabel for="stock" value="Stock" class="mt-2 block w-full" />
				<TextInput id="stock" v-model="props.form.stock" type="number" class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.stock" class="mt-0" />

				<InputLabel for="contador_ventas" value="Contador de Ventas" class="mt-2 block w-full" />
				<TextInput id="contador_ventas" v-model="props.form.contador_ventas" type="number"
					class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.contador_ventas" class="mt-0" />

				<InputLabel for="stock_real" value="Stock Real" class="mt-2 block w-full" />
				<TextInput id="stock_real" v-model="props.form.stock_real" type="number" class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.stock_real" class="mt-0" />

				<InputLabel for="stock_en_viaje" value="Stock en Viaje" class="mt-2 block w-full" />
				<TextInput id="stock_en_viaje" v-model="props.form.stock_en_viaje" type="number"
					class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.stock_en_viaje" class="mt-0" />

				<InputLabel for="stock_en_viaje_vendido" value="Stock en Viaje Vendido" class="mt-2 block w-full" />
				<TextInput id="stock_en_viaje_vendido" v-model="props.form.stock_en_viaje_vendido" type="number"
					class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.stock_en_viaje_vendido" class="mt-0" />

				<InputLabel for="stock_total" value="Stock Total" class="mt-2 block w-full" />
				<TextInput id="stock_total" :value="totalStock" type="number" class="mt-1 block w-full" disabled />

				<InputLabel for="stock_minimo" value="Stock Mínimo" class="mt-2 block w-full" />
				<TextInput id="stock_minimo" v-model="props.form.stock_minimo" type="number"
					class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.stock_minimo" class="mt-0" />

				<InputLabel for="stock_maximo" value="Stock Máximo" class="mt-2 block w-full" />
				<TextInput id="stock_maximo" v-model="props.form.stock_maximo" type="number"
					class="mt-1 block w-full" />
				<InputError :message="$page.props.errors.stock_maximo" class="mt-0" />

				<InputLabel for="imagen_principal" value="Imagen Principal" class="mt-2 block w-full" />
				<div v-if="props.form.imagen_principal || previewImagenPrincipal">
					<img :src="previewImagenPrincipal || `/storage/${props.form.imagen_principal}`" alt="Main" />
					<button type="button" @click="deleteImagenPrincipal">Eliminar Foto Principal</button>
				</div>
				<input type="file" id="imagen_principal" @change="handleImagenPrincipal" />
				<InputError :message="$page.props.errors.imagen_principal" class="mt-0" />

				<InputLabel for="imagenes" value="Imagenes" class="mt-2 block w-full" />
				<div v-for="(photo, index) in previewImagenes" :key="index">
					<img :src="photo" alt="Extras" />
					<button type="button" @click="deleteImagenes(index)">Eliminar Foto</button>
				</div>
				<input type="file" multiple @change="handleImagenes" />
				<InputError :message="$page.props.errors.imagenes" class="mt-0" />

				<InputLabel for="video" value="Video" class="mt-2 block w-full" />
				<div v-if="previewVideo || props.form.video">
					<video :src="previewVideo || `/storage/${props.form.video}`" controls></video>
					<button type="button" @click="deleteVideo">Eliminar Video</button>
				</div>
				<input type="file" @change="handleVideo" />
				<InputError :message="$page.props.errors.video" class="mt-0" />

				<InputLabel for="proveedores" value="Proveedores" class="mt-2 block w-full" />
				<div v-for="(proveedor, index) in proveedoresList" :key="index" class="flex items-center gap-2">
					<TextInput v-model="proveedoresList[index]" type="text" class="mt-1 block w-full"
						@input="updateProveedores" />
					<a :href="proveedoresList[index]" target="_blank" class="text-blue-500 hover:underline">Abrir</a>
					<button type="button" @click="removeProveedor(index)">Eliminar</button>
				</div>
				<button type="button" @click="addProveedor">Agregar Proveedor</button>
				<InputError :message="$page.props.errors.proveedores" class="mt-0" />
			</div>
		</template>

		<template #actions>
			<div class="grid gap-4 grid-cols-2 justify-items-center">
				<PrimaryButton>
					{{ updating ? "Actualizar" : "Crear" }}
				</PrimaryButton>

				<Link :href="route('products.index')"
					class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">
				<button>CANCELAR</button>
				</Link>
			</div>
		</template>
	</FormSection>
</template>
