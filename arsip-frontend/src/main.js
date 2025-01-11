import { createApp } from "vue";
import { createWebHistory, createRouter } from "vue-router";


// styles

import 'flowbite';
import "@fortawesome/fontawesome-free/css/all.min.css";
import "@/assets/styles/tailwind.css";

// mouting point for the whole app

import App from "@/App.vue";

// layouts
import AdminDashboard from "@/layouts/AdminDashboard.vue";
import Admin from "@/layouts/Admin.vue";
import Auth from "@/layouts/Auth.vue";

// views for Admin layout

// import Dashboard from "@/views/admin/Dashboard.vue";
// import Settings from "@/views/admin/Settings.vue";
// import Tables from "@/views/admin/Tables.vue";
// import Maps from "@/views/admin/Maps.vue";
import ArsipStatis from "@/views/admin/ArsipStatis.vue";
import ArsipDinamis from "@/views/admin/ArsipDinamis.vue";
import SuratDisposisi from "@/views/admin/SuratDisposisi.vue";
import NaskahMasuk from "@/views/admin/naskahmasuk/NaskahMasuk.vue";
import NaskahKeluar from "@/views/admin/naskahkeluar/NaskahKeluar.vue";
import UserJabatan from "@/views/admin/UserJabatan.vue";
import UserPegawai from "@/views/admin/pegawai/UserPegawai.vue";
import TambahNaskahMasuk from "@/views/admin/naskahmasuk/TambahNaskahMasuk.vue";
import EditNaskahMasuk from "@/views/admin/naskahmasuk/EditNaskahMasuk.vue";
import TambahNaskahKeluar from "@/views/admin/naskahkeluar/TambahNaskahKeluar.vue";
import EditNaskahKeluar from "@/views/admin/naskahkeluar/EditNaskahKeluar.vue";


// views for Auth layout

import Login from "@/views/auth/Login.vue";
import Register from "@/views/auth/Register.vue";

// views without layouts

// import Landing from "@/views/Landing.vue";
// import Profile from "@/views/Profile.vue";
// import Index from "@/views/Index.vue";

// routes

const routes = [
  {
    path: "/admindashboard",
    component: AdminDashboard,
  },
  {
    path: "/admin",
    component: Admin,
    children: [
      {
        path: "/admin/arsip-statis",
        component: ArsipStatis,
      },
      {
        path: "/admin/arsip-dinamis",
        component: ArsipDinamis,
      },
      {
        path: "/admin/surat-disposisi",
        component: SuratDisposisi,
      },
      {
        path: "/admin/naskah/naskah-masuk",
        component: NaskahMasuk,
      },
      {
        path: "/admin/naskah/naskah-keluar",
        component: NaskahKeluar,
      },
      // Pegawai
      {
        path: "/admin/user-jabatan",
        component: UserJabatan,
      },
      {
        path: "/admin/pegawai/user-pegawai",
        component: UserPegawai,
      },
      // Crud Naskah Masuk
      {
        path: "/admin/naskah/tambah-naskah-masuk",
        component: TambahNaskahMasuk,
      },
      {
        path: "/admin/naskah/edit-naskah-masuk",
        component: EditNaskahMasuk,
      },
   
       // Crud Naskah Keluar
       {
        path: "/admin/naskah/tambah-naskah-keluar",
        component: TambahNaskahKeluar,
      },
      {
        path: "/admin/naskah/edit-naskah-keluar",
        component: EditNaskahKeluar,
      },
   

    ],
  },
  {
    path: "/",
    redirect: "/auth/login",
    component: Auth,
    children: [
      {
        path: "/auth/login",
        component: Login,
      },
      {
        path: "/auth/register",
        component: Register,
      },
    ],
  },

  { path: "/:pathMatch(.*)*", redirect: "/" },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

createApp(App).use(router).mount("#app");
