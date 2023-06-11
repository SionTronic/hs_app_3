<template>
    <div>
      <p>Operating System: {{ os }}</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        os: null
      };
    },
    mounted() {
      this.os = navigator.platform;
    }
  };
  </script>
  