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
                                Tambah Berkas Arsip
                            </h3>
                        </div>
                    </div>
                </div>
                <hr class="md:min-w-full" />
                <div class="block w-full overflow-x-auto">
                    <!-- Form Inputs -->
                    <form @submit.prevent="handleAddBerkas" class="px-4 py-4" enctype="multipart/form-data">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <!-- No Naskah -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="no_berkas" class="text-sm font-semibold">No Berkas</label>
                                <input type="text" id="no_naskah" v-model="no_berkas"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Jenis Naskah -->
                            <div class="mb-3 pt-0">
                                <label for="nama_berkas" class="text-sm font-semibold">Nama Berkas</label>
                                <input type="text" id="nama_berkas" v-model="nama_berkas"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                            <div class="mb-3 pt-0 mr-2">
                                <label for="nama_berkas" class="text-sm font-semibold">Jumlah Item</label>
                                <input type="number" id="nama_berkas" v-model="jml_item"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Tanggal Naskah -->
                            <div class="mb-3 pt-0">
                                <label for="tgl_naskah" class="text-sm font-semibold">Retensi Waktu</label>
                                <input type="date" id="tgl_naskah" v-model="retensi_waktu"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                            <div class="mb-3 pt-0 mr-2">
                                <label for="perihal" class="text-sm font-semibold">Perihal</label>
                                <textarea type="text" id="perihal" v-model="perihal"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                        </div>
                        <div class="mt-6">
                            <router-link to="/admin/berkas-arsip"
                                class="bg-red-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-red-800 mr-2">
                                Batal
                            </router-link>
                            <button type="submit" :disabled="loading"
                                class="bg-emerald-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-emerald-600">
                                Tambah Berkas
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
import Swal from 'sweetalert2';

export default {
    name: "TambahBerkasArsip",
    data() {
        return {
            nama_berkas: '',
            no_berkas: '',
            perihal: '',
            jml_item: '',
            retensi_waktu: '',
            loading: false,
        };
    },
    methods: {
        handleFileUpload(event) {
            this.file = event.target.files[0];
        },
        async handleAddBerkas() {
            this.loading = true;
            const token = sessionStorage.getItem('token');

            const formData = new FormData();
            formData.append('nama_berkas', this.nama_berkas);
            formData.append('no_berkas', this.no_berkas);
            formData.append('perihal', this.perihal);
            formData.append('jml_item', this.jml_item);
            formData.append('retensi_waktu', this.retensi_waktu);

            try {
                const response = await axios.post('http://127.0.0.1:8000/api/path-arsips/store', formData, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        'Content-Type': 'multipart/form-data',
                    },
                });

                console.log(response.data);
                Swal.fire({
                    title: 'Success',
                    text: 'Berhasil Menambahkan Data',
                    icon: 'success',
                })
                this.$router.push('/admin/berkas-arsip');
            } catch (error) {
                console.error(error);
                Swal.fire({
                    title: 'Gagal',
                    text: 'Gagal Menambahkan Data',
                    icon: 'error',
                })

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
