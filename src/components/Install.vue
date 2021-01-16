<template>
  <div class="settings">
    
    <div class="outer-box">
      <div v-if="install" class="box">

        <h4 class="text-red">Die Installation kann einige Zeit in Anspruch nehmen.<br>Bitte haben Sie Geduld.<br><br></h4>

        <ul>

          <li>
            <div class="box-long">
              Daten vom Server laden und entpacken
              <div class="text-red">{{list.downloadBranch.msg}}</div>
            </div>
            <div class="box-icon">
              <img v-if="list.downloadBranch.install == true && list.downloadBranch.return == true" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-if="list.downloadBranch.install == false && list.downloadBranch.return == false" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="list.downloadBranch == 'loading'" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>
          <li>
            <div class="box-long">
              Webserver Basisverzeichnis befüllen (CSS, JS, Bilder)
              <div class="text-red">{{list.moveFiles.msg}}</div>
            </div>
            <div class="box-icon">
              <img v-if="list.moveFiles.install == true && list.moveFiles.return == true" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-if="list.moveFiles.install == false && list.moveFiles.return == false" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="list.moveFiles == 'loading'" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>
          <li>
            <div class="box-long">
              Konfigurationsdatei schreiben (data/config/config.php)
              <div class="text-red">{{list.makeConfig.msg}}</div>
            </div>
            <div class="box-icon">
              <img v-if="list.makeConfig.install == true && list.makeConfig.return == true" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-if="list.makeConfig.install == false && list.makeConfig.return == false" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="list.makeConfig == 'loading'" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>
          <li>
            <div class="box-long">
              Tabellen in der Datenbank erstellen
              <div class="text-red">{{list.initDbTable.msg}}</div>
            </div>
            <div class="box-icon">
              <img v-if="list.initDbTable.install == true && list.initDbTable.return == true" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-if="list.initDbTable.install == false && list.initDbTable.return == false" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="list.initDbTable == 'loading'" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>
          <li>
            <div class="box-long">
              Administrator Zugang setzen
              <div class="text-red">{{list.preSettingsSql.msg}}</div>
            </div>
            <div class="box-icon">
              <img v-if="list.preSettingsSql.install == true && list.preSettingsSql.return == true" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-if="list.preSettingsSql.install == false && list.preSettingsSql.return == false" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="list.preSettingsSql == 'loading'" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>
          <li>
            <div class="box-long">
              Versenden der Zugangsdaten an den Admin
              <div class="text-red">{{list.sendMail.msg}}</div>
            </div>
            <div class="box-icon">
              <img v-if="list.sendMail.install == true" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-if="list.sendMail.install == false" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="list.sendMail == 'loading'" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>
          <li>
            <div class="box-long">
              Temporäre Daten löschen
              <div class="text-red">{{list.removeFolder.msg}}</div>
            </div>
            <div class="box-icon">
              <img v-if="list.removeFolder.install == true && list.removeFolder.return == true" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-if="list.removeFolder.install == false && list.removeFolder.return == false" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="list.removeFolder == 'loading'" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>
          
        </ul>
        
        <button v-if="!loading" class="btn" @click="back">Zurück</button>

        

      </div>

      

      <div v-if="install == false" class="outer-install"  >
        
        <div class="box-full box-done">
          <h2>Herzlichen Glückwunsch</h2>
          <h3>Die Installation war erfolgreich!</h3>
        </div>
        
        <div class="box-full">
          <h1>Und jetzt?</h1>
          <p class="text-red"><strong>Um das System in den Beriebszustand zu versetzen und abzusichern, müssen Sie noch folgendes erledigen:</strong></p>
        </div>  

        <div class="box">
          
          <h3>1. Cronjobs</h3>
          <p>Folgende Cronjobs müssen noch bei Ihrem Hoster angelegt werden:</p>
          <p></p>
          <ul>
            <li class="padding-tb">
              <div>
                <div class="input-small">{{cronUrl1}}</div>
                <div class="input-underline">Alle 15 Minuten</div>
              </div>
            </li>
            <li>
              <div class="padding-tb">
                <div class="input-small">{{cronUrl2}}</div>
                <div class="input-underline">Alle 3 Minuten</div>
              </div>
            </li>
          </ul>

          <h3>2. Domian</h3>
          <p>Falls noch nicht geschehen ändern Sie bitte den Pfad der Domain direkt auf den 'www' Ordner. Die Einstellungen dazu können Sie bei Ihrem Webhoster vornehmen.</p>

        </div>
        <div class="box">

          <h3>3. Installationsordner entfernen</h3>
          <p>Damit keine weitere Installation durchgeführt werden kann, muss der "install" Ordner vom Server gelöscht werden</p>
          <button v-if="loadingDeleteFolder == false"
            class="btn red" @click="deleteFolder">Jetzt löschen</button>
          <img v-if="loadingDeleteFolder == 'done'" src="../assets/icons/check.svg" alt="ok" title="ok" class="icon-done"/>
          <div v-if="loadingDeleteFolder == 'error'" class="box-red">{{loadingDeleteFolderError}}</div>
          <img v-if="loadingDeleteFolder == true" src="../assets/icons/spinner.gif" alt="loading" title="loading" class="icon-done"/>


          <h3>4. Support-Forum</h3>
          <p>Falls Sie Fragen oder Anregungen haben besuchen Sie unser Forum. Dort können mit der Community Lösungen, Probleme oder Wünsche besprochen werden.</p>
          <button class="btn yellow" @click="openWebsite">https://www.schule-intern.de</button>

          <div class="spacer-top"></div>
          <h2>Viel Erfolg mit Ihrer Installation der SchuleIntern Software!</h2>
          <button class="btn" @click="openSystem">Zur Website</button>

        </div>
      </div>
    </div>

  </div>
