<template>
  <h1>Active Jobs</h1>
    <div v-for = "job in activeJobs" :key="job.id" class="jobs">
      <router-link :to="{ name: 'Job'  , params: { id: job.id }}" :active-jobs="activeJobs">
        <div class="row border p-1">
            <div class="col-md-5">
            <p>{{ job.jobNumber }} - {{ job.clientAddress }}</p>
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
  // async getOptionsFromTable(table) {
  //   return axios
  //     .get(`http://localhost:8000/databaseAPI.php?table=${table}`)
  //     .then((response) => {
  //       if (Array.isArray(response.data)) { // Check if response.data is an array
  //         this.jobs = response.data.filter((job) =>
  //         (job.pM === this.myName ||
  //           job.engineer === this.myName ||
  //           job.technician === this.myName) &&
  //         job.Status === "Active");
  //       }else{
  //         console.log("Invalid response data format");
  //       }
  //     })
  //     .catch((error) => {
  //       console.log(error);
  //     });
  //   },

    openModal() {
      this.modalVisible = true
      console.log(this.modalVisible) 
    },
      
    closeModal(){
      console.log("close modal")
      this.modalVisible=false
    },

    submitNewJob(data){
      console.log("Submit New Job")
      console.log(data)
      this.recordTableData("createNewJob",data)
      this.getTableData('customerdata', this.myName)
      this.closeModal
    },
    async getTableData(table){
      // axios.get(`http://localhost:8000/databaseAPI.php?table=${table}&name=${this.myName}`)
      axios.get(`databaseAPI.php?table=${table}&name=${this.myName}`)
        .then(response => {
            const responseData = response.data;
            this.jobs = responseData;
            this.activeJobs = responseData.filter(job => job.jobStatus === 'Active'); 
            console.log('Table data received successfully:', responseData);
          })
        .catch(error => {
          console.log(error.message);
          });
      },
    recordTableData(table,tableData){
      // axios.post(`http://localhost:8000/databaseAPI.php?table=${table}`,tableData)
      axios.post(`databaseAPI.php?table=${table}`,tableData)
        .then(response => {
            const responseData = response.data;
            console.log('Assessment data sent successfully:', responseData);
          })
        .catch(error => {
          console.log(error.message);
          });
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