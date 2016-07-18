<?php $template->startBlock("content") ?>
<div class="panel panel-default">
        <div class="panel-heading">Messtwerte</div>
        <div class="panel-body">
            <h2>y-Abweischung</h2>
            <div id="x_chart_y"></div>
            <hr/>
            <h2>Rotation (allgemein)</h2>
            <div id="x_chart_r"></div>
            
            <h2>Rotation (Gewicht rechts, Gewicht Links)</h2>
            <div id="x_chart_r_2"></div>
            
            <div class="row">
                <div class="col-sm-6">
                    <h2>speed of transport</h2>
                    <div id="speed_n"></div>
                </div>
                <div class="col-sm-6">
                    <h2>speed of transport (m/N const)</h2>
                    <div id="speed_n_m"></div>
                </div>
            </div>
            
        </div>
    </div>
<?php $template->endBlock("content"); ?>

    
<?php $template->startBlock("scripts") ?>
    <script src="<?php echo BASEURL ?>/public/js/chartist.min.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/charts.js"></script>
<?php $template->endBlock("scripts"); ?>
    