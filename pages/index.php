<?php $template->startBlock("content") ?>
    <div class="row">
        <div class="col-sm-9">
            <div id="canvas_container"></div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">Einstellungen</div>
                <div class="panel-body">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Render Mode:
                              </a>
                            </h4>
                          </div>
                          <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                               <select class="form-control" id="sel_renderMode" onchange="setRenderMode($(this).val())">
                                    <option value="solid" selected="selected">Solid</option>
                                    <option value="wireframe">Wireframe</option>
                                </select>   
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                  Ameisen
                              </a>
                            </h4>
                          </div>
                          <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <label for="inp_ants_count">Ameisen Anzahl:</label>
                                <input class="form-control" type="number" value="10" id="inp_ants_count" onchange="ants_count = parseInt($(this).val())" />
                                <label for="inp_ants_mass">Ameisen Masse:</label>
                                <input class="form-control" type="number" value="5" id="inp_ants_mass" onchange="ants_mass = parseInt($(this).val())" />
                                <label for="inp_ants_force">Ameisen Geschw.:</label>
                                <input class="form-control" type="number" value="5" id="inp_ants_force" onchange="force_scale = parseInt($(this).val())" />
                                <label for="sel_ants_mode">Ameisen vert.:</label>
                                <select class="form-control" id="sel_ants_mode" onchange="ants_mode = $(this).val()">
                                    <option value="random" selected="selected">Zufällig</option>
                                    <option value="sort">geordnet</option>
                                </select>
                                <sub>per Rechtsklick können manuell Ameisen hinzugefügt werden.</sub>
                            </div>
                          </div>
                        </div>
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="heading3">
                            <h4 class="panel-title">
                              <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                  Objekt
                              </a>
                            </h4>
                          </div>
                          <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
                            <div class="panel-body">
                                <label for="inp_object_mass">Objekt Masse:</label>
                                <input class="form-control" type="number" value="300" id="inp_object_mass" onchange="object_mass = parseInt($(this).val())" />
                                <label for="sel_object_mode">Objekt Art:</label>
                                <select class="form-control" id="sel_object_mode" onchange="object_mode = $(this).val()">
                                    <option value="box" selected="selected">Box</option>
                                    <option value="cylinder">Zylinder</option>
                                    <option value="long">Kiste</option>
                                </select>
                                <label for="sel_object_mass_center">Masse-Zentrum:</label>
                                <select class="form-control" id="sel_object_mass_center" onchange="object_mass_center = $(this).val()">
                                    <option value="" selected="selected">Mittig</option>
                                    <option value="back">Hinten</option>
                                    <option value="front">Vorn</option>
                                    <option value="right">rechts</option>
                                    <option value="left">Links</option>
                                </select>
                            </div>
                          </div>
                        </div>
                    </div>
                    
                    
                    <input type="checkbox" id="cb_measure" value="1" checked="checked" onchange="toggle_measure($(this).is(':checked'))"> Werte messen
                    <hr/>
                    
                    <div style="margin-bottom: 20px">
                        <a class="btn btn-success btn-block" onclick="restart()">Restart</a>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <a class="btn btn-success btn-block" onclick="start()">Start</a>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn-default btn-block" onclick="stop()">Pause</a>
                        </div>
                    </div>

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

