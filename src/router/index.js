import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import LogOut from '../views/LogOut.vue'
import LogIn from '../views/LogIn.vue'
import MyTabs from '../views/MyTabs.vue'
import MyJobs from '../components/MyActiveJobs.vue'
import AllMyJobs from '../components/AllMyJobs.vue'
import navButtons from '../components/navButtons.vue'
import Job from '../views/Job.vue'
import newJob from '../views/newJob.vue'
import AllJobs from '../views/AllJobs.vue'
import ReportPage from '../views/ReportPage.vue'
import TimeSheetPage from '../views/TimeSheetPage.vue'
import GeneralRiskAssessment from '../views/GeneralRiskAssessment.vue'
import newJobModal from '../components/newJobModal.vue'


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    // path: '/LogIn',
     path: '/Login',
     name: 'Log In',
     component: LogIn
   },
  {
    path: '/LogOut',
    name: 'Log Out',
    component: LogOut
  },
  {
    path: '/MyTabs/:myName',//Jobs associated to name
    name: 'My Tabs',
    component: MyTabs,
    props:true
  },
  {
    path: '/MyTabs/:myName',//Jobs associated to name
    name: 'New Job',
    component: newJobModal,
    props:true
  },
  {
    path: '/MyJobs/:myName',//Jobs associated to name
    name: 'My Jobs',
    component: MyJobs,
    props:true
  },
   {
    path: '/navButtons',//Jobs associated to name
    name: 'navButtons',
    component: navButtons,
  },
  {
    path: '/AllMyJobs/:myName',//Jobs associated to name
    name: 'All My Jobs',
    component: AllMyJobs,
    props:true
  },
  {
    path: '/AllJobs',//ALL Jobs
    name: 'AllJobs',
    component: AllJobs,
  },

  {
    path: '/Job/:id/',//Selected Job
    name: 'Job',
    component: Job,
    props:true
  },
  {
    path: '/newJob',//Selected Job
    name: 'newJob',
    component: newJob,
  },
  {
    path: '/GeneralRiskAssessment/:id/:jobName',
    //path: '/GeneralRiskAssessment/:id',
    name: 'General Risk Assessment',
    component: GeneralRiskAssessment,
    props:true
  },
  {
    path: '/report',
    name: 'Report',
    component: ReportPage
  },
  {
    path: '/timesheet',
    name: 'TimeSheet',
    component: TimeSheetPage
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
  scrollBehavior() {
    document.getElementById('app').scrollIntoView({ behavior: 'smooth' });
}
})

export default router
