<!DOCTYPE html>
<html>
  <head>
    <title>Ants - collective Transport</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    
    <link href="<?php echo BASEURL ?>/public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo BASEURL ?>/public/css/chartist.min.css" rel="stylesheet">
    <link href="<?php echo BASEURL ?>/public/css/style.css" rel="stylesheet">
    <?php echo $template->header; ?>
  </head>
  <body>
      
      <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo BASEURL ?>">Collective Transport</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php echo $template->path == "index" ? "class=\"active\"" : ""?> ><a href="<?php echo BASEURL ?>">Simulation</a></li>
        <li <?php echo $template->path == "charts" ? "class=\"active\"" : ""?>><a href="<?php echo BASEURL ?>/charts">Messung</a></li>
        <li <?php echo $template->path == "presentation" ? "class=\"active\"" : ""?>><a href="<?php echo BASEURL ?>/presentation">Präsentation</a></li>
        <li><a href="https://www.eecs.harvard.edu/ssr/papers/aamas13-rubenstein.pdf" target="_blank">Paper</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
      
      
    <?php echo $template->content; ?>
      
      <div class="footer-wrapper">
          <div class="footer">
            <div class="container">
                <div class="row">
                        <div class="col-md-6 widget">
                            <h6>About</h6>
                        <article class="widget_content">
                            <ul>
                                <li>Kleine Demonstrationen zu kollektiven Transport</li>
                                <li>Enstanden im <a href="http://personal-homepages.mis.mpg.de/zahedi/" target="_blank">Robotik Seminar</a> an der Universität Leipzig</li>
                                <li>Git-Repo: <a href="https://github.com/falkmueller/Collective-Transport" target="_blank">Collective-Transport</a></li>
                         </ul>
                         </article>
                        </div>
                    <div class="col-md-6 widget">
                            <h6>Link</h6>
                        <article class="widget_content">
                            <ul>
                                <li><a target="_blank" href="http://www.cannonjs.org/">Cannon.js für phisikalische Simulation</a></li>
                                <li><a target="_blank" href="https://gionkunz.github.io/chartist-js/">chartist.js für Graphen</a></li>
                                <li><a target="_blank" href="http://threejs.org/">three.js für Canvas Animation</a></li>
                                <li><a target="_blank" href="http://www.uni-leipzig.de">Universität Leipzig</a></li>
                         </ul>
                         </article>
                        </div>
                </div>
            </div>
        </div>
          
          <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 widget">© <?php echo date("Y") ?> by falk-m.de <span class="pull-right"><a href="http://www.falk-m.de" target="_blank">falk-m.de »</a></span>
                    </div>
                </div>
            </div>
        </div> 
</div>
      
    <script src="<?php echo BASEURL ?>/public/js/jquery-2.2.4.min.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/bootstrap.min.js"></script>
    <?php echo $template->scripts; ?>
  </body>
</html>