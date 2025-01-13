<template>
    <div class="flex flex-col min-h-screen">
        <sidebar />
        <div class="relative flex-1 md:ml-64 bg-blueGray-100">
            <admin-navbar-dashboard />
            <header-stats />
            <div class="px-4 md:px-20 mx-auto w-full -m-24">
                <router-view />
            </div>
        </div>
        <footer-admin />
    </div>
</template>
<script>
import AdminNavbarDashboard from "@/components/Navbars/AdminNavbarDashboard.vue";
import Sidebar from "@/components/Sidebar/Sidebar.vue";
import HeaderStats from "@/components/Headers/HeaderStats.vue";
import FooterAdmin from "@/components/Footers/FooterAdmin.vue";
export default {
    name: "admin-layout",
    components: {
        AdminNavbarDashboard,
        Sidebar,
        HeaderStats,
        FooterAdmin,
    },
};
</script>