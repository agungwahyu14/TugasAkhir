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
                                Detail Naskah Keluar
                            </h3>

                            <router-link to="/admin/naskahkeluar/naskah-keluar"
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
                                <h3>Nomor Naskah</h3>
                                <p>{{ naskaKeluar.no_naskah }}</p>
                            </div>
                            <div class="bg-blue-400">
                                <h3>Tanggal Naskah</h3>
                                <p>{{ naskaKeluar.tgl_naskah }}</p>
                            </div>
                            <div class="bg-blue-500 mt-3">
                                <h3>Perihal</h3>
                                <p>{{ naskaKeluar.perihal }}</p>
                            </div>
                            <div class="bg-blue-500 mt-3">
                                <h3>Asal Naskah</h3>
                                <p>{{ naskaKeluar.asal_naskah }}</p>
                            </div>
                        </div>

                        <!-- Select Dropdowns -->

                        <div class="mb-4 pt-0 mr-2 mt-4">
                            <select id="jenis_naskah" name="jenis_naskah" disabled
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <option value="" class="text-sm font-semibold">
                                    {{ naskaKeluar.jenis_naskah }}
                                </option>
                            </select>
                        </div>



                        <div class="mb-4 pt-0 mr-2 mt-4">
                            <select id="tujuan" name="tujuan" disabled
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <option value="" class="text-sm font-semibold">
                                    {{ naskaKeluar.tujuan == 'kadis' ? 'Kepala Dinas' : naskaKeluar.tujuan == 'sekdis' ?
                                        'Sekretasris Dinas' :
                                        'Kepala Bagian' }}
                                </option>
                            </select>
                        </div>

                        <!-- Lampiran Section -->

                        <div class="mb-4 pt-0 mr-2">
                            <div
                                class="px-3 py-3 placeholder-blueGray-300 text-blueGray-600 relative bg-white rounded text-sm border border-blueGray-300 outline-none focus:outline-none focus:shadow-outline w-full pr-10">
                                <iframe :src="`http://127.0.0.1:8000/storage/${naskaKeluar.file}`"
                                    class="relative w-full rounded h-600-px" frameborder="0"></iframe>
                                <hr class="md:min-w-full mt-3" />
                            </div>
                        </div>

                        <div class="mb-4 pt-0 mr-2 mt-4" v-if="naskaKeluar.tujuan === 'kadis'">
                            <button @click="openWhatsApp"
                                class="text-white rounded bg-emerald-500 text-xs px-4 py-3 relative w-full pr-10">
                                <i class="fab fa-whatsapp text-sm"></i> Whatsapp
                            </button>
                        </div>

                        <!-- Pesan Default -->
                        <div v-else class="mb-4 pt-0 mr-2 mt-4">
                            <button class="text-white rounded bg-emerald-500 text-xs px-4 py-3 relative w-full pr-10"
                                @click="openAccept">
                                <i class="fa-solid fa-check"></i> Accept
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

