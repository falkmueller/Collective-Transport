<?php
require_once BASEDIR.'/vendor/parsedown/Parsedown.php';

class mdParser extends  Parsedown {
    
    /*set absolute Links*/
    protected function inlineLink($Excerpt){
       $element = parent::inlineLink($Excerpt);
       
       $element["element"]['attributes']['target'] = "_blank";
       
       if(strpos($element["element"]['attributes']['href'], "://") === false){
            $element["element"]['attributes']['href'] = BASEURL.'/'.$element["element"]['attributes']['href'];
        }
       
       return $element;
    }
    
    /*parent called inlineLink, so only reset target element*/
    protected function inlineImage($Excerpt)
    {
        $Inline = parent::inlineImage($Excerpt);
        unset($Inline['element']['attributes']['target']);
        
        return $Inline;
    }
    
    /*prevalidate input markdown*/
    function text($text)
    {
        $getImageURL = function($matches){
                $url = $matches[2];
                if(strpos($url, "://") === false){
                    $url = BASEURL.'/'.$url;
                }
                 return $matches[1].$url;
            };
            
        $getLinkURL = function($matches){
                $url = $matches[2];
                if(strpos($url, "://") === false){
                    $url = BASEURL.'/'.$url;
                }
                 return $matches[1].$url;
            };
            
        $text= preg_replace_callback("/(<img[^>]*src *= *[\"']?)([^\"']*)/i", $getImageURL, $text);
        $text = preg_replace_callback("/(<a[^>]*href *= *[\"']?)([^\"']*)/i", $getLinkURL, $text);  

        
        return parent::text($text);
    }

} ?>

<?php $template->startBlock("slides") ?>
 <div class="page_wrapper">
        <div class="page">
            <?php
            $Parsedown = new mdParser();

$files = scandir(BASEDIR.'/slides');
$page_id = 0;
foreach ($files as $file){
    if($file == "." || $file == ".."){ continue;}
    $page_id++;
    
    $number = current(explode("_", $file));
    $name = substr(substr($file, strlen($number) + 1),0,-3);
    $name = current(explode("~", $name));
    
    $number_split = explode(".",$number);
    $number = "";
    foreach ($number_split as $n){
        $n = intval($n);
        if(!$n) {continue;}
        if($number) {$number .= ".";}
        $number .= $n;
    }
    
    $slug = preg_replace('/[^A-Za-z0-9-]/', '', substr($file,0,-3));
    
    $content =  $Parsedown->text(file_get_contents(BASEDIR.'/slides/'.$file));

    ?>
    
    <section class="slide <?php echo $slug ?>">
        <?php if($name){ ?>
        <div class="header">
            <span class="number"><?php echo $number ?></span>
            <span class="title"><?php echo $name ?></span>
        </div>
        <?php } ?>
        <div class="content">
            <?php echo $content ?>
        </div>
        <div class="slide_footer">
            <img class="slide_logo" src="<?php echo BASEURL ?>/public/images/presentation/unileipziglogo.jpg" />
            <span class="slide_footer_text">Collective Transport of Complex Objects by Simple Robots</span>
            <span class="page_id"><?php echo $page_id ?></span>
        </div>
    </section>
    
    <?php
}

?>
        </div>
    </div>  
<?php $template->endBlock("slides"); ?>


<?php
if(isset($_GET["print"])){
    ob_start(); ?>
    <!DOCTYPE html>
    <html>
      <head>
        <title>presentation.js</title>
        <meta charset="utf-8">
        <link href="<?php echo BASEURL ?>/public/css/style.css" rel="stylesheet">
        <link href="<?php echo BASEURL ?>/public/css/presentation-theme.css" rel="stylesheet">
        <link href="<?php echo BASEURL ?>/public/css/pdf.css" rel="stylesheet">
      </head>
      <body>
        <?php echo $template->slides ?>
      </body>
    </html>

    <?php
    $html = ob_get_contents();
    ob_end_clean();

    //$html; exit();

    $factor = 0.75;
    require_once BASEDIR.'/vendor/dompdf/autoload.inc.php';
    $options = array("enable_remote" => true, "enable_html5_parser" => true);
    $dompdf = new Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper(array(0,0,960 * $factor,700 * $factor));
    $dompdf->render();
    $dompdf->stream();
}

?>

<?php $template->startBlock("header") ?>
    <link href="<?php echo BASEURL ?>/public/css/presentation.css" rel="stylesheet">
    <link href="<?php echo BASEURL ?>/public/css/presentation-theme.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo BASEURL ?>/public/css/featherlight.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?php echo BASEURL ?>/public/css/featherlight.gallery.css" type="text/css" media="screen" />

<?php $template->endBlock("header"); ?>

<?php $template->startBlock("content") ?>
    
    <div style="text-align: center; margin: 20px 0">
        <a class="btn btn-default" href="<?php echo BASEURL ?>/presentation?print=pdf">download als PDF</a>
    </div>
    
    <?php echo $template->slides ?>
    

<?php $template->endBlock("content"); ?>

<?php $template->startBlock("scripts") ?>
    <script src="<?php echo BASEURL ?>/public/js/presentation.js"></script>
    <script type="text/javascript">
          var p_screen = new presentation_screen();
          p_screen.init();
          
          var p_slides = new presentation_slides();
          p_slides.options.enableMouseWheel = false;
          p_slides.init();
      </script>
      
    <script type="text/javascript" src="<?php echo BASEURL ?>/public/js/featherlight.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL ?>/public/js/featherlight.gallery.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
		$('.lightbox').featherlightGallery({
                    root: ".page_wrapper"
                });
	});
</script>
<?php $template->endBlock("scripts"); ?>