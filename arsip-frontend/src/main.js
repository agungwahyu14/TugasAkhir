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
// import ArsipStatis from "@/views/admin/arsipstatis/ArsipStatis.vue";
// import ArsipDinamis from "@/views/admin/arsipdinamis/ArsipDinamis.vue";
// Disposisi
import SuratDisposisi from "@/views/admin/suratdisposisi/SuratDisposisi.vue";
import TambahSuratDisposisi from "@/views/admin/suratdisposisi/TambahSuratDisposisi.vue";
import EditSuratDisposisi from "@/views/admin/suratdisposisi/EditSuratDisposisi.vue";
import DetailSuratDisposisi from "@/views/admin/suratdisposisi/DetailSuratDisposisi.vue";

// Naskah Masuk
import NaskahMasuk from "@/views/admin/naskahmasuk/NaskahMasuk.vue";
import TambahNaskahMasuk from "@/views/admin/naskahmasuk/TambahNaskahMasuk.vue";
import EditNaskahMasuk from "@/views/admin/naskahmasuk/EditNaskahMasuk.vue";
import DetailNaskahMasuk from "@/views/admin/naskahmasuk/DetailNaskahMasuk.vue";
// Naskah Keluar
import NaskahKeluar from "@/views/admin/naskahkeluar/NaskahKeluar.vue";
import DetailNaskahKeluar from "@/views/admin/naskahkeluar/DetailNaskahKeluar.vue";
import TambahNaskahKeluar from "@/views/admin/naskahkeluar/TambahNaskahKeluar.vue";
import EditNaskahKeluar from "@/views/admin/naskahkeluar/EditNaskahKeluar.vue";
// Pegawai
import UserPegawai from "@/views/admin/pegawai/UserPegawai.vue";
import TambahUserPegawai from "@/views/admin/pegawai/TambahUserPegawai.vue";
import EditUserPegawai from "@/views/admin/pegawai/EditUserPegawai.vue";

// Admin
import UserAdmin from "@/views/admin/pegawai/UserAdmin.vue";
import TambahUserAdmin from "@/views/admin/pegawai/TambahUserAdmin.vue";
import EditUserAdmin from "@/views/admin/pegawai/EditUserAdmin.vue";

// views for Auth layout

import Login from "@/views/auth/Login.vue";
import Register from "@/views/auth/Register.vue";


// views for Berkas Arsip
import BerkasArsip from "@/views/admin/berkasarsip/BerkasArsip.vue"
import TambahBerkasArsip from "@/views/admin/berkasarsip/TambahBerkasArsip.vue"
import EditBerkasArsip from "@/views/admin/berkasarsip/EditBerkasArsip.vue"
import DetailBerkasArsip from "./views/admin/berkasarsip/DetailBerkasArsip.vue";
// views without layouts

// import Landing from "@/views/Landing.vue";
import Profile from "@/views/Profile.vue";
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
        path:'/admin/profile',
        component: Profile
      },

      // {
      //   path: "/admin/arsipstatis/arsip-statis",
      //   component: ArsipStatis,
      // },
      // {
      //   path: "/admin/arsipdinamis/arsip-dinamis",
      //   component: ArsipDinamis,
      // },
      // Disposisi
      {
        path: "/admin/suratdisposisi/surat-disposisi",
        component: SuratDisposisi,
      },
      {
        path: "/admin/suratdisposisi/tambah-surat-disposisi",
        component: TambahSuratDisposisi,
      },
      {
        path: "/admin/disposisimasuk/edit-disposisi-masuk/:id_disposisi",
        component: EditSuratDisposisi,
      },
      {
        path: "/admin/disposisimasuk/detail-disposisi-masuk/:id_disposisi",
        component: DetailSuratDisposisi,
      },

     
     
      // Pegawai
      {
        path: "/admin/pegawai/user-pegawai",
        component: UserPegawai,
      },
      {
        path: "/admin/pegawai/user-admin",
        component: UserAdmin,
      },
      // Crud Naskah Masuk
      {
        path: "/admin/naskahmasuk/naskah-masuk",
        component: NaskahMasuk,
      },
      {
        
        path: "/admin/naskahmasuk/tambah-naskah-masuk",
        component: TambahNaskahMasuk,
      },
      {
        path: "/admin/naskahmasuk/edit-naskah-masuk/:id_naskah_masuk",
        component: EditNaskahMasuk,
      },

      {
        path: "/admin/naskahmasuk/detail-naskah-masuk/:id_naskah_masuk",
        component: DetailNaskahMasuk,
      },
       // Crud Naskah Keluar
       {
        path: "/admin/naskahkeluar/naskah-keluar",
        component: NaskahKeluar,
      },
       {
        path: "/admin/naskahkeluar/tambah-naskah-keluar",
        component: TambahNaskahKeluar,
      },
      {
        path: "/admin/naskahkeluar/edit-naskah-keluar/:id_naskah_keluar",
        component: EditNaskahKeluar,
      },

      {
        path: "/admin/naskahkeluar/detail-naskah-keluar/:id_naskah_keluar",
        component: DetailNaskahKeluar,
      },

      // Crud Pegawai
      {
        path: "/admin/pegawai/tambah-user-pegawai",
        component: TambahUserPegawai,
      },
      {
        path: '/admin/pegawai/edit-user-pegawai/:nip',
        name: 'EditUserPegawai',
        component: EditUserPegawai,
        props: true, // Agar parameter 'nip' diteruskan sebagai props ke komponen
    },

    // Crud Admin
    {
      path: "/admin/pegawai/tambah-user-admin",
      component: TambahUserAdmin,
    },
    {
      path: '/admin/pegawai/edit-user-admin/:nip',
      name: 'EditUserAdmin',
      component: EditUserAdmin,
      props: true, // Agar parameter 'nip' diteruskan sebagai props ke komponen
    },

    // Berkas Arsip
      {
        path:'/admin/berkas-arsip',
        component:BerkasArsip
      },
      {
        path:'/admin/berkas-arsip/tambah-berkas-arsip',
        component:TambahBerkasArsip
      },
      {
        path:'/admin/berkas-arsip/edit-berkas-arsip/:id',
        component:EditBerkasArsip,
        props: true,
        name:'EditBerkasArsip'
      },
      {
        path: "/admin/berkas-arsip/detail-berkas-arsip/:id",
        component: DetailBerkasArsip,
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
