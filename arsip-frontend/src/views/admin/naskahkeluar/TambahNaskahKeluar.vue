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
                                Tambah Naskah Keluar
                            </h3>
                        </div>
                    </div>
                </div>
                <hr class="md:min-w-full" />
                <div class="block w-full overflow-x-auto">
                    <!-- Form Inputs -->
                    <form @submit.prevent="handleAddNaskah" class="px-4 py-4" enctype="multipart/form-data">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <!-- No Naskah -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="no_naskah" class="text-sm font-semibold">No Naskah</label>
                                <input type="number" id="no_naskah" v-model="no_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Jenis Naskah -->


                            <div class="mb-3 pt-0">
                                <label for="jenis_naskah" class="text-sm font-semibold">Jenis Naskah</label>
                                <select id="jenis_naskah" v-model="jenis_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                    <option value="Instruksi Bupati">Instruksi Bupati</option>
                                    <option value="Surat Edaran">Surat Edaran</option>
                                    <option value="Surat Perintah">Surat Perintah</option>
                                    <option value="Surat Perjanjian">Surat Perjanjian</option>
                                    <option value="Pengumuman">Pengumuman</option>


                                </select>
                            </div>


                            <div class="mb-3 pt-0 mr-2">
                                <label for="asal_naskah" class="text-sm font-semibold">Asal Naskah</label>
                                <select id="asal_naskah" v-model="asal_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                    <option value="Instruksi Bupati">Pemerintah</option>
                                    <option value="Surat Edaran">Bupati</option>
                                    <option value="Surat Perintah">Keuangan</option>


                                </select>
                            </div>

                            <!-- Perihal -->

                            <div class="mb-3 pt-0">
                                <label for="tujuan" class="text-sm font-semibold">Tujuan</label>
                                <select id="tujuan" name="tujuan" v-model="tujuan"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                    <option value="kadis">Kepala Dinas</option>
                                    <option value="sekdis">Sekretaris Dinas</option>
                                    <option value="kabag">Kepala Bagian</option>



                                </select>
                            </div>



                            <!-- File -->
                            <div class="mb-3 pt-0 mr-2 ">
                                <label for="file" class="text-sm font-semibold">File</label>
                                <input type="file" id="file" @change="handleFileUpload"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    accept=".doc,.docx,.pdf" required />
                            </div>
                            <div class="mb-3 pt-0">
                                <label for="tgl_naskah" class="text-sm font-semibold">Tanggal Naskah</label>
                                <input type="date" id="tgl_naskah" v-model="tgl_naskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="perihal" class="text-sm font-semibold">Perihal</label>
                                <textarea type="text" id="perihal" v-model="perihal"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Tanggal Naskah -->



                        </div>

                        <div class="mt-6">
                            <router-link to="/admin/naskahkelaur/naskah-keluar"
                                class="bg-red-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-red-800 mr-2">
                                Batal
                            </router-link>
                            <button type="submit" :disabled="loading"
                                class="bg-emerald-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-emerald-600">
                                Tambah Naskah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "TambahNaskahkeluar",
    data() {
        return {
            no_naskah: '',
            jenis_naskah: '',
            perihal: '',
            asal_naskah: '',
            tujuan: '',
            file: null,
            tgl_naskah: '',
            loading: false,
        };
    },
    methods: {
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        async handleAddNaskah() {
            this.loading = true;
            const token = sessionStorage.getItem('token');

            const formData = new FormData();
            formData.append('no_naskah', this.no_naskah);
            formData.append('jenis_naskah', this.jenis_naskah);
            formData.append('perihal', this.perihal);
            formData.append('asal_naskah', this.asal_naskah);
            formData.append('tujuan', this.tujuan);
            formData.append('file', this.file);
            formData.append('tgl_naskah', this.tgl_naskah);

            try {
                const response = await axios.post('http://127.0.0.1:8000/api/naskah-keluars', formData, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                });

                console.log(response.data);
                alert('Naskah berhasil ditambahkan!');
                this.$router.push('/admin/naskahkelaur/naskah-keluar');
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan saat menambahkan naskah.');
            } finally {
                this.loading = false;
            }
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
