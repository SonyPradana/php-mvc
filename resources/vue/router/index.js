import Home from '../views/Home.vue'
import About from '../views/About.vue'
import PageNotFound from '../views/PageNotFound.vue'
import UserRequest from '../views/user/UserRequest.vue'

export default {
  mode: 'history',

  routes: [
    {
      path: '/home',
      name: 'home',
      component: Home,
    },
    {
      path: '/about',
      name: 'about',
      component: About,
    },
    // page not found adn reddirect
    {
      path: '*',
      component: PageNotFound,
      redirect: { name: 'home' }
    },
  ]
}
