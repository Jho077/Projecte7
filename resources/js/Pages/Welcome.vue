<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Navbar from '@/Components/Navbar.vue';
import CardRestaurant from '@/Components/CardRestaurant.vue';
import "leaflet/dist/leaflet.css";
import L from 'leaflet';
import { ref, onMounted, watch } from 'vue';
import axios from 'axios';

// Definición de Props
const props = defineProps({
    loged: Object,
    ratings: Array,
    restaurant: Object,
});

// Variables Reactivas y Referencias
let map;
const markers = ref([]);
const filteredRestaurants = ref(props.restaurant);
const selectedRating = ref(0);

// Función onMounted
onMounted(() => {
    // Inicializar el mapa Leaflet
    map = L.map('mapid').setView([1, 1], 1);
    // Agregar capa de mapa base
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Inicializar marcadores
    updateMarkers(props.restaurant);
});

// Función para filtrar restaurantes
const filterRestaurants = (rating) => {
    // Establecer la calificación seleccionada
    selectedRating.value = rating;
    // Realizar solicitud HTTP para obtener los restaurantes filtrados
    axios.get('/api/restaurants', {
        params: {
            rating: rating
        }
    }).then(response => {
        // Actualizar los restaurantes filtrados con los datos recibidos
        filteredRestaurants.value = response.data;
        // Actualizar los marcadores en el mapa
        updateMarkers(filteredRestaurants.value);
    }).catch(error => {
        console.error("Error fetching filtered restaurants:", error);
    });
};

// Función para actualizar marcadores
const updateMarkers = (restaurants) => {
    // Limpiar marcadores existentes
    markers.value.forEach(marker => {
        map.removeLayer(marker);
    });
    markers.value = [];

    // Agregar nuevos marcadores
    restaurants.forEach(resto => {
        const marker = L.marker([resto.latitude, resto.longitude]).addTo(map);
        marker.bindPopup(`<b>${resto.name}</b><br>${resto.address}`);
        markers.value.push(marker);
    });
};

// Observador para los restaurantes filtrados
watch(() => filteredRestaurants.value, (newRestaurants) => {
    // Actualizar los marcadores cuando cambian los restaurantes filtrados
    updateMarkers(newRestaurants);
});


</script>

<template>
    <div>

        <Head title="Welcome" />
        <AuthenticatedLayout v-if="props.loged"></AuthenticatedLayout>
        <Navbar v-else></Navbar>
        <div class="bg-white min-h-screen">
            <div class="flex justify-center text-black text-5xl font-bold mt-20">
                <p>¡Vamos a comer!</p>
            </div>
            <div class="flex items-center justify-center mt-10">
                <div class="flex flex-col items-center">
                    <p>Filtra los restaurantes por el número de estrellas</p>
                    <div class="mt-5">
                        <div class="flex items-center">
                            <svg v-for="star in 5" :key="star" @click="filterRestaurants(star)"
                                class="w-6 h-6 cursor-pointer"
                                :class="{ 'text-yellow-500': star <= selectedRating, 'text-gray-300': star > selectedRating }"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 22 20">
                                <!-- Icono de estrella -->
                                <path
                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-center mt-5">
                <div id="mapid" style="height: 400px; width: 100%; max-width: 800px; overflow: hidden;"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 justify-items-center mt-8 mx-4 md:mx-0">
                <CardRestaurant class="cardrestaurant" v-for="resto in filteredRestaurants" :key="resto.id"
                    :restaurant="resto"></CardRestaurant>
            </div>
        </div>
    </div>
</template>

<style scoped>
@media (min-width: 768px) {
    .cardrestaurant {
        max-width: 30rem;
        /* Ajusta este valor según sea necesario */
        width: 100%;
        /* Para asegurarse de que ocupe el 100% del contenedor */
    }
}
</style>
