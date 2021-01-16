<template>
  <div class="server">

    <div class="outer-box">
      <div class="boxlist">
        <h2>Herzlich Willkommen bei der Installation zu SchuleIntern.</h2>
        <p>
          Bitte legen Sie sich folgende Daten bereit:
        </p>
        <ul class="ullist">
          <li>Ihren Schulnamen und die Schulnummer</li>
          <li>MySQL / MariaDB Datenbank mit passenden Zugangsdaten</li>
          <li>Name der Stundenplansoftware</li>
        </ul>
      </div>
      <div class="box box-bg-white">
          
        <h3>Server Test</h3>

        <ul>

          <li>
            <div class="box-long">
              Schreibrechte im Übergeordnetem Verzeichnis
              <p>
                Zur Sicherheit speichert SchuleIntern alle Daten außerhalb des öffentlichen Bereichs.
              </p>
              <div class="info">
                {{values.upperDir}}
              </div>
            </div>
            <div class="box-icon">
              <img v-if="!loading && values.upperDirWriteable" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-else-if="!loading && !values.upperDirWriteable" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="loading" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>
          <li>
            <div class="box-long">
              Schreibrechte im aktuellen Verzeichnis
              <div class="info">
                {{values.currentDir}}
              </div>
            </div>
            <div class="box-icon">
              <img v-if="!loading && values.currentDirWriteAble" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-else-if="!loading && !values.currentDirWriteAble" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="loading" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>
          <li>
            <div class="box-long">
              PHP Version
              <div class="info">
                Min. 7.2 - Installiert: {{values.phpVersion}}
              </div>
            </div>
            <div class="box-icon">
              <img v-if="!loading && values.phpVersionCompare" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-else-if="!loading && values.phpVersionCompare == false" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="loading" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>

          <li>
            <div class="box-long">
              PHP Zip Erweiterung
            </div>
            <div class="box-icon">
              <img v-if="!loading && values.zipEnable" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-else-if="!loading && values.zipEnable == false" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="loading" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>

          <li>
            <div class="box-long">
              Verbindung zum Update Server
              <div class="info"></div>
            </div>
            <div class="box-icon">
              <img v-if="!loading && values.branches" src="../assets/icons/check.svg" alt="ok" title="ok"/>
              <img v-else-if="!loading && ( !values.branches || values.branches == false)" src="../assets/icons/cancel.svg" alt="error" title="error"/>
              <img v-if="loading" src="../assets/icons/spinner.gif" alt="loading" title="loading"/>
            </div>
          </li>

        </ul>
        <div class="btn-box">
          <button v-if="btnState == false" @click="refresh"
            class="btn">Erneut Testen</button>
        </div>

      </div>
    </div>
    <div class="btn-outer-box">
      <button v-if="btnState" @click="next" class="btn">Weiter</button>
    </div>

    
  </div>
</template>

<script>

import axios from "axios";



export default {
  name: 'Server',
  props: {
    apiRoot: String
  },
  data: function () {
    return {
      values: false,
      btnState: false,
      loading: false
    }
  },
  created: function () {
    this.init();
  },
  methods: {
    init: function () {

      var that = this;

      this.loading = true;

      axios.get(this.apiRoot+'install.php?action=server')
      .then( function(response) {
        that.setData(response.data);
        
      }).catch(function (error) {

        that.setData( {
          upperDirWriteable: false,
          currentDirWriteAble: false,
          phpVersionCompare: false
        });

        console.error(error);
      });

    },
    setData: function (data) {

      this.values = data;

      if ( !this.required() ) {
          this.btnState = false;
      } else {
          this.btnState = true;
      }

      this.loading = false;

    },
    required: function () {

      if (!this.values.upperDirWriteable
        || !this.values.currentDirWriteAble
        || !this.values.phpVersionCompare) {
          return false;
      } else {
          return true;
      }

    },
    refresh: function () {

      this.init();

    },
    next: function () {

      if ( !this.required() ) {
          return false;
      }

      EventBus.$emit('done--step', {
        server: true
      })

    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
