/**
     * Demonstrates how to use the HingeConstraint.
     * A hinge constraint makes sure that two bodies can rotate around a common axis. For example, think of a door hinge.
     */
    
    var demo = new CANNON.Demo();
    var world;
    
    var ants = [];
    var ants_mass = parseInt($("#inp_ants_mass").val());
    var ants_count = parseInt($("#inp_ants_count").val());
    var force_scale = parseInt($("#inp_ants_force").val());
    var ants_mode = $("#sel_ants_mode").val(); //random/sort
    
    var moving_object;
    var object_mass = parseInt($("#inp_object_mass").val());
    var object_mode = $("#sel_object_mode").val();
    var object_mass_center = $("#sel_object_mass_center").val();
    
    var goalBody;
    
    var measure ={
        enable: $("#cb_measure").is(':checked'),
        time: 0,
        time_transport: 0,
        temp_start_time: 0,
        tracked_x: {},
        restart: function(){
            this.time = 0;
            this.time_transport = 0;
            this.tracked_x =  {};
        }
    }; 
    
    var pause = false;
    
    function getRandomCoords(min, max) { 
        y = 0;
        x = (Math.floor(Math.random() * (max - min +1)) + min);
                
        var w = 360 * Math.random();
                
        var x2 = (Math.cos(w) * x) - (Math.sin(w) * y);
        var y2 = (Math.sin(w) * x) + (Math.cos(w) * y);
                
        return {x: x2, y: y2}; 
    }
    
    function rotate(cx, cy, x, y, angle) {
        var radians = (Math.PI / 180) * angle,
            cos = Math.cos(radians),
            sin = Math.sin(radians),
            nx = (cos * (x - cx)) + (sin * (y - cy)) + cx,
            ny = (cos * (y - cy)) - (sin * (x - cx)) + cy;
        return {x: nx, y: ny};
    }

    demo.addScene("room",function(){
        world = demo.getWorld();
        world.gravity.set(0,0,-20);

        //material
        var groundMaterial = new CANNON.Material("groundMaterial");
        var antMaterial = new CANNON.Material("wheelMaterial");
        var objectMaterial = new CANNON.Material("objectMaterial");
        
        //material contacts
        var antGroundContactMaterial = new CANNON.ContactMaterial(groundMaterial,antMaterial, { friction: 0.8, restitution: 0.3 });
        world.addContactMaterial(antGroundContactMaterial);
        
        var objectGroundContactMaterial = new CANNON.ContactMaterial(groundMaterial,objectMaterial, { friction: 0.8, restitution: 0.3});
        world.addContactMaterial(objectGroundContactMaterial);
        
        var objectAntContactMaterial = new CANNON.ContactMaterial(antMaterial,objectMaterial, { friction: 0, restitution: 0});
        world.addContactMaterial(objectAntContactMaterial);
        
        //moving object
        demo.currentMaterial = new THREE.MeshLambertMaterial( { color: 0xFF0C0C } );
        moving_object = new CANNON.Body({ mass: object_mass,  material: objectMaterial });
        var objectShape = new CANNON.Box(new CANNON.Vec3(5,5,2));
        moving_object.position.set(  0,  0, 2);
        if(object_mode == "cylinder"){
            objectShape = new CANNON.Cylinder(10,10,3,8);
            moving_object.position.set(  0,  0, 4);
        }
        else if (object_mode == "long"){
            objectShape = new CANNON.Box(new CANNON.Vec3(3,15,2));
            moving_object.position.set(  0,  0, 2);
        }
        moving_object.label = "moving_object";
        moving_object.addShape(objectShape);
        
        world.addBody(moving_object);
        demo.addVisual(moving_object);
        demo.currentMaterial = new THREE.MeshLambertMaterial( { color: 0xdddddd } );
         
        if (object_mass_center){
            demo.currentMaterial = new THREE.MeshLambertMaterial( { color: 0x565CFF} );
            var moving_object_weight = new CANNON.Body({ mass: object_mass * 10,  material: objectMaterial });
            moving_object_weight.addShape(new CANNON.Cylinder(2,2,1,8));
            
            if(object_mass_center == "back" && object_mode != "long"){
                moving_object_weight.position.set(  -3,  0, 6);
            } else if (object_mass_center == "front" && object_mode != "long"){
                moving_object_weight.position.set(  3,  0, 6);
            } else if (object_mass_center == "right"){
                moving_object_weight.position.set(  0,  3, 6);
            } else if (object_mass_center == "left"){
                moving_object_weight.position.set(  0,  -3, 6);
            } else {
                moving_object_weight.position.set(  0,  0, 6);
            }
            
            
            world.addBody(moving_object_weight);
            demo.addVisual(moving_object_weight);
            world.addConstraint(new CANNON.LockConstraint(moving_object, moving_object_weight));
            demo.currentMaterial = new THREE.MeshLambertMaterial( { color: 0xdddddd } );
        }
        
       
        
        //goal
        demo.currentMaterial = new THREE.MeshLambertMaterial( { color: 0xF2FF00 } );
        var goalShape = new CANNON.Cylinder(5,5,1,8);
        goalBody = new CANNON.Body({ mass: 0});
        goalBody.addShape(goalShape);
        goalBody.position.set(  40,  0, 8);
        world.addBody(goalBody);
        demo.addVisual(goalBody);
        demo.currentMaterial = new THREE.MeshLambertMaterial( { color: 0xdddddd } );
        
        //ants
        demo.currentMaterial = new THREE.MeshLambertMaterial( { color: 0x6050A8 } );
        var x,y;
        for (i = 0; i < ants_count; i++) { 
            var antShape =  new CANNON.Sphere(1.2);
            var antBody =  new CANNON.Body({ mass: ants_mass, material: antMaterial });
            antBody.label = "ant";
            antBody.addShape(antShape);
            if (ants_mode == "random"){
                var c = getRandomCoords(20,30);
                x = c.x;
                y = c.y;
                
            } else {
                 var angle = 360 / ( ants_count) * i;
                 var r = rotate(0, 0, 20, 0, angle);
                 x = r.x;
                 y = r.y;
            }
            
            antBody.position.set( x , y , 1.2);
            
            ants.push(antBody);
            world.addBody(antBody);
            demo.addVisual(antBody);
        }
        demo.currentMaterial = new THREE.MeshLambertMaterial( { color: 0xdddddd } );

        // Ground
        var groundShape = new CANNON.Plane();
        var ground = new CANNON.Body({ mass: 0, material: groundMaterial });
        ground.addShape(groundShape);
        ground.position.z = 0;
        world.addBody(ground);
        demo.addVisual(ground);
        
        //collision event
        moving_object.addEventListener("collide",function(e){
            if(e.body.label == "ant" && !e.body.is_connect){
                console.log("connect ant");
                e.body.is_connect = true;
                //world.addConstraint(c = new CANNON.DistanceConstraint(e.target,e.body));
                //return;

                var zero = new CANNON.Vec3( e.contact.rj.x  + 0,  e.contact.rj.y  + 0,  e.contact.rj.z + 0);

                e.contact.rj.scale(1.5, zero);
                //zero.normalize();

                zero.z = -1.2;
                //console.log(zero);
                //if(zero.x < 0){zero.x -= 2; } else { zero.x += 2; }
                //if(zero.y < 0){zero.y -= 2; } else { zero.y += 2; }

                world.addConstraint(new CANNON.HingeConstraint(e.target, e.body,  { pivotA: zero, axisA: new CANNON.Vec3(1,1,0),  pivotB: new CANNON.Vec3(), axisB: new CANNON.Vec3() }));
            }

        });
        
        var onMouseDown = function(e){
             var screenX = e.clientX - $("#canvas_container").offset().left;
            var screenY = e.clientY - $("#canvas_container").offset().top + $(window).scrollTop();
            var SCREEN_WIDTH = $("#canvas_container").innerWidth();
            var SCREEN_HEIGHT = $("#canvas_container").innerHeight();

            var mouse3D = new THREE.Vector3();
            mouse3D.x = (screenX / SCREEN_WIDTH) * 2 - 1;
            mouse3D.y = -(screenY / SCREEN_HEIGHT) * 2 + 1;
            mouse3D.z = 0.5;
            
            var projector = new THREE.Projector();
            
            var raycaster = projector.pickingRay(mouse3D, demo.camera);
            var pos = raycaster.ray.intersectPlane(new THREE.Plane(new THREE.Vector3(0, 0, 1), 0));

            var antShape =  new CANNON.Sphere(1.2);
            var antBody =  new CANNON.Body({ mass: ants_mass, material: antMaterial });
            antBody.label = "ant";
            antBody.addShape(antShape);
            
            antBody.position.set( pos.x, pos.y , 1.2);
            
            ants.push(antBody);
            demo.addVisual(antBody);
            world.addBody(antBody);         

        }
        $("#canvas_container").unbind("contextmenu")
        $("#canvas_container").bind("contextmenu",onMouseDown);
       
    });
    
    function toggle_measure(checked){
        measure.enable = checked;
    }

    function setRenderMode(mode) { 
        demo.setRenderMode(mode);
        $("#sel_renderMode").val(mode);
    }
    
    function restart(){
        setRenderMode("solid");
        if(pause){
            demo.toggle_pause();
             pause = false;
        }
         
        measure.restart();
        measure.temp_start_time = performance.now();
        
        demo.start();
    }
    
    
    function stop(){
        if(!pause){
            demo.toggle_pause();
            pause = !pause;
        }
        
        if(measure.enable && Object.keys(measure.tracked_x).length > 0){
            draw_chart(measure.tracked_x);
        }
        
    }

    function start(){
        measure.temp_start_time = performance.now();
        
        if(pause){
            demo.toggle_pause();
            pause = !pause;
        }
        
    }
    
    
    restart();
    
    setInterval(function(){
        
        if(pause){return;}
        
        $.each(ants,function(i,a){
           
           if(!a.is_connect){
                var direction = new CANNON.Vec3();
                moving_object.position.vsub(a.position, direction);
                var totalLength = direction.length();
                direction.normalize();
                
                direction.scale(force_scale, a.velocity);
                
//                direction.scale(-100, direction);
//                direction.vsub(a.force, direction);
//                a.applyForce(direction,new CANNON.Vec3(0,0,0));
               
           } 
           else {
               //zum ziel gehen
                var direction = new CANNON.Vec3();
                goalBody.position.vsub(a.position, direction);
                var totalLength = direction.length();
                direction.normalize();
                
                direction.z = 0;
                
                direction.scale(force_scale, a.velocity);
                
//                direction.scale(100, direction);
//                direction.vsub(a.force, direction);
//                a.applyForce(direction,new CANNON.Vec3(0,0,0));
           }
           
        });
        
        if(measure.enable && measure.temp_start_time){
            var distance = moving_object.position.x;
            
            var time_span = performance.now() - measure.temp_start_time;
            measure.time += time_span
            if(Math.round(distance) > 0){
               measure.time_transport += time_span;
            }
            measure.temp_start_time = performance.now();
        
            $("#time").html(parseInt(measure.time));
            $("#time_transport").html(parseInt(measure.time_transport));
            $("#distance").html(parseInt(distance));
            
            measure.tracked_x[parseInt(distance)] = {t: parseInt(measure.time_transport), y: moving_object.position.y, o_z:moving_object.quaternion.z}
        }
        
    },100);
    
     
     function draw_chart(tracked_x){
         var data_y = {labels: [], series: [[]]};
         var data_r = {labels: [], series: [[]]};
         
         var y_0_diff = tracked_x[0].y;
         var r_0_diff = tracked_x[0].o_z;
         
        Object.keys(tracked_x).forEach(function(key,index) {
            data_y.labels.push(key);
            data_r.labels.push(key);
            data_y.series[0].push(tracked_x[key].y - y_0_diff);
            data_r.series[0].push((tracked_x[key].o_z - r_0_diff) * 180);
            //console.log(key + '\t' + (tracked_x[key].y - y_0_diff) + '\t' + ((tracked_x[key].o_z - r_0_diff) * 180));
        });
        
        
        var m = {
            ants_count: ants_count,
            ants_mass: ants_mass,
            ants_mode: ants_mode,
            ants_force: force_scale,
            object_mass: object_mass,
            object_mode: object_mode,
            time: measure.time,
            time_transport: measure.time_transport,
            distance: parseInt(moving_object.position.x),
            tracked_x: tracked_x
        };
        console.log(JSON.stringify(m));
        
        
        var options = {
          showPoint: false,
          lineSmooth: true,
          axisX: {
            showGrid: true,
            showLabel: true
          },
          axisY: {
            offset: 60,
            labelInterpolationFnc: function(value) {
              return value + ' r-px';
            }
          }
        };

        $("#x_chart_y_h2").show();
        new Chartist.Line('#x_chart_y', data_y, options);
        
        var options = {
          showPoint: false,
          lineSmooth: true,
          axisX: {
            showGrid: true,
            showLabel: true
          },
          axisY: {
            offset: 60,
            labelInterpolationFnc: function(value) {
              return value + ' °';
            }
          }
        };

        $("#x_chart_r_h2").show();
         new Chartist.Line('#x_chart_r', data_r, options);
     }


