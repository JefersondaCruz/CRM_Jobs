import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import store from "../store";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/access-denied',
      name: 'AccessDenied',
      component: () => import('@/views/AcessDeniedView.vue'),
      meta: {
        title: 'Acesso Negado',
      }
    },

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
        requiresAuth: true,
        requiresRecruiter: true
      }
    },
    {
      path: '/CandidateHistory',
      name: 'CandidateHistory',
      component: () => import('../views/CandidateHistoryView.vue'),
      meta: {
        title: 'CandidateHistory',
        requiresAuth: true,
        requiresCandidate: true
      }
    },
    {
      path: '/RegisterCandidate',
      name: 'Registercandidate',
      component: () => import('../views/RegisterCandidateView.vue'),
      meta: {
        title: 'RegisterCandidate',
        requiresAuth: true,
        requiresCandidate: true
      }
    },
    {
      path: '/FormsJobs',
      name: 'FormsJobs',
      component: () => import('../views/FormsJobsView.vue'),

      meta: {
        title: 'FormsJobs',
        requiresAuth: true,
        requiresRecruiter : true
      }
    },
    {
      path: '/EditForms/:id',
      name: 'EditForms',
      component: () => import('../views/EditFormsView.vue'),
      meta: {
        title: 'EditForms', 
        requiresAuth: true,
        requiresRecruiter : true
      }
    },
    {
      path: '/Home',
      name: 'HomeRecruiter',
      component: () => import('../views/HomeRecruiterView.vue'),
      meta: {
        title: 'HomeRecruiter',
        requiresAuth: true,
        requiresRecruiter: true
      }
    },
  ]
})

  router.beforeEach((to, from, next) => {
    document.title = to.meta.title;

    const userType = store.getters.getUser.type;
    const requiresAuth = to.meta.requiresAuth;
    const isRecruiterRoute = to.meta.requiresRecruiter;
    const isCandidateRoute = to.meta.requiresCandidate;
    if (to.meta.requiresAuth && !store.getters.loggedIn) {
      next('/SignIn');
    } else if (isRecruiterRoute && userType !== 'recruiter') {
      next('/access-denied');
    } else if (isCandidateRoute && userType !== 'candidate') {
      next('/acess-denied');
    } else {
      next()
    }
  });

export default router
