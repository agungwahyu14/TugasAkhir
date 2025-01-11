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
                                Tambah User Pegawai
                            </h3>
                        </div>
                    </div>
                </div>
                <hr class="md:min-w-full" />
                <div class="block w-full overflow-x-auto">
                    <!-- Form Inputs -->
                    <form @submit.prevent="updateEmployee" class="px-4 py-4">
                        <div class="grid md:grid-cols-2 md:gap-6">
                            <!-- NIP -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="nip" class="text-sm font-semibold">NIP</label>
                                <input type="text" id="nip" v-model="employee.nip"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Id Admin -->
                            <div class="mb-3 pt-0">
                                <label for="idPegawai" class="text-sm font-semibold">Id Admin</label>
                                <input type="text" id="nama" v-model="employee.id"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Nama -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="nama" class="text-sm font-semibold">Nama</label>
                                <input type="text" id="nama" v-model="employee.nama"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Email -->
                            <div class="mb-3 pt-0">
                                <label for="email" class="text-sm font-semibold">Email</label>
                                <input type="email" id="email" v-model="employee.email"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Password -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="password" class="text-sm font-semibold">Password</label>
                                <input type="password" id="password" v-model="employee.password"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Username -->
                            <div class="mb-3 pt-0">
                                <label for="username" class="text-sm font-semibold">Username</label>
                                <input type="text" id="username" v-model="employee.username"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    required />
                            </div>

                            <!-- Bidang -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="bidang" class="text-sm font-semibold">Bidang</label>
                                <input type="text" id="bidang" v-model="employee.bidang"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10" />
                            </div>

                            <!-- Status -->
                            <div class="mb-3 pt-0">
                                <label for="status" class="text-sm font-semibold">Status</label>
                                <select id="status" v-model="employee.status"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                            </div>

                            <!-- Created At (disabled and today's date) -->
                            <div class="mb-3 pt-0 mr-2">
                                <label for="createdAt" class="text-sm font-semibold">Created At</label>
                                <input type="text" id="createdAt" v-model="employee.createdAt"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    disabled />
                            </div>

                            <!-- Updated At (disabled and today's date) -->
                            <div class="mb-3 pt-0">
                                <label for="updatedAt" class="text-sm font-semibold">Updated At</label>
                                <input type="text" id="updatedAt" v-model="employee.updatedAt"
                                    class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10"
                                    disabled />
                            </div>
                        </div>

                        <div class="mt-6">
                            <router-link to="/admin/pegawai/user-pegawai"
                                class="bg-red-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-red-800 mr-2">
                                Batal
                            </router-link>
                            <button type="submit"
                                class="bg-emerald-500 text-white font-bold px-4 py-2 rounded shadow hover:bg-emerald-600">
                                Edit User
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

export default {
    name: "EditEmployee",
    data() {
        return {
            employee: {
                nip: "",
                id: "",
                nama: "",
                email: "",
                password: "",
                username: "",
                bidang: "",
                status: "",
                createdAt: "",
                updatedAt: "",
            },
        };
    },
    mounted() {
        const employeeId = this.$route.params.id;
        this.fetchEmployee(employeeId);
    },
    methods: {
        fetchEmployee(id) {
            const token = sessionStorage.getItem('token');
            axios
                .get(`http://127.0.0.1:8000/api/pegawai/${id}`, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    this.employee = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching employee data:", error);
                });
        },
        updateEmployee() {
            const token = sessionStorage.getItem('token');
            const employeeId = this.$route.params.id;
            axios
                .put(`http://127.0.0.1:8000/api/pegawai/${employeeId}`, this.employee, {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                })
                .then((response) => {
                    console.log("Employee updated:", response.data);
                    this.$router.push("/admin/pegawai"); // Redirect to list page
                })
                .catch((error) => {
                    console.error("Error updating employee:", error);
                });
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
