<template>
  <h1>Active Jobs</h1>
    <div v-for = "job in activeJobs" :key="job.id" class="jobs">
      <router-link :to="{ name: 'Job'  , params: { id: job.id}}" :active-jobs="activeJobs">
        <div class="row border p-1">
            <div class="col-md-5">
            <p>{{ job.jobName }}</p>
            </div>
            <div class="col-md-5">
                <div class="progress mt-3" role="progressbar" aria-label="Info example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" v-bind:style="{width: job.pcntComplete + '%'}">{{ job.pcntComplete }}% Complete</div>
                </div>
            </div>
            <div class="col-md-2">
              <router-link :to="{ name: 'General Risk Assessment', params: { id: job.id, jobName:job.jobName } }">
            <button class="btn btn-primary mt-1 mb-1 custom-btn">Risk Assessment</button>
          </router-link>
        </div>
        </div>
      </router-link>
    </div>
    <newJobModal
        v-if="modalVisible"
        :myName="myName"
        :modalVisible="modalVisible"
        @close="closeModal"
        @submit="submitNewJob">
    </newJobModal>
    <button @click="openModal" class="button2">Add</button>
  </template>
  
<script>
import axios from 'axios';
import newJobModal from '@/components/newJobModal.vue';

const dbUrl= 'databaseAPI.php';
export default {

props:['myName'],
data() {
      return {
      jobs: {},
      activeJobs:{},
      job:'',
      modalVisible: false,
      
      }
    },
components: {
newJobModal,
},

mounted(){
//this.getOptionsFromTable('customerdata')
this.getTableData('customerdata', this.myName)

},

methods: {
      openModal() {
      this.modalVisible = true
      console.log(this.modalVisible)
    },
      
    closeModal(){
      console.log("close modal")
      this.modalVisible=false
    },

    async submitNewJob(data){
      console.log("Submit New Job")
      console.log(data)
      await this.recordTableData("createNewJob", data)
      await this.getTableData('customerdata', this.myName)
      this.closeModal()
    },
    async getTableData(table , name){
      const response = await axios.get(`${dbUrl}?table=${table}&name=${name}`)
       try{
          this.jobs = response.data;
          this.activeJobs = response.data.filter(job => job.jobStatus === 'Active');
          console.log('Table data received successfully:', response);
       }catch(error){
          console.log(error.message);
      };
    },
    async recordTableData(table,tableData){
      const response = await axios.post(`${dbUrl}?table=${table}`,tableData)
      try {
          console.log('New Job data sent successfully:', response.data);
      }catch(error) {
        console.log(error.message);
      };
    },
  }
}
  </script> 
   <style>
 .custom-btn {
  padding-top: 0.25rem;
  padding-bottom: 0.25rem;
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