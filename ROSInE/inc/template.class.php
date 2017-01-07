<?php
/*********************************************************************************\
 * Author: Corvin Gröning                                                         * 
 * http://www.webmasterpro.de/coding/article/php-ein-eigenes-template-system.html *
 * changes to this file made by André Scholz                                      *
 * --------------------------------------------                                   *
 * For licence see upper webpage                                                  *
 * Date of this file: 2017-01-07                                                  *
 \********************************************************************************/

class Rosine_Template
{
    /**
     * Der Ordner in dem sich die Templates befinden.
     *
     * @access    private
     * @var       string
     */
	
    private $templateDir = "";

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
     * sets the variable templateDir
     *
     * returns nothing
     */
    
	public function set_templateDir($templateDir){
		$this->templateDir=$templateDir;
	}// end function set_templateDir
    
    public function rosine_setup_templates($renew="no"){
        echo 'This seems a new installation or this template is missing! Trying to copy it from the defaults!<br>';
        echo' Es scheint, dies ist eine neue Installation - es wird versucht, die Templates aus den Vorlagen zu kopieren!<br>';
        //copy template files
        //create folder if not exists
        if (!is_dir($this->templateDir)){
                mkdir(substr($this->templateDir,0,-1),0777,1);
                echo '<br>'.substr($this->templateDir,0,-1).' created <br>';
        }// endif
        echo 'Installation completed if there are no errors... <h1>Click <a href="index.php">here</a> to reload page!</h1><br>';
        $source_dir = opendir ('./templates/rosine_templates');
        while ($file = readdir ($source_dir))   { // read folder

                //copies only if file not exists. that way Your templates aren't overwritten!
                if ($file!='.' 
                		&& $file!='..' 
                		&& (
                				!is_file($this->templateDir.$file) 
                				|| $renew="yes"))
                {
	                        echo $file.' to '.$this->templateDir.$file;
	                        if (copy('./templates/rosine_templates/'.$file,$this->templateDir.$file)){
	                        	echo ' copied!<br>';
	                        }
	                        else {
	                        	echo ' could not be copied!<br>';
	                        }
                }//endif
    			
        }//endwhile
        closedir($source_dir);
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
        /* if there's a folder name in database, use this instead
         * this is mainly used for docker installations
         */
        if ($this->templateDir=='') {
        	echo 'Error(.1):Template Folder is not set!<br>';
        }//endif 
    	$this->templateName = $file;
        $this->templateFile = $this->templateDir.$file;
        
        // if a file name is offered, try to get the file 
        if( !empty($this->templateFile) ) {
            if( file_exists($this->templateFile) ) {
                $this->template = file_get_contents($this->templateFile);
            } else {
                echo "<br>Error: Template ".$this->templateFile." is missing<br>";
            	$this->rosine_setup_templates($this->templateDir);
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
//        $this->template = preg_replace("/\{L_(.*)\}/isUe", "\$lang[strtolower('\\1')]", 
//                                $this->template); deprecated
        $this->template =preg_replace_callback("/\{L_(.*)\}/isU", function ($m) use ($lang){
        							return $lang[strtolower($m[1])];
    								},
        						$this->template);
        
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
/*            $this->template = preg_replace( "/" .$this->leftDelimiterF ."include file=\"(.*)\.(.*)\""
                                            .$this->rightDelimiterF."/isUe",
                                            "file_get_contents(\$this->templateDir.'\\1'.'.'.'\\2')",
                                            $this->template );
*/ //deprecated
        	$templateDir=$this->templateDir;
        	$this->template =preg_replace_callback( "/" .$this->leftDelimiterF ."include file=\"(.*)\.(.*)\""
                                            .$this->rightDelimiterF."/isU", function ($m) use ($templateDir){
            	return file_get_contents($templateDir.$m[1].'.'.$m[2]);
            },
            $this->template);
            
        }


        // Kommentare löschen
/*        $this->template = preg_replace( "/" .$this->leftDelimiterC ."(.*)" .$this->rightDelimiterC ."/isUe",
                                        "", $this->template );  //deprecated
*/
        		$this->template = preg_replace_callback( "/".$this->leftDelimiterC ."(.*)".$this->rightDelimiterC ."/isU",
        				function () {return '';}, $this->template);
        
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
    /**
     * Das "fertige Template" als Rückgabewert.
     *
     * @access    public
     * @uses      $template
     */
    public function return_html(){
    	return $this->template;	
    }
	
    public function assign_array($replace,$replacement){
    	/**
    	 * this function assign all variables in array $a to the template 
    	 * the fields must be named like the variables in array
    	 * $replace   name of the array in template
    	 * $replacement     array with field which has to be assigned 
    	 */
    	array_walk($replacement, array($this,"assign_array_fields"), $replace);
    }

    private function assign_array_fields($value, $key, $replace){
    	$this->assign($replace.'['.$key.']', $value);
    }
}
?>
