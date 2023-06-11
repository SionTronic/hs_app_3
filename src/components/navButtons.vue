<template>
   <div class="nav2">
    <button  class="button2 print-hide" @click="back">❮ Back</button>
    <button  class="button2 print-hide" @click="forward">Next ❯</button>
  </div>
</template>

<script>
export default {

  props:{
    isEdited:Boolean
  },
    methods: {
    redirect(){
      this.$router.push({name:'Home'})
    },
    back(){
      if (this.isEdited) {
        const confirmMessage = 'The form has unsaved changes. Are you sure you want to go back?';
        const shouldGoBack = window.confirm(confirmMessage);
        if (shouldGoBack) {
          this.$router.go(-1);
        }
      } else {
        this.$router.go(-1);
      }
    },
    forward(){
      this.$router.go(1)
    }

}
}
</script>

<style scoped>
.button{
  background:#f4f4f4;
    padding:20px;
    border: 1px solid rgb(0,68,141);
    border-radius: 10px;
    margin: 10px auto;
    max-width: 600px;
    cursor: pointer;
    color:#444;

}
.button a{
  text-decoration: none;
}
.nav2{
  display:flex;
  justify-content: space-between;
}
.button2{
    text-decoration: none;
    background:#fff;
    text-align:left;  
    padding:5px;
    border-radius: 4px;
    border: 1px solid rgb(0,68,141); 
    margin: 10px 10px 10px 10px;
    max-width: 600px;
    cursor: pointer;
    color:#444;
}

.button2:hover{
    background:rgba(0,68,141,0.5); 
    color:white;
}
</style>