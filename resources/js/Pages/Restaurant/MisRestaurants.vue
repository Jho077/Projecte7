<template>
  <AuthenticatedLayout>
    <h1 class="text-center mt-20 text-5xl font-bold">Tus restaurantes!</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 mt-5">
      <div v-for="(restaurant, index) in restaurants" :key="restaurant.id" class="flex justify-center">
        <CardRestaurantNoButtons :restaurant="restaurant" class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-xl" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue';
import CardRestaurantNoButtons from '@/Components/CardRestaurantNoButtons.vue';

const props = defineProps({
  restaurants: Array,
});
</script>

<style scoped>
</style>
