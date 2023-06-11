<template>
    <div class="myBackdrop">
        <div class="myModal-content">
            <div class="container">
                <h1>New Job Details</h1>
                <div class="form-container">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Job Number</span>
                                    <input ref="jobNumberInput" type="text" class="form-control" v-model="job.jobNumber" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Job Name</span>
                                    <input type="text" class="form-control" v-model = "job.jobName" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text align-items-start" id="basic-addon2">Client Address</span>
                                    <textarea class="form-control" rows="5" height="100px" v-model="job.clientAddress" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Client Home Phone</span>
                                    <input type="text" class="form-control" v-model = "job.phone" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Client e-Mail</span>
                                    <input type="text" class="form-control" v-model = "job.email" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Date</span>
                                    <input type="text" class="form-control datepicker" v-model="job.contactedDate" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text align-items-start" id="basic-addon2">Job Description</span>
                                    <textarea class="form-control" rows="5" v-model="job.description" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                                </div>
                                
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Status</span>
                                    <select class="form-select" v-model="job.jobStatus">
                                    <option value="Active">{{status}}</option>
                                    <option v-for="js in jobStatus" :value="js">{{ js }}</option>
                                </select>
                                </div>
                                <!-- Project Manager -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Project Manager</span>
                                <select class="form-select" v-model="pM">
                                    <option value="">Select Project Manager</option>
                                    <option v-for="manager in projectManagers" :value="manager">{{ manager }}</option>
                                </select>
                            </div>
                            <!-- Engineer -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Engineer</span>
                                <select class="form-select" v-model="engineer">
                                    <option value="">Select Engineer</option>
                                    <option v-for="engineer in engineers" :value="engineer">{{ engineer }}</option>
                                </select>
                            </div>
                            <!-- Technician -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Technician</span>
                                <select class="form-select" v-model="technician">
                                    <option value="">Select Technician</option>
                                    <option v-for="technician in technicians" :value="technician">{{ technician }}</option>
                                </select>
                            </div>
                                <button type="submit" class="btn btn-primary mb-3 me-3 ">Notes</button>
                                <button type="submit" class="btn btn-primary mb-3">Job Folder</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="button-container">
                <button type="button" @click="$emit('submit',{
                    jobNumber,
                    jobName: jobNumber + ' - ' + jobName,
                    clientAddress,
                    phone,
                    email,
                    description,
                    contactedDate,
                    status,
                    pM,
                    engineer,
                    technician
                    })" class="button2">Submit</button>
                <button type="button" @click="$emit('close')" class="button2">Cancel</button>
            </div>
        </div>
    </div>
</template>

<script>
import navButtons from '@/components/navButtons.vue';

    
    export default {
    components: {
    navButtons,
    },

    props: ['id', 'myName'],

    data() {
        return {
            job:{
                jobNumber:'',
                jobName:'',
                clientAddress:'',
                phone:'',
                email:'',
                contactedDate:new Date().toLocaleDateString('en-GB'),
                jobStatus:'Active',
                description:'',
                pM:'',
                engineer:'',
                technician:'',
            },
            jobStatus:['Completed','Enquiry','Quoted', 'Accepted','Tendered','Suspended'],
            projectManagers: ['Ifan', 'Ian', 'Dyfed', 'Bryn', 'Bryan', 'Aled'],
            engineers: ['Martin', 'Sion', 'Jared', 'Byron', 'Arwel', 'Camilla', 'Dylan'],
            technicians: ['Erin', 'Tom', 'Mitch']
        }
    },

    mounted() {
        console.log(this.$route.query.name)
        //this.$refs.jobNumberInput.focus();
        
        flatpickr('.datepicker', {
            dateFormat: 'd/m/Y',  // Specify the desired date format
            defaultDate: 'today', // Set the default date to today
            onClose: (selectedDates, dateStr, instance) => {
            this.contactedDate = dateStr;  // Update the v-model value
            }
        });
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
    .myModal-content {
    width: 90%;
    max-width: 1200px; /* You can adjust this value to your desired maximum width */
    max-height: 80%;
    top: 50px;
    padding: 20px;
    margin: 20px auto;
    background: white;
    opacity:1 !important;
    border-radius: 10px;
    border:1px solid rgb(0,68,141); 
    overflow:auto;
}
    .myBackdrop{
    top:0;
    left:0;
    position:fixed;
    background:rgba(0,0,0,0.5)  ;
    /* opacity:0.5 !important; */
    width:100%;
    height:100%;
 }
 
 @media (max-width: 600px){


.myModal-content .form-container {
max-height: calc(100% - 90px); /* Adjust the height to leave space for the buttons */
overflow-y: auto; /* Enable vertical scrolling */
overflow-x: auto; /* Enable vertical scrolling */
}

.myModal-content .form-container::-webkit-scrollbar{
width:8px;
background: #ddd;
border-radius: 0px 10px 10px 0px;
}

.myModal-content .form-container::-webkit-scrollbar-thumb{
background:rgb(0, 68, 141);;
border-radius: 10px;
}
}

    </style>