<template>
  <!-- Section: Design Block -->
  <section class="text-center">
    <!-- Background image -->
    <div class="p-5 bg-image" style="
        background-image: url('https://mdbootstrap.com/img/new/textures/full/171.jpg');
        height: 330px;
      ">
      <h2 class="fw-bold text-white">Sign in now</h2>
    </div>

    <div class="container" style="margin-top:-180px">
      <form @submit.prevent="submit">
        <div class="card" style="background: hsla(0, 0%, 100%, 0.8); backdrop-filter: blur(30px);">
          <div class="card-body py-4">
            <div class="row d-flex justify-content-center">
              <div class="col-md-4">
                <!-- Email input -->
                <div class="form-outline">
                  <input v-model="form.email" required="required" type="email" id="form3Example3" class="form-control" />
                  <label class="form-label" for="form3Example3">Email address</label>
                </div>
              </div>
              <div class="col-md-4">
                <!-- Password input -->
                <div class="form-outline">
                  <input v-model="form.password" required="required" type="password" id="form3Example4" class="form-control" />
                  <label class="form-label" for="form3Example4">Password</label>
                </div>
              </div>
              <div class="col-md-2">
                <!-- Submit button -->
                <button type="submit" class="btn btn-success btn-block">
                  Sign in
                </button>
                <router-link to="/register" class="btn btn-primary btn-block">Sign up</router-link>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- Section: Design Block -->
</template>

<script>
export default {
  data(){
    return {
      form: {
        email: null,
        password: null
      }
    }
  },
  methods: {
    async submit(){
      const response = await this.axios.post('/api/user/login', this.form);

      this.$root.setAccessToken(response.data.access_token);
      this.$root.getAccessTokenUser().then(() => {
        this.$router.push('/dashboard');
      }).catch(() => {});
    }
  }
}
</script>
