<template>
    <div class="flex flex-wrap mt-4">
        <div class="w-full mb-12 px-4">

            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded"
                :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div
                            class="relative w-full px-4 max-w-full flex-grow flex-1 flex items-center justify-between mb-2">
                            <h3 class="font-semibold text-lg text-blueGray">
                                Detail Naskah Masuk
                            </h3>

                            <router-link to="/admin/naskahmasuk/naskah-masuk"
                                class="bg-red-500 text-white font-bold px-4 py-3 mr-2 rounded shadow hover:bg-blue-600">
                                Kembali
                            </router-link>
                        </div>
                    </div>
                </div>
                <hr class="md:min-w-full" />

                <div class="block w-full h-48 overflow-y-auto border border-gray-300">
                    <!-- Form Inputs -->

                    <div class="px-4 py-4">
                        <!-- Informasi Naskah -->

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="bg-blue-300 ">
                                <h3>Nomor Naskah</h3>
                                <p>{{ naskahMasuk.no_naskah }}</p>
                            </div>
                            <div class="bg-blue-400 ">
                                <h3>Tanggal Naskah</h3>
                                <p>{{ naskahMasuk.tgl_naskah }}</p>
                            </div>
                            <div class="bg-blue-500 mt-3 ">
                                <h3>Perihal</h3>
                                <p>{{ naskahMasuk.perihal }}</p>
                            </div>
                        </div>

                        <!-- Select Dropdowns -->

                        <div class="mb-4 pt-0 mr-2 mt-4">
                            <select id="jenis_naskah" name="jenis_naskah"
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <option value="" class="text-sm font-semibold">{{ naskahMasuk.jenis_naskah }}</option>
                            </select>
                        </div>

                        <div class="mb-4 pt-0 mr-2 mt-4">
                            <select id="tujuan" name="tujuan"
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <option value="" class="text-sm font-semibold">{{ naskahMasuk.tujuan }}</option>
                            </select>
                        </div>

                        <!-- Lampiran Section -->

                        <div class="mb-4 pt-0 mr-2">
                            <div
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <iframe :src="`http://127.0.0.1:8000/storage/${naskahMasuk.file}`"
                                    class="relative w-full rounded h-600-px" frameborder="0"></iframe>
                                <hr class="md:min-w-full mt-3" />

                            </div>
                        </div>

                        <div class="mb-4 pt-0 mr-2 mt-4" v-if="naskahMasuk.tujuan === 'kadis'">
                            <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                                class="text-white rounded bg-emerald-500 text-xs px-4 py-3 relative w-full pr-10">
                                <i class="fab fa-whatsapp text-sm"></i> Whatsapp
                            </button>
                        </div>

                        <!-- Pesan Default -->
                        <div v-else class="mb-4 pt-0 mr-2 mt-4">
                            <button class="text-white rounded bg-emerald-500 text-xs px-4 py-3 relative w-full pr-10"
                                @click="openAccept">
                                <i class="fa-solid fa-check"></i> Accept
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="authentication-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Sign in to our platform
                        </h3>
                        <button type="button"
                            class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" action="#">
                            <div>
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    email</label>
                                <input type="email" name="email" id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="name@company.com" required />
                            </div>
                            <div>
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                    password</label>
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    required />
                            </div>
                            <div class="flex justify-between">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="remember" type="checkbox" value=""
                                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                                            required />
                                    </div>
                                    <label for="remember"
                                        class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember
                                        me</label>
                                </div>
                                <a href="#" class="text-sm text-blue-700 hover:underline dark:text-blue-500">Lost
                                    Password?</a>
                            </div>
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login
                                to your account</button>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                Not registered? <a href="#"
                                    class="text-blue-700 hover:underline dark:text-blue-500">Create account</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
import axios from "axios";

export default {
    name: "EditNaskahMasuk",
    data() {
        return {
            naskahMasuk: {
                no_naskah: "",
                jenis_naskah: "",
                perihal: "",
                tujuan: "",
                tgl_naskah: "",
                status: "",
                file: "",
            },
        };
    },
    mounted() {
        const naskahID = this.$route.params.id_naskah_masuk;
        this.fetchNaskah(naskahID);
    },
    methods: {
        async fetchNaskah(id_naskah_masuk) {
            try {
                const token = sessionStorage.getItem("token");
                const response = await axios.get(
                    `http://127.0.0.1:8000/api/naskah-masuks/${id_naskah_masuk}`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                console.log("Fetch Detail Naskah Masuk Response:", response); // Print seluruh response
                console.log("Data Detail Naskah Masuk:", response.data.data); // 
                this.naskahMasuk = response.data.data;
            } catch (error) {
                console.error("Error fetching data:", error.response || error);
            }
        },


        async openWhatsApp() {
            try {
                const token = sessionStorage.getItem("token");
                const response = await axios.post(
                    `http://127.0.0.1:8000/api/naskah-masuks/sendWA`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                console.log("Fetch Detail Naskah Masuk Response:", response); // Print seluruh response
                console.log("Data Detail Naskah Masuk:", response.data.data); // 
                this.naskahMasuk = response.data.data;
            } catch (error) {
                console.error("Error fetching data:", error.response || error);
            }
        },


        async openAccept() {
            try {
                const token = sessionStorage.getItem("token");
                const naskahID = this.$route.params.id_naskah_masuk;
                const response = await axios.post(
                    'http://127.0.0.1:8000/api/naskah-masuks/accepet',
                    { id_naskah_masuk: naskahID }, // Pass the naskahID as part of the data payload
                    {
                        headers: {
                            Authorization: `Bearer ${token}`, // Corrected template literal for Bearer token
                        },
                    }
                );
                console.log("Fetch Detail Naskah Masuk Response:", response); // Print the whole response
                console.log("Data Detail Naskah Masuk:", response.data.data); // Log the specific data
                this.naskahMasuk = response.data.data;
                this.$router.push('/admin/naskahmasuk/naskah-masuk');
            } catch (error) {
                console.error("Error fetching data:", error.response || error);
            }
        }

    },
    props: {
        color: {
            default: "light",
            validator(value) {
                return ["light", "dark"].includes(value);
            },
        },
    },
};
</script>
