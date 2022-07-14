<template>
  <!-- Section: Design Block -->
  <section class="text-center">
    <!-- Background image -->
    <div class="p-5 bg-image" style="
        background-image: url('https://mdbootstrap.com/img/new/textures/full/171.jpg');
        height: 330px;
      ">
      <h2 class="fw-bold text-white">Sign up now</h2>
    </div>

    <div class="container" style="margin-top:-180px">
      <form @submit.prevent="submit">
        <div class="card" style="background: hsla(0, 0%, 100%, 0.8); backdrop-filter: blur(30px);">
          <div class="card-body py-4">
            <div class="row d-flex justify-content-center">
              <div class="col-md-3">
                <div class="form-outline">
                  <input v-model="form.name" required="required" type="text" id="form3Example1" class="form-control" />
                  <label class="form-label" for="form3Example1">Full name</label>
                </div>
              </div>
              <div class="col-md-3">
                <!-- Email input -->
                <div class="form-outline">
                  <input v-model="form.email" required="required" type="email" id="form3Example3" class="form-control" />
                  <label class="form-label" for="form3Example3">Email address</label>
                </div>
              </div>
              <div class="col-md-3">
                <!-- Password input -->
                <div class="form-outline">
                  <input v-model="form.password" required="required" type="password" id="form3Example4" class="form-control" />
                  <label class="form-label" for="form3Example4">Password</label>
                </div>
              </div>
              <div class="col-md-2">
                <!-- Submit button -->
                <button type="submit" class="btn btn-success btn-block">
                  Sign up
                </button>
                <router-link to="/login" class="btn btn-primary btn-block">Sign in</router-link>
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
          name: null,
          email: null,
          password: null
        }
      }
    },
    methods: {
      submit(){
        this.axios.post('/api/user/register', this.form).then(() => {
          this.$router.push('/login');
        }).catch(() => {});
      }
    }
  }
</script>
