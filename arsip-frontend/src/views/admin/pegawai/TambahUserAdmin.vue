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
                                Tambah User Admin
                            </h3>
                        </div>
                    </div>
                </div>
                <hr class="md:min-w-full" />
                <div class="block w-full overflow-x-auto">
                    <!-- Form Inputs -->
                    <form @submit.prevent="handleAddAdmin" class="px-4 py-4">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <!-- NIP -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="nip" class="text-sm font-semibold">NIP</label>
                                <input type="text" id="nip" v-model="nip"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Nama -->
                            <div class="mb-3 pt-0 ">
                                <label for="nama" class="text-sm font-semibold">Nama</label>
                                <input type="text" id="nama" v-model="nama"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Email -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="email" class="text-sm font-semibold">Email</label>
                                <input type="email" id="email" v-model="email"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Password -->
                            <div class="mb-3 pt-0">
                                <label for="password" class="text-sm font-semibold">Password</label>
                                <input type="password" id="password" v-model="password"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Username -->
                            <div class="mb-3 pt-0 mr-2 ">
                                <label for="username" class="text-sm font-semibold">Username</label>
                                <input type="text" id="username" v-model="username"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Bidang -->
                            <div class="mb-3 pt-0">
                                <label for="bidang" class="text-sm font-semibold">Bidang</label>
                                <input type="text" id="bidang" v-model="bidang"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10" />
                            </div>

                            <!-- Status -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="status" class="text-sm font-semibold">Status</label>
                                <select id="status" v-model="status"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                    <option value="aktif">Aktif</option>

                                </select>
                            </div>

                        </div>

                        <div class="mt-6">
                            <router-link to="/admin/pegawai/user-pegawai"
                                class="bg-red-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-red-800 mr-2">
                                Batal
                            </router-link>
                            <button type="submit" :disabled="loading"
                                class="bg-emerald-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-emerald-600">
                                Tambah User Admin
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
    name: "TambahUserAdmin",
    data() {
        return {
            nip: '',
            nama: '',
            email: '',
            password: '',
            username: '',
            bidang: '',
            status: 'aktif',
            loading: false,
        };
    },
    methods: {
        async handleAddAdmin() {
            this.loading = true;
            const token = sessionStorage.getItem('token'); // Ambil token dari localStorage atau sumber lain

            try {
                const response = await axios.post('http://127.0.0.1:8000/api/admin', {
                    nip: this.nip,
                    nama: this.nama,
                    email: this.email,
                    password: this.password,
                    username: this.username,
                    bidang: this.bidang,
                    status: this.status,
                }, {
                    headers: {
                        Authorization: `Bearer ${token}` // Tambahkan header Bearer Token
                    }
                });

                console.log(response.data);
                alert('User berhasil ditambahkan!');
                this.$router.push('/admin/pegawai/user-admin');
            } catch (error) {
                console.error(error);
                alert('Terjadi kesalahan saat menambahkan user.');
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
