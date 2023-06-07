<template>
    <div class="backdrop">
      <div class="myModal">
        <h2>New Assessment</h2>
        <form>
          <div class="table-container">
          <table>
            <thead>
              <tr class="title">
                <th>Identified Hazard</th>
                <th>Consequence</th>
                <th>Severity</th>
                <th>Probability</th>
                <th>Risk</th>
                <th>People Effected</th>
                <th>Mitigation Measures</th>
                <th>Severity</th>
                <th>Residual Risk</th>
                <th>% Effective</th>
                <!-- <th>Equipment</th> -->
                <!-- Add more table headers as needed -->
              </tr>
            </thead>
            <tbody>
              <tr class="input">
                <td>
                  <input
                    v-model="selectedHazard"
                    @click="openModal('hazard')"
                    type="text"
                    />
                </td>
                <td>
                  <input
                    v-model="selectedInjury"
                    @click="openModal('injury')"
                    type="text"
                    />
                </td>
                <td>
                  <input
                    v-model="severity"
                    type="number"
                    class="number-input"
                    min="1"
                    max="10"
                    @change="handleChange" 
                    />
                     <!-- @click="openModal('injury_weighting')" -->
                </td>
                <td>
                  <input 
                    v-model="probability" 
                    type="number" 
                    class="number-input" 
                    min="1" 
                    max="10" 
                    @change="handleChange" 
                    />
                </td>
                <td>
                  <input 
                    v-model="risk" 
                    type="number" 
                    class="number-input" 
                    :style="{ backgroundColor: colorForValue(risk) }"
                    :readonly="true" 
                    />
                </td>
                <td>
                  <input
                    v-model="selectedPeopleEffected"
                    @click="openModal('people_effected')"
                    type="text"
                    />
                </td>
                <td>
                  <input
                    v-model="selectedMitigation"
                    type="text"
                    @click="openModal('mitigation')"
                    />  
                </td>
                <td>
                  <input v-model="mitigatedSeverity" 
                    type="number" 
                    class="number-input" 
                    min="1" 
                    max="10" 
                    @change="handleChange" 
                    
                    />
                    <!-- @click="openModal('mitigated_severity')" -->
                </td>
                <td>
                  <input v-model="residualRisk" 
                    type="number"
                    class="number-input"
                    :style="{ backgroundColor: colorForValue(residualRisk) }"
                    :readonly="true" 
                    />
                </td>
                <td>
                  <input v-model="effectiveness" 
                    type="number"
                    min="0"
                    max="100"
                    class="number-input"
                    :readonly="true" 
                    />
                </td>
                <!-- Add more table cells as needed -->
              </tr>
            </tbody>
          </table>
        </div>
          <!-- Add other form elements or buttons as needed -->

          <button type="button" @click="$emit('record', 
          { selectedHazard, 
            selectedInjury, 
            severity, 
            probability, 
            risk, 
            selectedPeopleEffected, 
            selectedMitigation, 
            mitigatedSeverity, 
            residualRisk, 
            effectiveness })" class="button2">Record</button>
          <button type="button" @click="$emit('closeModal2')" class="button2">Close</button>
        </form>
        </div>
      
        <!-- Modal for hazard options -->
        <!-- ----------------------------------------HAZARD-------------------------------------------------------------- -->
        <div v-if="showModal === 'hazard'" class="myModal2">
          <h3>Select Hazard</h3>
          <ul class="listContainer">
            <li v-for="hazardOption in hazardOptions" :key="hazardOption.id" @click="selectOption(hazardOption, 'hazard')" class="listItem">
              {{ hazardOption.hazard }}
            </li>
          </ul>
        </div>
        <!-- Modal for consequence options -->
        <!-- ----------------------------------------INJURY-------------------------------------------------------------- -->
        <div v-if="showModal === 'injury'" class="myModal2">
          <h3>Select Exposure Consequence</h3>
          <ul class="listContainer">
            <li v-for="injuryOption in injuryOptions" :key="injuryOption.id" @click="selectOption(injuryOption, 'injury')" class="listItem">
              {{ injuryOption.injury_name }}
            </li>
          </ul>
        </div>
        <!-- ----------------------------------------INJURY WEIGHTING-------------------------------------------------------------- -->
        <!-- <div v-if="showModal === 'injury_weighting'" class="mymodal">
          <h3>Select Consequence Score</h3>
          <ul class="listItem">
            <li v-for="number in 10" :key="number" @click="selectOption({weighting:number}, 'injury_weighting')">
              {{ number }}
            </li>
          </ul>
        </div> -->
        <!-- ----------------------------------------PEOPLE EFECTED-------------------------------------------------------------- -->
        <div v-if="showModal === 'people_effected'" class="myModal2">
          <h3>Select People Effected</h3>
          <ul class="listContainer">
            <li v-for="peopleEffectedOption in peopleEffectedOptions" :key="peopleEffectedOption.id" @click="selectOption(peopleEffectedOption, 'people_effected')" class="listItem">
              {{ peopleEffectedOption.category }}
            </li>
          </ul>
        </div>
        <!-- ----------------------------------------MITIGATION-------------------------------------------------------------- -->
        <div v-if="showModal === 'mitigation'" class="myModal2">
          <h3>Select Mitigation Measures</h3>
          <ul class="listContainer">
            <li v-for="mitigationOption in mitigationOptions" :key="mitigationOption.id" @click="selectOption(mitigationOption, 'mitigation')" class="listItem">
              {{ mitigationOption.mitigation }}
            </li>
          </ul>
        </div>
        <!-- ----------------------------------------EQUIPMENT-------------------------------------------------------------- -->
        <!-- Modal for quipment options -->
        <div v-if="showModal === 'equipment'" class="myModal2">
          <h3>Select Equipment</h3>
          <ul class="listContainer">
            <li v-for="equipmentOption in equipmentOptions" :key="equipmentOption.id" @click="selectOption(equipmentOption, 'equipment')" class="listItem">
              {{ equipmentOption.equipment }}
            </li>
          </ul>
        </div>
        <!-- Add more modals for other options as needed -->
      </div>
  </template>
  
  <script>
