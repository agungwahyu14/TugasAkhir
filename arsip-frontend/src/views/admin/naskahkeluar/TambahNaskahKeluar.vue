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
                    <form @submit.prevent="submitForm" class="px-4 py-4">

                        <div class="grid md:grid-cols-2 md:gap-6">
                            <div class="mb-3 pt-0 mr-2">
                                <label for="idNaskah" class="text-sm font-semibold">Id Naskah</label>
                                <input type="text" id="idNaskah" v-model="formData.idNaskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                            <div class="mb-3 pt-0 ">
                                <label for="idPengguna" class="text-sm font-semibold">Id Pengguna</label>
                                <input type="text" id="idPengguna" v-model="formData.idPengguna"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <div class="mb-3 pt-0 mr-2">
                                <label for="noNaskah" class="text-sm font-semibold">No Naskah</label>
                                <input type="text" id="noNaskah" v-model="formData.noNaskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                            <div class="mb-3 pt-0">
                                <label for="jenisNaskah" class="text-sm font-semibold">Jenis Naskah</label>
                                <input type="text" id="jenisNaskah" v-model="formData.jenisNaskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <div class="mb-3 pt-0 mr-2 ">
                                <label for="perihal" class="text-sm font-semibold">Perihal</label>
                                <input type="text" id="perihal" v-model="formData.perihal"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                            <div class="mb-3 pt-0">
                                <label for="perihal" class="text-sm font-semibold">Asal Naskah</label>
                                <input type="text" id="perihal" v-model="formData.perihal"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                            <div class="mb-3 pt-0 mr-2 ">
                                <label for="tujuan" class="text-sm font-semibold">Tujuan</label>
                                <input type="text" id="tujuan" v-model="formData.tujuan"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>
                            <div class="mb-3 pt-0">
                                <label for="file" class="text-sm font-semibold">File</label>
                                <input type="file" id="file" @change="handleFileChange"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10" />
                            </div>
                            <div class="mb-3 pt-0">
                                <label for="tanggalNaskah" class="text-sm font-semibold">Tanggal Naskah</label>
                                <input type="date" id="tanggalNaskah" v-model="formData.tanggalNaskah"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                        </div>
                        <div class="mt-6">
                            <router-link to="/admin/naskah/naskah-keluar"
                                class="bg-red-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-red-800 mr-2">
                                Batal
                            </router-link>
                            <button type="submit"
                                class="bg-emerald-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-emerald-600">
                                Simpan Naskah
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ArsipDinamis",
    data() {
        return {
            formData: {
                idNaskah: '',
                idPengguna: '',
                noNaskah: '',
                jenisNaskah: '',
                perihal: '',
                tujuan: '',
                file: null,
                tanggalNaskah: ''
            }
        };
    },
    methods: {
        submitForm() {
            // Handle form submission
            console.log("Form data:", this.formData);
            // Perform the action (e.g., API call)
        },
        handleFileChange(event) {
            this.formData.file = event.target.files[0];
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
