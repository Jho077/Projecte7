<script setup>
  import { useForm } from '@inertiajs/vue3';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  
  const form = useForm({
    name: '',
    address: '',
    latitude: '',
    longitude: '',
    description: '',
    image: null,
  });

  const submit = () => {
    form.post(route('restaurants.store'));
};
  </script>

<template>
  <AuthenticatedLayout></AuthenticatedLayout>
  <div class="min-h-screen flex items-center justify-center bg-gray-100 mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
      <h1 class="text-2xl font-bold text-center mb-6">Crear Restaurante</h1>
      <form @submit.prevent="submit" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4 mt-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
            Nombre:
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" v-model="form.name" type="text" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="address">
            Dirección:
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address" v-model="form.address" type="text" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="latitude">
            Latitud:
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="latitude" v-model="form.latitude" type="number" min="-90" max="90" step="0.0000001" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="longitude">
            Longitud:
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="longitude" v-model="form.longitude" type="number" min="-180" max="180" step="0.0000001" required>
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
            Descripción:
          </label>
          <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" v-model="form.description"></textarea>
        </div>
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="image">
            Imagen:
          </label>
          <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="image" @change="event => form.image = event.target.files[0]" type="file" required>
        </div>
        <div class="flex items-center justify-between">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
            Crear Restaurante
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

  
  