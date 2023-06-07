<template>
<div class="container">
  <h3>Logged in as {{ myName }}</h3>
    
  <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" 
      type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Active Jobs</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" 
      type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Week Ahead</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="timesheet-tab" data-bs-toggle="tab" data-bs-target="#timesheet-tab-pane" 
      type="button" role="tab" aria-controls="timesheet-tab-pane" aria-selected="false">Timesheet</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link " id="all-jobs-tab" data-bs-toggle="tab" data-bs-target="#all-jobs-tab-pane" 
      type="button" role="tab" aria-controls="all-jobs-tab-pane" aria-selected="false">All Jobs</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
      <MyJobs :myName="myName"
      ></MyJobs>
    </div>
    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
      Week Ahead
    
    </div>
    <div class="tab-pane fade" id="timesheet-tab-pane" role="tabpanel" aria-labelledby="timesheet-tab" tabindex="0">
      My Timesheet
    </div>
    <div class="tab-pane fade " id="all-jobs-tab-pane" role="tabpanel" aria-labelledby="all-jobs-tab" tabindex="0">
      <AllMyJobs :myName="myName"
      ></AllMyJobs>
    </div>
  </div>
  
</div>

 
</template>

<script>

import MyJobs from '../components/MyActiveJobs.vue';
import AllMyJobs from '../components/AllMyJobs.vue';


export default {
    props: ["myName"],
    components: { MyJobs, AllMyJobs}
}
</script>

<style>

</style>