import axios from 'axios';

export default {
  data() {
    return {
      selectedHazard: '',
      inputInjury: '',
      selectedInjury: '',
      severity:'',
      probability:'',
      risk:'',
      mitigation:'',
      mitigatedSeverity:'',
      mitigatedSeverityN:'',
      residualRisk:'',
      effectiveness:'',

      selectedPeopleEffected: '',
      selectedEquipment: '',
      selectedMitigation: '', // Updated to an array
      
      showModal: null,
      hazardOptions: {},
      injuryOptions: [],
      peopleEffectedOptions: [],
      mitigationOptions:[],
      equipmentOptions: [],
      
      // Add more options arrays as needed
    };
  },
  methods: {
    openModal(option) {
      switch (option) {
    case 'hazard':
      this.showModal = option;
      break;
    case 'injury':
      this.showModal = option;
      this.selectedInjury += ' '; // Add a space before appending the new selection
      break;
    case 'injury_weighting':
      this.showModal = option;
      break;
    case 'people_effected':
      this.showModal = option;
      break;
    case 'mitigation':
      this.showModal = option;
      break;
    case 'equipment':
      this.showModal = option;
      this.selectedEquipment += ' '; // Add a space before appending the new selection
      break;
    case 'mitigated_severity':
      this.showModal = option;
      break;
    // Add cases for other options as needed
    }
    },
    selectOption(option, type) {
      switch (type) {
        case 'hazard':
          this.selectedHazard = option.hazard;
          break;
        case 'injury':
          this.selectedInjury = option.injury_name;
          this.severity = option.weighting
          this.calculateRisk()
          break;
        case 'equipment':
          this.selectedEquipment = option.equipment;
          break;
        case 'people_effected':
          this.selectedPeopleEffected = option.category;
          break;
        case 'mitigation':
          this.selectedMitigation = option.mitigation; // Push the selected value into the array
          this.mitigatedSeverityN = option.mitigated_severity;
          this.calculateMitigatedSeverity()
          this.calculateResidualRisk()
          this.calculateEffectiveness()
          break;
        // Add cases for other options as needed
      }
      this.showModal = null; // Close the modal after selecting an option
    },
  
    async getOptionsFromTable(table) {
      const url = 'databaseAPI.php';
      const params = new URLSearchParams({
        table: table,
      });
      const response = await axios.get(`${url}?${params}`);
      console.log('response.data', response.data)
      return response.data;
      
    },

    handleChange(){
      this.calculateRisk();
      this.calculateResidualRisk();
      this.calculateEffectiveness();
    },
    calculateRisk(){
      this.risk = this.severity * this.probability; 
    },
    calculateResidualRisk(){
      this.residualRisk = this.mitigatedSeverity * this.probability; 
    },
    calculateMitigatedSeverity(){
      this.mitigatedSeverity = this.mitigatedSeverityN * this.severity; 
    },
    calculateEffectiveness(){
      this.effectiveness = 100- ((this.residualRisk / this.risk )*100);
    },

    colorForValue(value) {
      // Calculate the color based on the value
      if (value >= 70) {
        return '#ff7474'; // Red
      } else if (value >= 50) {
        return '#ff824f'; // Orange
      } else if (value >= 30) {
        return '#ffef66'; // Amber
      } else if (value >= 15) {
        return '#ffd776'; // Light Amber
      } else {
        return '#a1d587'; // Green
      }
    },
  },

  async mounted() {
    try{
    this.hazardOptions = await this.getOptionsFromTable('hazards');
    this.injuryOptions =  await this.getOptionsFromTable('injury');
    this.peopleEffectedOptions =  await this.getOptionsFromTable('people_effected');
    this.mitigationOptions =  await this.getOptionsFromTable('mitigation');
    }catch(error){
      console.log(error)
    }
   
  },
}
</script>

