<template>
  <div class="app-container vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <router-link to="/" class="navbar-brand">{{ $root.ui.name }}</router-link>
        <div class="d-flex">
          <div v-if="$root.auth.user" class="navbar-nav">
            <router-link to= "/create" class="nav-item nav-link">Create New</router-link>
            <router-link to="/dashboard" class="nav-item nav-link">All Events</router-link>
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
    <div v-show="$root.ui.loading" class="loading-screen align-items-center justify-content-center">
      <div class="spinner"></div>
    </div>
  </div>
</template>

<style>
  .loading-screen {
    background-color: rgba(255, 255, 255, 0.9);
    display: flex;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
  .spinner {
    border: 16px solid #f3f3f3;
    border-top: 16px solid #3498db;
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
  }
  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>