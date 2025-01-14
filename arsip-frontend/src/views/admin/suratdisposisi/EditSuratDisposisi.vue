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
                                Edit Surat Disposisi
                            </h3>
                        </div>
                    </div>
                </div>
                <hr class="md:min-w-full" />
                <div class="block w-full overflow-x-auto">
                    <!-- Form Inputs -->
                    <form @submit.prevent="updateDisposisi" class="px-4 py-4">



                        <div class="grid md:grid-cols-2 md:gap-6">


                            <div class="mb-3 pt-0 mr-2">
                                <label for="jenis_disposisi" class="text-sm font-semibold">Jenis Disposisi</label>
                                <select id="jenis_disposisi" v-model="suratDisposisi.jenis_disposisi"
                                    name="jenis_disposisi"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                    <option value="Instruksi Bupati">Instruksi Bupati</option>
                                    <option value="Surat Edaran">Surat Edaran</option>
                                    <option value="Surat Perintah">Surat Perintah</option>
                                    <option value="Surat Perjanjian">Surat Perjanjian</option>
                                    <option value="Pengumuman">Pengumuman</option>


                                </select>
                            </div>


                            <div class="mb-3 pt-0 mr-2">
                                <label for="isi_disposisi" class="text-sm font-semibold">Isi Disposisi</label>
                                <input type="text" id="isi_disposisi" v-model="suratDisposisi.isi_disposisi"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="tujuan" class="text-sm font-semibold">Tujuan</label>
                                <select id="tujuan" name="tujuan" v-model="suratDisposisi.tujuan"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                    <option value="kadis">Kepala Dinas</option>
                                    <option value="sekdis">Sekretaris Dinas</option>
                                    <option value="kabag">Kepala Bagian</option>
                                </select>
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="tgl_waktu" class="text-sm font-semibold">Tanggal Disposisi</label>
                                <input type="date" id="tgl_waktu" v-model="suratDisposisi.tgl_waktu"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>



                            <div class="mb-3 pt-0 mr-2">
                                <label for="status" class="text-sm font-semibold">File</label>
                                <input type="file" id="file" v-on:change="handleFileChange" name="file"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10" />
                                <p v-if="suratDisposisi.file" class="mt-2 text-sm text-blueGray-600 font-bold">
                                    File sebelum: {{ suratDisposisi.file }}
                                </p>
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="perihal" class="text-sm font-semibold">Perihal</label>
                                <textarea type="text" id="perihal" v-model="suratDisposisi.perihal"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required maxlength="255" />
                            </div>

                        </div>
                        <div class="mt-6">
                            <router-link to="/admin/suratdisposisi/surat-disposisi"
                                class="bg-red-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-red-800 mr-2">
                                Batal
                            </router-link>
                            <button type="submit"
                                class="bg-emerald-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-emerald-600">
                                Update Disposisi
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
import Swal from 'sweetalert2'

export default {
    name: "EditSuratDisposisi",
    data() {
        return {
            suratDisposisi: {
                jenis_disposisi: '',
                isi_disposisi: '',
                perihal: '',
                tujuan: '',
                file: '',
                tgl_waktu: ''
            }
        };
    },
    mounted() {
        const disposisiID = this.$route.params.id_disposisi;
        this.fetchDisposisi(disposisiID);
        console.log("apa ini");
        console.log(disposisiID);
    },
    methods: {
        fetchDisposisi(id_disposisi) {
            const token = sessionStorage.getItem('token'); // Ambil token dari localStorage
            axios
                .get(`http://127.0.0.1:8000/api/disposisis/${id_disposisi}`, {
                    headers: {
                        Authorization: `Bearer ${token}` // Tambahkan header Bearer Token
                    }
                })
                .then((response) => {
                    console.log("Fetch Disposisi Response:", response); // Print seluruh response
                    console.log("Data Disposisi:", response.data.data); // Print hanya data pegawai
                    this.suratDisposisi = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching data:", error.response || error); // Print error detail
                });
        },

        handleFileChange(event) {
            this.suratDisposisi.file = event.target.files[0];
        },
        updateDisposisi() {
            const token = sessionStorage.getItem('token');
            const disposisiID = this.$route.params.id_disposisi;

            axios
                .put(`http://127.0.0.1:8000/api/disposisis/${disposisiID}`, this.suratDisposisi, {
                    headers: {
                        Authorization: `Bearer ${token}`,

                    },
                })
                .then((response) => {
                    console.log("Disposisi updated:", response.data);

                    // Tampilkan notifikasi sukses dengan SweetAlert2
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        // Redirect ke halaman daftar setelah notifikasi selesai
                        this.$router.push('/admin/suratdisposisi/surat-disposisi');
                    });
                })
                .catch((error) => {
                    console.error("Error updating disposisi:", error);

                    // Tampilkan notifikasi error dengan SweetAlert2
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong while updating the disposisi!",
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
