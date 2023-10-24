<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { BanknotesIcon, CheckBadgeIcon, UserGroupIcon, WalletIcon } from '@heroicons/vue/24/outline';
import { Head } from '@inertiajs/vue3';

defineOptions({
    layout: AuthenticatedLayout,
})
</script>

<template>
    <Head title="Dashboard" />

    <div class="px-4 py-6">
        <div class="py-4">
            <h3 class="text-xl font-semibold capitalize">Dashboard</h3>
        </div>
        <div class="grid grid-cols-4 gap-4">
            <div class="flex justify-between p-4 bg-white border rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex items-center justify-center p-3 bg-teal-500 rounded-xl">
                        <WalletIcon class="w-5 h-5 text-white" />
                    </div>
                    <div class="ml-4">
                        <div class="text-[10px] font-medium text-gray-500">Total</div>
                        <div class="text-sm font-semibold text-gray-900">Project</div>
                    </div>
                </div>
                <div class="flex flex-col self-center text-right">
                    <div class="text-lg font-semibold text-gray-900">16</div>
                    <div class="text-[10px] font-medium text-gray-500"><span class="text-teal-500">18%</span> completed</div>
                </div>
            </div>
            <div class="flex justify-between p-4 bg-white border rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex items-center justify-center p-3 rounded-xl bg-sky-500">
                        <CheckBadgeIcon class="w-5 h-5 text-white" />
                    </div>
                    <div class="ml-4">
                        <div class="text-[10px] font-medium text-gray-500">Total</div>
                        <div class="text-sm font-semibold text-gray-900">Tasks</div>
                    </div>
                </div>
                <div class="flex flex-col self-center text-right">
                    <div class="text-lg font-semibold text-gray-900">40</div>
                    <div class="text-[10px] font-medium text-gray-500"><span class="text-teal-500">12%</span> completed</div>
                </div>
            </div>
            <div class="flex justify-between p-4 bg-white border rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex items-center justify-center p-3 bg-rose-500 rounded-xl">
                        <BanknotesIcon class="w-5 h-5 text-white" />
                    </div>
                    <div class="ml-4">
                        <div class="text-[10px] font-medium text-gray-500">Total</div>
                        <div class="text-sm font-semibold text-gray-900">Expense</div>
                    </div>
                </div>
                <div class="flex flex-col self-center text-right">
                    <div class="text-lg font-semibold text-gray-900">16</div>
                    <div class="text-[10px] font-medium text-gray-500"></div>
                </div>
            </div>
            <div class="flex justify-between p-4 bg-white border rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="flex items-center justify-center p-3 bg-amber-500 rounded-xl">
                        <UserGroupIcon class="w-5 h-5 text-white" />
                    </div>
                    <div class="ml-4">
                        <div class="text-[10px] font-medium text-gray-500">Total</div>
                        <div class="text-sm font-semibold text-gray-900">Customers</div>
                    </div>
                </div>
                <div class="flex flex-col self-center text-right">
                    <div class="text-lg font-semibold text-gray-900">9</div>
                    <div class="text-[10px] font-medium text-gray-500"></div>
                </div>
            </div>
            <div class="bg-white border rounded-lg shadow-sm">
                <div class="py-4 border-b">
                    <div class="px-4 border-l-2 border-teal-600">
                        <h5 class="text-base font-medium">Project Status</h5>
                    </div>
                </div>
                <div class="px-4 py-6">
                    <div class="grid grid-cols-2 p-4 gap-x-6 gap-y-8">
                        <div>
                            <span class="block text-xs font-light text-gray-600">In Progress</span>
                            <div class="text-xl font-semibold text-sky-500">
                                30%
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded relative overflow-hidden shadow">
                                <div class="absolute inset-y-0 bg-sky-500" style="width: 30%;"></div>
                            </div>
                        </div>
                        <div>
                            <span class="block text-xs font-light text-gray-600">On Hold</span>
                            <div class="text-xl font-semibold text-amber-500">
                                5%
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded relative overflow-hidden shadow">
                                <div class="absolute inset-y-0 w-4 bg-amber-500" style="width: 5%;"></div>
                            </div>
                        </div>
                        <div>
                            <span class="block text-xs font-light text-gray-600">Complete</span>
                            <div class="text-xl font-semibold text-teal-500">
                                3%
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded relative overflow-hidden shadow">
                                <div class="absolute inset-y-0 w-2 bg-teal-500" style="width: 3%;"></div>
                            </div>
                        </div>
                        <div>
                            <span class="block text-xs font-light text-gray-600">Canceled</span>
                            <div class="text-xl font-semibold text-rose-500">
                                3%
                            </div>
                            <div class="w-full h-1.5 bg-gray-200 rounded relative overflow-hidden shadow">
                                <div class="absolute inset-y-0 w-2 bg-rose-500" style="width: 3%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-2 overflow-hidden bg-white border rounded-lg shadow-sm">
                <div class="py-4 border-b">
                    <div class="px-4 border-l-2 border-teal-600">
                        <h5 class="text-base font-medium">Proyek Tenggat Waktu Terdekat</h5>
                    </div>
                </div>
                <div class="">
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-900 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-semibold">
                                        Nama Proyek
                                    </th>
                                    <th scope="col" class="px-6 py-3 font-semibold">
                                        Tenggat Waktu
                                    </th>
                                    <th scope="col" class="px-6 py-3 font-semibold">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Proyek A
                                    </th>
                                    <td class="px-6 py-4">
                                        21 Nov 2023
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-4 py-1.5 text-xs font-medium text-white bg-teal-400 rounded-lg">
                                            In Progress
                                        </span>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Proyek B
                                    </th>
                                    <td class="px-6 py-4">
                                        24 Nov 2023
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-4 py-1.5 text-xs font-medium text-white bg-teal-400 rounded-lg">
                                            In Progress
                                        </span>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        Proyek C
                                    </th>
                                    <td class="px-6 py-4">
                                        25 Des 2023
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-4 py-1.5 text-xs font-medium text-white bg-amber-400 rounded-lg">
                                            On Hold
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">You're logged in!</div>
        </div> -->
    </div></template>
