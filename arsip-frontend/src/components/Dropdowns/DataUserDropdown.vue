<template>
    <div>

        <a href="#pablo" ref="btnDropdownRef" @click.prevent="toggleDropdown"
            class="text-xs uppercase py-3 font-bold block flex justify-between items-center" :class="[
                isActive ? 'text-emerald-500 hover:text-emerald-600' : 'text-blueGray-700 hover:text-blueGray-500'
            ]">
            <!-- Ikon tools -->
            <span class="flex items-center">
                <i class="fas fa-archive mr-2 text-sm" :class="isActive ? 'opacity-75' : 'text-blueGray-300'">
                </i>
                Data User
            </span>
            <!-- Ikon panah bawah -->
            <i class="fas fa-chevron-down ml-2 text-sm" :class="[isActive ? 'opacity-75' : 'text-blueGray-300']">
            </i>
        </a>

        <div ref="popoverDropdownRef"
            class="bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" v-bind:class="{
                hidden: !dropdownPopoverShow,
                block: dropdownPopoverShow,
            }">

            <router-link to="/admin/pegawai/user-pegawai"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                @click="hideDropdown">
                Data Pegawai
            </router-link>

            <router-link v-if="isAdminAvailable" to="/admin/pegawai/user-admin"
                class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700"
                @click="hideDropdown">
                Data Admin
            </router-link>




        </div>
    </div>
</template>
<script>
import { createPopper } from "@popperjs/core";

export default {
    data() {
        return {
            dropdownPopoverShow: false,
            isActive: false,
        };
    },
    computed: {
        isAdminAvailable() {
            // Ambil nilai bidang dari sessionStorage
            const bidang = sessionStorage.getItem('bidang');
            // Return true jika bidang adalah salah satu dari nilai yang diinginkan
            return ['kadis', 'sekdis', 'kabag'].includes(bidang);
        }
    },
    methods: {
        toggleDropdown: function (event) {
            event.preventDefault();
            if (this.dropdownPopoverShow) {
                this.dropdownPopoverShow = false;
                this.isActive = false;
                document.removeEventListener("click", this.handleOutsideClick);

            } else {
                this.dropdownPopoverShow = true;
                this.isActive = true;
                createPopper(this.$refs.btnDropdownRef, this.$refs.popoverDropdownRef, {
                    placement: "bottom-end",
                });
                document.addEventListener("click", this.handleOutsideClick);
            }
        },
        handleOutsideClick(event) {
            if (
                !this.$refs.popoverDropdownRef.contains(event.target) &&
                !this.$refs.btnDropdownRef.contains(event.target)
            ) {
                this.dropdownPopoverShow = false;
                this.isActive = false;
                document.removeEventListener("click", this.handleOutsideClick);
            }
        },
        hideDropdown() {
            this.dropdownPopoverShow = false;
            this.isActive = false;
            document.removeEventListener("click", this.handleOutsideClick);
        },

    },
};
</script>