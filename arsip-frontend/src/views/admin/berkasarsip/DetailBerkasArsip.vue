<template>
  <div class="flex flex-wrap mt-4">
    <div class="w-full mb-12 px-4">
      <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded"
        :class="[color === 'light' ? 'bg-white' : 'bg-emerald-900 text-white']">
        <div class="rounded-t mb-0 px-4 py-3 border-0">
          <div class="flex flex-wrap items-center">
            <div class="relative w-full px-4 max-w-full flex-grow flex-1 flex items-center justify-between mb-2">
              <h3 class="font-semibold text-lg text-blueGray">
                Detail Berkas Arsip
              </h3>

              <router-link to="/admin/berkas-arsip"
                class="bg-red-500 text-white font-bold px-4 py-3 mr-2 rounded shadow hover:bg-blue-600">
                Kembali
              </router-link>
            </div>
          </div>
        </div>
        <hr class="md:min-w-full" />

        <!-- Folder Grid -->
        <div class="p-6 m-3">
          <button 
            @click="addFolder(id_path)" 
            class="bg-emerald-500 text-white font-bold px-3 py-1 rounded shadow hover:bg-green-600"
          >
            <i class="fas fa-folder-plus"></i> Tambah Folder
          </button>

          <div class="flex flex-wrap gap-6 mt-3">
            <!-- Folder Items -->
            <div v-for="(folder, index) in folders" :key="index" 
                 class="flex flex-col items-center p-4 rounded-lg hover:bg-gray-100 cursor-pointer border border-transparent hover:border-gray-300 transition-all duration-200"
                 @click="viewFolderContents(folder.id)">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
              </svg>
              <span class="mt-2 text-sm font-medium">{{ folder.name }}</span>
              <!-- Folder Actions -->
              <div class="flex mt-3">
                <button @click.stop="deleteFolder(folder.id)" class="bg-red-500 p-2 text-white rounded-full text-xs mr-3">
                  <i class="fas fa-trash"></i>
                </button>
                <button  @click.stop="addSubFolder(folder.id,id_path)" class="bg-emerald-500 p-2 text-white rounded-full text-xs mr-3">
                    <i class="fas fa-folder-plus"></i>
                </button>
                <button  @click.stop="addFile(folder.id,id_path)" class="bg-emerald-800 p-2 text-white rounded-full text-xs mr-3">
                    <i class="fas fa-file-export"></i>
                </button>
              </div>
            </div>
          </div>
        </div>

      <!-- Folder Contents -->
      <div v-if="currentFolderContents.length > 0" class="p-6 m-3">
        <h3 class="font-semibold text-lg text-blueGray">Contents of Folder: {{ currentFolder.name }}</h3>
        <div class="flex flex-wrap gap-6 mt-3">
          <div v-for="(content, index) in currentFolderContents" :key="index" 
              class="flex flex-col items-center p-4 rounded-lg hover:bg-gray-100 cursor-pointer border border-transparent hover:border-gray-300 transition-all duration-200"
              @click="content.type === 'folder' ? viewFolderContents(content.id) : ''">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path v-if="content.type === 'folder'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6H10a2 2 0 00-2 2v12h-4V4a2 2 0 012-2z" />
            </svg>
            <span class="mt-2 text-sm font-medium">{{ content.name }}</span>
            <!-- File Actions -->
            <div class="flex mt-3">
              <button v-if="content.type === 'file'" @click.stop="viewFile(content.id, content.path, content.extension)" class="bg-orange-500 p-2 text-white rounded-full text-xs mr-3">
                <i class="fas fa-eye"></i>
              </button>
              <button v-if="content.type === 'file'" @click.stop="deleteFile(content.id)" class="bg-red-500 p-2 text-white rounded-full text-xs mr-3">
                <i class="fas fa-trash"></i>
              </button>
              <button v-if="content.type==='folder'" @click.stop="deleteFolder(content.id)" class="bg-red-500 p-2 text-white rounded-full text-xs mr-3">
                <i class="fas fa-trash"></i>
              </button>
              <button v-if="content.type==='folder'" @click.stop="addSubFolder(content.id, id_path)" class="bg-emerald-500 p-2 text-white rounded-full text-xs mr-3">
                <i class="fas fa-folder-plus"></i>
              </button>
              <button  v-if="content.type==='folder'" @click.stop="addFile(content.id,id_path)" class="bg-emerald-800 p-2 text-white rounded-full text-xs mr-3">
                    <i class="fas fa-file-export"></i>
                </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Handle Click on Parent Folder and Empty Folder -->
      <div v-if="isFolderEmpty && currentFolderContents.length === 0" class="p-6 m-3">
        <p class="text-center text-gray-500 mt-4">This folder is empty. Click another folder to view contents.</p>
      </div>

      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Swal from 'sweetalert2'
