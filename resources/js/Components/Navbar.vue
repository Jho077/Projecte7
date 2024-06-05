<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

</script>


<template>
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="/images/Logo2.png" class="h-10 w-auto" alt="Logo">
        <span class="self-center text-2xl font-semibold whitespace-nowrap">Pop</span>
    </a>
    <div class="flex md:order-2 space-x-2 rtl:space-x-reverse">
    <a href="/login" class="text-white bg-black font-bold rounded-xl text-sm px-4 py-2 text-center">Iniciar Sessión</a>
    <a href="/register" class="text-white bg-black font-bold rounded-xl text-sm px-4 py-2 text-center">Registrate</a>
    <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
      <span class="sr-only">Open main menu</span>
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
      </svg>
  </button>
</div>
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1 ml-32" id="navbar-sticky">
      <ul
                            class="flex flex-col p-4 md:p-0 mt-4 font-medium border rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0    dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                            <Link :href="route('welcome')" class="block py-2 px-3 font-bold text-black rounded md:p-0">
                            Inicio
                            </Link>
                            <Link :href="route('misRestaurantes')" class="block py-2 px-3 font-bold text-black rounded md:p-0">
                            Mis Restaurantes
                            </Link>
                            <li>
                                <Link :href="route('restaurants.create')"
                                    class="block py-2 px-3 font-bold text-black rounded md:p-0">
                                Crear Restaurant
                                </Link>
                            </li>
                        </ul>
    </div>
    </div>
  </nav>
</template>

