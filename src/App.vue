<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg" style="background-color:#00448d;">
      <div class="container-fluid">
        <a class="navbar-brand" href="/Jobs2">
          <img src="/CadarnLogo.svg" alt="Cadarn Logo" width="200" >
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon navbar-dark print-hide"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="color:white;">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="/" style="color:white;">Home</a>
            </li>
            <li class="nav-item">
              <a v-if="!loggedIn" class="nav-link" @click="login" style="color:white;">Login</a>
              <a v-else class="nav-link" @click="logout" style="color:white;">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
  <router-view/>
</template>

<script>
export default {
  data() {
    return {
      loggedIn: false
    }
  },
  methods: {
    login() {
      // Perform login logic
      console.log("login")
      this.loggedIn = true;
      // Redirect to the desired route after successful login
      this.$router.push('/Login');
    },
    logout() {
      // Perform logout logic
      this.loggedIn = false;
      console.log("logout")
      // Redirect to the home page or any other desired route after logout
      this.$router.push('/');
    }
  }
}
</script>

<style>
#app {
  text-align: center;
}

.nav-link:hover{
  cursor: pointer;
}
</style>
