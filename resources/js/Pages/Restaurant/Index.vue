<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const rating = ref('');

const props = defineProps({
    restaurant: Object,
    ratings: Number
});
console.log('Valor de rating:', rating);

const form = useForm({ ...props.restaurant });

function submitRating() {
    console.log('Enviando puntuación:', rating.value);
    console.log('ID del restaurante:', props.restaurant.id);

    Inertia.post(route('ratings.store'), {
        rating: rating.value,
        restaurant_id: props.restaurant.id
    }).then(() => {
        console.log('Puntuación enviada correctamente');
    }).catch(error => {
        console.error('Error al enviar la puntuación:', error);
    });
}
</script>


<template>
    <div>
        <AuthenticatedLayout></AuthenticatedLayout>
        <div class="mt-20 mx-4 md:mx-8 lg:mx-12 xl:mx-16">
            <h2 class="text-center text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-semibold mb-4">{{
                props.restaurant.name }}</h2>
            <div class="flex justify-center items-center h-40 md:h-48 lg:h-60 xl:h-72">
                <img class="rounded-t-lg w-full h-full object-cover" :src="'/storage/' + props.restaurant.image" alt="">
            </div>

            <!-- Grid con dos espacios -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <!-- Espacio 1 -->
                <div class="bg-gray-800 p-4 rounded-lg flex justify-center text-white">
                    <div class="flex flex-col items-center text-left">
                        <p class="mb-2">Nombre: {{ props.restaurant.name }}</p>
                        <p class="mb-2">Dirección: {{ props.restaurant.address }}</p>
                        <p class="mb-2">Descripción: {{ props.restaurant.description }}</p>
                    </div>
                </div>

                <!-- Espacio 2 -->
                <div class="bg-gray-800 p-4 rounded-lg flex justify-center text-white">
                    <div class="flex flex-col items-center text-left">
                        <p class="text-xl font-bold mb-4">VALORACIÓN</p>
                        <form @submit.prevent="submitRating" class="flex items-center">
                            <label for="rating" class="mr-2">Puntuación:</label>
                            <input class="text-black border-2 border-gray-600 rounded-md px-3 py-1" type="number"
                                id="rating" v-model="rating" min="1" max="5">
                            <button
                                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-1 px-4 rounded-md ml-2">Enviar</button>
                        </form>
                        <p>Puntuación promedio: {{ ratings }}</p>
                    </div>
                </div>
                <!-- Espacio 3 -->
                <div class="bg-gray-800 p-4 rounded-lg flex justify-center text-white">
                    <div class="text-xl font-bold mb-4flex flex-col items-center text-left">
                        <p>COMENTARIOS</p>
                    </div>
                </div>

                <!-- Espacio 4 -->
                <div class="bg-gray-800 p-4 rounded-lg flex justify-center text-white">
                    <div class="text-xl font-bold mb-4 flex flex-col items-center text-left">
                        <p> MAPA </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>