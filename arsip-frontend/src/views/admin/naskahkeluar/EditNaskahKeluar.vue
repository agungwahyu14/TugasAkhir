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
                                Edit Naskah Keluar
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
                                <label for="jenis_naskah" class="text-sm font-semibold">Jenis Naskah</label>
                                <select id="jenis_naskah" v-model="formData.jenis_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                    <option value="Instruksi Bupati">Instruksi Bupati</option>
                                    <option value="Surat Edaran">Surat Edaran</option>
                                    <option value="Surat Perintah">Surat Perintah</option>
                                    <option value="Surat Perjanjian">Surat Perjanjian</option>
                                    <option value="Pengumuman">Pengumuman</option>


                                </select>
                            </div>

                            <div class="mb-3 pt-0">
                                <label for="perihal" class="text-sm font-semibold">Perihal</label>
                                <input type="text" id="perihal" v-model="formData.perihal"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required maxlength="255" />
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="asal_naskah" class="text-sm font-semibold">Asal Naskah</label>
                                <input type="text" id="asal_naskah" v-model="formData.asal_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required maxlength="255" />
                            </div>

                            <div class="mb-3 pt-0">
                                <label for="tujuan" class="text-sm font-semibold">Tujuan</label>
                                <input type="text" id="tujuan" v-model="formData.tujuan"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required maxlength="255" />
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="tgl_naskah" class="text-sm font-semibold">Tanggal Naskah</label>
                                <input type="date" id="tgl_naskah" v-model="formData.tgl_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <div class="mb-3 pt-0">
                                <label for="status" class="text-sm font-semibold">Status</label>
                                <select id="status" v-model="formData.status"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required>
                                    <option value="Menunggu Validasi">Menunggu Validasi</option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Ditolak">Ditolak</option>
                                    <option value="Diproses">Diproses</option>
                                </select>
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="status" class="text-sm font-semibold">File</label>
                                <input type="file" id="file" v-on:change="handleFileChange" name="file"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10" />
                                <p v-if="formData.file" class="mt-2 text-sm text-blueGray-600 font-bold">
                                    File sebelum: {{ formData.file }}
                                </p>
                            </div>

                        </div>
                        <div class="mt-6">
                            <router-link to="/admin/naskahkeluar/naskah-keluar"
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
    name: "EditNaskahkeluar",
    data() {
        return {
            formData: {
                jenis_naskah: '',
                perihal: '',
                asal_naskah: '',
                tujuan: '',
                tgl_naskah: '',
                status: '',
                file: '',
            }
        };
    },
    mounted() {
        const naskahID = this.$route.params.id_naskah_keluar;
        this.fetchNaskah(naskahID);
        console.log("apa ini");
        console.log(naskahID);
    },
    methods: {
        fetchNaskah(id_naskah_keluar) {
            const token = sessionStorage.getItem('token'); // Ambil token dari localStorage
            axios
                .get(`http://127.0.0.1:8000/api/naskah-keluars/${id_naskah_keluar}`, {
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
        updateNaskah() {
            const token = sessionStorage.getItem('token');
            const naskahID = this.$route.params.id_naskah_keluar;

            // Membuat instance FormData untuk mengirim file dan data lainnya
            const formData = new FormData();
            formData.append('jenis_naskah', this.formData.jenis_naskah);
            formData.append('perihal', this.formData.perihal);
            formData.append('tujuan', this.formData.tujuan);
            formData.append('tgl_naskah', this.formData.tgl_naskah);
            formData.append('status', this.formData.status);
            formData.append('_method', 'PUT');
            // Jika file ada, tambahkan file ke FormData
            if (this.formData.file) {
                formData.append('file', this.formData.file);
            }

            axios
                .post(`http://127.0.0.1:8000/api/naskah-keluars/${naskahID}`, formData, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'multipart/form-data', // Pastikan header ini ada saat mengirim file
                    },
                })
                .then((response) => {
                    console.log("Naskah updated:", response.data);
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Your work has been saved',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        this.$router.push('/admin/naskahkeluar/naskah-keluar');
                    });
                })
                .catch((error) => {
                    console.log(error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong while updating the naskah!',
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
