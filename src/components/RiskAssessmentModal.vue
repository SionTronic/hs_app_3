<template>
  <div class="backdrop">
    <div class="modal-content">
      <h2>Assessment Library</h2>
      <div class="table-container">
        <table class="table">
          <thead>
            <!-- Table headings -->
            <tr>
              <th>Identified Hazard</th>
              <th>Exposure Consequence</th>
              <th>Hazard Probability</th>
              <th>Hazard Value</th>
              <th>Risk Value</th>
              <th>People Effected</th>
              <th>Risk Mitigation</th>
              <th>Mitigated Severity</th>
              <th>Residual Risk Value</th>
              <!-- <th>Edit</th>
              <th>Delete</th> -->
            </tr>
          </thead>
          <tbody>
            <!-- Table rows -->
            <tr
              class="form-group"
              v-for="assessment in assessments"
              :key="assessment.id"
              :class="{ 'selected': assessment.selected }"
              @click="selectItem(assessment)"
            >
              <td>{{ assessment.hazard }}</td>
              <td>{{ assessment.consequence }}</td>
              <td>{{ assessment.severity }}</td>
              <td>{{ assessment.probability }}</td>
              <td :style="{ backgroundColor: colorForValue(assessment.risk) }">{{ assessment.risk }}</td>
              <td>{{ assessment.peopleEffected }}</td>
              <td>{{ assessment.mitigation }}</td>
              <td>{{ assessment.mitigatedSeverity }}</td>
              <td :style="{ backgroundColor: colorForValue(assessment.residualRisk) }">{{ assessment.residualRisk }}</td>
              <!-- <td><button class="button2" @click="editRiskAssessment(assessment.id)">Edit</button></td>
              <td><button class="button2" @click.prevent="$emit('deleteRiskAssessment', assessment.id)">Delete</button></td> -->
            </tr>
          </tbody>
        </table>
      </div>
      <div class="button-container">
        <button type="submit" @click.prevent="saveRiskAssessment()" class="button2">Add Selected</button>
        <button type="button" @click="$emit('close')" class="button2">Cancel</button>
        <button type="button" @click="$emit('new')" class="button2">New Assessment</button>
      </div>
    </div>
  </div>
</template>

  
<script>
  import axios from 'axios';

  export default {
    data() {
      return {
        assessments: [],
      };
    },
    mounted() {
      this.getAllRiskAssessments();
    },
    methods: {
      selectItem(item) {
        item.selected = !item.selected; // Fixed typo: 'assessmentItems' should be 'item'
      },

      async getAllRiskAssessments() {
        const url = 'databaseAPI.php';
        const params = new URLSearchParams({
          table: 'assessments',
        });
        const response = await axios.get(`${url}?${params}`);
        this.assessments = response.data;
        console.log('assessment', this.assessments)
      },

      saveRiskAssessment() {
        const selectedItems = this.assessments.filter(assessment => assessment.selected);
        this.$emit('save', selectedItems);
        this.$emit('close');
      },

      logIt(myObject) {
        console.log(myObject);
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

    computed: {
      itemsWithSelection() {
        // Add the 'selected' property to each item
        return this.items.map(item => {
          return {
              ...item,
              selected: false
          };
        });
      },
    }
  }
</script>

<style scoped>
  .myModal{
    width:100%;
  }
  .modal-content {
    width: 90%;
    max-width: 1200px; /* You can adjust this value to your desired maximum width */
    max-height: 80%;
    top: 50px;
    padding: 20px;
    margin: 20px auto;
    background: white;
    border-radius: 10px;
    border:1px solid rgb(0,68,141); 
    overflow: hidden;
  }

  .table-container {
    max-height: calc(100% - 90px); /* Adjust the height to leave space for the buttons */
    overflow-y: auto; /* Enable vertical scrolling */
  }

  .table-container::-webkit-scrollbar{
    width:8px;
    background: #ddd;
    border-radius: 0px 10px 10px 0px;
  }

  .table-container::-webkit-scrollbar-thumb{
    background:rgb(0, 68, 141);;
    border-radius: 10px;
  }
  .backdrop{
      top:0;
      left:0;
      position:fixed;
      background:rgba(0,0,0,0.5);
      width:100%;
      height:100%;
  }
  .form-group{
      font-size:0.75rem;
      border-top:solid 1px rgba(0,68,141,0.5); 
      border-bottom:solid 1px rgba(0,68,141,0.5); 
      
  }

  .hazardItem{
      width:500px;
      display:flex;
  }
  .table {
    font-size: 0.75rem;
    width: 100%;
  }
  .table thead {
    position: sticky;
    top: 0;
    background-color: white;
    z-index: 1;
  }
  tr:hover {
    background-color: #ddd;
    cursor: pointer;
  }

  tr.selected {
    background-color: #c9e1f0;
  }
  .button-container {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 10px;
  }
  th,
  td {
    text-align: left;
    padding: 8px;
  }

  th {
    border: #b7bdb7;
  }


  /* td.green {
    background-color: #a3eb8d;
  }

  td.amber {
    background-color: #fdd170;
  }

  td.red {
    background-color: #ff7474;
  } */
  
</style>
  