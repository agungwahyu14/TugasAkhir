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
                  Berkas Arsip
                </h3>

              </div>


            </div>
            <router-link to="/admin/berkas-arsip/tambah-berkas-arsip"
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
                  class=" px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-center"
                  :class="[color === 'light' ? 'bg-blueGray-50 text-blueGray-500 border-blueGray-100' : 'bg-emerald-800 text-emerald-300 border-emerald-700'] ">
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
              <template v-if="berkasarsip.length > 0">
                <tr v-for="(berkasarsip, index) in berkasarsip" :key="berkasarsip.id">
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap text-center">
                    {{ index + 1 }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap  text-center">
                    {{ berkasarsip.no_berkas || '-' }}
                  </td>

                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap  text-center">
                    {{ berkasarsip.nama_berkas || '-' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap  text-center">
                    {{ berkasarsip.perihal || '-' }}
                  </td>

                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap  text-center">
                    {{ berkasarsip.jml_item || '-' }}
                  </td>
                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap  text-center">
                    {{ calculateYearsRemaining( berkasarsip.retensi_waktu) || '-' }}
                  </td>

                  <td class="px-6 align-middle border border-solid py-3 text-xs whitespace-nowrap text-center">
                    <router-link :to="`/admin/berkas-arsip/edit-berkas-arsip/${berkasarsip.id}`"
                      class="text-white rounded bg-orange-500 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-edit text-sm "></i>
                    </router-link>

                    <button @click="deleteBerkas(berkasarsip.id)"
                      class="text-white rounded bg-red-500 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-trash text-sm "></i>
                    </button>

                    <router-link :to="`/admin/berkas-arsip/detail-berkas-arsip/${berkasarsip.id}`"
                      class="text-white rounded bg-emerald-400 text-xs px-4 py-2 mr-2">
                      <i class="fas fa-folder text-sm "></i>
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
import Swal from 'sweetalert2'
  export default{
    name:"BerkasArsip",
    data() {
    return {
      berkasarsip: [],
      searchQuery: "",
      headers: [
        "No Berkas",
        "Nama Berkas",
        "Perihal",
        "Jumlah Item",
        "Retensi waktu ",
        "Aksi",
      ],
    };
  },
  props: {
    color: {
      default: "light",
      validator: function (value) {
        return ["light", "dark"].indexOf(value) !== -1;
      },
    },
  },
  computed: {
    filteredBerkas() {
      if (!this.berkasarsip) return []; // Pastikan data ada
      return this.berkasarsip.filter((data) => {
        return (
          (data.no_berkas ?? "").toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          (data.nama_berkas ?? "").toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          (data.perihal ?? "").toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          String(data.jml_item ?? "").includes(this.searchQuery)
        );
      });
    }

  },
  mounted() {
    const token = sessionStorage.getItem('token');
    if (!token) {
      alert("Anda harus login terlebih dahulu!");
      this.$router.push("/login");
    }
    this.fetchData();
  },
  methods:{
    fetchData(){
      const token = sessionStorage.getItem('token');
      if (!token) {
        alert("Anda harus login terlebih dahulu!");
        this.$router.push("/login");
      }

      axios
        .get(`http://127.0.0.1:8000/api/path-arsips`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          this.berkasarsip = JSON.parse(JSON.stringify(response.data.data));
        })
        .catch((error) => {
          console.error("Error fetching data:", error.response || error);
        });
    },
    calculateYearsRemaining(retensiWaktu) {
      if (!retensiWaktu) return "-";
      const today = new Date();
      const retensiDate = new Date(retensiWaktu);
      const yearsRemaining = retensiDate.getFullYear() - today.getFullYear();
      return yearsRemaining > 0 ? `${yearsRemaining} tahun` : "Sudah habis";
    },
    deleteBerkas(id) {
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
            .delete(`http://127.0.0.1:8000/api/path-arsips/${id}`, {
              headers: {
                Authorization: `Bearer ${token}`,
              }
            })
            .then((response) => {
              console.log("Delete Naskah Response:", response);
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
              }).then(() => {
                location.reload();
              });
            })
            .catch((error) => {
              console.error("Error deleting Naskah:", error.response || error);
              Swal.fire({
                title: "Error!",
                text: "There was an error deleting the file.",
                icon: "error"
              });
            });
        }
      });
    }
  }
  }
</script>