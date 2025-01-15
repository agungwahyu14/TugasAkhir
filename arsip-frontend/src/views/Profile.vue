<template>
  <div>
    <navbar />
    <main class="profile-page">
      <section class="relative block h-500-px">
        <div
          class="absolute top-0 w-full h-full bg-center bg-cover"
          style="
            background-image: url('https://images.unsplash.com/photo-1499336315816-097655dcfbda?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=2710&q=80');
          "
        >
          <span
            id="blackOverlay"
            class="w-full h-full absolute opacity-50 bg-black"
          ></span>
        </div>
        <div
          class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-70-px"
          style="transform: translateZ(0);"
        >
          <svg
            class="absolute bottom-0 overflow-hidden"
            xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="none"
            version="1.1"
            viewBox="0 0 2560 100"
            x="0"
            y="0"
          >
            <polygon
              class="text-blueGray-200 fill-current"
              points="2560 0 2560 100 0 100"
            ></polygon>
          </svg>
        </div>
      </section>
      <section class="relative py-16 bg-blueGray-200">
        <div class="container mx-auto px-4">
          <div
            class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64"
          >
            <div class="px-6">
              <div class="flex flex-wrap justify-center">
                <div
                  class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center"
                >
                  <div class="relative">
                    <img
                      alt="..."
                      :src="team2"
                      class="shadow-xl rounded-full h-auto align-middle border-none absolute -m-16 -ml-20 lg:-ml-16 max-w-150-px"
                    />
                  </div>
                </div>

              </div>
              <div class="text-center mt-32">
                <h3
                  class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2"
                >
                {{ userData ? userData.nama : 'User Name' }}
                </h3>
                <div class="mb-2 text-blueGray-600 mt-10">
                  <i
                    class="fas fa-lock mr-2 text-lg text-blueGray-400"
                  ></i>
                  {{ userData ? userData.nip : '-' }}
                </div>
                <div class="mb-2 text-blueGray-600 mt-3">
                  <i
                    class="fas fa-user-tie mr-2 text-lg text-blueGray-400"
                  ></i>
                  {{ bidangLabel }}
                </div>
                <div class="mb-2 text-blueGray-600 mt-3">
                  <i
                    class="fas fa-envelope mr-2 text-lg text-blueGray-400"
                  ></i>
                  {{ userData ? userData.email : '-' }}
                </div>
                <div class="mb-2 text-blueGray-600 mt-5">
                  <span :class="{
                      'bg-emerald-600': userData && userData.status === 'aktif',
                      'bg-red-500': userData && userData.status === 'tidak aktif'
                    }" class="text-white px-3 py-1 rounded">
                    {{ userData ? userData.status : '-' }}
                  </span>
                </div>
              </div>
              <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                <div class="flex flex-wrap justify-center">
                  <div class="w-full lg:w-9/12 px-4">
                    <p class="mb-4 text-lg leading-relaxed text-blueGray-700">
                      An artist of considerable range, Jenna the name taken by
                      Melbourne-raised, Brooklyn-based Nick Murphy writes,
                      performs and records all of his own music, giving it a
                      warm, intimate feel with a solid groove structure. An
                      artist of considerable range.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
    <footer-admin />
  </div>
</template>
<script>
import Navbar from "@/components/Navbars/AuthNavbar.vue";
import FooterAdmin from "@/components/Footers/FooterAdmin.vue";

import team2 from "@/assets/img/user.png";

export default {
  data() {
    return {
      team2,
      userData: null,
    };
  },
  components: {
    Navbar,
    FooterAdmin,
  },
  computed: {
    bidangLabel() {
      if (this.userData) {
        switch (this.userData.bidang) {
          case 'kadis':
            return 'Kepala Dinas';
          case 'sekdis':
            return 'Sekretaris Dinas';
          case 'kabag':
            return 'Kepala Bagian';
          case 'staff':
            return 'Staff';
          default:
            return '-';
        }
      }
      return '-'; // Default jika userData atau bidang tidak ada
    },
  },
  mounted() {
    this.userData = this.getDataFromSessionStorage();
  },
  methods: {
    getDataFromSessionStorage() {
      const data = sessionStorage.getItem('user');
      if (data) {
        try {
          return JSON.parse(data);
        } catch (error) {
          console.error('Error parsing sessionStorage data:', error);
          return null;
        }
      } else {
        console.log(`No data found for ke}`);
        return null;
      }
    },
  },
};
</script>