<style scoped>
.myModal {
  max-width: 1200px; /* Adjust the maximum width as needed */
  top: 60px;
  padding: 20px;
  margin: 20px auto;
  background: white;
  border: 1px solid rgb(0, 68, 141);
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a box shadow for a separate object appearance */
}


.myModal2 {
  display: block;
  max-width: 600px; /* Adjust the maximum width as needed */
  top: 60px;
  max-height:300px;
  padding: 20px;
  margin: 20px auto;
  background: rgb(232, 238, 245);
  border: 1px solid rgb(0, 68, 141);
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a box shadow for a separate object appearance */
  overflow-y: scroll;
  overflow-x: hidden;
}

.myModal2::-webkit-scrollbar{
  width:8px;
  background: #ddd;
  border-radius: 0px 10px 10px 0px;
}

.myModal2::-webkit-scrollbar-thumb{
  background:rgb(0, 68, 141);;
  border-radius: 10px;
}

.listContainer{
  width: 100%;
}
.listItem{
  width: 90%;
  list-style-type: none;
  border: 1px solid  rgb(0,68,141); 
  border-radius: 10px;
}

.listItem:hover{
  background-color: #ddd;
  cursor:pointer;
}
.backdrop {
  top: 0;
  left: 0;
  position: fixed;
  background: rgba(0, 0, 0, 0.5);
  width: 100%;
  height: 100%;
}
.table-container {
  overflow-x: auto;
}
table {
  
  font-size: 0.75rem;
  width: auto;
}

.tbody{
  display:flex;
}
.input{
  border-top: 1px solid rgb(0,68,141); 
  border-bottom: 1px solid rgb(0,68,141); 

}
tr:hover {
  background-color: #ddd;
  cursor: pointer;
}
tr.selected {
  background-color: #c9e1f0;
}
th,
td {
  text-align: left;
  padding: 8px;
}
th {
  border: #b7bdb7;
}
.number-input {
  width: 50px; /* Adjust the width to your desired value */
}
 ul{
  margin:10px;
  
 }

</style>