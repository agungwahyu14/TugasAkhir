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
                                Detail Surat Disposisi
                            </h3>

                            <router-link to="/admin/suratdisposisi/surat-disposisi"
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
                            <div class="bg-blue-300">
                                <h3>Jenis Disposis</h3>
                                <p>{{ suratDisposis.jenis_disposisi }}</p>
                            </div>
                            <div class="bg-blue-400">
                                <h3>Tanggal Surat Disposisi</h3>
                                <p>{{ suratDisposis.tgl_waktu }}</p>
                            </div>
                            <div class="bg-blue-500 mt-3">
                                <h3>Perihal</h3>
                                <p>{{ suratDisposis.perihal }}</p>
                            </div>
                            <div class="bg-blue-500 mt-3">
                                <h3>Isi Disposisi</h3>
                                <p>{{ suratDisposis.isi_disposisi }}</p>
                            </div>
                        </div>

                        <!-- Select Dropdowns -->

                        <div class="mb-4 pt-0 mr-2 mt-4">
                            <select id="tujuan" name="tujuan" disabled
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <option value="" class="text-sm font-semibold">
                                    {{ suratDisposis.tujuan == 'kadis' ? 'Kepala Dinas' : suratDisposis.tujuan ==
                                        'sekdis' ?
                                        'Sekretasris Dinas' :
                                        'Kepala Bagian' }}
                                </option>
                            </select>
                        </div>

                        <!-- Lampiran Section -->

                        <div class="mb-4 pt-0 mr-2">
                            <div
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <iframe :src="`http://127.0.0.1:8000/storage/${suratDisposis.file}`"
                                    class="relative w-full rounded h-600-px" frameborder="0"></iframe>
                                <hr class="md:min-w-full mt-3" />
                            </div>
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
    name: "EditSuratDisposis",
    data() {
        return {
            suratDisposis: {
                jenis_disposisi: '',
                isi_disposisi: '',
                perihal: '',
                tujuan: '',
                file: '',
                tgl_waktu: '',
            },
        };
    },
    mounted() {
        const disposisiId = this.$route.params.id_disposisi;
        this.fetchSuratDisposisi(disposisiId);
    },
    methods: {
        async fetchSuratDisposisi(id_disposisi) {
            try {
                const token = sessionStorage.getItem("token");
                const response = await axios.get(
                    `http://127.0.0.1:8000/api/disposisis/${id_disposisi}`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                console.log("Fetch Detail Surat Disposisi Response:", response); // Print seluruh response
                console.log("Data Detail Surat Disposisi:", response.data.data); //
                this.suratDisposis = response.data.data;
            } catch (error) {
                console.error("Error fetching data:", error.response || error);
            }
        },




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
