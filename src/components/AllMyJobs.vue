<template>
    <h1>All My Jobs</h1>
    <div v-for = "job in jobs" :key="job.id" class="jobs" >
        <router-link :to="{ name: 'Job', params: { id: job.id } }">
                <p :class="{ 'Completed': job.Status === 'Completed' }" >{{ job.jobNumber }} - {{ job.street }}, {{ job.city }}, Status - {{ job.jobStatus }} </p>
        </router-link >
          </div>
    
  </template>
  
  <script>

import axios from 'axios';

  export default {
   
      props:['myName'],
    data() {
          return {
          jobs: {}
          }
          const name=createNode()
      },
      mounted(){
      this.getOptionsFromTable('customerdata')
        },
        methods: {
            async getOptionsFromTable(table) {
        return axios
            .get(`http://localhost:8000/databaseAPI.php?table=${table}`)
            .then((response) => {
            if (Array.isArray(response.data)) { // Check if response.data is an array
                if(this.myName === "Caryl" ||this.myName === "Catrin" ||this.myName === "Ifan"){
                    this.jobs = response.data
                }else{
                    this.jobs = response.data.filter((job) =>
                    (job.pM === this.myName ||
                    job.engineer === this.myName ||
                    job.technician === this.myName) );
                    }
            }else {
                console.log("Invalid response data format");
            }
            })
            .catch((error) => {
            console.log(error);
            });
        },
       
     }
}
  </script>
  <style scoped>
.Completed {
    /* CSS styles for the 'Completed' class */
    /* For example: */
    background-color: gray;
  }
  </style>