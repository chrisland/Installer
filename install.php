<?php 

define('UPDATESERVER', 'https://update.schule-intern.de');
define('FERIENURL', 'https://ferien.schule-intern.de/Ferien.txt');

define('FOLDER_SETUP', getcwd() );
define('FOLDER_WWW', FOLDER_SETUP.'/../');
define('FOLDER_TEMP', FOLDER_WWW.'/install_temp');
//define('FOLDER_ROOT', FOLDER_SETUP.'/../system');
define('FOLDER_ROOT', FOLDER_SETUP.'/../../');

error_reporting(0);

$action = $_GET['action'];
$Installer = new Installer;

switch ($action) {

  /*
    Step 1 - Server - get
  */
  case 'server';

    $branches = file_get_contents(UPDATESERVER . "/api/branches");
    if($branches != false) {
        $branches = true;
    }

    $zip = new ZipArchive();

    $return = array(
      'currentDir' => FOLDER_WWW,
      'currentDirWriteAble' => is_writable(FOLDER_WWW),
      'upperDir' => FOLDER_ROOT,
      'upperDirWriteable' => is_writable(FOLDER_ROOT), // Ein Verzeichnis nach oben
      'phpVersion' => phpversion(),
      'phpVersionCompare' => version_compare(phpversion(), '7.2.0', '>'),
      'branches' => $branches,
      'zipEnable' => $zip ? true : false
    );

    echo json_encode($return);
    exit;

    break;
  
  /*
    Step 2 - Settings - get
  */
  case 'settings';

    $branches = file_get_contents(UPDATESERVER . "/api/branches");
    if($branches === false) {
      exit;
    }

    $return = array(
      'uri' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}/index.php",
      'cronkey' => $Installer->getRandomString(30),
      'apikey' => $Installer->getRandomString(30),
      'adminuser' => 'admin',
      'dbport' => '3306',
      'adminpass' => $Installer->getRandomString(10),
      'notenverwaltung' => 0,
      'branches' => json_decode($branches, true)
    );

    echo json_encode($return);
    exit;

    break;


  /*
    Step 3.1 - downloadBranch
  */
  case 'downloadBranch':
    
    $return = array('install' => false);

    // required data
    if ( !$Installer->requiredPost() ) {
      $return = array('install' => false, 'error' => 'Missing Data');
      echo json_encode($return);
      exit;
    }
    
    $return['return'] = $Installer->downloadBranch();
    if ( $return['return'] === true ) {
      $return['install'] = true;
    }
    
    echo json_encode($return);
    exit;
    break;


  /*
    Step 3.2 - moveFiles
  */
  case 'moveFiles':
    
    $return = array('install' => false);

    // required data
    if ( !$Installer->requiredPost() ) {
      $return = array('install' => false, 'error' => 'Missing Data');
      echo json_encode($return);
      exit;
    }
    
    $return['return'] = $Installer->moveFiles();
    if ( $return['return'] === true ) {
      $return['install'] = true;
    }

    echo json_encode($return);
    exit;
    break;

  /*
    Step 3.3 - makeConfig
  */
  case 'makeConfig':
    
    $return = array('install' => false);

    // required data
    if ( !$Installer->requiredPost() ) {
      $return = array('install' => false, 'error' => 'Missing Data');
      echo json_encode($return);
      exit;
    }
    
    $return['return'] = $Installer->makeConfig();
    if ( $return['return'] === true ) {
      $return['install'] = true;
    }

    echo json_encode($return);
    exit;
    break;


  /*
    Step 3.4 - initDbTable
  */
  case 'initDbTable':
    
    $return = array('install' => false);

    // required data
    if ( !$Installer->requiredPost() ) {
      $return = array('install' => false, 'error' => 'Missing Data');
      echo json_encode($return);
      exit;
    }
    
    $return['return'] = $Installer->initDbTable();
    if ( $return['return'] === true ) {
      $return['install'] = true;
    }

    echo json_encode($return);
    exit;
    break;

  /*
    Step 3.5 - preSettingsSql
  */
  case 'preSettingsSql':

    $return = array('install' => false);

    // required data
    if ( !$Installer->requiredPost() ) {
      $return = array('install' => false, 'error' => 'Missing Data');
      echo json_encode($return);
      exit;
    }
    
    $return['return'] = $Installer->preSettingsSql();
    if ( $return['return'] === true ) {
      $return['install'] = true;
    }

    echo json_encode($return);
    exit;
    break;

  /*
    Step 3.6 - sendMail
  */
  case 'sendMail':
    
    $return = array('install' => false);

    // required data
    if ( !$Installer->requiredPost() ) {
      $return = array('install' => false, 'error' => 'Missing Data');
      echo json_encode($return);
      exit;
    }
    
    $return['return'] = $Installer->sendMail();
    if ( $return['return'] === true ) {
      $return['install'] = true;
    }

    echo json_encode($return);
    exit;
    break;

  /*
    Step 3.7 - removeFolder
  */
  case 'removeFolder':
    
    $return = array('install' => false);

    // required data
    if ( !$Installer->requiredPost() ) {
      $return = array('install' => false, 'error' => 'Missing Data');
      echo json_encode($return);
      exit;
    }
    
    $return['return'] = $Installer->removeFolder();
    if ( $return['return'] === true ) {
      $return['install'] = true;
    }

    echo json_encode($return);
    exit;
    break;




  /*
    Step Manual - deleteFolder - get
  */
  case 'deleteFolder';

    $return = array('install' => true);

    $return['deleteFolder'] = rrmdir(FOLDER_SETUP);

    if ( !$return['deleteFolder'] ) {
      $return =  array(
        'install' => false,
        'errorMsg' => 'Ordner konnte nicht gelöscht werden!'
      );
    }

    echo json_encode($return);
    exit;

    break;

  default:
    exit;
    break;

}

