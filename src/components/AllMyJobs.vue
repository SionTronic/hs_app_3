<template>
  <h1>All My Jobs</h1>
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
<div v-for="job in matchingJobs" :key="job.id" class="jobs">
      <router-link :to="{name: 'Job', params: {id: job.id}}">
        <p>{{ job.jobName }}  | Status - {{ job.jobStatus }}</p>
      </router-link>
    </div>
</template>
  
<script>
import axios from 'axios';
import { computed, ref, watch, watchEffect } from 'vue'
import newJobModal from '@/components/newJobModal.vue'

const dbUrl = 'databaseAPI.php'
export default {
  components:{newJobModal},

  props:['myName'],
  
  data() {
    return {
    jobs: {},
    modalVisible: false,
    myName:this.myName
    }
  },

  mounted(){
  this.getOptionsFromTable('customerdata')
  },

  methods: {
    async getOptionsFromTable(table) {
      const response = await axios.get(`${dbUrl}?table=${table}`)
      try {
        if (Array.isArray(response.data)) { // Check if response.data is an array
          if(this.myName === "Caryl" ||this.myName === "Catrin" ||this.myName === "Ifan"){
            this.jobs = response.data
          }else{
            this.jobs = response.data.filter((job) =>
            (job.pM === this.myName ||
            job.engineer === this.myName ||
            job.technician === this.myName) );
          }
        }else{
          console.log("Invalid response data format");
        }
      }catch(error){
      console.log(error);
      };
    },    
  },
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
}
</script>
<style scoped>
.Completed {
  /* CSS styles for the 'Completed' class */
  /* For example: */
  background-color: gray;
}
</style>