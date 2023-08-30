<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

defineProps({
    errors: Object
})

const form = useForm({
    name: '',
    start_date: '',
    end_date: '',
    client_name: '',
    status: '',
})
const tabActive = ref(1)

</script>

<template>
    <Head title="Buat Project Baru"/>

    <AuthenticatedLayout>
        <div class="flex flex-col md:flex-row border-y">
            <div class="h-screen overflow-auto md:border-r-2 basis-full md:basis-2/3">
                <div class="sticky top-0 px-4 py-3 bg-red-300">
                    <div class="flex flex-row items-center justify-between">
                        <div><Link :href="route('project.index')" class="font-semibold hover:underline">Proyek</Link> / Baru</div>
                    </div>
                </div>
                <div class="p-4">
                    <form @submit.prevent="form.post(route('project.store'))">
                        <div class="bg-white border">
                            <div class="flex flex-row justify-between px-4 py-2 border-b">
                                <div></div>
                                <div class="flex gap-2 glex-row">
                                    <SecondaryButton @click="router.get(route('project.index'))">
                                        Kembali
                                    </SecondaryButton>
                                    <PrimaryButton type="submit">
                                        Simpan
                                    </PrimaryButton>
                                </div>
                            </div>
                            <div class="py-6">
                                <div class="px-8 mb-4 md:mb-6">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                        Nama Proyek
                                    </label>
                                    <input type="text" v-model="form.name"
                                        class="border-x-0 border-t-0 border-gray-300 hover:border-gray-600 focus:border-gray-600 text-gray-900 text-3xl block w-full p-2.5 focus:ring-0"
                                        placeholder="Nama Proyek" required>
                                    <template v-if="errors.name">
                                        <span class="text-sm text-red-500">{{ errors.name }}</span>
                                    </template>
                                </div>
                                <div class="mb-4">
                                    <ul class="flex flex-row px-8 border-b">
                                        <li class="z-10 flex-nowrap -mr-[1px] cursor-pointer" @click="tabActive = 1">
                                            <div class="p-2 text-sm -mb-[1px] font-light border cursor-pointer whitespace-nowrap " :class="tabActive == 1 ? 'border-t-stone-800 border-b-white bg-white':'bg-gray-50'">
                                                General Information
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div v-if="tabActive === 1">
                                    <div class="grid grid-cols-1 gap-4 px-8 py-4 mb-4 md:mb-6 md:grid-cols-2">
                                        <div class="flex flex-row items-center gap-4">
                                            <label for="type_id" class="text-sm font-medium whitespace-nowrap">Nama Klien</label>
                                            <div class="w-full">
                                                <input type="text" v-model="form.client_name"
                                                    class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 disabled:bg-gray-100 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0">
                                                <template v-if="errors.client_name">
                                                    <span class="text-sm text-red-500">{{ errors.client_name }}</span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="flex flex-row items-center gap-4">
                                            <label for="type_id" class="text-sm font-medium whitespace-nowrap">No Telp</label>
                                            <div class="w-full">
                                                <input id="code" type="text" v-model="form.phone"
                                                    class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 disabled:bg-gray-100 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0">
                                                <template v-if="errors.client_name">
                                                    <span class="text-sm text-red-500">{{ errors.client_name }}</span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="flex flex-row items-center gap-4">
                                            <label for="start_date" class="text-sm font-medium whitespace-nowrap">Tanggal Mulai</label>
                                            <div class="w-full">
                                                <input id="start_date" type="date" v-model="form.start_date"
                                                        class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 disabled:bg-gray-100 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0">
                                                <template v-if="errors.start_date">
                                                    <span class="text-sm text-red-500">{{ errors.start_date }}</span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="flex flex-row items-center gap-4">
                                            <label for="end_date" class="text-sm font-medium whitespace-nowrap">Tanggal Selesai</label>
                                            <div class="w-full">
                                                <input id="end_date" type="date" v-model="form.end_date"
                                                        class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 disabled:bg-gray-100 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0">
                                                <template v-if="errors.end_date">
                                                    <span class="text-sm text-red-500">{{ errors.end_date }}</span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-4 col-span-full">
                                            <label for="description" class="text-sm font-medium text-left whitespace-nowrap">Deskripsi</label>
                                            <div class="w-full">
                                                <textarea id="description" v-model="form.description"
                                                    placeholder="Tulis deskripsi proyek atau catatan lainnya disini"
                                                    class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 disabled:bg-gray-100 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"></textarea>
                                                <template v-if="errors.description">
                                                    <span class="text-sm text-red-500">{{ errors.description }}</span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white basis-full md:basis-1/3">
                <div class="sticky px-4 py-3 bg-white basis-2/3 top-14">
                    <div class="flex flex-row items-center justify-between">
                        <PrimaryButton>
                            Kirim Pesan
                        </PrimaryButton>
                    </div>
                </div>
                <div>
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas ex porro blanditiis nulla id nobis est repellendus harum voluptatum ducimus aspernatur sequi nemo saepe nam, provident minima sunt pariatur dignissimos quisquam omnis accusantium? Quis, beatae! Expedita velit eius at possimus dignissimos ipsam dolor molestiae amet suscipit quo qui aliquam eaque, atque omnis facilis numquam id dolorem quaerat! Itaque excepturi modi nam at repudiandae commodi esse tenetur corporis necessitatibus atque. Ipsa, dolorum excepturi. Atque minus fuga pariatur hic praesentium nostrum recusandae distinctio expedita? Dicta sed eos reiciendis nulla repellat eum, officia porro est, quae labore nemo. Veritatis quia blanditiis sint dicta sequi, suscipit, earum nobis ipsam accusantium, necessitatibus expedita? Aperiam, iure magni? Distinctio, quae repellat. In error similique sunt sapiente sed voluptatibus aliquam earum vel, blanditiis corrupti dolores reprehenderit ducimus recusandae! Corporis excepturi nobis quod, delectus blanditiis voluptates, itaque nostrum aspernatur totam minima odit perspiciatis. Doloremque, sunt! Officiis quia fugiat vero! Tempora repudiandae excepturi libero hic ipsam adipisci, modi quibusdam explicabo placeat voluptates! Obcaecati cupiditate soluta, veniam esse reprehenderit rem! Odit, sapiente quia. Dolores ad eum neque unde molestias vitae necessitatibus et suscipit, ut quidem, dignissimos, consequuntur sequi. Dolore, ex quam voluptates corrupti eveniet consequuntur sit iste ipsam modi numquam cum. Assumenda commodi quos quam labore necessitatibus repellendus quibusdam, tempora in modi. Obcaecati, esse soluta quae totam at, iusto adipisci unde quo mollitia est laudantium perspiciatis facilis quia eveniet tempora accusantium assumenda quibusdam maxime vel tempore suscipit odit? Praesentium officiis itaque voluptates! Rerum inventore et commodi earum exercitationem perspiciatis ex quos mollitia dolore minima provident delectus placeat eveniet reprehenderit aliquid, nemo neque amet. Facilis corporis rem soluta voluptatem rerum, numquam eum iusto architecto aperiam, eveniet quod sunt voluptas? Itaque, nemo. Accusamus enim rerum voluptate maiores necessitatibus error maxime cumque labore, facere harum modi. Nobis dolores unde maxime? Praesentium, sequi fugit nesciunt doloribus harum debitis qui sit in reprehenderit dicta voluptate culpa voluptates similique ullam autem voluptas sunt! Ea quidem adipisci sit vero delectus, et eaque. Distinctio omnis nisi esse facere deserunt fuga sed earum nesciunt. Nihil optio mollitia reprehenderit officia doloribus nulla autem quas vel, ad sapiente accusantium exercitationem distinctio laboriosam necessitatibus. Debitis fuga nemo et incidunt, dolores a rem reprehenderit repellat adipisci minus ipsam facere iusto laboriosam at harum vero officia illum nobis. Enim, blanditiis aliquam facilis eum architecto quis esse ad facere, sint cumque aspernatur exercitationem non, hic corporis nobis. Pariatur optio inventore aut incidunt illo voluptate mollitia recusandae ducimus aperiam architecto minima aliquam numquam sapiente vero reprehenderit error at, debitis accusamus a necessitatibus laudantium tempora sunt voluptatem? Veniam ex quisquam enim, praesentium amet deleniti temporibus officiis velit, ipsam veritatis laborum eligendi modi asperiores quam deserunt eum? Quam repudiandae harum accusantium temporibus at dolorem distinctio accusamus, doloremque veniam quaerat consequuntur expedita. Illum quis, impedit possimus laudantium obcaecati laboriosam consequuntur, sint, corrupti facilis qui dolorum repellendus ex voluptas similique voluptate eos repudiandae modi cumque! Natus commodi exercitationem suscipit cumque obcaecati eum? Dolore dolorem, doloribus repellat itaque expedita ratione consequatur ad aspernatur ullam quod praesentium! Quibusdam dolore quam maiores corrupti, totam molestiae unde, enim nisi optio tempore, iusto molestias voluptate nobis fugit laudantium tenetur. Aliquam obcaecati blanditiis doloremque quod recusandae? Rerum tempore nulla delectus repudiandae temporibus sapiente deleniti eos mollitia molestiae vel. Excepturi est, id inventore quos similique illum beatae nam optio reprehenderit ab maiores placeat dolor magnam consequatur maxime ea! Consectetur assumenda dignissimos ex magni mollitia delectus soluta aliquid nobis, aut asperiores impedit quis necessitatibus, commodi aspernatur quam quaerat? Corrupti laboriosam possimus ullam, harum voluptates voluptatibus id repellat rem natus tenetur. Quas sed repellat quia repudiandae cum optio consequuntur asperiores commodi minima dolorem, exercitationem quod officiis earum harum ullam tenetur temporibus neque id enim ex, eum possimus? Excepturi quisquam perspiciatis facere minus quae illo molestias, porro sed eius quidem? Repellendus autem quasi nihil sapiente eveniet sit obcaecati nulla, vitae itaque! Doloribus, saepe? Temporibus ipsam officia dolore, et nam at voluptate. Natus exercitationem fuga inventore? Commodi quae reiciendis cumque? Culpa sed non doloremque ex quaerat. Tempora, natus sint? Voluptates dolores possimus ratione eum similique, hic consectetur neque iusto ab quas atque facilis aperiam et animi nobis culpa architecto accusantium blanditiis veritatis in! Blanditiis, natus. Velit, rerum? Facere in laboriosam ex inventore id obcaecati modi iste tempora, quos dolor quo a et, dicta deserunt. Iure soluta porro maiores quas saepe eos facilis aliquid, aut ut delectus! Quisquam rem minus veritatis voluptate suscipit molestiae libero nulla repellendus possimus, maxime culpa aut nobis excepturi adipisci esse nam doloribus ad odio! Repellendus possimus cum nam recusandae vel iure tempore minus odio esse, odit laudantium exercitationem aspernatur voluptate perspiciatis, suscipit expedita! Esse accusantium natus libero mollitia quam alias et ea consequuntur repellat, illo eum, excepturi iste dolorem dolorum debitis officiis iure blanditiis officia suscipit aperiam odio? Alias officia assumenda ratione autem repudiandae nihil mollitia quis, distinctio eaque error corporis reiciendis, in inventore numquam dignissimos, natus consequatur magnam quo doloribus recusandae. Dolore, nobis tenetur aliquid et rem provident, animi sequi blanditiis incidunt magni ullam laboriosam tempora, nostrum iure minus dignissimos assumenda fugit! Aperiam quas maiores placeat vel nobis perferendis voluptatem? Minima inventore eius, labore animi dolorem nobis, praesentium illo blanditiis, excepturi eveniet iure harum id ducimus? Ex ab accusantium temporibus porro aliquam! Corporis esse ipsam ducimus nesciunt inventore ipsum dignissimos repellat facilis fugit maiores reprehenderit, nihil, nulla eaque eligendi corrupti earum at molestias dolorem quae totam quidem optio. Maiores nostrum obcaecati molestias neque quisquam sit. Nam perferendis, ipsum nesciunt impedit cum tempore sit omnis veniam modi soluta magnam, nobis facilis dolorem molestias animi voluptas voluptatem ipsa et, architecto veritatis dignissimos iste praesentium eligendi. Dolor nam dolores enim explicabo. Illum temporibus, facilis quia quos ab alias cumque eum perspiciatis tempore corporis eius, nihil delectus. Modi quos provident repellat quisquam odit maxime quaerat dolore ipsa facilis inventore itaque tenetur, a doloribus, quae doloremque esse quia? Mollitia molestias ipsum totam sunt expedita illum inventore ipsa! Ut perspiciatis, quasi voluptatem reiciendis, quam possimus similique voluptas eligendi repellendus odio maiores nostrum adipisci tenetur praesentium perferendis eveniet repudiandae explicabo ex nulla tempora consectetur dignissimos voluptatum enim doloremque. Iusto est officiis enim maxime labore?
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
