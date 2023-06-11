<template>
  <h1>All Jobs</h1>
  <h3>Logged in as Admin</h3>
  <div class="d-flex justify-content-center">
  <div class="form-group mr-3 mx-auto col-lg-4">
    <div class="input-group">
      <span class="input-group-text" id="basic-addon1" for="textSearch">Text Search:</span>
      <input class="form-control" type="text" id="textSearch" v-model="textSearch">
    </div>
    <div class="input-group">
      <span class="input-group-text" for="statusFilter">Filter by Status:</span>
      <select class="form-select" id="statusFilter" v-model="statusFilter">
        <option value="">All</option>
        <option value="Enquiry">Enquiry</option>
        <option value="Quoted">Quoted</option>
        <option value="Tendered">Tendered</option>
        <option value="Accepted">Accepted</option>
        <option value="Active">Active</option>
        <option value="Completed">Completed</option>
      </select>
    </div>
  </div>
</div>
  <newJobModal
    v-if="modalVisible"
    :myName="myName"
    :modalVisible="modalVisible"
    @close="closeModal"
    @submit="submitNewJob">
  </newJobModal>
  <button @click="openModal" class="button2">Add New Job</button>
  <p> {{ matchingJobs.length }} matches</p>
  <div v-if="jobs">
    <div v-for="job in matchingJobs" :key="job.id" class="jobs">
      <router-link :to="{name: 'Job', params: {id: job.id}}">
        <p>{{ job.jobName }}  | Status - {{ job.jobStatus }}</p>
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

const dbUrl='databaseAPI.php'
export default {
  
  setup() {
    const statusFilter = ref('');
    const textSearch = ref('');
    const filterSearch = ref('');
    const jobs = ref([]);
    // const statusFilter = ref('');
    // const textSearch = computed(() => search.value.toLowerCase());

    watch (filterSearch, ()=>{
        console.log('watch ran')
        //console.log(jobs)
    });

    watchEffect(() => {
        console.log('watchEffect ran', filterSearch.value);
    });

    const matchingJobs = computed(() => {
      return jobs.value.filter(job => {
        if (job.jobName == null) {
          job.jobName = 'Unassigned';
        }
        const lowerCaseJobName = job.jobName ? job.jobName.toLowerCase(): 'No Job Name'
        const lowerCaseJobStatus = job.jobStatus ? job.jobStatus.toLowerCase() : 'No Status Assinged';
        const lowerCaseTextSearch = textSearch.value.toLowerCase();
        // Check if the job matches the status filter
        const statusMatch = !statusFilter.value || lowerCaseJobStatus.includes(statusFilter.value.toLowerCase());
        // Check if the job matches the text search
        const textMatch =
        lowerCaseJobName.includes(lowerCaseTextSearch) ||
        lowerCaseJobStatus.includes(lowerCaseTextSearch)
        return statusMatch && textMatch;
      });
    });

    return {jobs, filterSearch, matchingJobs, statusFilter, textSearch,};
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
      const response = await axios.get(`${dbUrl}?table=${table}`)
      try {
        if (Array.isArray(response.data)) { // Check if response.data is an array
          this.jobs = response.data
        }else {
          console.log("Invalid response data format");
        }
      }catch(error){
        console.log(error);
      };
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

    async submitNewJob(data){
      console.log("Submit New Job")
      console.log(data)
      try{
        await this.recordTableData("createNewJob", data)
        await this.getOptionsFromTable('customerdata');
        this.closeModal()
      }catch (error) {
        console.log(error.message);
      }
    },

    async getTableData(table){
      const response = await axios.get(`${dbUrl}?table=${table}&name=${this.myName}`)
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