/**
 * 
 * Installer class for Webportal SchuleIntern
 * 
 * @category   WebportalSchuleIntern
 * @package    Installer
 * @author     Christian Marienfeld <post@chrisland.de>
 * @copyright  2019
 * @license    GPL-2.0
 * @version    1.0
 * @link       https://github.com/chrisland/Installer
 * @deprecated 
 */

class Installer {

  public $mysqli;

  public function preSettingsSql() {

    if (!$this->connectDB()) {
      return array(
        'errorMsg' => 'Es kann keine Verbindung zur Datenbank aufgebaut werden. '.$this->mysqli->error
      );
    }
    
    $version = file_get_contents(UPDATESERVER . "/api/branch/" . $_POST['branch'] . "/version");
    if ($version === false) {
      return array(
        'errorMsg' => 'Es kann leider keine aktuelle Version heruntergeladen werden.'
      );
    } else {
      $version = json_decode($version, true)['id'];

      if ($version) {
        $q = "INSERT INTO `settings` (`settingName`, `settingValue`)";
        $q .= " values('current-release-id', '$version' );";
        if ( !$this->mysqli->query($q) ) {
          return array(
            'errorMsg' => 'Datenbank Query konnte nicht richtig ausgeführt werden. CODE 001.'.$this->mysqli->error
          );
        }
  
      }
    }
    

    $password = crypt( trim((string)$_POST['adminpass']) , '$2a' . '$10' . '$' . substr(sha1(mt_rand()),0,22) );

    $username = (string)$_POST['adminuser'];
    $time = strtotime('now');

    if ($username && $password && $time) {
      $q = "INSERT INTO `users`";
      $q .= " (`userID`, `userName`, `userCachedPasswordHash`, `userCachedPasswordHashTime`, `userNetwork`)";
      $q .= " values ( 1, '$username', '$password', $time,'SCHULEINTERN');";

      if ( !$this->mysqli->query($q) ) {
        return array(
          'errorMsg' => 'Datenbank Query konnte nicht richtig ausgeführt werden. CODE 002'
        );
      }


      $q = "INSERT INTO `users_groups` (`userID`, `groupName`)";
      $q .= " values(1,'Webportal_Administrator');";

      if ( !$this->mysqli->query($q) ) {
        return array(
          'errorMsg' => 'Datenbank Query konnte nicht richtig ausgeführt werden. CODE 003'
        );
      }

    } else {
      return array(
        'errorMsg' => 'Adminuser oder Passwort ist leer!'
      );
    }

    return true;
  }

