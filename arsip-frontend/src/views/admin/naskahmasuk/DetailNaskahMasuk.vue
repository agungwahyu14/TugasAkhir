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
                                Kemabali
                            </router-link>
                        </div>
                    </div>
                </div>
                <hr class="md:min-w-full" />

                <div class="block w-full h-48 overflow-y-auto border border-gray-300">
                    <!-- Form Inputs -->


                    <div class="px-4 py-4">
                        <!-- Judul -->
                        <h5 class="text-lg font-semibold mb-4">Naskah Masuk Dari :</h5>

                        <!-- Gambar dan Nama -->
                        <a class="text-blueGray-500 block py-4" href="#pablo" ref="btnDropdownRef"
                            v-on:click="toggleDropdown($event)">
                            <div class="flex items-center mb-4">
                                <!-- Gambar -->
                                <span
                                    class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full mr-3">
                                    <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg"
                                        :src="image" />
                                </span>
                                <!-- Nama -->
                                <h3 class="text-base font-medium">Nama</h3>
                            </div>
                        </a>

                        <!-- Informasi Naskah -->

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="bg-blue-200  ">Nomor Refrensi</div>
                            <div class="bg-blue-300 ">Nomor Naskah</div>
                            <div class="bg-blue-400 ">Tanggal Naskah</div>
                            <div class="bg-blue-500 ">Hal</div>
                            <div class="bg-blue-600 ">Isi Ringkasan</div>
                        </div>



                        <div class="mb-4 pt-0 mr-2">

                            <select id="jenis_naskah" name="jenis_naskah"
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <option value="" class="text-sm font-semibold">Detail Naskah Dinas</option>

                            </select>
                        </div>

                        <div class="mb-4 pt-0 mr-2">

                            <select id="jenis_naskah" name="jenis_naskah"
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <option value="" class="text-sm font-semibold">Penerima</option>


                            </select>
                        </div>


                        <div class="mb-4 pt-0 mr-2">
                            <div
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <iframe src="NGROK.pdf" class="relative w-full rounded h-600-px"
                                    frameborder="0"></iframe>

                                <hr class="md:min-w-full mt-3" />


                                <h5 class="text-lg font-semibold m-3"> 0 Lampiran</h5>

                            </div>

                        </div>




                        <div class="mb-4 pt-0 mr-2 mt-4">

                            <select id="jenis_naskah" name="jenis_naskah"
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <option value="" class="text-sm font-semibold">Whatsapp</option>


                            </select>
                        </div>

                        <div class="mb-4 pt-0 mr-2">

                            <select id="jenis_naskah" name="jenis_naskah"
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <option value="" class="text-sm font-semibold">History Naskah</option>


                            </select>
                        </div>



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
            formData: {
                no_naskah: '',
                jenis_naskah: '',
                perihal: '',
                tujuan: '',
                tgl_naskah: '',
                status: '',
                file: '',
            }
        };
    },
    mounted() {
        const naskahID = this.$route.params.id_naskah_masuk;
        this.fetchNaskah(naskahID);
        console.log("apa ini");
        console.log(naskahID);
    },
    methods: {
        fetchNaskah(id_naskah_masuk) {
            const token = sessionStorage.getItem('token'); // Ambil token dari localStorage
            axios
                .get(`http://127.0.0.1:8000/api/naskah-masuks/${id_naskah_masuk}`, {
                    headers: {
                        Authorization: `Bearer ${token}` // Tambahkan header Bearer Token
                    }
                })
                .then((response) => {
                    console.log("Fetch Naskah Response:", response); // Print seluruh response
                    console.log("Data Naskah:", response.data.data); // Print hanya data pegawai
                    this.formData = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching data:", error.response || error); // Print error detail
                });
        },
        handleFileChange(event) {
            this.formData.file = event.target.files[0];
        },


    },
    props: {
        color: {
            default: "light",
            validator: function (value) {
                return ["light", "dark"].indexOf(value) !== -1;
            },
        },
    },
};
</script>
