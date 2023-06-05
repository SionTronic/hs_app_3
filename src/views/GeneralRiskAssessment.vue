<template>
  <div class="container">
    <!-- <textarea v-model="riskAssessment"></textarea> -->
    <navButtons></navButtons>
    <h1>{{ $route.params.jobName }} </h1>

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


    

    <button @click="openModal" class="button2">Add</button>
    <button @click="printAssessment" class="button2">Print</button>
  </div>
</template>

<script>
import RiskAssessmentModal from '@/components/RiskAssessmentModal.vue'
import newRiskAssessmentModal from '@/components/newRiskAssessmentModal.vue'
import editRiskAssessmentModal from '@/components/editRiskAssessmentModal.vue'
import RiskAssessmentList from '@/components/RiskAssessmentList.vue'
import navButtons from '@/components/navButtons.vue';
import axios from 'axios'


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
      this.getData();
      this.jobNumber = this.$route.params.jobNumber;
      

  },
  methods: {
    props() {
      return {
        id: this.$route.params.id,
        jobName: this.$route.params.jobName
      };
    },
      async getJobRiskAssessments(){
        // const url = 'http://localhost:8000/databaseAPI.php';
        const url = 'http://cadarn.wales/data/databaseAPI.php';
        const params = new URLSearchParams({
            table: 'assessments_customerdata',
            customer_id: this.id,
          });
            try {
            const response = await fetch(`${url}?${params}`);
            const data = await response.json();
            this.assessmentIDs = data.map(item => item.assessment_id);
          } catch (error) {
            console.log(error.message);
          }
      },

      async getData() {
        // const url = 'http://localhost:8000/databaseAPI.php';
        const url = 'http://cadarn.wales/data/databaseAPI.php';
        const params = new URLSearchParams({
            table: 'assessments'
          });
          try {
            const response = await fetch(`${url}?${params}`);
            const data = await response.json();
            
            const filteredItems = data.filter(assessment => this.assessmentIDs.includes(assessment.id));
            this.assessmentItems = filteredItems;
            
            console.log('assessmentItems', this.assessmentItems);
          } catch (error) {
            console.log(error.message);
          }
      },  
 
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
             const tabelData = {
              jobID: this.id,
              assessmentID: id
             }
             this.recordTableData('delete',tabelData)
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

    
      recordTableData(table,tableData){
        // axios.post(`http://localhost:8000/databaseAPI.php?table=${table}`,tableData)
        axios.post(`http://cadarn.wales/data/databaseAPI.php?table=${table}`,tableData)
            .then(response => {
                const responseData = response.data;
                console.log('Assessment data sent successfully:', responseData);
              })
            .catch(error => {
              console.log(error.message);
              });
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

</style>