export default {
    name: "EditNaskahKeluar",
    data() {
        return {
            naskaKeluar: {
                no_naskah: "",
                jenis_naskah: "",
                perihal: "",
                asal_naskah: "",
                tujuan: "",
                tgl_naskah: "",
                status: "",
                file: "",
            },
        };
    },
    mounted() {
        const naskahID = this.$route.params.id_naskah_keluar;
        this.fetchNaskah(naskahID);
    },
    methods: {
        async fetchNaskah(id_naskah_keluar) {
            try {
                const token = sessionStorage.getItem("token");
                const response = await axios.get(
                    `http://127.0.0.1:8000/api/naskah-keluars/${id_naskah_keluar}`,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                console.log("Fetch Detail Naskah Masuk Response:", response); // Print seluruh response
                console.log("Data Detail Naskah Masuk:", response.data.data); //
                this.naskaKeluar = response.data.data;
            } catch (error) {
                console.error("Error fetching data:", error.response || error);
            }
        },

        async openWhatsApp() {
            const naskahID = this.$route.params.id_naskah_keluar;
            const nip = sessionStorage.getItem("nip");

            try {
                const { value: formValues } = await Swal.fire({
                    title: "Document Details",
                    html: `
      <style>
        .swal2-input {
          width: 100%;
          padding: 10px;
          margin: 5px 0;
          border-radius: 5px;
          border: 1px solid #ccc;
          font-size: 14px;
        }

        /* Custom Style for Select */
        #swal-input2 {
          background-color: #f7f7f7;
          border-color: #ddd;
          font-weight: bold;
        }

        #swal-input2:focus {
          border-color: #5cb85c;
          box-shadow: 0 0 5px rgba(92, 184, 92, 0.5);
        }

        /* Style for Textarea */
        #swal-input3 {
          height: 100px;
          resize: vertical;
        }

        /* Left-align the label */
        label {
          font-size: 16px;
          font-weight: bold;
          color: #333;
          display: block;
          margin-bottom: 5px;
          text-align: left; /* Ensures label is aligned to the left */
        }
      </style>

      <label for="swal-input1">ID Naskah Masuk</label>
      <input id="swal-input1" class="swal2-input" value="${naskahID}" placeholder="Enter ID Naskah Masuk" disabled>
      
      <label for="swal-input2">Validasi</label>
      <select id="swal-input2" class="swal2-input">
        <option value="true">Benar</option>
        <option value="false">Salah</option>
      </select>
      
      <label for="swal-input3">Catatan</label>
      <textarea id="swal-input3" class="swal2-input" placeholder="Enter Catatan"></textarea>
      
      <label for="swal-input4">User NIP</label>
      <input id="swal-input4" value="${nip}" class="swal2-input" placeholder="Enter NIP" disabled>
    `,
                    focusConfirm: false,
                    preConfirm: () => {
                        return {
                            id_naskah_keluar: document.getElementById("swal-input1").value,
                            is_valid: document.getElementById("swal-input2").value,
                            catatan: document.getElementById("swal-input3").value,
                            nip: document.getElementById("swal-input4").value
                        };
                    },
                    confirmButtonText: "Send",  // Customize the button text
                });

                if (formValues) {
                    // Handle the form values here
                    console.log("Form Values:", formValues);

                    // Send the form data to the API
                    const token = sessionStorage.getItem("token");
                    const response = await axios.post(
                        `http://127.0.0.1:8000/api/naskah-keluars/sendWA`,
                        {
                            id_naskah_keluar: formValues.id_naskah_keluar,
                            is_valid: formValues.is_valid,
                            catatan: formValues.catatan,
                            nip: formValues.nip
                        },
                        {
                            headers: {
                                Authorization: `Bearer ${token}`,
                            },
                        }
                    );

                    console.log("Fetch Detail Naskah Masuk Response:", response); // Print the whole response
                    console.log("Data Detail Naskah Masuk:", response.data);

                    const whatsappLink = response.data.whatsapp_url;

                    console.log("apa isis dalamnya: ", whatsappLink);
                    // Print the response data

                    // Optionally update the `naskaKeluar` property if needed
                    // this.naskaKeluar = response.data.data;

                    Swal.fire({
                        title: 'Success',
                        text: 'Berhasil Mengirim',
                        icon: 'success',
                        showCancelButton: true,  // Show cancel button if needed
                        cancelButtonText: 'Close',  // Customize cancel button text
                        confirmButtonText: 'Open WhatsApp',  // Custom button to open WhatsApp link
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to the WhatsApp link
                            window.open(whatsappLink, '_blank');
                        }
                    });
                }
            } catch (error) {
                console.error("Error sending data:", error.response || error);
                Swal.fire("Error sending data. Please try again.");
            }
        },


        async openAccept() {
            try {
                const token = sessionStorage.getItem("token");
                const naskahID = this.$route.params.id_naskah_keluar;
                const response = await axios.post(
                    "http://127.0.0.1:8000/api/naskah-keluars/accepet",
                    { id_naskah_keluar: naskahID }, // Pass the naskahID as part of the data payload
                    {
                        headers: {
                            Authorization: `Bearer ${token}`, // Corrected template literal for Bearer token
                        },
                    }
                );
                console.log("Fetch Detail Naskah Masuk Response:", response); // Print the whole response
                console.log("Data Detail Naskah Masuk:", response.data.data); // Log the specific data
                this.naskaKeluar = response.data.data;
                this.$router.push("/admin/naskahkeluar/naskah-keluar");
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
