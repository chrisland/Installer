import Vue from 'vue'
import App from './App.vue'

window.EventBus = new Vue();


Vue.config.productionTip = false

require('./assets/css/style.css')

document.title = 'SchuleIntern Installer';

new Vue({
  render: h => h(App),
}).$mount('#app')
