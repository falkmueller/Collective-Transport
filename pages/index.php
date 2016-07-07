<?php $template->startBlock("content") ?>
    <div class="row">
        <div class="col-sm-9">
            <div id="canvas_container"></div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">Einstellungen</div>
                <div class="panel-body">
                    <label for="sel_renderMode">Render Mode:</label>
                    <select class="form-control" id="sel_renderMode" onchange="setRenderMode($(this).val())">
                        <option value="solid" selected="selected">Solid</option>
                        <option value="wireframe">Wireframe</option>
                    </select>
                    <hr>
                    <label for="inp_ants_count">Ameisen Anzahl:</label>
                    <input class="form-control" type="number" value="10" id="inp_ants_count" onchange="set_ants_count($(this).val())" />
                    <label for="inp_ants_mass">Ameisen Masse:</label>
                    <input class="form-control" type="number" value="5" id="inp_ants_mass" onchange="set_ants_mass($(this).val())" />
                    <label for="inp_ants_force">Ameisen Geschw.:</label>
                    <input class="form-control" type="number" value="5" id="inp_ants_force" onchange="set_ants_force($(this).val())" />
                    <label for="sel_ants_mode">Ameisen vert.:</label>
                    <select class="form-control" id="sel_ants_mode" onchange="set_ants_mode($(this).val())">
                        <option value="random" selected="selected">Zufällig</option>
                        <option value="sort">geordnet</option>
                    </select>
                    <hr>
                    <label for="inp_object_mass">Objekt Masse:</label>
                    <input class="form-control" type="number" value="300" id="inp_object_mass" onchange="set_object_mass($(this).val())" />
                    <label for="sel_object_mode">Objekt Art:</label>
                    <select class="form-control" id="sel_object_mode" onchange="set_object_mode($(this).val())">
                        <option value="box" selected="selected">Box</option>
                        <option value="cylinder">Zylinder</option>
                        <option value="long">Kiste</option>
                    </select>
                    <hr>
                    <input type="checkbox" id="cb_measure" value="1" checked="checked" onchange="toggle_measure($(this).is(':checked'))"> Werte messen
                    <hr/>
                    <a class="btn btn-success btn-block" onclick="start()">Start</a>
                    <a class="btn btn-default btn-block" onclick="stop()">Pause</a>
                    <a class="btn btn-success btn-block" onclick="restart()">Restart</a>
                </div>
            </div>
        </div>
    </div>
      
    <div class="panel panel-default">
        <div class="panel-heading">Messtwerte</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    Zeit (ms): <span id="time"></span> 
                </div>
                <div class="col-sm-4">
                    Transport-Zeit (ms): <span id="time_transport"></span> 
                </div>
                <div class="col-sm-4">
                    Strecke (r-px): <span id="distance"></span> 
                </div>
            </div>
            <hr>
            <div style="display: none;" id="x_chart_y_h2"><h2>y-Abweischung</h2></div>
            <div id="x_chart_y">
                
            </div>
            <div style="display: none;" id="x_chart_r_h2"><h2>Rotation</h2></div>
            <div id="x_chart_r">
                
            </div>
        </div>
    </div>
<?php $template->endBlock("content"); ?>

<?php $template->startBlock("scripts") ?>
      <script src="<?php echo BASEURL ?>/public/js/build/cannon.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/cannon.demo.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/libs/dat.gui.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/libs/Three.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/libs/TrackballControls.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/libs/Detector.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/libs/Stats.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/libs/smoothie.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/chartist.min.js"></script>
    <script src="<?php echo BASEURL ?>/public/js/Demo.js"></script>
<?php $template->endBlock("scripts"); ?>

