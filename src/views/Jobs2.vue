<template>
    <h1>All Jobs</h1>
    <span>Search </span>
    <input type="text" v-model="search">
    <newJobModal
        v-if="modalVisible"
        :myName="myName"
        :modalVisible="modalVisible"
        @close="closeModal" 
        @submit="submitNewJob">
    </newJobModal>
    <button @click="openModal" class="button2">Add</button>
    <p> {{ matchingJobs.length }} matches</p>
    <div v-if="jobs">
      <div v-for="job in matchingJobs" :key="job.jobName" class="jobs">
        <router-link :to="{name: 'Job', params: {id: job.id}}">
          <p>{{ job.jobNumber }} - {{ job.street }}, {{ job.city }} | Status - {{ job.Status }}</p>
        </router-link>
      </div>
    </div>
    <div v-else>
      <p>Loading ...</p>
    </div>
  </template>
  
  <script>
  import newJobModal from '@/components/newJobModal.vue'
import axios from 'axios'
import { computed, ref, watch, watchEffect } from 'vue'
  export default {
  
    setup() {
    const search = ref('');
    const jobs = ref([])
 

    watch (search, ()=>{
        console.log('watch ran')
        //console.log(jobs)
    });

    watchEffect(() => {
        console.log('watchEffect ran', search.value);
    });

    const matchingJobs = computed(() => {
        return jobs.value.filter(job => job.jobName.includes(search.value));
      });
     
      return {jobs, search, matchingJobs };
    },
    components:{newJobModal},
    data(){
      return{
        modalVisible: false,
        myName:'Admin'
    }
      
    },
    mounted(){
      this.getOptionsFromTable('customerdata');
    },
    methods:{
      async getOptionsFromTable(table) {
        return axios
            // .get(`http://localhost:8000/databaseAPI.php?table=${table}`)
            .get(`databaseAPI.php?table=${table}`)
            .then((response) => {
            if (Array.isArray(response.data)) { // Check if response.data is an array
                    this.jobs = response.data
            }else {
                console.log("Invalid response data format");
            }
            })
            .catch((error) => {
            console.log(error);
            });     
      },
      openModal() {
      this.modalVisible = true
      document.body.classList.add('modal-open');
      console.log(this.modalVisible) 
    },
      
    closeModal(){
      console.log("close modal")
      document.body.classList.remove('modal-open');
      this.modalVisible=false
    },

    submitNewJob(data){
      console.log("Submit New Job")
      console.log(data)
      this.recordTableData("createNewJob",data)
      this.getTableData('customerdata', this.myName)
      this.closeModal
    },
    }
      
  };
  </script>
    
    <style>
   body.modal-open {
    overflow: hidden;
  }
    
    .jobs p{
        background:#f4f4f4;
        padding:5px;
        border: 1px solid rgb(0,68,141);
        border-radius: 10px;
        margin: 10px auto ;
        max-width: 600px;
        cursor: pointer;
        color:#444;
    }
    .jobs p:hover{
        background:#ddd;
    }
    .jobs a{
        text-decoration: none;
    }
    </style>