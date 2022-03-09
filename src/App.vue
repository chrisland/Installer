<template>
  <div id="app">

    <nav>
      <ul>
        <li><a href="https://www.schule-intern.de" target="_blank">SchuleIntern Homepage</a></li>
        <li><a href="http://doku.schule-intern.de/display/ADMINHANDBUCH" target="_blank">Adminhandbuch</a></li>
        <li><a href="https://www.schule-intern.de/forum/" target="_blank">Support Forum</a></li>
        <li><a href="https://www.github.com/schuleintern" target="_blank">Github</a></li>
        <li>Installer Version 1.2</li>
      </ul>
    </nav>

    <div class="header">
      <div class="logo"></div>
      <div class="title">
        <h2>Installation</h2>
        <h1>SchuleIntern</h1>
      </div>
    </div>
    

    <Server v-if="steps == 'server'" v-bind:apiRoot="apiRoot" ></Server>

    <Settings v-if="steps == 'settings'" v-bind:apiRoot="apiRoot" v-bind:userValues="values"></Settings>

    <Install v-if="steps == 'install'"  v-bind:apiRoot="apiRoot" v-bind:userValues="values"></Install>

  </div>
</template>

<script>

import Server from "./components/Server.vue";
import Settings from "./components/Settings.vue";
import Install from "./components/Install.vue";


export default {
  name: 'app',
  components: {
    Server,
    Settings,
    Install
  },
  data: function () {
    return {
      apiRoot: './',
      dataPost: {},
      steps: 'server',
      values: {}
    }
  },
  created: function () {

    var that = this;

    EventBus.$on('done--step', data => {

      if (data.server == true) {
        //console.log('server done!');
        this.steps = 'settings';
      }

      if (data.settings == true && data.values) {
        //console.log('settings done!');
        that.values = data.values;
        this.steps = 'install';
      }

    });

  },  
  methods: {
    
  }
}
</script>

<style>


</style>
