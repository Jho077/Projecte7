<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import L from 'leaflet';
import "leaflet/dist/leaflet.css";

let map;
var popup = L.popup();
var longitude
var latitude


onMounted(() => {
    map = L.map('mapid').setView([props.restaurant.latitude, props.restaurant.longitude], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    let currentMarker;
    currentMarker = L.marker([props.restaurant.latitude, props.restaurant.longitude]);
    currentMarker.addTo(map);

});
const rating = ref('');
const comment = ref('');
const editingCommentId = ref(null);
const editedComment = ref('');

const props = defineProps({
    restaurant: Object,
    ratings: Number,
    comments: Array,
    user: Object,
    userRating: Number,
});

console.log(props.user)
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

function submitComment() {
    Inertia.post(route('comments.store'), {
        comment: comment.value,
        restaurant_id: props.restaurant.id
    }).then(() => {
        comment.value = '';
    }).catch(error => {
        console.error('Error al enviar el comentario:', error);
    });
}
function startEditing(commentId) {
    editingCommentId.value = commentId;
    // También podrías establecer el texto original del comentario en editedComment.value aquí
}
function saveEditedComment(commentId) {
    // Realizar una solicitud PUT a la ruta comments.update
    Inertia.put(route('comments.update', { comment: commentId }), {
        comment: editedComment.value,
        restaurant_id: props.restaurant.id
    }).then(() => {
        // Restablecer los valores después de editar
        editingCommentId.value = null;
        editedComment.value = '';

        // Opcional: mostrar un mensaje de éxito
        console.log('Comentario editado exitosamente');
    }).catch(error => {
        console.error('Error al editar el comentario:', error);
    });
}
function cancelEditing() {
    // Restablecer los valores después de cancelar la edición
    editingCommentId.value = null;
    editedComment.value = '';
}
function deleteComment(commentId, restaurantId) {
    if (confirm('¿Estás seguro de que quieres eliminar este comentario?')) {
        // Realizar una solicitud DELETE a la ruta comments.destroy
        Inertia.delete(route('comments.destroy', { id: commentId }))
            .then(() => {
                // Redirigir a la página del restaurante después de eliminar el comentario
                location.href = route('showRestaurant', { id: restaurantId });
            })
            .catch(error => {
                console.error('Error al eliminar el comentario:', error);
            });
    }
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
                        <p class="text-xl font-bold mb-4">Datos generales</p>
                        <p class="mb-2">Nombre: {{ props.restaurant.name }}</p>
                        <p class="mb-2">longitud: {{ props.restaurant.longitude }}</p>
                        <p class="mb-2">latitud: {{ props.restaurant.latitude }}</p>
                        <p class="mb-2">Dirección: {{ props.restaurant.address }}</p>
                        <p class="mb-2">Descripción: {{ props.restaurant.description }}</p>
                    </div>
                </div>




                <!-- Espacio 2 -->
                <div class="bg-gray-800 p-4 rounded-lg flex justify-center text-white">
                    <div class="flex flex-col items-center text-left">
                        <p class="text-xl font-bold mb-4">Valoración</p>
                        <form @submit.prevent="submitRating" class="flex items-center mb-2">
                            <label for="rating" class="mr-2">Tu voto:</label>
                            <input class="text-black border-2 border-gray-600 rounded-md px-3 py-1" type="number"
                                id="rating" v-model="rating" min="1" max="5">
                            <button
                                class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-1 px-4 rounded-md ml-2">Enviar</button>
                        </form>
                        <div class="flex items-center mb-2">
                            <span class="mr-2">Tu puntuación fue de:</span>
                            <span class="text-yellow-500 text-xl" v-if="userRating">{{ userRating }}</span>
                            <span class="text-gray-400" v-else>No has votado aún</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <span class="mr-2">Puntuación promedio del restaurante:</span>
                            <span class="text-yellow-500 text-xl">{{ ratings }}</span>
                        </div>
                        <p class="text-sm text-gray-400">Si cambias de opinión, ¡vuelve a votar!</p>
                    </div>
                </div>



                <!-- Espacio 3 -->
                <div class="bg-gray-800 p-6 rounded-lg flex justify-center text-white mb-8">
                    <div class="flex flex-col items-center text-left w-full">
                        <h2 class="text-2xl font-bold mb-4">Comentarios</h2>
                        <form @submit.prevent="submitComment" class="w-full">
                            <label for="comment" class="mb-2 block text-gray-300">Comentario:</label>
                            <textarea
                                class="text-black border-2 border-gray-600 rounded-md px-3 py-2 mb-2 w-full focus:outline-none focus:border-blue-500"
                                id="comment" v-model="comment"></textarea>
                            <button type="submit"
                                class="bg-orange-500 hover:bg-orange-800 text-white font-bold py-2 px-4 rounded-md focus:outline-none">Enviar</button>
                        </form>
                        <div class="mt-6 w-full max-h-60 overflow-y-auto scrollbar-custom">
                            <!-- Añadido scrollbar-custom -->
                            <h3 class="text-lg font-bold mb-2 text-gray-300">Comentarios anteriores:</h3>
                            <ul class="list-disc list-inside text-gray-300">
                                <li v-for="comment in props.comments" :key="comment.id">
                                    <template v-if="editingCommentId !== comment.id">
                                        <strong>{{ comment.user.name }}:</strong> {{ comment.comment }}
                                        <template v-if="comment.user_id === props.user.id">
                                            <button
                                                class="bg-blue-500 hover:bg-orange-800 text-white px-2 py-1 rounded ml-3"
                                                @click="startEditing(comment.id)">Editar</button>
                                            <button
                                                class="bg-red-600 hover:bg-red-800 text-white px-2 py-1 rounded ml-3"
                                                style="margin-right: 5px;"
                                                @click="deleteComment(comment.id, props.restaurant.id)">Eliminar</button>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <input type="text" class="text-black rounded" v-model="editedComment"
                                            @keyup.enter="saveEditedComment(comment.id)">
                                        <button @click="saveEditedComment(comment.id)"
                                            class="bg-blue-500 hover:bg-orange-800 text-white px-2 py-1 rounded ml-3">Guardar</button>
                                        <button @click="cancelEditing"
                                            class="bg-red-600 hover:bg-red-800 text-white px-2 py-1 rounded ml-3">Cancelar</button>
                                    </template>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>




                <!-- Espacio 4 -->
                <div class="bg-gray-800 p-4 rounded-lg flex justify-center text-white mb-8">
                    <div class="text-xl font-bold mb-4 flex flex-col items-center text-left w-full">
                        <p> Mapa </p>
                        <div id="mapid" style="height: 400px; width: 100%; max-width: 800px; overflow: hidden;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.scrollbar-custom::-webkit-scrollbar {
    width: 12px;
}
</style>