</template>

<script>

import axios from "axios";

export default {
  name: 'Finish',
  props: {
    apiRoot: String,
    userValues: Object
  },
  data: function () {
    return {
      loading: false,
      install: true,

      loadingDeleteFolder: false,
      loadingDeleteFolderError: 'Das Löschen war nicht erfolgreich. Bitte löschen Sie den Ordner manuell!',

      cronUrl1: '',
      cronUrl2: '',
      
      list: {  // Reihenfolge ist wichtig!
        downloadBranch: false,
        moveFiles: false,
        makeConfig: false,
        initDbTable: false,
        preSettingsSql: false,
        sendMail: false,
        removeFolder: false
      }
    }
  },
  created: function () {

    this.load();

  },
  methods: {
    
    load: function () {

      const list = Object.keys(this.list)
      var next = false;
      for (const key of list) {
        if ( !next && this.list[key] == false ) {
          next = key;
        }
      }

      if (!next) {
        //console.log('---- loop ende ----');
        // Loop ist fertig

        this.cronUrl1 = this.userValues.uri.replace("index.php","cron.php?cronkey="+this.userValues.cronkey);
        this.cronUrl2 = this.userValues.uri.replace("index.php","cron.php?cronkey="+this.userValues.cronkey+"&cronName=MailSender");

        this.install = false;

        for (const key of list) {
          // If error:
          if (this.list[key] == false) {
            this.install = true;
          }
        }
        
      } else {

        var params = new URLSearchParams();
        for (var prop in this.userValues) {
          params.append(prop, this.userValues[prop]);
        }

        this.loading = true;
        this.list[next] = 'loading';

        var that = this;
        axios.post(this.apiRoot+'install.php?action='+next, params)
        .then( function(response) {

          that.loading = false;
          that.list[next] = response.data;

          if (response.data.install == true) {
            
            that.load();
          } else {

            if (response.data.return.errorMsg) {
              that.list[next].msg = response.data.return.errorMsg;
            }
            that.list[next].return = false;
          }
        
        }).catch(function (error) {
          //console.log('error2', next, error);
          that.loading = false;
          that.list[next] = { "install": false, "return": false };
        });
      }

    },
    back: function () {

      EventBus.$emit('done--step', {
        server: true
      })

    },
    deleteFolder: function () {

      var that = this;

      this.loadingDeleteFolder = true;

      axios.get(this.apiRoot+'install.php?action=deleteFolder')
      .then( function(response) {
        if (response.data.install == true) {
          that.loadingDeleteFolder = 'done';
        } else {
          that.loadingDeleteFolder = 'error';
        }
        

      }).catch(function (error) {
        that.loadingDeleteFolder = 'error';
        console.error(error);
      });

    },
    openWebsite: function () {

      var win = window.open('https://www.schule-intern.de/forum/', '_blank');
      win.focus();

    },
    openSystem: function () {

      if (this.userValues.uri) {
        var win = window.open(this.userValues.uri, '_blank');
        win.focus();
      }
      
    }

  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
