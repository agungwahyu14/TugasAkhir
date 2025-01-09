import { createApp } from "vue";
import { createWebHistory, createRouter } from "vue-router";

// styles

import "@fortawesome/fontawesome-free/css/all.min.css";
import "@/assets/styles/tailwind.css";

// mouting point for the whole app

import App from "@/App.vue";

// layouts

import Admin from "@/layouts/Admin.vue";
import Auth from "@/layouts/Auth.vue";

// views for Admin layout

import Dashboard from "@/views/admin/Dashboard.vue";
import Settings from "@/views/admin/Settings.vue";
import Tables from "@/views/admin/Tables.vue";
import Maps from "@/views/admin/Maps.vue";
import ArsipStatis from "@/views/admin/ArsipStatis.vue";
import ArsipDinamis from "@/views/admin/ArsipDinamis.vue";
import SuratDisposisi from "@/views/admin/SuratDisposisi.vue";
import NaskahMasuk from "@/views/admin/NaskahMasuk.vue";
import NaskahKeluar from "@/views/admin/NaskahKeluar.vue";
import UserJabatan from "@/views/admin/UserJabatan.vue";
import UserPegawai from "@/views/admin/UserPegawai.vue";


// views for Auth layout

import Login from "@/views/auth/Login.vue";
import Register from "@/views/auth/Register.vue";

// views without layouts

import Landing from "@/views/Landing.vue";
import Profile from "@/views/Profile.vue";
import Index from "@/views/Index.vue";

// routes

const routes = [
  {
    path: "/admin",
    redirect: "/admin/dashboard",
    component: Admin,
    children: [
      {
        path: "/admin/dashboard",
        component: Dashboard,
      },
      {
        path: "/admin/settings",
        component: Settings,
      },
      {
        path: "/admin/tables",
        component: Tables,
      },
      {
        path: "/admin/maps",
        component: Maps,
      },
// Arsip
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
        path: "/admin/naskah-masuk",
        component: NaskahMasuk,
      },
      {
        path: "/admin/naskah-keluar",
        component: NaskahKeluar,
      },
      // Pegawai
      {
        path: "/admin/user-jabatan",
        component: UserJabatan,
      },
      {
        path: "/admin/user-pegawai",
        component: UserPegawai,
      },

    ],
  },
  {
    path: "/auth",
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
  {
    path: "/landing",
    component: Landing,
  },
  {
    path: "/profile",
    component: Profile,
  },
  {
    path: "/",
    component: Index,
  },
  { path: "/:pathMatch(.*)*", redirect: "/" },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

createApp(App).use(router).mount("#app");