export default {
  name: "DetailBerkasArsip",
  data() {
    return {
      id_path:null,
      folders: [],
      currentFolderContents: [],
      currentFolder: {},
      isFolderEmpty: false
    };
  },
  mounted() {
    const id = this.$route.params.id;
    this.id_path = id;
    this.fetchFolder(id);
  },
  methods: {
    async fetchFolder(id) {
      const token = sessionStorage.getItem('token');
      axios
        .get(`http://127.0.0.1:8000/api/path-arsips/${id}`, {
          headers: {
            Authorization: `Bearer ${token}` 
          }
        })
        .then((response) => {
          this.folders = response.data.data.folders;
          if (this.folders.length === 0) {
            // Menampilkan pesan jika folder kosong
            Swal.fire({
              title: "Folder Kosong",
              text: "Tidak ada folder yang ditemukan di lokasi ini.",
              icon: "info"
            });
          }
        })
        .catch((error) => {
          console.error("Error fetching data:", error.response || error); 
        });
    },

    viewFolderContents(folderId) {
      const token = sessionStorage.getItem("token");
      axios
        .get(`http://127.0.0.1:8000/api/folders/${folderId}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          this.currentFolder = response.data;
          console.log(this.currentFolder.id)
          this.currentFolderContents = [
            ...response.data.children.map((child) => ({
              ...child,
              type: "folder",
            })),
            ...response.data.files.map((file) => ({
              ...file,
              type: "file",
              name: file.name,
            })),
          ];

          this.isFolderEmpty = this.currentFolderContents.length === 0;

          // Jika folder kosong, tampilkan pesan atau beri tahu pengguna
          if (this.isFolderEmpty) {
            Swal.fire({
              title: "Folder Kosong",
              text: "Tidak ada sub-folder atau file di dalam folder ini.",
              icon: "info",
            });
          }
        })
        .catch((error) => {
          console.error("Error fetching folder contents:", error.response || error);
        });
    },


    deleteFolder(folderId) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          const token = sessionStorage.getItem("token");
          axios
            .delete(`http://127.0.0.1:8000/api/folders/${folderId}/force`, {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            })
            .then((response) => {
              console.log(response);
              this.fetchFolder(this.currentFolder.id);
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
              }).then(() => {
                location.reload();
              });
            })
            .catch((error) => {
              console.error("Error deleting folder:", error.response || error);
              Swal.fire(
                'Error!',
                'There was an error deleting the folder.',
                'error'
              );
            });
        }
      });
    },


    deleteFile(fileId) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
      }).then((result) => {
        if (result.isConfirmed) {
          const token = sessionStorage.getItem("token");
          axios
            .delete(`http://127.0.0.1:8000/api/folders/${this.currentFolder.id}/file/${fileId}`, {
              headers: {
                Authorization: `Bearer ${token}`,
              },
            })
            .then((response) => {
              console.log(response);
              this.fetchFolder(this.currentFolder.id); // Refresh the folder contents
              Swal.fire({
                title: "Deleted!",
                text: "Your file has been deleted.",
                icon: "success"
              }).then(() => {
                location.reload();
              });
            })
            .catch((error) => {
              console.error("Error deleting file:", error.response || error);
              Swal.fire(
                'Error!',
                'There was an error deleting the file.',
                'error'
              );
            });
        }
      });
    },

    viewFile(fileId, filePath) {
      console.log("Viewing file with ID:", fileId);
      const fileUrl = `http://127.0.0.1:8000/storage/${filePath}`;
      window.open(fileUrl, "_blank");
    },

    addSubFolder(parentID,id_path) {
      Swal.fire({
        title: 'Enter folder name',
        input: 'text',
        inputPlaceholder: 'Folder name',
        showCancelButton: true,
        confirmButtonText: 'Create',
        cancelButtonText: 'Cancel',
      }).then((result) => {
        if (result.isConfirmed && result.value) {
          const folderName = result.value.trim();
          
          if (!folderName) {
            Swal.fire('Error!', 'Folder name cannot be empty.', 'error');
            return;
          }

          const token = sessionStorage.getItem('token');
          axios
            .post(`http://127.0.0.1:8000/api/folders`, 
              { 
                name: folderName,
                parent_id: parentID 
              }, 
              {
                headers: {
                  Authorization: `Bearer ${token}`,
                },
              }
            )
            .then((response) => {
              console.log(response);
              Swal.fire({
                title: "Created!",
                text: "Success create new folder.",
                icon: "success"
              }).then(() => {
               this.fetchFolder(id_path)
              });
            })
            .catch((error) => {
              console.error('Error creating folder:', error.response || error);
              Swal.fire('Error!', 'There was an error creating the folder.', 'error');
            });
        }
      });
    },
   
    addFolder(idPathArsip) {
      Swal.fire({
        title: 'Enter folder name',
        input: 'text',
        inputPlaceholder: 'Folder name',
        showCancelButton: true,
        confirmButtonText: 'Create',
        cancelButtonText: 'Cancel',
      }).then((result) => {
        if (result.isConfirmed && result.value) {
          const folderName = result.value.trim();
          
          if (!folderName) {
            Swal.fire('Error!', 'Folder name cannot be empty.', 'error');
            return;
          }

          const token = sessionStorage.getItem('token');
          axios
            .post(`http://127.0.0.1:8000/api/folders`, 
              { 
                name: folderName,
                path_arsip_id: idPathArsip 
              }, 
              {
                headers: {
                  Authorization: `Bearer ${token}`,
                },
              }
            )
            .then((response) => {
              console.log(response);
              Swal.fire({
                title: "Created!",
                text: "Success create new folder.",
                icon: "success"
              }).then(() => {
                location.reload();
              });
            })
            .catch((error) => {
              console.error('Error creating folder:', error.response || error);
              Swal.fire('Error!', 'There was an error creating the folder.', 'error');
            });
        }
      });
    },

    async addFile(folderId, idPathArsip) {
    const { value: file } = await Swal.fire({
      title: 'Pilih file untuk diunggah',
      input: 'file',
      inputAttributes: {
        'accept': '.doc,.docx,.pdf',
        'aria-label': 'Choose file'
      },
      showCancelButton: true,
      confirmButtonText: 'Upload',
      cancelButtonText: 'Cancel',
    });

    // Jika file dipilih
    if (file) {
      const formData = new FormData();
      formData.append('file', file);
      const token = sessionStorage.getItem('token');

      try {
        await axios.post(`http://127.0.0.1:8000/api/folders/${folderId}/upload`, formData, {
          headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'multipart/form-data'
          }
        });
        Swal.fire({
          title: 'Berhasil!',
          text: 'File berhasil diunggah.',
          icon: 'success'
        }).then(() => {
          this.fetchFolder(idPathArsip);
        });

      } catch (error) {
        console.error('Error uploading file:', error);
        Swal.fire({
          title: 'Gagal!',
          text: 'Terjadi kesalahan saat mengunggah file.',
          icon: 'error'
        });
      }
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

<style scoped>
/* Add any additional styling here */
</style>
