import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {
        title: 'Home'
      }
    },
    {
      path: '/SignUp',
      name: 'SignUp',
      component: () => import('../views/SignUpView.vue'),
      meta: {
        title: 'SignUp'
      }
    },
    {
      path: '/SignIn',
      name: 'SignIn',
      component: () => import('../views/SignInView.vue'),
      meta: {
        title: 'SignIn'
      }
    },
    {
      path: '/RegisterRecruiter',
      name: 'RegisterRecruiter',
      component: () => import('../views/RegisterRecruiterView.vue'),
      meta: {
        title: 'RegisterRecruiter'
      }
    },
    {
      path: '/RegisterCandidate',
      name: 'Registercandidate',
      component: () => import('../views/RegisterCandidateView.vue'),
      meta: {
        title: 'RegisterCandidate'
      }
    },
    {
      path: '/FormsJobs',
      name: 'FormsJobs',
      component: () => import('../views/FormsJobsView.vue'),
      meta: {
        title: 'FormsJobs'
      }
    },
    {
      path: '/EditForms',
      name: 'EditForms',
      component: () => import('../views/EditFormsView.vue'),
      meta: {
        title: 'EditForms'
      }
    },
    {
      path: '/Home',
      name: 'HomeRecruiter',
      component: () => import('../views/HomeRecruiterView.vue'),
      meta: {
        title: 'HomeRecruiter'
      }
    },
  ]
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});

export default router
