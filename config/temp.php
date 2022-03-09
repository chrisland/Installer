<?php

class GlobalSettings {
    /**
     * Ist die Anwendung im Debug modus?
     * @var bool
     */
    public $debugMode = false;

    /**
     * Schulnummer als String (mit führender Null)
     * @var string
     */
    public $schulnummer = "{{schulnummer}}";

    /**
     * Datenbankeinstellungen für diese Installation
     * @var array
     */
    public $dbSettigns = array(
        'host' => '{{dbhost}}',
        'port' => {{dbport}},
        'user' => '{{dbuser}}',
        'password' => '{{dbpass}}',
        'database' => '{{dbname}}'
    );

    /**
     * URL zur index.php für diese Installation (SSL!)
     * @var string
     */
    public $urlToIndexPHP = "{{uri}}";

    /**
     * Schlüssel zum Ausführen des Cron Jobs.
     * @var string
     */
    public $cronkey = "{{cronkey}}";

    /**
     * Schlüssel für den Zugriff auf die API
     * @var string
     */
    public $apiKey = "{{apikey}}";

    /**
     * Seitenname zur Darstellung auf LoginSeite
     * @var string
     */
    public $siteNameHTMLDisplay = "<b>{{name1}}</b>{{name2}}";

    /**
     * Seitenname zur Darstellung auf LoginSeite
     * @var string
     */
    public $siteNameHTMLDisplayShort = "<b>{{name1}}</b>";

    /**
     * Einfacher Seitenname
     * @var string
     */
    public $siteNamePlain = "{{name1}}{{name2}}";
    /**
     * Schulname
     * @var string
     */
    public $schoolName = "{{name}}";

    /**
     * Modus der Schülerbenutzer:
     * SYNC:	Synchronisierung
     * ASV:		Benutzer kommen aus der ASV (werden automatisch erstellt.)
     * @var string
     */
    public $schuelerUserMode = "ASV";
    /**
     * Modus der Lehrerbenutzer:
     * SYNC:	Synchronisierung
     * ASV:		Benutzer kommen aus der ASV (werden automatisch erstellt.)
     * @var string
     */
    public $lehrerUserMode = "ASV";
    /**
     * Modus der Eltern:
     * ASV_MAIL:		E-Mailadressen kommen aus der ASV
     * ASV_CODE:		Eltern bekommen Elternbrief mit Code zur Selbstregistrierung^
     * KLASSENELTERN
     * @var string
     */
    public $elternUserMode = "{{elternbenutzer}}";

    /**
     * Verwendete Stundenplan Software
     * UNTIS, SPM++, SPM++V2
     * @var string
     */
    public $stundenplanSoftware = "{{stundenplan}}";

    /**
     * Hat eine Notenverwaltung?
     * @var boolean
     */
    public $hasNotenverwaltung = {{notenverwaltung}};

    /**
     * Daten der Azure App, die für den Zugriff auf die GraphAPI nötig ist.
     * @var array
     */
    public $office365AppCredentials = [
        'client_id' => '',
        'scope' => 'https://graph.microsoft.com/.default',
        'client_secret' => '',
        'grant_type' => 'client_credentials'
    ];

    /**
     * URL zur Ferienliste für den Import in den Kalender.
     * @var string
     */
    public $ferienURL = "{{ferienURL}}";

    /**
     * Domain des Update Servers
     * @var string
     */
    public $updateServer = "{{updateServer}}";

    /**
     * Domain des Extension Servers
     * @var string
     */
    public $extensionsServer = "https://extensions.schule-intern.de/";

}