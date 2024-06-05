<script setup>
import { useForm } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    restaurant: Object,
});

const form = useForm({ ...props.restaurant });

const deleteRestaurant = () => {
    if (confirm('¿Estás seguro de que quieres eliminar este restaurante?')) {
        form.delete(route('restaurants.destroy', props.restaurant.id));
    }
};
</script>

<template>
    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a :href="route('showRestaurant', { id: props.restaurant.id })">
            <img class="rounded-t-lg" :src="'/storage/' + props.restaurant.image" alt="Imagen de Restaurante">
        </a>
        <div class="p-5">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ props.restaurant.name }}
            </h5>
            <p class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">{{
                props.restaurant.address }}</p>
            <p class="mt-2 text-gray-500">{{ props.restaurant.description }}</p>
            <div class="flex space-x-2 mt-5">
                <Link :href="route('restaurants.edit', props.restaurant.id)"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-black rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Editar
                </Link>
                <button @click="deleteRestaurant"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    Eliminar
                </button>
            </div>
        </div>
    </div>
</template>
