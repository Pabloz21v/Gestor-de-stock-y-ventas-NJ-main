<script setup>


import { Inertia } from '@inertiajs/inertia'

const props = defineProps({
	categories: {
		type: Boolean,
	},
    
});


</script>

<template>
	<div class="bg-gray-100" >
		<div>
			<div>
				<header >
					
				</header>

				<!-- MENU CARTA RESTAURANTE -->
				<main class="">
					<div class="max-w-3xl mx-auto">
						<!-- Imagen superior -->
						<div class=" p-6">
							<div class="flex justify-center ">
								<div class="mb-4 ">
									<img src="../../../storage/app/public/images/2024-06 logo-02.png" alt="Logo Restaurant" class="xl:max-w-80 sm:max-w-64">
								</div>
							</div>
							
							<!-- Imágenes inferiores -->
							<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 justify-items-center items-center mx-5">
								<div>
									<img src="../../../storage/app/public/images/Carpano.png" alt="" class=" max-w-36">
								</div>
								<div>
									<img src="../../../storage/app/public/images/FB02.png" alt="" class=" max-w">
								</div>
								<div>
									<img src="../../../storage/app/public/images/LOGO-VODKA-NEGRO.png" alt="" class=" max-w-36">
								</div>
							</div>
						</div>
					</div>
					<div class="bg-gray-100">
						<div class=" mx-auto xl:p-4" v-for="category in categories" :key="category.id">
							<div v-if="category.visible">
								<div v-if="category.name">
									<h1 class="text-4xl font-bold bg-category-name text-white  p-8">{{category.name}}</h1>
								</div>
								<div v-if="category.comment">
									<h1 class="text-3xl font-bold bg-white text-gray-700 text-center p-4">{{category.comment}}</h1>
								</div>
									<div class="mt-4 p-4" v-for="subcategory in category.subcategories" :key="subcategory.id">
									<div v-if="subcategory.visible">
										<div v-if="subcategory.name">
										<h2 class="text-2xl font-semibold bg-black text-white  p-4">{{subcategory.name}}</h2>
										</div>
										<div v-if="subcategory.comment">
											<h2 class="text-2xl font-semibold bg-white text-gray-700 text-center p-2">{{subcategory.comment}}</h2>
										</div>
										<div class="mt-4"  v-for="dishe in subcategory.dishes" :key="dishe.id">
											<div v-if="dishe.visible">
												<div class="bg-white p-4 border-t border-gray-200 divide-y divide-dashed">
												<div class="flex justify-between">
													<div class="font-bold text-gray-700">{{dishe.name}}</div>
													<div class="text-gray-700">${{dishe.price}}</div>
												</div>
													<div class="text-gray-600">{{dishe.ingredients}}</div>
												</div>
											</div>
											
										</div>
									</div>
									
								</div>
								</div>
								
							</div>
						</div>
				</main>

				<footer class="pt-16 text-center text-sm text-black dark:text-white/70">
					<!-- Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }}) -->
					<div class="bg-gray-800 text-white py-8">
						<div class="container mx-auto px-8">
							<div class="flex flex-col md:flex-row justify-around items-center">
							<!-- Información de la página -->
								<div class="mb-6 md:mb-0">
									<h3 class="text-lg font-semibold">Información</h3>
									<p>Teléfono: +1 234 567 890</p>
									<p>Dirección: 123 Calle Principal, Ciudad</p>
									<p>Horario de atención: Lun - Vie, 9:00 - 18:00</p>
								</div>
								<!-- Iconos de redes sociales -->
								<div class="flex space-x-4">
									<a href="https://www.facebook.com" target="_blank" class="hover:text-blue-500">
									<!-- Icono de Facebook -->
										<img src="./../../../storage/app/public/iconos/facebook.svg" width="26" height="26"  alt="facebook Icon">
									
									</a>
									<a href="https://www.instagram.com" target="_blank" class="hover:text-pink-500">
									<!-- Icono de Instagram -->
										<img src="./../../../storage/app/public/iconos/instagram.svg" width="26" height="26"  alt="instagram Icon">
									
									</a>

									<a href="https://www.youtube.com" target="_blank" class="hover:text-red-500">
									<!-- Icono de youtube -->
										<img src="./../../../storage/app/public/iconos/youtube.svg" width="26" height="26"  alt="youtube Icon">
									
									</a>

									<a href="https://x.com" target="_blank" class="hover:text-black">
									<!-- Icono de Twitter (X) -->
										<img src="./../../../storage/app/public/iconos/x.svg" width="26" height="26"  alt="X Icon">
									</a>
									
									<a href="https://www.whatsapp.com" target="_blank" class="hover:text-green-500">
									<!-- Icono de WhatsApp -->
										<!-- SVG aquí -->
										<img src="./../../../storage/app/public/iconos/whatsapp2.svg" width="26" height="26"  alt="WhatsApp Icon">
									</a>
								</div>
							</div>
						</div>
					</div>
				</footer>
			</div>
		</div>
	</div>
</template>