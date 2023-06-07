<template>
<div class="container" v-if="job">
    <navButtons />
    <h1>Job Details</h1>
      <form>
        <div class="row">
          <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Job Number</span>
                <input type="text" class="form-control" v-model="job.jobNumber" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">job Name</span>
                <input type="text" class="form-control" v-model = job.jobName aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text align-items-start" id="basic-addon2">Client Address/Job Name</span>
                <textarea class="form-control" rows="5" height="100px" v-model="job.clientAddress" aria-label="Username" aria-describedby="basic-addon1"></textarea>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Client Home Phone</span>
                <input type="text" class="form-control" v-model = job.phone aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Client e-Mail</span>
                <input type="text" class="form-control" v-model = job.email aria-label="Username" aria-describedby="basic-addon1">
            </div>
          </div>
          <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text align-items-start" id="basic-addon2">Job Description</span>
                <textarea class="form-control" rows="5" v-model="job.description" aria-label="Username" aria-describedby="basic-addon1"></textarea>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Project Manager</span>
                <input type="text" class="form-control" v-model = job.pM aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Engineer</span>
                <input type="text" class="form-control" v-model = job.engineer aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Technician</span>
                <input type="text" class="form-control" v-model = job.technician aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <button type="submit" class="btn btn-primary mb-3 me-3 ">Notes</button>
            <button type="submit" class="btn btn-primary mb-3 me-3">Finance</button>
            <button type="submit" class="btn btn-primary mb-3" @click="openJobFolder">Job Folder</button>
          </div>
        </div>
        <div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" v-bind:style="{width: job.pcntComplete + '%'}">{{job.pcntComplete}}% Complete</div>
        </div><br>
        <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
      </form>
      <div class="nav2" v-if=job.jobName>
        <router-link class ="button2" to="/report">Report</router-link>
        <router-link class ="button2" to="/timesheet">Timesheet</router-link>
        <!-- <router-link class="button2" :to="{ name: 'General Risk Assessment', jobName:jobName, params: { id: job.id  } }">Risk Assessment</router-link> -->
        <router-link class="button2" :to="{ name: 'General Risk Assessment', params: { id: job.id, jobName:job.jobName } }">Risk Assessment</router-link>
    </div>

</div>
    
<div v-else>
<p>Loading ...</p>

</div>


</template>

<script>
import navButtons from '@/components/navButtons.vue';
import axios from 'axios'

const dbUrl= 'databaseAPI.php';
export default {
  components: {
    navButtons,
  },
  props: ['id'],

  data() {
    return {
      job: {},
    }
  },

  mounted() {
    this.getOptionsFromTable();
  //  this.job = this.activeJobs.find(job => job.id === this.id);
  //  console.log(this.job)
  },

  methods: {
    async getOptionsFromTable() {
      const params = new URLSearchParams({table: 'customerdata', id: this.id,});
      try {
        const response = await axios.get(`${dbUrl}?${params}`);
        this.job  = response.data[0]
        this.logJobs();
      } catch (error) {
        console.log(error.message);
      }
    },

    openJobFolder(){
        alert("openJobFolder")
        this.openFolderBrowser()
    },
    openFolderBrowser() {
      // Create an input element dynamically
      const input = document.createElement('input');
      
      // Set input attributes
      input.type = 'file';
      input.webkitdirectory = true;

      // Add an event listener to handle the selected folder
      input.addEventListener('change', (event) => {
        const folderPath = event.target.files[0].path;
        // Do something with the selected folder path
        console.log('Selected folder:', folderPath);
      });

      // Trigger the click event on the input element
      input.click();
    },
    
    logJobs() {
      console.log('job', this.job);
    },
    redirect() {
      this.$router.push({ name: 'Home' });
    },
    back() {
      this.$router.go(-1);
    },
    forward() {
      this.$router.go(1);
    },
  },
}
</script>

<style scoped>

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