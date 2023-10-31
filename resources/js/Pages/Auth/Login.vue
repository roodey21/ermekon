<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-teal-600">
            {{ status }}
        </div>

        <div class="flex mb-16 text-sm font-medium lg:hidden">
            <div class="text-gray-700">
                <h2 class="mb-1 text-xl font-medium text-teal-800 md:text-2xl">Welcome Back</h2>
                <!-- <p class="font-light">Welcome to Simple Workspace Management System</p> -->
                <p class="font=light">Sign in to your account to continue.</p>
            </div>
        </div>

        <form @submit.prevent="submit" class="w-full">
            <div>
                <InputLabel for="email" value="Email / Username" />

                <TextInput
                    id="email"
                    type="email"
                    class="block w-full mt-1 text-sm"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="block w-full mt-1 text-sm"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div> -->

            <div class="flex items-center justify-center mt-8">
                <!-- <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link> -->

                <PrimaryButton type="submit" class="!px-4 !py-3 uppercase shadow rounded-full" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Sign In
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
