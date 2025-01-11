<template>
  <div class="container mx-auto px-4 h-full">
    <div class="flex content-center items-center justify-center h-full">
      <div class="w-full lg:w-4/12 px-4">
        <div
          class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-200 border-0">
          <div class="rounded-t mb-0 px-6 py-6">
            <div class="text-center mb-3">
              <h6 class="text-blueGray-500 text-sm font-bold">
                Sign In
              </h6>
            </div>
            <hr class="mt-6 border-b-1 border-blueGray-300" />
          </div>
          <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
            <div class="text-blueGray-400 text-center mb-3 font-bold">
              <small>Welcome Home</small>
            </div>
            <form @submit.prevent="handleLogin">
              <div class="relative w-full mb-3">
                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="email">
                  Email
                </label>
                <input v-model="email" type="email" id="email"
                  class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                  placeholder="Email" required />
              </div>

              <div class="relative w-full mb-3">
                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="password">
                  Password
                </label>
                <input v-model="password" type="password" id="password"
                  class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                  placeholder="Password" required />
              </div>

              <div class="text-center mt-6">
                <button
                  class="bg-blueGray-800 text-white active:bg-blueGray-600 text-sm font-bold uppercase px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 w-full ease-linear transition-all duration-150"
                  type="submit" :disabled="loading">
                  Sign In
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="flex justify-center mt-6 relative">
          <div class="text-center">
            <router-link to="/auth/register" class="text-blueGray-200">
              <small>Create new account</small>
            </router-link>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      loading: false,
    };
  },
  methods: {
    async handleLogin() {
      this.loading = true;
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', {
          email: this.email,
          password: this.password,
        });

        const data = response.data;
        console.log('Login berhasil:', data);

        // Simpan token ke localStorage
        localStorage.setItem('token', data.token);

        // Simpan detail pengguna ke localStorage
        localStorage.setItem('user', JSON.stringify(data.user));

        // // Tampilkan pesan sukses (opsional)
        // alert(data.message);

        // Optionally, store token or redirect
        // Example: localStorage.setItem('token', response.data.token);
        this.$router.push('/admindashboard'); // Redirect to a dashboard or home page
      } catch (error) {
        // Handle login error
        console.error('Login failed:', error.response ? error.response.data : error.message);
        alert('Login failed. Please check your credentials.');
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>
