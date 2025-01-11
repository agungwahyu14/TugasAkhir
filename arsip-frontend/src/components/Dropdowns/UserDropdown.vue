<template>
  <div>
    <a class="text-blueGray-500 block" href="#pablo" ref="btnDropdownRef" v-on:click="toggleDropdown($event)">
      <div class="items-center flex">
        <span class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full">
          <img alt="..." class="w-full rounded-full align-middle border-none shadow-lg" :src="image" />
        </span>
      </div>
    </a>
    <div ref="popoverDropdownRef"
      class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" v-bind:class="{
        hidden: !dropdownPopoverShow,
        block: dropdownPopoverShow,
      }">
      <a href="javascript:void(0);"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">
        Profile
      </a>
      <a href="javascript:void(0);"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">
        Settings
      </a>
      <a href="javascript:void(0);" @click="logout"
        class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">
        Logout
      </a>

    </div>
  </div>
</template>

<script>
import { createPopper } from "@popperjs/core";

import image from "@/assets/img/team-1-800x800.jpg";

export default {
  data() {
    return {
      dropdownPopoverShow: false,
      image: image,
    };
  },
  methods: {
    toggleDropdown: function (event) {
      event.preventDefault();
      this.dropdownPopoverShow = !this.dropdownPopoverShow;

      if (this.dropdownPopoverShow) {
        createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
          placement: "bottom-start", // Sesuaikan arah dropdown
        });
        // Tambahkan event listener untuk klik di luar
        document.addEventListener("click", this.handleOutsideClick);
      } else {
        // Hapus event listener saat dropdown ditutup
        document.removeEventListener("click", this.handleOutsideClick);
      }
    },
    handleOutsideClick(event) {
      if (
        !this.$refs.popoverDropdownRef.contains(event.target) &&
        !this.$refs.btnDropdownRef.contains(event.target)
      ) {
        this.dropdownPopoverShow = false;
        document.removeEventListener("click", this.handleOutsideClick);
      }
    },
    logout() {
      // Tampilkan dialog konfirmasi
      if (confirm("Apakah Anda yakin ingin logout?")) {
        // Hapus data dari localStorage
        localStorage.removeItem('token');
        localStorage.removeItem('user');

        // Redirect ke halaman login
        this.$router.push('/auth/login');


      } else {
        // Tampilkan pesan pembatalan (opsional)
        console.log("Logout dibatalkan");
      }
    },

  },
};
</script>
