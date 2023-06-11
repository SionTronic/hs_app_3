<template>
    <div class="myBackdrop">
        <div class="myModal-content">
            <div v-if="jobDetails" class="container">
                <h1>New Job Details</h1>
                <div class="form-container">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Job Number</span>
                                    <input ref="jobNumberInput" type="text" class="form-control" v-model="jobDetails.jobNumber" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Job Name</span>
                                    <input type="text" class="form-control" v-model = "jobDetails.jobName" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text align-items-start" id="basic-addon2">Client Address</span>
                                    <textarea class="form-control" rows="5" height="100px" v-model="jobDetails.clientAddress" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Client Home Phone</span>
                                    <input type="text" class="form-control" v-model = "jobDetails.phone" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon2">Client e-Mail</span>
                                    <input type="text" class="form-control" v-model = "jobDetails.email" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text align-items-start" id="basic-addon2">Job Description</span>
                                    <textarea class="form-control" rows="5" v-model="jobDetails.description" aria-label="Username" aria-describedby="basic-addon1"></textarea>
                                </div>
                                <!-- Project Manager -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Project Manager</span>
                                <select class="form-select" v-model="jobDetails.pM">
                                    <option value="">Select Project Manager</option>
                                    <option v-for="manager in jobDetails.projectManagers" :value="manager">{{ manager }}</option>
                                </select>
                            </div>
                            <!-- Engineer -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Engineer</span>
                                <select class="form-select" v-model="jobDetails.engineer">
                                    <option value="">Select Engineer</option>
                                    <option v-for="engineer in jobDetails.engineers" :value="engineer">{{ engineer }}</option>
                                </select>
                            </div>
                            <!-- Technician -->
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon2">Technician</span>
                                <select class="form-select" v-model="jobDetails.technician">
                                    <option value="">Select Technician</option>
                                    <option v-for="technician in jobDetails.technicians" :value="technician">{{ technician }}</option>
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
export default {
    props: {
        value: {
        type: Object,
        required: true
        }
    },
    computed: {
        jobDetails: {
        get() {
            return this.value;
        },
        set(newValue) {
            this.$emit('input', newValue);
        }
        }
    },

    mounted() {
        console.log(this.$route.query.name)
        this.$nextTick(() => {
            const jobNumberInput = this.$refs.jobNumberInput;
            if (jobNumberInput) {
                jobNumberInput.focus();
                jobNumberInput.select();
            }
        });
    },
};
</script>