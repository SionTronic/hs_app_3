<template>
<div class="container" v-if="job">
    <navButtons :isEdited="isEdited" />
    <h1>Job Details</h1>
      <form>
        <div class="row">
          <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Job Number</span>
                <input type="text" class="form-control" v-model="job.jobNumber"  @input="handleInputChange" aria-label="jobNumber" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">job Name</span>
                <input type="text" class="form-control" v-model = job.jobName  @input="handleInputChange" aria-label="jobName" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text align-items-start" id="basic-addon2">Client Address/Job Name</span>
                <textarea class="form-control" rows="5" height="100px" v-model="job.clientAddress"  @input="handleInputChange" aria-label="Address" aria-describedby="basic-addon1"></textarea>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Client Home Phone</span>
                <input type="text" class="form-control" v-model = job.phone aria-label="phone" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Client e-Mail</span>
                <input type="text" class="form-control" v-model = job.email aria-label="email"  @input="handleInputChange" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Contact Date</span>
                <input type="text" class="form-control datepicker" v-model="job.contactDate"  @input="handleInputChange" aria-label="contactDate" aria-describedby="basic-addon1">
            </div>
          </div>
          <div class="col-md-6">
            <div class="input-group mb-3">
                <span class="input-group-text align-items-start" id="basic-addon2">Job Description</span>
                <textarea class="form-control" rows="5" v-model="job.description"  @input="handleInputChange" aria-label="Job Description" aria-describedby="basic-addon1"></textarea>
            </div>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Status</span>
                <select class="form-select" v-model="job.jobStatus" @input="handleInputChange" >
                <option value="Active">Active</option>
                <option v-for="js in jobStatus" :value="js">{{ js }}</option>
            </select>
            </div>
             <!-- Project Manager -->
             <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Project Manager</span>
                <select class="form-select" v-model="job.pM" @input="handleInputChange" >
                    <option value="">Select Project Manager</option>
                    <option v-for="manager in projectManagers" :value="manager">{{ manager }}</option>
                </select>
            </div>
            <!-- Engineer -->
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Engineer</span>
                <select class="form-select" v-model="job.engineer" @input="handleInputChange" >
                    <option value="">Select Engineer</option>
                    <option v-for="engineer in engineers" :value="engineer">{{ engineer }}</option>
                </select>
            </div>
            <!-- Technician -->
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">Technician</span>
                <select class="form-select" v-model="job.technician" @input="handleInputChange" >
                    <option value="">Select Technician</option>
                    <option v-for="technician in technicians" :value="technician">{{ technician }}</option>
                </select>
            </div>
            <button :disabled="!isEdited" :class="{'btn btn-primary': !isEdited, 'btn btn-danger': isEdited}" class="mb-3 me-3" @click="saveEdits">Save</button>
            <button  class="btn btn-primary mb-3 me-3" @click="openJobFolder">Job Folder</button>
            <button  class="btn btn-primary mb-3" @click="revert">Revert</button>
          </div>
        </div>
        <div class="progress" role="progressbar" aria-label="Info example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" v-bind:style="{width: job.pcntComplete + '%'}">{{job.pcntComplete}}% Complete</div>
        </div><br>
      </form>
      <div class="nav2" v-if=job.jobName>
        <router-link class ="button2" to="/report">Report</router-link>
        <router-link class ="button2" to="/timesheet">Timesheet</router-link>
        <router-link class="button2" :to="{ name: 'General Risk Assessment', params: { id: job.id, jobName:job.jobName } }">Risk Assessment</router-link>
    </div>

</div>
    
<div v-else>
<p>Loading ...</p>

</div>


</template>

<script>
import navButtons from '@/components/navButtons.vue';
import navigator from '@/components/navButtons.vue';
import axios from 'axios'

 const dbUrl= 'databaseAPI.php';
// const openExplorer = require('open-file-explorer');

export default {
  components: {
    navButtons,
    navigator
  },
  props: ['id'],

  data() {
    return {
      job: {},
      jobStatus:['Completed','Enquiry','Quoted', 'Accepted','Tendered','Suspended'],
      projectManagers: ['Ifan', 'Ian', 'Dyfed', 'Bryn', 'Bryan', 'Aled'],
      engineers: ['Martin', 'Sion', 'Jared', 'Byron', 'Arwel', 'Camilla', 'Dylan'],
      technicians: ['Erin', 'Tom', 'Mitch'],
      jobfolderPath:"C:\Users\Sion\Documents\AGS Engineering Solution Ltd\Cadarn",
      isEdited:false,
      isLoading: true,
    }
  },

  mounted() {
    this.getOptionsFromTable();
    this.isEdited=false;
    console.log("this.isEdited", this.isEdited)
    flatpickr('.datepicker', {
        dateFormat: 'd/m/Y',  // Specify the desired date format
        defaultDate: 'today', // Set the default date to today
        onClose: (selectedDates, dateStr, instance) => {
            this.contactedDate = dateStr;  // Update the v-model value
        }
    });
  },
  

  methods: {
    async getOptionsFromTable() {
      const params = new URLSearchParams({table: 'customerdata', id: this.id,});
      try {
        const response = await axios.get(`${dbUrl}?${params}`);
        this.job  = response.data[0]
        this.logJobs();
        this.isLoading = false;
        console.log('isLoading',this.isLoading);
      } catch (error) {
        console.log(error.message);
      }
    },
    handleInputChange(){
      this.isEdited=true
      console.log('this.edited', this.isEdited)
    },
    saveEdits(){
      event.preventDefault();
      this.recordTableData('update_customerdata',this.job)
      console.log("saved")
      this.isEdited = false;
    },

    revert() {
      event.preventDefault();
      // Reset the form data to the original job object
      this.job = Object.assign({}, this.originalJob);
      this.isEdited = false;
    },
    async recordTableData(table,tableData){
      const response = await axios.post(`${dbUrl}?table=${table}`,tableData)
      try {
          console.log('New Job data sent successfully:', response.data);
      }catch(error) {
        console.log(error.message);
      };
    },
    openJobFolder(){
      event.preventDefault();
        this.openFolderBrowser()
    },
    openFolderBrowser() {
      window.open(this.jobfolderPath);
    },
    logJobs() {
      console.log('job', this.job);
    },
    
  },
  created() {
    // Create a copy of the job object as the originalJob
    this.originalJob = Object.assign({}, this.job);
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