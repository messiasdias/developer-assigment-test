import Vue from 'vue'
import App from './App.vue'
import Vuelidate from 'vuelidate'
import './styles/main.scss'
import './assets/fontawesome-free-5.15.3-web/js/all.min.js'
import 'bootstrap';

Vue.use(Vuelidate)
new Vue({
  render: h => h(App),
}).$mount('#app')
