<template>
    <div class="flex flex-wrap mt-4">
        <div class="w-full mb-12 px-4">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded"
                :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
                <div class="rounded-t mb-0 px-4 py-4 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-lg"
                                    :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
                                    Data Admin
                                </h3>

                            </div>


                        </div>
                        <router-link to="/admin/pegawai/tambah-user-admin"
                            class="bg-emerald-500 text-white font-bold px-4 py-3 mr-2 rounded shadow hover:bg-blue-600">
                            <i class="fas fa-plus text-sm mr-2 ml-2 "> </i>
                        </router-link>
                        <div class="relative flex flex-wrap items-stretch">
                            <span
                                class="z-10 h-full leading-snug font-normal absolute text-center text-blueGray-300 absolute bg-transparent rounded text-base items-center justify-center w-8 pl-3 py-3">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" placeholder="Search here..."
                                class="border-0 px-4 py-2 placeholder-blueGray-300 text-blueGray-600 relative bg-white bg-white rounded shadow outline-none focus:outline-none focus:ring  pl-10" />
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                    <!-- Projects table -->
                    <table class="items-center w-full bg-transparent border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                                    :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700']">
                                    #
                                </th>
                                <th v-for="header in headers" :key="header"
                                    class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center "
                                    :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700']">
                                    {{ header }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="employees.length > 0">
                                <tr v-for="(employee, index) in employees" :key="employee.id">
                                    <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                                        {{ index + 1 }}
                                    </td>
                                    <td
                                        class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap text-center">
                                        {{ employee.nip || '-' }}
                                    </td>
                                    <!-- <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                                        {{ employee.id_admin || '-' }}
                                    </td> -->
                                    <td
                                        class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap text-center">
                                        {{ employee.nama || '-' }}
                                    </td>
                                    <td
                                        class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap text-center">
                                        {{ employee.email || '-' }}
                                    </td>
                                    <!-- <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                                        {{ employee.password || '-' }}
                                    </td> -->
                                    <td
                                        class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap text-center">
                                        {{ employee.username || '-' }}
                                    </td>
                                    <td
                                        class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap text-center">
                                        {{ employee.bidang || '-' }}
                                    </td>
                                    <td
                                        class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap text-center">
                                        {{ employee.status || '-' }}
                                    </td>
                                    <!-- <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                                        {{ formatDate(employee.created_at) || '-' }}
                                    </td>
                                    <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                                        {{ formatDate(employee.updated_at) || '-' }}
                                    </td> -->
                                    <td
                                        class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap text-center">
                                        <router-link :to="`/admin/pegawai/edit-user-pegawai/${employee.nip}`"
                                            class="text-white rounded bg-orange-500 text-xs px-4 py-2 mr-2">
                                            <i class="fas fa-edit text-sm "></i>
                                        </router-link>

                                        <button @click="deleteEmployee(employee.nip)"
                                            class="text-white rounded bg-red-500 text-xs px-4 py-2 mr-2">
                                            <i class="fas fa-trash text-sm "></i>
                                        </button>

                                        <button @click="toggleStatus(employee)"
                                            :class="employee.status === 'aktif' ? 'bg-red-500' : 'bg-emerald-500'"
                                            class="text-white rounded text-xs px-4 py-2">
                                            {{ employee.status === 'aktif' ? 'NonAktifkan' : 'Aktifkan' }}
                                        </button>


                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="13" class="text-center py-4 text-sm text-gray-500">
                                        Tidak ada data tersedia.
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";

export default {
    name: "DataPegawai",
    data() {
        return {
            employees: [], // Store API data
            headers: [
                "NIP",
                // "Id Admin",
                "Nama",
                "Email",
                // "Password",
                "Username",
                "Bidang",
                "Status",
                // "Create At",
                // "Update At",
                "Aksi",
            ],
        };
    },
    mounted() {
        this.fetchEmployees();
    },
    methods: {
        fetchEmployees() {
            const token = sessionStorage.getItem('token'); // Ambil token dari localStorage
            axios
                .get("http://127.0.0.1:8000/api/admin", {
                    headers: {
                        Authorization: `Bearer ${token}` // Tambahkan header Bearer Token
                    }
                })
                .then((response) => {
                    console.log("Fetch Employees Response:", response); // Print seluruh response
                    console.log("Data Admin:", response.data.data); // Print hanya data pegawai
                    this.employees = response.data.data;
                })
                .catch((error) => {
                    console.error("Error fetching data:", error.response || error); // Print error detail
                });
        },
        deleteEmployee(nip) {
            const token = sessionStorage.getItem('token'); // Ambil token dari localStorage
            axios
                .delete(`http://127.0.0.1:8000/api/admin/${nip}`, {
                    headers: {
                        Authorization: `Bearer ${token}` // Tambahkan header Bearer Token
                    }
                })
                .then((response) => {
                    console.log("Delete Employee Response:", response); // Print seluruh response
                    console.log("Employee Deleted:", response.data); // Print hanya pesan sukses
                    // Fetch employees again or update state after deletion
                    this.fetchEmployees();
                })
                .catch((error) => {
                    console.error("Error deleting employee:", error.response || error); // Print error detail
                });
        },

        toggleStatus(employee) {
            const token = sessionStorage.getItem("token"); // Ambil token dari sessionStorage
            if (!token) {
                console.error("Token tidak tersedia. Pastikan Anda sudah login.");
                return;
            }

            // Tentukan endpoint berdasarkan status karyawan saat ini
            const endpoint = `http://127.0.0.1:8000/api/admin/${employee.nip}/${employee.status === "aktif" ? "deactivate" : "activate"
                }`;

            // Kirim permintaan PATCH ke API
            axios
                .patch(endpoint, {}, {
                    headers: {
                        Authorization: `Bearer ${token}`, // Tambahkan header Bearer Token
                    },
                })
                .then(() => {
                    console.log(
                        `Status karyawan ${employee.nip} berhasil diubah menjadi ${employee.status === "aktif" ? "non-aktif" : "aktif"
                        }`
                    );

                    // Refresh data karyawan setelah berhasil update
                    this.fetchEmployees();
                })
                .catch((error) => {
                    console.error("Error saat mengubah status karyawan:", error.response || error);
                    alert("Gagal mengubah status. Silakan coba lagi.");
                });
        },

    },
    props: {
        color: {
            default: "light",
            validator: function (value) {
                // The value must match one of these strings
                return ["light", "dark"].indexOf(value) !== -1;
            },
        },
    },
};
</script>