  public function sendMail() {

    $cronurl = str_replace('index.php','cron.php?cronkey='.$_POST['cronkey'], $_POST['uri']);

    $mailtext = '<html>
      <head>
          <title>Installation SchuleIntern</title>
      </head>
      <body>
        <h2>Herzlichen Glückwunsch</h2>
        <h3>Ihre Installation von SchuleIntern war erfolgreich</h3>
        <br>
        <b>Ihre URL</b>
        <br>
        <a href="'.$_POST['uri'].'">'.$_POST['uri'].'</a>
        <br>
        <br>
        <b>Ihre Zugangsdaten:</b>
        <br>
        Benutzer: <span>'.$_POST['adminuser'].'</span>
        <br>
        Passwort: <span>'.$_POST['adminpass'].'</span>
        <br>
        <br>

        <h1>Und jetzt?</h1>
        <strong>Um das System in den Beriebszustand zu versetzen und abzusichern, müssen Sie noch folgendes erledigen:</strong>
        <br>

        <h3>1. Cronjobs</h3>
        <p>Folgende Cronjobs müssen noch bei Ihrem Hoster angelegt werden:</p>
        <ul>
            <li>
                '.$cronurl.'
                <br>
                Alle 15 Minuten
            </li>
            <li>
              '.$cronurl.'&cronName=MailSender
              <br>
              Alle 3 Minuten
            </li>
        </ul>

        <h3>2. Domian</h3>
        <p>Falls noch nicht geschehen ändern Sie bitte den Pfad der Domain direkt auf den "www" Ordner. Die Einstellungen dazu können Sie bei Ihrem Webhoster vornehmen.</p>

        <h3>3. Installationsordner entfernen</h3>
        <p>Damit keine weitere Installation durchgeführt werden kann, muss der "install" Ordner vom Server gelöscht werden</p>

        <h3>4. Support-Forum</h3>
        <p>Falls Sie Fragen oder Anregungen haben besuchen Sie unser Forum. Dort können mit der Community Lösungen, Probleme oder Wünsche besprochen werden.</p>
        <a href="https://www.schule-intern.de/forum/">https://www.schule-intern.de/forum/</a>
        
        <div class="spacer-top"></div>
        <h2>Viel Erfolg mit Ihrer Installation der SchuleIntern Software!</h2>
        <a href="'.$_POST['uri'].'">Zur Website</a>
        <br><br>
      </body>
    </html>';

    $empfaenger = (string)$_POST['adminemail'] ; //Mailadresse
    $absender   = "SchuleIntern";
    $betreff    = "Installation SchuleIntern";
    $antwortan  = "Webportal-Installation";
    
    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=utf-8\r\n";
    
    $header .= "From: $absender\r\n";
    $header .= "Reply-To: $antwortan\r\n";
    // $header .= "Cc: $cc\r\n";  // falls an CC gesendet werden soll
    $header .= "X-Mailer: PHP ". phpversion();
    
    if ( mail( $empfaenger, $betreff, $mailtext, $header) ) {
      return true;
    }
 
    return false;
  }

  public function requiredPost() {

    $list = array(
      'dbhost',
      'dbport',
      'dbname',
      'dbuser',
      'name',
      'nummer',
      'name1',
      'name2',
      'uri',
      'cronkey',
      'apikey',
      'branch',
      'elternbenutzer',
      'stundenplan',
      'notenverwaltung',
      'adminemail',
      'adminuser',
      'adminpass'
    );

    for($i = 0; $i < count($list); $i++) {
      
      if ( !isset($list[$i]) || $list[$i] = '' ) {
        return false;
      }

    }
    
    return true;
  }

  public function removeFolder() {
    
    if ( !rrmdir(FOLDER_TEMP) ) {
      return array(
        'errorMsg' => 'Ordner konnte nicht gelöscht werden!'
      );
    }
    return true;

  }

  public function connectDB() {

    if ( !isset($_POST['dbhost']) ) {
      return array(
        'errorMsg' => 'Fehlende Daten! (Host)'
      );
    }
    if ( !isset($_POST['dbuser']) ) {
      return array(
        'errorMsg' => 'Fehlende Daten! (User)'
      );
    }
    if ( !isset($_POST['dbname']) ) {
      return array(
        'errorMsg' => 'Fehlende Daten! (Name)'
      );
    }

    $this->mysqli = new mysqli(
      (string)$_POST['dbhost'],
      (string)$_POST['dbuser'],
      (string)$_POST['dbpass'],
      (string)$_POST['dbname']
    );

    if ($this->mysqli->connect_errno) {
      return array(
        'errorMsg' => 'Es kann keine Verbindung zur Datenbank aufgebaut werden. '.$this->mysqli->error
      );
    }

    return true;

  }


  public function initDbTable() {

    if (!$this->connectDB()) {
      return array(
        'errorMsg' => 'Es kann keine Verbindung zur Datenbank aufgebaut werden. '.$this->mysqli->error
      );
    }

    if ( !file_exists(FOLDER_TEMP."/Datenbank/Installation/database.sql") ) {
      return array(
        'errorMsg' => 'Fehler beim Download und entpacken. database.sql wurde nicht gefunden.'
      );
    }
    $sqlInstallation = file_get_contents(FOLDER_TEMP."/Datenbank/Installation/database.sql");

    if ( !$sqlInstallation ) {
      return array(
        'errorMsg' => 'Datenbank Datei konnte nicht geöffnet werden.'
      );
    }

    if ( !$this->mysqli->multi_query($sqlInstallation) ) {
      return array(
        'errorMsg' => 'Datenbank Query konnte nicht richtig ausgeführt werden.'
      );
    }

    do {
      if($result = mysqli_store_result($this->mysqli)){
          mysqli_free_result($result);
      }
    } while(mysqli_next_result($this->mysqli));

    return true;

  }


