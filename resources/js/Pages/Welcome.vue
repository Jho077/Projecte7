<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Navbar from '@/Components/Navbar.vue';
import Search from '@/Components/Search.vue';
import CardRestaurant from '@/Components/CardRestaurant.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
const isLoggedIn = ref(false);

const checkAuthentication = () => {
    // Hacer una solicitud al servidor para verificar la autenticación del usuario
    fetch('/api/user/session', {
        method: 'GET',
        credentials: 'include'
    })
    .then(response => {
        if (response.ok) {
            isLoggedIn.value = true; // Usuario autenticado
        } else {
            isLoggedIn.value = false; // Usuario no autenticado
        }
    })
    .catch(error => {
        console.error('Error al verificar la autenticación:', error);
    });
};

// Llamar a la función para verificar la autenticación al cargar el componente
checkAuthentication();

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <div>
      <Head title="Welcome" />
      <!-- Renderizar Navbar solo si el usuario no está autenticado -->
      <template v-if="!isLoggedIn">
        <Navbar></Navbar>
      </template>
      <!-- Renderizar AuthenticatedLayout solo si el usuario está autenticado -->
      <template v-else>
        <AuthenticatedLayout></AuthenticatedLayout>
      </template>
      <!-- Contenido común que se mostrará en ambos casos -->
      <div class="bg-white min-h-screen">
        <div class="flex justify-center text-black text-5xl font-bold mt-20 ">
          <p>¡Vamos a comer! </p>
        </div>
        <div class="mt-4 mx-4 md:mx-0">
          <Search></Search>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 justify-items-center mt-8 mx-4 md:mx-0">
          <CardRestaurant></CardRestaurant>
          <CardRestaurant></CardRestaurant>
          <CardRestaurant></CardRestaurant>
          <CardRestaurant></CardRestaurant>
        </div>
      </div>
    </div>
  </template>
<style scoped>


</style>
