<template>
  <div class="flex flex-col min-h-screen bg-blueGray-100">
    <sidebar />
    <div class="relative flex-1 md:ml-64 bg-blueGray-100">
      <admin-navbar />
      <div class="px-4 md:px-20 mx-auto w-full -m-24">
        <router-view />
      </div>
    </div>
    <footer-admin />
  </div>
</template>

<script>
import AdminNavbar from "@/components/Navbars/AdminNavbar.vue";
import Sidebar from "@/components/Sidebar/Sidebar.vue";
// import HeaderStats from "@/components/Headers/HeaderStats.vue";
import FooterAdmin from "@/components/Footers/FooterAdmin.vue";
export default {
  name: "admin-layout",
  components: {
    AdminNavbar,
    Sidebar,
    // HeaderStats,
    FooterAdmin,
  },
};
</script>
