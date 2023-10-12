<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavDropdown from '@/Components/NavDropdown.vue';
import { Link } from '@inertiajs/vue3';
import ProjectSidebar from '@/Layouts/Project/ProjectSidebar.vue';
import { Cog6ToothIcon, CreditCardIcon, BuildingOffice2Icon, ShoppingCartIcon, ClipboardDocumentListIcon, ArchiveBoxIcon } from '@heroicons/vue/24/outline';

const open = ref(false);
const showingNavigationDropdown = ref(false);

const activeMenu = ref(null)

const onMenuHovered = (menu) => {
    activeMenu.value = menu
}
</script>

<template>
    <div>
        <div class="relative flex min-h-screen bg-white">
            <!-- sidebar -->
            <nav class="z-40 flex flex-col gap-24 py-5 bg-white border-r border-gray-300 shadow-lg">
                <ApplicationLogo class="w-10 h-10 mx-auto fill-gray-500"/>
                <div class="flex flex-col divide-y divide-gray-300 navbar-group">
                    <div ref="setting_menu"
                        @mouseover="onMenuHovered('master')"
                        class="relative flex items-center justify-center text-center bg-white hover:cursor-pointer hover:bg-gray-100 group w-14 h-14"
                        :class="{ '!bg-gray-100':activeMenu == 'master' || route().current('product*') || route().current('unit*') }"
                        >
                        <Cog6ToothIcon class="w-6 h-6 text-gray-600 group-hover:text-teal-700" :class="{'text-teal-700':activeMenu == 'master' || route().current('product*')|| route().current('unit*')}" />
                        <div
                            class="absolute invisible group-hover:visible bottom-0 border-t-0 border-r-0 border-l-[15px] border-b-[15px] border-r-transparent border-l-transparent border-t-transparent border-b-teal-700 right-0"
                            :class="{ '!visible':activeMenu == 'master' || route().current('product*') || route().current('unit*') }"
                            ></div>
                    </div>
                    <div ref="payment_menu"
                        @mouseover="onMenuHovered('payment')"
                        class="relative flex items-center justify-center text-center bg-white hover:cursor-pointer hover:bg-gray-100 w-14 h-14 group"
                        >
                        <CreditCardIcon class="w-6 h-6 text-gray-600 group-hover:text-teal-700" />
                        <div class="absolute invisible group-hover:visible bottom-0 border-t-0 border-r-0 border-l-[15px] border-b-[15px] border-r-transparent border-l-transparent border-t-transparent border-b-teal-700 right-0"></div>
                    </div>
                    <div ref="absensi_menu"
                        @mouseover="onMenuHovered('absensi')"
                        class="relative flex items-center justify-center text-center bg-white hover:cursor-pointer hover:bg-gray-100 w-14 h-14 group"
                        >
                        <svg class="w-5 h-5 fill-gray-500 group-hover:fill-teal-700" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.09755 22.4313H3.7767C1.38047 22.4313 0 21.1332 0 18.8798V4.55149C0 2.29815 1.38047 1 3.7767 1H9.37658C11.7728 1 13.1532 2.29815 13.1532 4.55149V6.81706C13.1532 7.31917 12.7105 7.73555 12.1765 7.73555C11.6426 7.73555 11.1998 7.31917 11.1998 6.81706V4.55149C11.1998 3.30236 10.7049 2.83697 9.37658 2.83697H3.7767C2.44835 2.83697 1.95345 3.30236 1.95345 4.55149V18.8798C1.95345 20.129 2.44835 20.5943 3.7767 20.5943H7.09755C7.6315 20.5943 8.07428 21.0107 8.07428 21.5128C8.07428 22.0149 7.6315 22.4313 7.09755 22.4313Z"/>
                            <path d="M17.8548 27.33H10.2494C7.63174 27.33 6.12109 25.9094 6.12109 23.4478V9.78078C6.12109 7.31925 7.63174 5.89868 10.2494 5.89868H17.8548C20.4725 5.89868 21.9701 7.31925 21.9701 9.78078V23.4478C21.9701 25.9094 20.4725 27.33 17.8548 27.33ZM10.2494 7.73565C8.6866 7.73565 8.07455 8.31121 8.07455 9.78078V23.4478C8.07455 24.9174 8.6866 25.493 10.2494 25.493H17.8548C19.4046 25.493 20.0166 24.9174 20.0166 23.4478V9.78078C20.0166 8.31121 19.4046 7.73565 17.8548 7.73565H10.2494Z"/>
                            <path d="M24.2231 22.4313H20.9935C20.4596 22.4313 20.0168 22.0149 20.0168 21.5128C20.0168 21.0107 20.4596 20.5943 20.9935 20.5943H24.2231C25.5515 20.5943 26.0465 20.129 26.0465 18.8798V4.55149C26.0465 3.30236 25.5515 2.83697 24.2231 2.83697H18.6234C17.295 2.83697 16.8001 3.30236 16.8001 4.55149V6.81706C16.8001 7.31917 16.3573 7.73555 15.8234 7.73555C15.2895 7.73555 14.8467 7.31917 14.8467 6.81706V4.55149C14.8467 2.29815 16.2271 1 18.6234 1H24.2231C26.6194 1 27.9999 2.29815 27.9999 4.55149V18.8798C27.9999 21.1332 26.6194 22.4313 24.2231 22.4313Z"/>
                            <path d="M16.6044 13.8587H11.3952C10.8612 13.8587 10.4185 13.4423 10.4185 12.9402C10.4185 12.4381 10.8612 12.0217 11.3952 12.0217H16.6044C17.1383 12.0217 17.5811 12.4381 17.5811 12.9402C17.5811 13.4423 17.1383 13.8587 16.6044 13.8587Z"/>
                            <path d="M16.6044 17.5328H11.3952C10.8612 17.5328 10.4185 17.1164 10.4185 16.6143C10.4185 16.1122 10.8612 15.6958 11.3952 15.6958H16.6044C17.1383 15.6958 17.5811 16.1122 17.5811 16.6143C17.5811 17.1164 17.1383 17.5328 16.6044 17.5328Z"/>
                            <path d="M13.9997 27.33C13.4657 27.33 13.0229 26.9136 13.0229 26.4115V22.7376C13.0229 22.2355 13.4657 21.8191 13.9997 21.8191C14.5336 21.8191 14.9764 22.2355 14.9764 22.7376V26.4115C14.9764 26.9136 14.5336 27.33 13.9997 27.33Z"/>
                        </svg>
                    </div>
                    <div
                        @mouseover="onMenuHovered('project')"
                        class="relative flex items-center justify-center text-center bg-white hover:cursor-pointer hover:bg-gray-100 w-14 h-14 group"
                        >
                        <BuildingOffice2Icon class="w-6 h-6 text-gray-600 group-hovertext-teal-700" :class="{'text-teal-700':activeMenu == 'project' || route().current('project*')}" />
                        <div
                        class="absolute invisible bottom-0 border-t-0 border-r-0 border-l-[15px] border-b-[15px] border-r-transparent border-l-transparent border-t-transparent border-b-teal-700 right-0"
                        :class="{ '!visible':activeMenu == 'project' || route().current('project*') }"
                        ></div>
                    </div>
                    <div ref="employee_menu"
                        class="relative flex items-center justify-center text-center bg-white hover:cursor-pointer hover:bg-gray-100 w-14 h-14 group"
                        >
                        <svg class="w-6 h-6 text-gray-600 group-hover:text-teal-700" viewBox="0 0 12 12" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.68878 2.85292L8.66253 2.8325C8.61207 2.44925 8.42861 2.04996 8.14219 1.71338C7.67698 1.1665 6.91865 0.75 5.90365 0.75C4.90323 0.75 4.19828 1.20617 3.78236 1.77171C3.58835 2.03333 3.44971 2.33175 3.3749 2.64875C3.36128 2.70811 3.35038 2.76806 3.34223 2.82842L3.31073 2.85262C2.9829 3.10667 2.74228 3.41467 2.79944 3.76787C2.85428 4.10912 3.16286 4.31679 3.44986 4.44367C3.52278 4.47604 3.60153 4.50637 3.68523 4.53467C3.64306 4.86346 3.67143 5.19746 3.76845 5.51442C3.86547 5.83139 4.02891 6.12405 4.24789 6.3729C4.46686 6.62176 4.73635 6.8211 5.0384 6.95766C5.34045 7.09421 5.66813 7.16484 5.99961 7.16484C6.33109 7.16484 6.65877 7.09421 6.96082 6.95766C7.26287 6.8211 7.53235 6.62176 7.75133 6.3729C7.97031 6.12405 8.13375 5.83139 8.23077 5.51442C8.32779 5.19746 8.35615 4.86346 8.31398 4.53467C8.39769 4.50637 8.47644 4.47633 8.54936 4.44367C8.83636 4.31679 9.14465 4.10912 9.19978 3.76787C9.25694 3.41467 9.01632 3.10667 8.68848 2.85262L8.68878 2.85292ZM3.94219 3.27933C3.90428 3.17025 3.89436 2.99496 3.94365 2.77825C3.99207 2.56679 4.0924 2.33492 4.2499 2.12025V2.9375C4.2499 3.01485 4.28063 3.08904 4.33533 3.14374C4.39003 3.19844 4.46421 3.22917 4.54157 3.22917C4.61892 3.22917 4.69311 3.19844 4.74781 3.14374C4.80251 3.08904 4.83323 3.01485 4.83323 2.9375V1.59875C5.07328 1.46225 5.36348 1.36687 5.70823 1.34062V2.35417C5.70823 2.43152 5.73896 2.50571 5.79366 2.56041C5.84836 2.6151 5.92255 2.64583 5.9999 2.64583C6.07726 2.64583 6.15144 2.6151 6.20614 2.56041C6.26084 2.50571 6.29157 2.43152 6.29157 2.35417V1.35871C6.59956 1.39753 6.89688 1.49664 7.16657 1.65037V2.9375C7.16657 3.01485 7.1973 3.08904 7.25199 3.14374C7.30669 3.19844 7.38088 3.22917 7.45823 3.22917C7.53559 3.22917 7.60978 3.19844 7.66447 3.14374C7.71917 3.08904 7.7499 3.01485 7.7499 2.9375V2.15525C8.07219 2.56825 8.14773 3.01392 8.05703 3.28137C8.03455 3.34757 8.03661 3.41964 8.06281 3.48445C8.08901 3.54926 8.13762 3.6025 8.19978 3.63448C8.26194 3.66646 8.33352 3.67506 8.40148 3.65869C8.46945 3.64233 8.52927 3.6021 8.57007 3.54533C8.62753 3.62554 8.62548 3.66812 8.62432 3.67483C8.62053 3.69817 8.5759 3.79442 8.31369 3.9105C8.19994 3.96067 8.06461 4.00587 7.91265 4.04583L7.90565 4.04758C7.74086 4.09017 7.5574 4.12633 7.36111 4.15608C6.99706 4.20858 6.63014 4.23877 6.2624 4.2465C6.00961 4.25282 5.75667 4.25009 5.50407 4.23833C5.21353 4.22533 4.92382 4.19768 4.63607 4.1555C4.45367 4.12901 4.27278 4.09299 4.09415 4.04758L4.08715 4.04583C3.95011 4.01137 3.81601 3.96612 3.68611 3.9105C3.4239 3.79442 3.37928 3.69817 3.37548 3.67483C3.37432 3.66812 3.37228 3.62554 3.42973 3.54533C3.4706 3.60236 3.53064 3.64275 3.59887 3.65909C3.66709 3.67543 3.73892 3.66664 3.80119 3.63432C3.86345 3.602 3.91199 3.54832 3.93788 3.48312C3.96378 3.41792 3.96531 3.34557 3.94219 3.27933ZM4.25632 4.68196C4.35315 4.70092 4.45348 4.71813 4.55615 4.73358C4.86765 4.78025 5.20307 4.81 5.54432 4.824C5.84849 4.8365 6.15306 4.8365 6.45723 4.824C6.79673 4.81 7.13098 4.78025 7.44103 4.73358C7.54225 4.71885 7.6431 4.70163 7.74348 4.68196C7.76423 4.9235 7.73455 5.16672 7.65635 5.3962C7.57815 5.62567 7.45312 5.83639 7.28919 6.015C7.12526 6.19361 6.92601 6.33621 6.70406 6.43376C6.48212 6.53131 6.24233 6.58168 5.9999 6.58168C5.75747 6.58168 5.51768 6.53131 5.29574 6.43376C5.0738 6.33621 4.87454 6.19361 4.71062 6.015C4.54669 5.83639 4.42166 5.62567 4.34345 5.3962C4.26525 5.16672 4.23558 4.9235 4.25632 4.68196Z" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.45833 7.30957C7.65025 7.34311 7.84567 7.3822 8.04167 7.42682C9.62921 7.78936 11.25 8.51415 11.25 9.49999V11.25H0.75V9.49999C0.75 8.51415 2.37079 7.78936 3.95833 7.42682C4.15174 7.38275 4.34625 7.34365 4.54167 7.30957V8.62499H7.45833V7.30957ZM3.375 8.18457C3.56575 8.12624 3.76146 8.07345 3.95833 8.0259V9.20832H8.04167V8.0262C8.33712 8.09689 8.62911 8.18137 8.91667 8.27936V10.6667H9.5V8.50745C9.58458 8.54507 9.66625 8.58386 9.74442 8.62382C10.076 8.7924 10.3219 8.96624 10.4777 9.13249C10.6308 9.29582 10.6667 9.41628 10.6667 9.49999V10.6667H1.33333V9.49999C1.33333 9.41628 1.36921 9.29582 1.52233 9.13249C1.67808 8.96624 1.92396 8.7924 2.25558 8.62382C2.42154 8.53924 2.6015 8.4599 2.79167 8.38611V10.6667H3.375V8.18457Z" />
                        </svg>
                        <div class="absolute invisible group-hover:visible bottom-0 border-t-0 border-r-0 border-l-[15px] border-b-[15px] border-r-transparent border-l-transparent border-t-transparent border-b-teal-700 right-0"></div>
                    </div>
                    <div ref="shopping_menu"
                        @mouseover="onMenuHovered('purchase')"
                        class="relative flex items-center justify-center text-center bg-white hover:cursor-pointer hover:bg-gray-100 w-14 h-14 group">
                        <ShoppingCartIcon class="w-6 h-6 text-gray-600 group-hover:text-teal-700" />
                        <div class="absolute invisible group-hover:visible bottom-0 border-t-0 border-r-0 border-l-[15px] border-b-[15px] border-r-transparent border-l-transparent border-t-transparent border-b-teal-700 right-0"></div>
                    </div>
                    <div ref="report_menu"
                        class="relative flex items-center justify-center text-center bg-white hover:cursor-pointer hover:bg-gray-100 w-14 h-14 group">
                        <ClipboardDocumentListIcon class="w-6 h-6 text-gray-600 group-hover:text-teal-700" />
                        <div class="absolute invisible group-hover:visible bottom-0 border-t-0 border-r-0 border-l-[15px] border-b-[15px] border-r-transparent border-l-transparent border-t-transparent border-b-teal-700 right-0"></div>
                    </div>
                    <div ref="warehouse_menu"
                        @mouseover="onMenuHovered('warehouse')"
                        class="relative flex items-center justify-center text-center bg-white hover:cursor-pointer hover:bg-gray-100 w-14 h-14 group">
                        <ArchiveBoxIcon class="w-6 h-6 text-gray-600 group-hover:text-teal-700" />
                        <div class="absolute invisible group-hover:visible bottom-0 border-t-0 border-r-0 border-l-[15px] border-b-[15px] border-r-transparent border-l-transparent border-t-transparent border-b-teal-700 right-0"></div>
                    </div>
                </div>
            </nav>
            <Transition
                enter-active-class="duration-500 ease-out"
                enter-from-class="bg-opacity-0"
                enter-to-class="bg-opacity-100"
                leave-active-class="duration-700 ease-in delay-200"
                leave-from-class="bg-opacity-100"
                leave-to-class="bg-opacity-0"
                >
                <div class="fixed z-30 w-full bg-gray-400/20 left-14" @click="activeMenu=null" v-show="activeMenu">
                    <Transition
                        enter-active-class="duration-700 ease-out"
                        enter-from-class="-translate-x-full"
                        enter-to-class=""
                        leave-active-class="duration-700 ease-in delay-200"
                        leave-from-class=""
                        leave-to-class="-translate-x-full"
                        >
                        <div class="w-56 min-h-screen py-5 bg-white shadow-lg" v-show="activeMenu">
                            <ul class="sidebar-setting" v-if="activeMenu=='master'">
                                <h3 class="px-6 py-4 text-lg">Master Data</h3>
                                <li class="text-black">
                                    <Link :href="route('product.index')" class="block px-6 py-3 text-xs transition-all hover:cursor-pointer hover:bg-gray-200" :class="{ 'text-teal-700' : route().current('product.index') }">
                                        Data Produk
                                    </Link>
                                </li>
                                <li class="text-black">
                                    <Link :href="route('unit.index')" class="block px-6 py-3 text-xs transition-all hover:cursor-pointer hover:bg-gray-200" :class="{ 'text-teal-700' : route().current('unit.index') }">
                                        Data Satuan
                                    </Link>
                                </li>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        Data User
                                    </div>
                                </li>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        Data Permission dan Role User
                                    </div>
                                </li>
                            </ul>
                            <ul class="sidebar-payment" v-if="activeMenu=='payment'">
                                <h3 class="px-6 py-4 text-lg">Penjualan</h3>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        Penjualan
                                    </div>
                                </li>
                            </ul>
                            <ul class="sidebar-payment" v-if="activeMenu=='absensi'">
                                <h3 class="px-6 py-4 text-lg">Absensi</h3>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        Absensi Karyawan
                                    </div>
                                </li>
                            </ul>
                            <ul class="sidebar-payment" v-if="activeMenu=='project'">
                                <h3 class="px-6 py-4 text-lg">Proyek</h3>
                                <li class="text-black">
                                    <Link :href="route('project.index')" :class="{ 'text-teal-700' : route().current('project.index') }" class="block px-6 py-3 text-xs transition-all hover:cursor-pointer hover:bg-gray-200">
                                        List Proyek
                                    </Link>
                                </li>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        BoQ Proyek
                                    </div>
                                </li>
                                <hr class="my-1">
                                <h4 class="px-6 py-4 text-sm">Alat Bantu Hitung</h4>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        Koefiensi Pekerjaan
                                    </div>
                                </li>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        Head Pompa
                                    </div>
                                </li>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        BTUH AC
                                    </div>
                                </li>
                            </ul>
                            <ul class="sidebar-payment" v-if="activeMenu=='purchase'">
                                <h3 class="px-6 py-4 text-lg">Pembelian</h3>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        Pembelian
                                    </div>
                                </li>
                            </ul>
                            <ul class="sidebar-payment" v-if="activeMenu=='warehouse'">
                                <h3 class="px-6 py-4 text-lg">Logistik / Gudang</h3>
                                <li class="text-black">
                                    <div class="px-6 py-3 text-xs hover:cursor-pointer hover:bg-gray-200">
                                        Daftar Gudang
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </Transition>
                </div>
            </Transition>
            <!-- second sidebar -->
            <!-- <slot name="sidebar" /> -->
            <!-- <template v-if="route().current('project*')">
                <ProjectSidebar/>
            </template> -->

            <div class="flex flex-col w-full bg-gray-50">
                <!-- navbar -->
                <nav class="flex justify-end bg-white border-b border-gray-300 shadow-sm h-14">
                    <NavDropdown/>
                </nav>
                <!-- <div class="w-full bg-teal-600 h-14"></div> -->
                <!-- content -->
                <div class="overflow-y-scroll" style="height: calc(100vh - 3.5rem);">
                    <slot/>
                </div>
            </div>
        </div>
    </div>
</template>
