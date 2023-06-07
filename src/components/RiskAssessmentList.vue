<template>
  <h2>Risk Assessment</h2>
  <div class="table-container">
    <table>
      <thead>
        <tr>
          <th>Identified Hazard</th>
          <th>Exposure Consequence</th>
          <th>Hazard Probability</th>
          <th>Hazard Value</th>
          <th>Risk Value</th>
          <th>People Effected</th>
          <th>Risk Mitigation</th>
          <th>Mitigated Probability</th>
          <th>Residual Risk Value</th>
          <th class="print-hide">Edit</th>
          <th class="print-hide">Delete</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td>{{ item.hazard }}</td>
          <td>{{ item.consequence }}</td>
          <td>{{ item.probability }}</td>
          <td>{{ item.severity }}</td>
          <td :style="{ backgroundColor: colorForValue(item.risk) }">{{ item.risk }}</td>
          <td>{{ item.peopleEffected }}</td>
          <td>{{ item.mitigation }}</td>
          <td>{{ item.mitigatedSeverity }}</td>
          <td :style="{ backgroundColor: colorForValue(item.residualRisk) }">{{ item.residualRisk }}</td>
          <td><button class="button2 print-hide" @click="$emit('editItem',(item.id))">Edit</button></td>
          <!-- <td><button class="button2" @click="deleteRiskAssessment(item.hazard)">Delete</button></td> -->
          <td><button class="button2 print-hide" @click="$emit('deleteItem',(item.id))">Delete</button></td>
        </tr>
      </tbody>
    </table>

  </div>
   
</template>

<script>
export default {
    name:"RiskAssessmentList",
    emits:["deleteItem","editItem"],

  data(){
    return{
      modalVisible:true
    }
  },
  props: {
    items: {
      type: Array,
      required: true
    }
  },
  methods: {


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
    
  }
}
</script>

<style>
/* CSS for table styling */
table {
  font-size: 0.75rem;
  width: 100%;
  overflow-x:auto;
}

th,
td {
  text-align: left;
  padding: 8px;
}

th {
  border: #b7bdb7;
}

tr:nth-child(even) {
  background-color: #f2f2f2;
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

@media (max-width: 600px){


  .table-container {
  max-height: calc(100% - 90px); /* Adjust the height to leave space for the buttons */
  overflow-y: auto; /* Enable vertical scrolling */
}

.table-container::-webkit-scrollbar{
  width:8px;
  height:8px;
  background: #ddd;
  border-radius: 0px 10px 10px 0px;
}

.table-container::-webkit-scrollbar-thumb{
  background:rgb(0, 68, 141);;
  border-radius: 10px;
}
}
@media print {
  /* Add print-specific styles here */
  /* td.green {
    background-color: #a3eb8d;
  }

  td.amber {
    background-color: #fdd170;
  }

  td.red {
    background-color: #ff7474;
  } */
}
  

</style>
