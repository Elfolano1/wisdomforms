import { createRouter, createWebHashHistory,createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authstore";
import NProgress from "nprogress/nprogress.js";

// Main layout variations
import LayoutSimple from "@/layouts/variations/Simple.vue";
import LayoutLanding from "@/layouts/variations/Landing.vue";
import LayoutBackend from "@/layouts/variations/Backend.vue";

// Frontend: Landing
const Landing = () => import("@/views/landing/LandingView.vue");


// Backend: Dashboard
const BackendDashboard = () => import("@/views/backend/DashboardView.vue");

//interview
const InterviewForms=()=> import("@/views/interviewForms/interviewForm.vue");
const EditinterviewForm=()=> import("@/views/interviewForms/EditinterviewForm.vue");
const InterviewFormsList=()=> import("@/views/interviewForms/interviewFormList.vue");

// Backend: Generic Pages
const BackendPagesGenericBlank = () =>
  import("@/views/backend/pages/generic/BlankView.vue");
const BackendPagesGenericSearch = () =>
  import("@/views/backend/pages/generic/SearchView.vue");
const BackendPagesGenericProfile = () =>
  import("@/views/backend/pages/generic/ProfileView.vue");
// Auth
const AuthSignIn = () => import("@/views/auth/SignInView.vue");
const AuthSignUp = () => import("@/views/auth/SignUpView.vue");
const AuthLock = () => import("@/views/auth/LockView.vue");
const AuthReminder = () => import("@/views/auth/ReminderView.vue");


// Set all routes
const routes = [
  /*
  |
  |--------------------------------------------------------------------------
  | Landing Routes
  |--------------------------------------------------------------------------
  |
  */
  {
    path: "/",
    component: LayoutLanding,
    children: [
      {
        path: "",
        name: "landing",
        component: Landing,
      },
    ],
  },




  /*
  |
  |--------------------------------------------------------------------------
  | Backend Routes
  |--------------------------------------------------------------------------
  |
  */
  {
    path: "/forms",
    redirect: "/forms/dashboard",
    component: LayoutBackend,
    children: [
      {
        path: "dashboard",
        name: "backend-dashboard",
        component: BackendDashboard,
      },

      /*
      |--------------------------------------------------------------------------
      | Backend Generic Pages Routes
      |--------------------------------------------------------------------------
      */
      {
        path: "",
        redirect: "/blank",
        children: [

          {
            path: "interview",
            name: "interview-form",
            component: InterviewForms,
              meta: { requiresAuth: true }
          },
          {
            path: "Editinterview/:id",
            name: "edit-interview-form",
            props: true,
            component: EditinterviewForm,
              meta: { requiresAuth: true }
          },
          {
            path: "interviewList",
            name: "interview-form-list",
            component: InterviewFormsList,
              meta: { requiresAuth: true }
          },
          {
            path: "search",
            name: "backend-pages-generic-search",
            component: BackendPagesGenericSearch,
          },
          {
            path: "profile",
            name: "backend-pages-generic-profile",
            component: BackendPagesGenericProfile,
          },


        ],
      },
      /*
      |--------------------------------------------------------------------------
      | Backend Generic Pages Routes
      |--------------------------------------------------------------------------
      */
      {
        path: "pages/generic",
        redirect: "/pages/generic/blank",
        children: [
          {
            path: "blank",
            name: "backend-pages-generic-blank",
            component: BackendPagesGenericBlank,
          },
          {
            path: "interview",
            name: "interview-form",
            component: InterviewForms,
              meta: { requiresAuth: true }
          },
          {
            path: "search",
            name: "backend-pages-generic-search",
            component: BackendPagesGenericSearch,
          },
          {
            path: "profile",
            name: "backend-pages-generic-profile",
            component: BackendPagesGenericProfile,
          },


        ],
      },

    ],
  },


  /*
  |
  |--------------------------------------------------------------------------
  | Auth Routes
  |--------------------------------------------------------------------------
  |
  */
  {
    path: "/auth",
    component: LayoutSimple,
    children: [
      {
        path: "signin",
        name: "auth-signin",
        component: AuthSignIn,
      },
      {
        path: "signup",
        name: "auth-signup",
        component: AuthSignUp,
      },
      {
        path: "lock",
        name: "auth-lock",
        component: AuthLock,
      },
      {
        path: "reminder",
        name: "auth-reminder",
        component: AuthReminder,
      },

    ],
  },

];

// Create Router
const router = createRouter({
  history: createWebHistory(),
  linkActiveClass: "active",
  linkExactActiveClass: "",
  scrollBehavior() {
    return { left: 0, top: 0 };
  },
  routes,
});

// NProgress
/*eslint-disable no-unused-vars*/
NProgress.configure({ showSpinner: false });
router.beforeResolve((to, from, next) => {
    if (to.name) {
        NProgress.start();
    }

    next();
});

router.afterEach(() => {
    NProgress.done();
});


//to.meta.requiresAuth = undefined;
// router.beforeEach((to,from,next)=>{
//     const authstore = useAuthStore();
//
//     if (!authstore.user.token) {
//         next({name:'landing'})
//     }else{
//         next()
//     }
//
// })
/*eslint-enable no-unused-vars*/

export default router;
