<?php

/*Define Globals*/
define("BASEDIR",     __dir__);
define("BASEURL", ((strstr('https',$_SERVER['SERVER_PROTOCOL']) === false)?'http':'https').'://'.$_SERVER['HTTP_HOST'].(dirname($_SERVER['SCRIPT_NAME']) != '/' ? dirname($_SERVER["SCRIPT_NAME"]): '')); 

/*Get request Path*/
$path = substr($_SERVER["REQUEST_URI"], strlen((dirname($_SERVER['SCRIPT_NAME']) != '/' ? dirname($_SERVER["SCRIPT_NAME"]).'/' : '/')));
        
if(strpos($path, "?") !== false){
    $path = substr($path, 0, strpos($path, "?"));
}

$path = trim($path, "/");
if(!$path){$path = "index";}

/*Route*/
$template = new template();
$template->path = $path;
if (file_exists(BASEDIR."/pages/{$path}.php")){
    require_once BASEDIR."/pages/{$path}.php";
} else {
    require_once BASEDIR."/pages/404.php";
}

$template->render();

class template {
    
    public $template;
    
    private $vars = array();


    public function __construct(){
        $this->template = BASEDIR.'/layout.php';
    }
    
    public function startBlock($name){
        ob_start();
    }
    
    public function endBlock($name){
       $content = ob_get_contents();
       ob_end_clean();
        
       $this->vars[$name] = $content;
    }
    
    public function __get($name) 
    {
        if(ISSET($this->vars[$name])){
            return $this->vars[$name];
        } else {
            return "";
        }
    }
    
    public function __set($name, $value) 
    {
        $this->vars[$name] = $value;
    }
    
    public function render(){
        ob_clean();
        $template = $this;
        require_once $this->template;
    }
    
}

?>
