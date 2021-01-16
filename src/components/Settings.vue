<template>
  <div class="settings">
    
    <form v-on:submit.prevent>
      <div class="btn-outer-box">
        <button @click="install" class="btn">Installieren</button>
      </div>
      
      <div class="outer-box">
        <div class="box box-bg-white">
          <h3 class="header-box green">Einstellungen</h3>
          <ul>
            <li class="box-input">
              Schulname
              <input type="text" name="name" v-model="values.name" placeholder="z.B. Staatliches Digitalgymnasium" required="true"/>
              <div class="input-underline"></div>
            </li>
            <li class="box-input">
              Schulnummer
              <input type="text" name="nummer" v-model="values.nummer" placeholder="0123" required="true" />
              <div class="input-underline">Vierstellig mit führender Null</div>
            </li>
            <li class="box-input">
              Name der Seite
              <input type="text" name="name1" v-model="values.name1" placeholder="RSU" maxlength="10" minlength="2" class="" required="true" >
              <input type="text" name="name2" v-model="values.name2" placeholder="intern" maxlength="10" minlength="2" class="" required="true" >
              <div class="input-underline">Zweiteilig. z.B. RSU intern</div>
            </li>
            <li class="box-input">
              Modus für Elternbenutzer
              <select v-model="values.elternbenutzer" class="" required="true">
                  <option value="ASV_CODE">Registrierungscodes</option>
                  <option value="ASV_MAIL">E-Mailadresse aus ASV Import verwenden</option>
              </select>
            </li>
            <li class="box-input">
              Stundenplan Software
              <select v-model="values.stundenplan" class="" required="true">
                  <option value="UNTIS">UNTIS</option>
                  <option value="SPM++">SPM++ / VPM++</option>
                  <option value="TIME2007">TIME2007</option>
                  <option value="WILLI">WILLI</option>
              </select>
            </li>
            <li class="box-input">
              Notenverwaltung aktivieren?
              <select v-model="values.notenverwaltung" class="">
                  <option value="false">Nein</option>
                  <option value="true">Ja</option>
              </select>
              <div class="input-underline">
                <strong>Bitte beachten:</strong>
                <br>Die Notenverwaltung ist bisher nur für Gymnasien und die Klassenstunden 5 bis 9 einsetzbar.
              </div>
            </li>
            
            
          </ul>

          <h3 class="header-box">System</h3>
          <ul>
            <li class="box-input">
              URL zur Index.php
              <input type="text" v-model="values.uri" placeholder="https://" required="true" />
              <div class="input-underline">
                <strong>Beachten Sie bitte folgende Hinweise:</strong>
                <ul>
                  <li>Wenn Sie SSL verwenden (Empfohlen!), dann geben Sie hier bitte die URL mit https beginnend ein!</li>
                  <li>Stellen Sie bitte am Server die automatische Umleitung auf SSL aus! Dies übernimmt die Software für Sie.</li>
                </ul>
              </div>
            </li>
            <li class="box-input">
              Schlüssel für Cron Jobs
              <input type="text" v-model="values.cronkey" placeholder="" required="true" />
              <div class="input-underline">
                Mindestens 20 Stellen, max 30 Stellen
              </div>
            </li>
            <li class="box-input">
              Schlüssel für API
              <input type="text" v-model="values.apikey" placeholder="" required="true" />
              <div class="input-underline">
                Mindestens 20 Stellen, max 30 Stellen
              </div>
            </li>
            <li class="box-input">
                Zu installierende Verson wählen 
                <select v-model="values.branch" class="" required="true" >
                    <option v-bind:key="index" v-for="(item, index) in values.branches" :value="item.Name">{{item.Desc}}</option>
                </select>
                <div class="input-underline">
                  Ausgewählte Version wird vom Updateserver heruntergeladen.
                </div>
            </li>
          </ul>

        </div>

        <div class="box box-bg-white">
          <h3 class="header-box red">Datenbank</h3>
          <ul>
            <li class="box-input">
              <strong>Bitte beachten Sie, dass die Datenbank bereits angelegt sein muss.</strong>
            </li>
            <li class="box-input">
              Datenbank - Host
              <input type="text" name="dbhost" v-model="values.dbhost" placeholder="z.B. localhost" required="true" />
            </li>
            <li class="box-input">
              Datenbank - Port
              <input type="text" name="dbport" v-model="values.dbport" placeholder="" required="true" />
            </li>
            <li class="box-input">
              Datenbank - Benutzername
              <input type="text" name="dbuser" v-model="values.dbuser" placeholder="z.B. root" required="true" />
            </li>
            <li class="box-input">
              Datenbank - Passwort
              <input type="text" name="dbpass" v-model="values.dbpass" placeholder="z.B. secret"  />
            </li>
            <li class="box-input">
              Datenbank - Datenbankname
              <input type="text" name="dbname" v-model="values.dbname" placeholder="z.B. schuleinterndatenbank" required="true" />
            </li>
          </ul>

          <h3 class="header-box blue">Administratorzugang</h3>

          <ul>
            <li class="box-input">
              E-Mail
              <input type="text" name="adminemail" v-model="values.adminemail" required="true"/>
            </li>
            <li class="box-input">
              Benutzername
              <input type="text" v-model="values.adminuser" required="true"/>
            </li>
            <li class="box-input">
              Passwort
              <input type="text" v-model="values.adminpass" required="true" />
              <div class="input-underline text-red">
                Bitte merken!
              </div>
            </li>
          </ul>
        </div>
      </div>

      <div class="btn-outer-box">
        <button @click="install" class="btn">Installieren</button>
      </div>
    </form>
    

  </div>
</template>

<script>

import axios from "axios";

export default {
  name: 'Settings',
  props: {
    apiRoot: String,
    userValues: Object
  },
  data: function () {
    return {
      values: {}
    }
  },
  created: function () {
    
    if (this.userValues.name) {
      this.setData(this.userValues);
    } else {
      this.init();
    }
    
  
  },
  methods: {
    init: function () {

      var that = this;

      axios.get(this.apiRoot+'install.php?action=settings')
      .then( function(response) {
        that.setData(response.data);
      }).catch(function (error) {
        console.error(error);
      });

    },
    setData: function (data) {

      this.values = data;

    },
    required: function () {

      if (!this.values.name
        || !this.values.nummer
        || !this.values.name1
        || !this.values.name2
        || !this.values.uri
        || !this.values.stundenplan
        // || this.values.notenverwaltung == ''
        || !this.values.elternbenutzer
        || !this.values.branch
        || !this.values.cronkey
        || !this.values.apikey
        || !this.values.dbhost
        || !this.values.dbport
        //|| !this.values.dbpass
        || !this.values.dbname
        || !this.values.dbuser
        || !this.values.adminemail
        || !this.values.adminuser
        || !this.values.adminpass
        
         ) {
          return false;
      } else {
          return true;
      }

    },
    install: function () {

      if ( !this.required() ) {
          // TODO: error msg
          //console.log(this.values);
          console.log('error: required');
          return false;
      }
      this.values.branches = false;

      EventBus.$emit('done--step', {
        settings: true,
        values: this.values
      })

    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
