<template>
  <div class="flex flex-wrap mt-4">
    <div class="w-full mb-12 px-4">
      <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded"
        :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
        <div class="rounded-t mb-0 px-4 py-4 border-0">
          <div class="flex flex-wrap items-center">
            <div class="relative w-full px-4 max-w-full flex-grow flex-1">
              <div class="flex items-center justify-between mb-2">
                <h3 class="font-semibold text-lg" :class="[color === 'light' ? 'text-blueGray-700' : 'text-white']">
                  Data Naskah Masuk
                </h3>

              </div>


            </div>
            <router-link to="/admin/naskahmasuk/tambah-naskah-masuk"
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
                <th
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left"
                  :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700']">
                  #
                </th>
                <th v-for="header in headers" :key="header"
                  class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center"
                  :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700']">
                  {{ header }}
                </th>
              </tr>
            </thead>
            <tbody>
              <template v-if="naskahs.length > 0">
                <tr v-for="(naskah, index) in naskahs" :key="naskah.id">
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ index + 1 }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ naskah.no_naskah || '-' }}
                  </td>
                  <!-- <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                                      {{ employee.id_admin || '-' }}
                                  </td> -->
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ naskah.jenis_naskah || '-' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ naskah.perihal || '-' }}
                  </td>
                  <!-- <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                                      {{ employee.password || '-' }}
                                  </td> -->
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ naskah.tujuan == 'kadis' ? 'Kepala Dinas' : naskah.tujuan == 'sekdis' ? 'Sekretasris Dinas' :
                      'Kepala Bagian' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ naskah.tgl_naskah || '-' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ naskah.status || '-' }}
                  </td>
                  <!-- <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                                      {{ formatDate(employee.created_at) || '-' }}
                                  </td>
                                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                                      {{ formatDate(employee.updated_at) || '-' }}
                                  </td> -->
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    <router-link :to="`/admin/naskahmasuk/edit-naskah-masuk/${naskah.id_naskah_masuk}`"
                      class="text-white rounded bg-orange-500 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-edit text-sm "></i>
                    </router-link>

                    <button @click="deleteEmployee(naskah.id_naskah_masuk)"
                      class="text-white rounded bg-red-500 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-trash text-sm "></i>
                    </button>

                    <button @click="toggleStatus(naskah)"
                      class="text-white bg-emerald-500 rounded text-xs px-4 py-2 mr-2">
                      <i class="fab fa-whatsapp text-sm "></i>
                    </button>

                    <router-link :to="`/admin/naskahmasuk/detail-naskah-masuk/${naskah.id_naskah_masuk}`"
                      class="text-white rounded bg-orange-500 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-info-circle text-sm "></i>
                    </router-link>



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
  name: "DataNaskahMasuk",
  data() {
    return {
      naskahs: [], // Store API data
      headers: [
        "No Naskah",
        // "Id Admin",
        "Jenis Naskah",
        "Perihal",
        // "Password",
        "Tujuan",

        "Tanggal Naskah",
        "Status",

        "Aksi",
      ],
    };
  },
  mounted() {
    this.fetchNaskah();
  },
  methods: {
    fetchNaskah() {
      const token = sessionStorage.getItem('token'); // Ambil token dari localStorage
      axios
        .get("http://127.0.0.1:8000/api/naskah-masuks", {
          headers: {
            Authorization: `Bearer ${token}` // Tambahkan header Bearer Token
          }
        })
        .then((response) => {
          console.log("Fetch Naskah Response:", response); // Print seluruh response
          console.log("Data Naskah:", response.data.data); // Print hanya data pegawai
          this.naskahs = response.data.data.data;
        })
        .catch((error) => {
          console.error("Error fetching data:", error.response || error); // Print error detail
        });
    },
    deleteEmployee(id_naskah_masuk) {
      const token = sessionStorage.getItem('token'); // Ambil token dari localStorage
      axios
        .delete(`http://127.0.0.1:8000/api/naskah-masuks/${id_naskah_masuk}`, {
          headers: {
            Authorization: `Bearer ${token}` // Tambahkan header Bearer Token
          }
        })
        .then((response) => {
          console.log("Delete Naskah Response:", response); // Print seluruh response
          console.log("Naskah Deleted:", response.data); // Print hanya pesan sukses
          // Fetch Naskahs again or update state after deletion
          this.fetchNaskah();
        })
        .catch((error) => {
          console.error("Error deleting Naskah:", error.response || error); // Print error detail
        });
    },

    // toggleStatus(employee) {
    //   const token = sessionStorage.getItem("token"); // Ambil token dari sessionStorage
    //   if (!token) {
    //     console.error("Token tidak tersedia. Pastikan Anda sudah login.");
    //     return;
    //   }

    //   // Tentukan endpoint berdasarkan status karyawan saat ini
    //   const endpoint = `http://127.0.0.1:8000/api/admin/${employee.nip}/${employee.status === "aktif" ? "deactivate" : "activate"
    //     }`;

    //   // Kirim permintaan PATCH ke API
    //   axios
    //     .patch(endpoint, {}, {
    //       headers: {
    //         Authorization: `Bearer ${token}`, // Tambahkan header Bearer Token
    //       },
    //     })
    //     .then(() => {
    //       console.log(
    //         `Status karyawan ${employee.nip} berhasil diubah menjadi ${employee.status === "aktif" ? "non-aktif" : "aktif"
    //         }`
    //       );

    //       // Refresh data karyawan setelah berhasil update
    //       this.fetchEmployees();
    //     })
    //     .catch((error) => {
    //       console.error("Error saat mengubah status karyawan:", error.response || error);
    //       alert("Gagal mengubah status. Silakan coba lagi.");
    //     });
    // },

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