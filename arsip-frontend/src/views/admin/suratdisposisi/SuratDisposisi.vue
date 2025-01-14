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
                  Data Surat Disposisi
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
              <input type="text" placeholder="Search here..." v-model="searchQuery" @input="searchInput"
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
                <tr v-for="(naskah, index) in filteredNaskahs" :key="naskah.id">
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ index + 1 }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ naskah.no_naskah || '-' }}
                  </td>

                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ naskah.jenis_naskah || '-' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ naskah.perihal || '-' }}
                  </td>

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

                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    <router-link :to="`/admin/naskahmasuk/edit-naskah-masuk/${naskah.id_disposisis}`"
                      class="text-white rounded bg-orange-500 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-edit text-sm "></i>
                    </router-link>

                    <button @click="deleteEmployee(naskah.id_disposisis)"
                      class="text-white rounded bg-red-500 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-trash text-sm "></i>
                    </button>

                    <button class="text-white bg-emerald-500 rounded text-xs px-4 py-2 mr-2">
                      <i class="fab fa-whatsapp text-sm "></i>
                    </button>

                    <router-link :to="`/admin/naskahmasuk/detail-naskah-masuk/${naskah.id_disposisis}`"
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
        <div class=" px-4 py-4">

          <div class="flex items-center justify-end space-x-1">



            <button @click="goToPreviousPage" :disabled="currentPage === 1"
              class="px-4 py-2 mr-2 text-sm font-medium rounded-md border bg-emerald-500 text-white"
              :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }">
              Previous
            </button>

            <button
              class="px-4 py-2 mr-2 text-sm font-medium rounded-md border-emerald-500 border bg-white text-emerald-500">
              {{ currentPage }}
            </button>

            <button
              class="px-4 py-2 mr-2 text-sm font-medium rounded-md border-emerald-500 border bg-white text-emerald-500">
              ...
            </button>

            <button @click="goToLastPage"
              class="px-4 py-2 mr-2 text-sm font-medium rounded-md border-emerald-500 border bg-white text-emerald-500">
              {{ totalPages }}
            </button>

            <button @click="goToNextPage" :disabled="currentPage === totalPages"
              class="px-4 py-2 mr-2 text-sm font-medium rounded-md border bg-emerald-500 text-white"
              :class="{ 'opacity-50 cursor-not-allowed': currentPage === totalPages }">
              Next
            </button>




          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { debounce } from 'lodash';

export default {
  name: "DataSuratDisposisi",
  data() {
    return {
      naskahs: [],
      searchQuery: "",
      headers: [
        "Jenis Disposisi",
        "Isi Disposisi",
        "Perihal",
        "Tujuan",
        "Tanggal Waktu",
        "Aksi",
      ],
      totalPages: 0,
      currentPage: 1,
    };
  },
  computed: {
    filteredNaskahs() {
      // Filter naskahs berdasarkan searchQuery
      return this.naskahs.filter(naskah => {
        return (
          String(naskah.no_naskah ?? "").includes(this.searchQuery)
          ||
          naskah.jenis_naskah.includes(this.searchQuery) ||
          naskah.perihal.includes(this.searchQuery) ||
          naskah.tujuan.includes(this.searchQuery) ||
          naskah.tgl_naskah.includes(this.searchQuery) ||
          naskah.status.includes(this.searchQuery)
        );
      });
    }
  },
  created() {
    this.debouncedSearch = debounce(this.fetchPagination, 500); // Menambahkan debounce
  },
  mounted() {
    const token = sessionStorage.getItem('token');
    if (!token) {
      alert("Anda harus login terlebih dahulu!");
      this.$router.push("/login");
    }
    this.fetchPagination();
  },
  methods: {
    searchInput() {
      if (this.searchQuery.length > 0) {
        this.debouncedSearch(); // Menjalankan fungsi pencarian dengan debounce
      } else {
        this.disposisi = []; // Kosongkan hasil pencarian jika searchQuery kosong
      }
    },
    fetchPagination(page = 1) {
      const token = sessionStorage.getItem('token');
      if (!token) {
        alert("Anda harus login terlebih dahulu!");
        this.$router.push("/login");
      }

      axios
        .get(`http://127.0.0.1:8000/api/disposisis?page=${page}&search=${this.searchQuery}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          console.log("Fetch Naskah Response:", response);
          this.disposisi = response.data.data.data;
          this.totalPages = response.data.data.last_page;
          this.currentPage = response.data.data.current_page;
        })
        .catch((error) => {
          console.error("Error fetching data:", error.response || error);
        });
    },
    goToPage(page) {
      this.fetchPagination(page);
    },
    goToNextPage() {
      if (this.currentPage < this.totalPages) {
        this.fetchPagination(this.currentPage + 1);
      }
    },
    goToPreviousPage() {
      if (this.currentPage > 1) {
        this.fetchPagination(this.currentPage - 1);
      }
    },
    goToLastPage() {
      this.fetchPagination(this.totalPages);
    },
    deleteEmployee(id_disposisis) {
      const token = sessionStorage.getItem('token');
      axios
        .delete(`http://127.0.0.1:8000/api/disposisis/${id_disposisis}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          }
        })
        .then((response) => {
          console.log("Delete Naskah Response:", response);
          this.fetchPagination(this.currentPage); // Refresh data setelah menghapus
        })
        .catch((error) => {
          console.error("Error deleting Naskah:", error.response || error);
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
