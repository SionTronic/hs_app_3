<template>
    <navButtons/>
    <h1>New Job Details</h1>
    <form>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Job Number</span>
                    <input type="text" class="form-control" v-model="jobNumber" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2">Client Name</span>
                    <input type="text" class="form-control" v-model = "clientName" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text align-items-start" id="basic-addon2">Client Address</span>
                    <textarea class="form-control" rows="5" height="100px" v-model="clientAddress" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2">Client Home Phone</span>
                    <input type="text" class="form-control" v-model = "phone" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2">Client e-Mail</span>
                    <input type="text" class="form-control" v-model = "email" aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <span class="input-group-text align-items-start" id="basic-addon2">Job Description</span>
                    <textarea class="form-control" rows="5" v-model="description" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2">Project Manager</span>
                    <input type="text" class="form-control" v-model = "pM" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2">Engineer</span>
                    <input type="text" class="form-control" v-model = "engineer" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon2">Technician</span>
                    <input type="text" class="form-control" v-model = "technician" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <button type="submit" class="btn btn-primary mb-3 me-3 ">Notes</button>
                <button type="submit" class="btn btn-primary mb-3">Job Folder</button>
            </div>
        </div>
    </form>
    <div class="button-container">
        <button type="button" @click="$emit('submit',{
            jobNumber,
            clientName,
            clientAddress,
            phone,
            email,
            description,
            pM,
            engineer,
            technician
        })" class="button2">Submit</button>
        <button type="button" @click="$emit('close')" class="button2">Cancel</button>
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
            jobNumber:'Enter Job Number',
            clientName:'',
            clientAddress:'',
            phone:'',
            email:'',
            description:'',
            pM:'',
            engineer:this.myName,
            technician:''
        }
    },
}
</script>