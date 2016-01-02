<?php
class Rosine_Template
{
    /**
     * Der Ordner in dem sich die Templates befinden.
     *
     * @access    private
     * @var       string
     */
    private $templateDir = "templates/rosine/";

    /**
     * Der Ordner in dem sich die Sprach-Dateien befinden.
     *
     * @access    private
     * @var       string
     */
    private $languageDir = "languages/";

    /**
     * Der linke Delimter für einen Standard-Platzhalter.
     *
     * @access    private
     * @var       string
     */
    private $leftDelimiter = '{$';

    /**
     * Der rechte Delimter für einen Standard-Platzhalter.
     *
     * @access    private
     * @var       string
     */
    private $rightDelimiter = '}';

    /**
     * Der linke Delimter für eine Funktion.
     *
     * @access    private
     * @var       string
     */
    private $leftDelimiterF = '{';

    /**
     * Der rechte Delimter für eine Funktion.
     *
     * @access    private
     * @var       string
     */
    private $rightDelimiterF = '}';

    /**
     * Der linke Delimter für ein Kommentar.
     * Sonderzeichen müssen escapt werden, weil der Delimter in einem regulärem
     * Ausdruck verwendet wird.
     *
     * @access    private
     * @var       string
     */
    private $leftDelimiterC = '\{\*';

    /**
     * Der rechte Delimter für ein Kommentar.
     * Sonderzeichen müssen escapt werden, weil der Delimter in einem regulärem
     * Ausdruck verwendet wird.
     *
     * @access    private
     * @var       string
     */
    private $rightDelimiterC = '\*\}';

    /**
     * Der linke Delimter für eine Sprachvariable
     * Sonderzeichen müssen escapt werden, weil der Delimter in einem regulärem
     * Ausdruck verwendet wird.
     *
     * @access    private
     * @var       string
     */
    private $leftDelimiterL = '\{L_';

    /**
     * Der rechte Delimter für eine Sprachvariable
     * Sonderzeichen müssen escapt werden, weil der Delimter in einem regulärem
     * Ausdruck verwendet wird.
     *
     * @access    private
     * @var       string
     */
    private $rightDelimiterL = '\}';

    /**
     * Der komplette Pfad der Templatedatei.
     *
     * @access    private
     * @var       string
     */
    private $templateFile = "";

    /**
     * Der komplette Pfad der Sprachdatei.
     *
     * @access    private
     * @var       string
     */
    private $languageFile = "";

    /**
     * Der Dateiname der Templatedatei.
     *
     * @access    private
     * @var       string
     */
    private $templateName = "";

    /**
     * Der Inhalt des Templates.
     *
     * @access    private
     * @var       string
     */
    private $template = "";


    /**
     * Die Pfade festlegen.
     *
     * @access    public
     */
    public function __construct($tpl_dir = "", $lang_dir = "") {
        // Template Ordner
        if ( !empty($tpl_dir) ) {
            $this->templateDir = $tpl_dir;
        }

        // Sprachdatei Ordner
        if ( !empty($lang_dir) ) {
            $this->languageDir = $lang_dir;
        }
    }

    /**
     * Eine Templatedatei öffnen.
     *
     * @access    public
     * @param     string $file Dateiname des Templates.
     * @uses      $templateName
     * @uses      $templateFile
     * @uses      $templateDir
     * @uses      parseFunctions()
     * @return    boolean
     */
    public function load($file)    {
        // Eigenschaften zuweisen
        $this->templateName = $file;
        $this->templateFile = $this->templateDir.$file;

        // Wenn ein Dateiname übergeben wurde, versuchen, die Datei zu öffnen
        if( !empty($this->templateFile) ) {
            if( file_exists($this->templateFile) ) {
                $this->template = file_get_contents($this->templateFile);
            } else {
                return false;
            }
        } else {
           return false;
        }

        // Funktionen parsen
        $this->parseFunctions();
    }

    /**
     * Einen Standard-Platzhalter ersetzen.
     *
     * @access    public
     * @param     string $replace     Name des Platzhalters.
     * @param     string $replacement Der Text, mit dem der Platzhalter ersetzt
     *                                werden soll.
     * @uses      $leftDelimiter
     * @uses      $rightDelimiter
     * @uses      $template
     */
    public function assign($replace, $replacement) {
        $this->template = str_replace( $this->leftDelimiter .$replace.$this->rightDelimiter,
                                       $replacement, $this->template );
    }
    
	
    /**
     * Die Sprachdateien öffnen und Sprachvariablem im Template ersetzen.
     *
     * @access    public
     * @param     array $files Dateinamen der Sprachdateien.
     * @uses      $languageFiles
     * @uses      $languageDir
     * @uses      replaceLangVars()
     * @return    array
     */
    public function loadLanguage($files) {
        $this->languageFiles = $files;

        // Versuchen, alle Sprachdateien einzubinden
        for( $i = 0; $i < count( $this->languageFiles ); $i++ ) {
            if ( !file_exists( $this->languageDir .$this->languageFiles[$i] ) ) {
                return false;
            } else {
                 include_once( $this->languageDir .$this->languageFiles[$i] );
                 // Jetzt steht das Array $lang zur Verfügung
            }
        }

        // Die Sprachvariablen mit dem Text ersetzen
        $this->replaceLangVars($lang);

        // $lang zurückgeben, damit $lang auch im PHP-Code verwendet werden kann
        return $lang;
    }

    /**
     * Sprachvariablen im Template ersetzen.
     *
     * @access    private
     * @param     string $lang Die Sprachvariablen.
     * @uses      $template
     */
    private function replaceLangVars($lang) {
        $this->template = preg_replace("/\{L_(.*)\}/isUe", "\$lang[strtolower('\\1')]", $this->template);
    }

    /**
     * Includes parsen und Kommentare aus dem Template entfernen.
     *
     * @access    private
     * @uses      $leftDelimiterF
     * @uses      $rightDelimiterF
     * @uses      $template
     * @uses      $leftDelimiterC
     * @uses      $rightDelimiterC
     */
    private function parseFunctions() {
        // Includes ersetzen ( {include file="..."} )
        while( preg_match( "/" .$this->leftDelimiterF ."include file=\"(.*)\.(.*)\""
                           .$this->rightDelimiterF ."/isUe", $this->template) )
        {
            $this->template = preg_replace( "/" .$this->leftDelimiterF ."include file=\"(.*)\.(.*)\""
                                            .$this->rightDelimiterF."/isUe",
                                            "file_get_contents(\$this->templateDir.'\\1'.'.'.'\\2')",
                                            $this->template );
        }


        // Kommentare löschen
        $this->template = preg_replace( "/" .$this->leftDelimiterC ."(.*)" .$this->rightDelimiterC ."/isUe",
                                        "", $this->template );
    }

    /**
     * Das "fertige Template" ausgeben.
     *
     * @access    public
     * @uses      $template
     */
    public function display() {
        echo $this->template;
    }
}
?>
