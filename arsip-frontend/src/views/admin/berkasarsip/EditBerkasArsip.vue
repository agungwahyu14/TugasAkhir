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
                                Edit Berkas Arsip
                            </h3>
                        </div>
                    </div>
                </div>
                <hr class="md:min-w-full" />
                <div class="block w-full overflow-x-auto">
                    <!-- Form Inputs -->
                    <form @submit.prevent="updateBerkas" class="px-4 py-4">



                        <div class="grid md:grid-cols-2 md:gap-6">

                            <div class="mb-3 pt-0 mr-2">
                                <label for="no_berkas" class="text-sm font-semibold">No Berkas</label>
                                <input type="text" id="no_naskah" v-model="berkasArsip.no_berkas"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <div class="mb-3 pt-0">
                                <label for="nama_berkas" class="text-sm font-semibold">Nama Berkas</label>
                                <input type="text" id="nama_berkas" v-model="berkasArsip.nama_berkas"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="jml_item" class="text-sm font-semibold">Jumlah Item</label>
                                <input type="number" id="jml_item" v-model="berkasArsip.jml_item"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10" />
                            </div>
                            <div class="mb-3 pt-0">
                                <label for="retensi_waktu" class="text-sm font-semibold">Retensi Waktu</label>
                                <input type="date" id="retensi_waktu" v-model="berkasArsip.retensi_waktu"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                            <div class="mb-3 pt-0 mr-2">
                                <label for="perihal" class="text-sm font-semibold">Perihal</label>
                                <textarea type="text" id="perihal" v-model="berkasArsip.perihal"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                        </div>
                        <div class="mt-6">
                            <router-link to="/admin/berkas-arsip"
                                class="bg-red-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-red-800 mr-2">
                                Batal
                            </router-link>
                            <button type="submit"
                                class="bg-emerald-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-emerald-600">
                                Update Naskah
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";
import Swal from 'sweetalert2';

export default {
    name: "EditBerkasArsip",
    data() {
        return {
            berkasArsip: {
                nama_berkas: '',
                no_berkas: '',
                perihal: '',
                jml_item: '',
                retensi_waktu: '',
            }
        };
    },
    mounted() {
        const id = this.$route.params.id;
        this.fetchNaskah(id);
        console.log(id);
    },
    methods: {
        fetchNaskah(id) {
            const token = sessionStorage.getItem('token');
            axios
                .get(`http://127.0.0.1:8000/api/path-arsips/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}` // Tambahkan header Bearer Token
                    }
                })
                .then((response) => {
                    console.log("Fetch Naskah Response:", response); // Print seluruh response
                    console.log("Data Naskah:", response.data.data); // Print hanya data pegawai
                    this.berkasArsip = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching data:", error.response || error); // Print error detail
                });
        },
        updateBerkas() {
            const token = sessionStorage.getItem('token');
            const id = this.$route.params.id;

            axios
                .put(`http://127.0.0.1:8000/api/path-arsips/${id}`, this.berkasArsip, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    console.log("Naskah updated:", response.data);
                    Swal.fire({
                        title: 'Success',
                        text: 'Berhasil Update Data',
                        icon: 'success',
                    })
                    this.$router.push('/admin/berkas-arsip');
                })
                .catch((error) => {
                    console.error("Error updating naskah:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong while updating the naskah!",
                    });
                });
        }
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
