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
            <router-link to="/admin/suratdisposisi/tambah-surat-disposisi"
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
              <template v-if="disposisis.length > 0">
                <tr v-for="(disposisi, index) in filteredDisposisis" :key="disposisi.id">
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ index + 1 }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ disposisi.jenis_disposisi || '-' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ disposisi.isi_disposisi || '-' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ disposisi.perihal || '-' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ disposisi.tujuan == 'kadis' ? 'Kepala Dinas' : disposisi.tujuan == 'sekdis' ? 'Sekretasris Dinas'
                      :
                      'Kepala Bagian' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    {{ disposisi.tgl_waktu || '-' }}
                  </td>

                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap">
                    <router-link :to="`/admin/disposisimasuk/edit-disposisi-masuk/${disposisi.id_disposisi}`"
                      class="text-white rounded bg-orange-500 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-edit text-sm "></i>
                    </router-link>

                    <button @click="disposisiEmployee(disposisi.id_disposisi)"
                      class="text-white rounded bg-red-500 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-trash text-sm "></i>
                    </button>

                    <router-link :to="`/admin/disposisimasuk/detail-disposisi-masuk/${disposisi.id_disposisis}`"
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
import Swal from 'sweetalert2';

export default {
  name: "DataSuratDisposisi",
  data() {
    return {
      disposisis: [],
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
    filteredDisposisis() {
      // Filter disposisis berdasarkan searchQuery
      return this.disposisis.filter(disposisi => {
        return (
          // String(disposisi.no_disposisi ?? "").includes(this.searchQuery)
          // ||
          disposisi.jenis_disposisi.includes(this.searchQuery) ||
          disposisi.isi.includes(this.searchQuery) ||
          disposisi.perihal.includes(this.searchQuery) ||
          disposisi.tujuan.includes(this.searchQuery) ||
          disposisi.tgl_waktu.includes(this.searchQuery)

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
        this.disposisis = []; // Kosongkan hasil pencarian jika searchQuery kosong
      }
    },
    fetchPagination(page = 1) {
      const token = sessionStorage.getItem("token");
      if (!token) {
        alert("You must log in first!");
        this.$router.push("/login");
        return;
      }

      axios
        .get(`http://127.0.0.1:8000/api/disposisis?page=${page}&search=${this.searchQuery}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          console.log("Fetch Disposisi Response:", response);
          this.disposisis = response.data.data.data;
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
    disposisiEmployee(id_disposisis) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          const token = sessionStorage.getItem('token');

          // Proses penghapusan hanya terjadi jika dikonfirmasi
          axios
            .delete(`http://127.0.0.1:8000/api/disposisis/${id_disposisis}`, {
              headers: {
                Authorization: `Bearer ${token}`,
              }
            })
            .then((response) => {
              console.log("Delete Naskah Response:", response);

              // Tampilkan notifikasi sukses setelah penghapusan berhasil
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
              });

              // Refresh data setelah menghapus
              this.fetchPagination(this.currentPage);
            })
            .catch((error) => {
              console.error("Error deleting Naskah:", error.response || error);

              // Tampilkan notifikasi error jika penghapusan gagal
              Swal.fire({
                title: "Error!",
                text: "There was an error deleting the file.",
                icon: "error"
              });
            });
        }
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
