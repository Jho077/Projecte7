<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Navbar from '@/Components/Navbar.vue';
import Search from '@/Components/Search.vue';
import CardRestaurant from '@/Components/CardRestaurant.vue';

const props = defineProps({
    loged: Object,
    rating: Array,
    restaurant: Array,
});
</script>

<template>
    <div>
        <Head title="Welcome" />
        <AuthenticatedLayout v-if="props.loged"></AuthenticatedLayout>
        <Navbar v-else></Navbar>
        <div class="bg-white min-h-screen">
            <div class="flex justify-center text-black text-5xl font-bold mt-20 ">
                <p>¡Vamos a comer! </p>
            </div>
            <div class="mt-4 mx-4 md:mx-0">
                <Search></Search>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 justify-items-center mt-8 mx-4 md:mx-0">
                <CardRestaurant class="cardrestaurant" v-for="resto in props.restaurant" :key="resto.id" :restaurant="resto"></CardRestaurant>
            </div>
        </div>
    </div>
</template>

<style scoped>
@media (min-width: 768px) {
    .cardrestaurant {
        max-width: 30rem; /* Ajusta este valor según sea necesario */
        width: 100%; /* Para asegurarse de que ocupe el 100% del contenedor */
    }
}
</style>
