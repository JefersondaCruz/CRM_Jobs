import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import store from "../store";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {
        title: 'Home',
      }
    },
    {
      path: '/perfil',
      name: 'profile',
      component: () => import('../views/ProfileView.vue'),
      meta: {
        title: 'profile',
        requiresAuth: true
      }
    },
    {
      path: '/SignUp',
      name: 'SignUp',
      component: () => import('../views/SignUpView.vue'),
      meta: {
        title: 'SignUp',
      }
    },
    {
      path: '/SignIn',
      name: 'SignIn',
      component: () => import('../views/SignInView.vue'),
      meta: {
        title: 'SignIn',
      }
    },
    {
      path: '/RegisterRecruiter',
      name: 'RegisterRecruiter',
      component: () => import('../views/RegisterRecruiterView.vue'),
      meta: {
        title: 'RegisterRecruiter',
        requiresAuth: true
      }
    },
    {
      path: '/RegisterCandidate',
      name: 'Registercandidate',
      component: () => import('../views/RegisterCandidateView.vue'),
      meta: {
        title: 'RegisterCandidate',
        requiresAuth: true
      }
    },
    {
      path: '/FormsJobs',
      name: 'FormsJobs',
      component: () => import('../views/FormsJobsView.vue'),

      meta: {
        title: 'FormsJobs',
        requiresAuth: true
      }
    },
    {
      path: '/EditForms',
      name: 'EditForms',
      component: () => import('../views/EditFormsView.vue'),
      meta: {
        title: 'EditForms',
        requiresAuth: true
      }
    },
    {
      path: '/Home',
      name: 'HomeRecruiter',
      component: () => import('../views/HomeRecruiterView.vue'),
      meta: {
        title: 'HomeRecruiter',
        requiresAuth: true
      }
    },
  ]
})

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  
  console.log('requiresAuth:', to.meta.requiresAuth);
  console.log('loggedIn:', store.getters.loggedIn);
  if (to.meta.requiresAuth && !store.getters.loggedIn) {
    next('/SignIn');
  } else {
    next();
    }
});

export default router