  public function makeConfig() {

    // Make Config file
    $configTemp = file_get_contents("./config/temp.php");

    if ( !$configTemp ) {
      return array(
        'errorMsg' => 'Fehlende Config Vorlage.'
      );
    }

    $configTemp = str_replace('{{schulnummer}}', $_POST['nummer'], $configTemp);
    $configTemp = str_replace('{{dbhost}}', $_POST['dbhost'], $configTemp);
    $configTemp = str_replace('{{dbport}}', $_POST['dbport'], $configTemp);
    $configTemp = str_replace('{{dbname}}', $_POST['dbname'], $configTemp);
    $configTemp = str_replace('{{dbuser}}', $_POST['dbuser'], $configTemp);
    $configTemp = str_replace('{{dbpass}}', $_POST['dbpass'], $configTemp);
    $configTemp = str_replace('{{name}}', $_POST['name'], $configTemp);
    $configTemp = str_replace('{{name1}}', $_POST['name1'], $configTemp);
    $configTemp = str_replace('{{name2}}', $_POST['name2'], $configTemp);
    $configTemp = str_replace('{{uri}}', $_POST['uri'], $configTemp);
    $configTemp = str_replace('{{cronkey}}', $_POST['cronkey'], $configTemp);
    $configTemp = str_replace('{{apikey}}', $_POST['apikey'], $configTemp);
    $configTemp = str_replace('{{elternbenutzer}}', $_POST['elternbenutzer'], $configTemp);
    $configTemp = str_replace('{{stundenplan}}', $_POST['stundenplan'], $configTemp);
    $configTemp = str_replace('{{notenverwaltung}}', $_POST['notenverwaltung'], $configTemp);
    $configTemp = str_replace('{{ferienURL}}', FERIENURL, $configTemp);
    $configTemp = str_replace('{{updateServer}}', UPDATESERVER, $configTemp);

    if ( !file_put_contents(FOLDER_ROOT."/data/config/config.php", $configTemp) ) {
      return array(
        'errorMsg' => 'Datei konnte nicht gespeichert werden.'
      );
    }

    return true;
  }

  public function moveFiles() {

    // Move Files to Folders
    mkdir(FOLDER_ROOT);
    rename(FOLDER_TEMP."/Upload/cli", FOLDER_ROOT."/cli");
    rename(FOLDER_TEMP."/Upload/data", FOLDER_ROOT."/data");
    rename(FOLDER_TEMP."/Upload/framework", FOLDER_ROOT."/framework");
    //rename(FOLDER_TEMP."/Upload/www", FOLDER_ROOT."/../");
    recCopy(FOLDER_TEMP."/Upload/www", FOLDER_ROOT."/www");
    return true;

  }

  public function downloadBranch() {

    $version = file_get_contents(UPDATESERVER . "/api/branch/" . $_POST['branch'] . "/version");

    if ($version === false) {
      
      return array(
        'errorMsg' => 'Es kann leider keine aktuelle Version heruntergeladen werden.'
      );
    
    } else {
        $version = json_decode($version, true);
        $url = UPDATESERVER . "/api/release/" . $version['id'] . "/download";

        mkdir(FOLDER_TEMP);
        file_put_contents(FOLDER_TEMP."/install.zip", fopen($url, 'r'));

        $zip = new ZipArchive;
        if ($zip->open(FOLDER_TEMP.'/install.zip') === TRUE) {
            $zip->extractTo(FOLDER_TEMP.'/');
            $zip->close();
            return true;

        } else {
            return array(
              'errorMsg' => 'Installationsdatei konnte nicht entpackt werden.'
            );
        }
    }
    
  }

  public function getRandomString($length) {
    return str_replace("+","S", str_replace("/", "L", substr(base64_encode(random_bytes(100)), 4, $length)));
  }

}

function rrmdir($dir) { 
  if (is_dir($dir)) { 
    $objects = scandir($dir); 
    foreach ($objects as $object) { 
      if ($object != "." && $object != "..") { 
        if (is_dir($dir."/".$object))
          rrmdir($dir."/".$object);
        else
          unlink($dir."/".$object); 
      } 
    }
    rmdir($dir); 
    return true;
  } 
  return false;
}

function recCopy($source,$destination) {
  $dir = opendir($source);
  @mkdir($destination);
  while(( $file = readdir($dir)) ) {
      if (( $file != '.' ) && ( $file != '..' ) && $file != '.gitignore') {
          if ( is_dir($source . '/' . $file) ) {
              recCopy($source .'/'. $file, $destination .'/'. $file);
          }
          else {
              copy($source .'/'. $file,$destination .'/'. $file);
          }
      }
  }
  closedir($dir);
}