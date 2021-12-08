import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)

/* Guest Component */
function setComponent(path_file) {
    const route_path = "./components/app/pages/" + path_file + "Component.vue";
    return import ("" + route_path);
}

const Routes = [
 { path: "*", component: () => setComponent("error/404") },
    {
        path: "/",
        redirect: { path: '/home' }
    },
    {
        path : "/home",
        component:() => setComponent("Home"),
        name:"Home",
    },
 
]

var router  = new VueRouter({
    mode: 'history',
    routes: Routes
})

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.MIX_APP_NAME}`
    if(to.meta.middleware=="guest"){
        if(store.state.auth.authenticated){
            next({name:"dashboard"})
        }
        next()
    }else{
        if(store.state.auth.authenticated){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router