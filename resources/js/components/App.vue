<template>
  <div class="app-container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <router-link to="/" class="navbar-brand">{{ $root.appName }}</router-link>
        <div class="d-flex">
          <div v-if="$root.auth.user" class="navbar-nav">
            <router-link to= "/create" class="nav-item nav-link">Create New</router-link>
            <router-link to="/dashboard" class="nav-item nav-link">All Appointments</router-link>
            <a @click="$root.logout" href="#" class="nav-item nav-link">Logout</a>
          </div>
          <div v-else="" class="navbar-nav">
            <router-link to= "/register" class="nav-item nav-link">Register</router-link>
            <router-link to="/login" class="nav-item nav-link">Login</router-link>
          </div>
        </div>
      </div>
    </nav>
    <router-view></router-view>
  </div>
</template>
