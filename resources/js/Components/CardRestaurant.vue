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
            <img class="rounded-t-lg" :src="'/storage/' + props.restaurant.image" alt="Imagen de Restaurant">
        </a>
        <div class="p-5">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ props.restaurant.name }}
            </h5>
            <p class="block mt-1 text-lg leading-tight font-medium text-black hover:underline">{{
                props.restaurant.address }}</p>
            <p class="mt-2 text-gray-500">{{ props.restaurant.description }}</p>
            <div class="flex space-x-2 mt-5">
            </div>
        </div>
    </div>
</template>
