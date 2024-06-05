<template>
    <AuthenticatedLayout></AuthenticatedLayout>
      <h1 class="text-center mt-20 text-5xl font-bold">Tus restaurantes!</h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 mt-5">
        <div v-for="(restaurant, index) in restaurants" :key="restaurant.id" :class="getGridItemClass(index)">
          <div class="w-full h-full flex justify-center items-center">
            <CardRestaurantNoButtons :restaurant="restaurant" class="w-full h-full" />
          </div>
        </div>
      </div>
  </template>
  
  <script setup>
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { defineProps } from 'vue';
  import { Link } from '@inertiajs/inertia-vue3';
  import CardRestaurantNoButtons from '@/Components/CardRestaurantNoButtons.vue';
  
  const props = defineProps({
    restaurants: Array,
  });
  
  const getGridItemClass = (index) => {
    return index % 4 === 0 ? 'col-span-4 sm:col-span-2 md:col-span-1 justify-self-center' : 'justify-self-center';
  }
  </script>
  
  <style scoped>
  /* No se necesita ningún estilo adicional para hacerlo responsive con Tailwind CSS */
  </style>
  