<template>
  <div class="container">
    <!-- <textarea v-model="riskAssessment"></textarea> -->
    <navButtons></navButtons>
    <h2>{{ $route.params.jobName }} </h2>

    <risk-assessment-list v-if="assessmentItems"
      :items="assessmentItems"
      @deleteItem= "deleteRiskAssessmentItem"
      @editItem= "editRiskAssessmentItem">
    </risk-assessment-list>

    <risk-assessment-modal
      v-if="modal1Visible"
      :modal1Visible="modal1Visible"
      :assessments="assessmentItems"
      @close="closeModal"
      @save="handleSelectedItems"
      @new="openNewAssessmentModal">
    </risk-assessment-modal>

    <newRiskAssessmentModal
      v-if="modal2Visible"
      :modal2Visible="modal2Visible"
      @closeModal2="closeModal2" 
      @record="recordAssessment">
    </newRiskAssessmentModal>

    <editRiskAssessmentModal
     v-if="modal3Visible"
      :item="assessmentItem"
      :modal3Visible="modal3Visible"
      @closeModal3="closeModal3" 
      @record="recordAssessment">
    </editRiskAssessmentModal>


    

    <button @click="openModal" class="button2 print-hide">Add</button>
    <button @click="printAssessment" class="button2 print-hide">Print</button>
  </div>
</template>

<script>
import RiskAssessmentModal from '@/components/RiskAssessmentModal.vue'
import newRiskAssessmentModal from '@/components/newRiskAssessmentModal.vue'
import editRiskAssessmentModal from '@/components/editRiskAssessmentModal.vue'
import RiskAssessmentList from '@/components/RiskAssessmentList.vue'
import navButtons from '@/components/navButtons.vue';
import axios from 'axios'

const dbUrl= 'databaseAPI.php';
export default {

props:['id'],

  // Rest of the component definition
components: {
    RiskAssessmentList,
    RiskAssessmentModal,
    newRiskAssessmentModal,
    editRiskAssessmentModal,
    navButtons
  },

  data() {
    return {
      job:'',
      riskAssessment:'',
      modal1Visible: false,
      modal2Visible: false,
      modal3Visible: false,
      assessmentItem:[],
      assessmentItems: [],
      assessmentIDs:[],
     
    }
  },
  mounted() {
      this.getJobRiskAssessments();
      this.getAssessmentData();
      this.jobNumber = this.$route.params.jobNumber;
      

  },
  methods: {
    // props() {
    //   return {
    //     id: this.$route.params.id,
    //     jobName: this.$route.params.jobName
    //   };
    // },

    //----------------------------------------API METHODS---------------------------------------------------
    async getJobRiskAssessments(){
      const params = new URLSearchParams({table: 'assessments_customerdata', customer_id: this.id});
          try {
          const response = await axios.get(`${dbUrl}?${params}`);
          const data = await response.data;
          this.assessmentIDs = data.map(item => item.assessment_id);
        } catch (error) {
          console.log(error.message);
        }
    },

    async getAssessmentData() {
      const params = new URLSearchParams({table: 'assessments'});
      try {
        const response = await axios.get(`${dbUrl}?${params}`);
        const data = await response.data;
        const filteredItems = data.filter(assessment => this.assessmentIDs.includes(assessment.id));
        this.assessmentItems = filteredItems;
        
        console.log('assessmentItems', this.assessmentItems);
      } catch (error) {
        console.log(error.message);
      }
    },
    async recordTableData(table,tableData){
      const response = await axios.post(`${dbUrl}?table=${table}`,tableData)
      try{
        const response = await response.data;
        console.log('Assessment data sent successfully:', response);
      } catch(error){
        console.log(error.message);
      };
    },
  //----------------------------------------^API METHODS^---------------------------------------------------

    recordAssessment(data){
      const assessmentData = {
        jobID:this.id,
        hazard: data.selectedHazard,
        consequence: data.selectedInjury,
        severity:data.severity,
        probability: data.probability,
        risk: data.risk,
        peopleEffected: data.selectedPeopleEffected,
        mitigation:data.selectedMitigation,
        mitigatedSeverity:data.mitigatedSeverity,
        residualRisk: data.residualRisk,
        effectiveness: data.effectiveness
      };
      console.log("assessmentData",assessmentData)
      this.recordTableData('recordAssessment',assessmentData)
      this.assessmentItems.push(assessmentData);
      this.closeModal();
      this.closeModal2();
      this.closeModal3();
    },
    deleteRiskAssessmentItem(id) {
    // Find the index of the item with the given ID in the items array
      const index = this.assessmentItems.findIndex(item => item.id === id);
      if (index !== -1) {
        // Remove the item at the found index
        this.assessmentItems.splice(index, 1);
        //Find the ID of the assessment
        console.log(id);
        const tableData = {
          jobID: this.id,
          assessmentID: id
        }
        this.recordTableData('delete',tableData)
      }
    },

    openModal() {
      this.modal1Visible = true
      console.log(this.modal1Visible)
    },
      
    closeModal(){
      console.log("close modal")
      this.modal1Visible=false
    },
    closeModal2(){
      console.log("close modal 2")
      this.modal2Visible = false
    },
    closeModal3(){
      console.log("close modal 3")
      this.modal3Visible = false
    },
    saveRiskAssessment() {
    // this.riskAssessments.push(data)
      console.log("save risk assessment")
        
    },
    handleSelectedItems(selectedItems) {
      this.assessmentItems.push(...selectedItems);
      selectedItems.forEach((item) => {
        const tableData = { ...item, jobID:this.id };
        this.recordTableData('recordAssessment', tableData);
      });
        //console.log('Selected items:', tableData);
    },

    editRiskAssessmentItem(assessmentID) {
      console.log('assessmentID', assessmentID)
      // Call a method on the parent component to edit the record with the given ID
      this.assessmentItem = this.assessmentItems.find((item)=>item.id===assessmentID);
      console.log('assessmentItem', this.assessmentItem)
      this.modal3Visible=true
    },

    openNewAssessmentModal(){
      this.modal2Visible = true
      console.log('modal2Visible', this.modal2Visible)
    },

    printAssessment(){
      window.print()
    }
  }

}
</script>

<style>

.button2{
  text-decoration: none;
  background:#fff;
  text-align:center;
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
@media print {
  .print-hide {
    display: none;
  }
}
</style>