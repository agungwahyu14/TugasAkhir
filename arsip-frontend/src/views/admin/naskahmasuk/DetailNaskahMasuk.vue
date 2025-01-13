<template>
    <div class="flex flex-wrap mt-4">
        <div class="w-full mb-12 px-4">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded"
                :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-lg"
                                :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
                                Detail Naskah Masuk
                            </h3>
                        </div>
                    </div>
                </div>
                <hr class="md:min-w-full" />
                <div class="block w-full overflow-x-auto">
                    <!-- Form Inputs -->
                    <form @submit.prevent="updateNaskah" class="px-4 py-4">

                        <div class="grid md:grid-cols-2 md:gap-6">

                            <div class="mb-3 pt-0 mr-2">
                                <label for="jenis_naskah" class="text-sm font-semibold">No Naskah</label>
                                <input type="text" id="jenis_naskah" v-model="formData.no_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required maxlength="255" />
                            </div>

                            <div class="mb-3 pt-0">
                                <label for="jenis_naskah" class="text-sm font-semibold">Jenis Naskah</label>
                                <input type="text" id="jenis_naskah" v-model="formData.jenis_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required maxlength="255" />
                            </div>



                            <div class="mb-3 pt-0 mr-2">
                                <label for="tujuan" class="text-sm font-semibold">Tujuan</label>
                                <input type="text" id="tujuan" v-model="formData.tujuan"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required maxlength="255" />
                            </div>


                            <div class="mb-3 pt-0">
                                <label for="tgl_naskah" class="text-sm font-semibold">Tanggal Naskah</label>
                                <input type="date" id="tgl_naskah" v-model="formData.tgl_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="status" class="text-sm font-semibold">Status</label>
                                <input type="text" id="status" v-model="formData.status"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <div class="mb-3 pt-0">
                                <label for="status" class="text-sm font-semibold">File</label>
                                <input type="text" id="file" v-model="formData.file" name="file"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10" />
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="perihal" class="text-sm font-semibold">Perihal</label>
                                <textarea type="text" id="perihal" v-model="formData.perihal"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required maxlength="255" />
                            </div>

                        </div>
                        <div class="mt-6">
                            <router-link to="/admin/naskahmasuk/naskah-masuk"
                                class="bg-red-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-red-800 mr-2">
                                Kembali
                            </router-link>
                        </div>


                    </form>
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
