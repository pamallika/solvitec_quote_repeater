import { createRouter, createWebHistory } from "vue-router"
import LoginComponent from "@/components/Auth/LoginComponent.vue";
import RegistrationComponent from "@/components/Auth/RegistrationComponent.vue";
import DashboardComponent from "@/components/DashboardComponent.vue";
const routes = [
    {
        path : "/auth/login",
        component : LoginComponent
    },
    {
        path : "/auth/registration",
        component : RegistrationComponent
    },
    {
        path: "/dashboard",
        component: DashboardComponent
    }
]

const router = createRouter({
    history : createWebHistory(),
    routes : routes
})
export default router;
