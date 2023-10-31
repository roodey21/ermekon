<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0">
        <div class="container flex w-full max-w-6xl gap-4 my-auto h-[571px]">
            <div class="items-end hidden p-16 text-white bg-right bg-no-repeat bg-cover rounded-lg shadow-lg lg:w-2/3 lg:flex brightness-90 grow bg-login-hd">
                <div class="ml-auto text-right">
                    <h2 class="mb-2 text-3xl font-medium">Welcome Back</h2>
                    <p>Welcome to Simple Workspace Management System</p>
                    <p>Sign in to your account to continue.</p>
                </div>
            </div>
            <div class="flex items-center w-full h-full max-w-md px-12 mx-auto bg-white rounded-lg shadow-lg lg:w-1/3">

                <div
                    class="w-full mt-6"
                >
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
