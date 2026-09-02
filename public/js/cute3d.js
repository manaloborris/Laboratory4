/**
 * Cute 3D Animals Background
 * --------------------------
 * Low-poly cute animals (panda, bear, cat, rabbit, fox, penguin)
 * floating in the background with a gentle bobbing animation,
 * mouse parallax and a subtle cyber-themed particle field.
 *
 * Requires Three.js r128 (UMD build) loaded before this file.
 */
(function () {
    'use strict';

    var canvas = document.getElementById('cute3d-bg');
    if (!canvas || typeof THREE === 'undefined') {
        return;
    }

    var reduceMotion = window.matchMedia &&
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    var renderer;
    try {
        renderer = new THREE.WebGLRenderer({
            canvas: canvas,
            alpha: true,
            antialias: true
        });
    } catch (e) {
        canvas.style.display = 'none';
        return;
    }

    renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
    renderer.setSize(window.innerWidth, window.innerHeight);

    var scene = new THREE.Scene();
    scene.fog = new THREE.Fog(0x050816, 55, 120);

    var camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight, 0.1, 200);
    camera.position.set(0, 1.5, 34);

    /* ---- Lights (cyber theme: white key + cyan/purple accents) ---- */
    scene.add(new THREE.AmbientLight(0x8899ff, 0.5));

    var keyLight = new THREE.DirectionalLight(0xffffff, 0.8);
    keyLight.position.set(8, 14, 12);
    scene.add(keyLight);

    var cyanLight = new THREE.PointLight(0x67e8f9, 1.1, 70);
    cyanLight.position.set(-16, 8, 10);
    scene.add(cyanLight);

    var purpleLight = new THREE.PointLight(0xc084fc, 0.9, 70);
    purpleLight.position.set(16, -8, 8);
    scene.add(purpleLight);

    /* ---- Materials ---- */
    function mat(color) {
        return new THREE.MeshPhongMaterial({ color: color, flatShading: true });
    }

    var C = {
        white: mat(0xf7f4ef),
        black: mat(0x1d1d24),
        brown: mat(0x8a5a3b),
        brownDark: mat(0x6b4226),
        cream: mat(0xe8d5b7),
        orange: mat(0xf08a3c),
        orangeDark: mat(0xd96c2f),
        gray: mat(0x9aa5b1),
        pink: mat(0xf4a7c3),
        penguin: mat(0x23262c),
        beak: mat(0xf5a623)
    };

    /* ---- Helpers ---- */
    function sphere(radius, material, x, y, z, sx, sy, sz) {
        var m = new THREE.Mesh(new THREE.SphereGeometry(radius, 20, 16), material);
        m.position.set(x || 0, y || 0, z || 0);
        if (sx || sy || sz) {
            m.scale.set(sx || 1, sy || 1, sz || 1);
        }
        return m;
    }

    function cone(radius, height, material, x, y, z, rx, rz) {
        var m = new THREE.Mesh(new THREE.ConeGeometry(radius, height, 12), material);
        m.position.set(x || 0, y || 0, z || 0);
        m.rotation.set(rx || 0, 0, rz || 0);
        return m;
    }

    /* ---- Animal builders (each returns a THREE.Group ~2.4 units tall) ---- */
    function buildPanda() {
        var g = new THREE.Group();
        g.add(sphere(1, C.white, 0, 0, 0, 1, 1.15, 1));          // body
        g.add(sphere(0.72, C.white, 0, 1.55, 0));                // head
        g.add(sphere(0.22, C.black, -0.42, 2.12, 0));            // ears
        g.add(sphere(0.22, C.black, 0.42, 2.12, 0));
        g.add(sphere(0.27, C.black, -0.26, 1.62, 0.55));         // eye patches
        g.add(sphere(0.27, C.black, 0.26, 1.62, 0.55));
        g.add(sphere(0.1, C.white, -0.26, 1.64, 0.78));          // eyes
        g.add(sphere(0.1, C.white, 0.26, 1.64, 0.78));
        g.add(sphere(0.05, C.black, -0.26, 1.64, 0.86));         // pupils
        g.add(sphere(0.05, C.black, 0.26, 1.64, 0.86));
        g.add(sphere(0.07, C.black, 0, 1.42, 0.68));             // nose
        g.add(sphere(0.34, C.black, -0.88, 0.35, 0));            // arms
        g.add(sphere(0.34, C.black, 0.88, 0.35, 0));
        g.add(sphere(0.4, C.black, -0.5, -1.0, 0));              // legs
        g.add(sphere(0.4, C.black, 0.5, -1.0, 0));
        return g;
    }

    function buildBear() {
        var g = new THREE.Group();
        g.add(sphere(1, C.brown, 0, 0, 0, 1, 1.1, 1));           // body
        g.add(sphere(0.68, C.brown, 0, 1.5, 0));                 // head
        g.add(sphere(0.2, C.brown, -0.4, 2.0, 0));               // ears
        g.add(sphere(0.2, C.brown, 0.4, 2.0, 0));
        g.add(sphere(0.28, C.cream, 0, 1.42, 0.6));              // snout
        g.add(sphere(0.09, C.black, 0, 1.44, 0.82));             // nose
        g.add(sphere(0.07, C.black, -0.24, 1.66, 0.55));         // eyes
        g.add(sphere(0.07, C.black, 0.24, 1.66, 0.55));
        g.add(sphere(0.34, C.brown, -0.88, 0.3, 0));             // arms
        g.add(sphere(0.34, C.brown, 0.88, 0.3, 0));
        g.add(sphere(0.42, C.brown, -0.5, -0.95, 0));            // legs
        g.add(sphere(0.42, C.brown, 0.5, -0.95, 0));
        return g;
    }

    function buildCat() {
        var g = new THREE.Group();
        g.add(sphere(0.95, C.gray, 0, 0, 0, 1, 1.05, 1));        // body
        g.add(sphere(0.6, C.gray, 0, 1.35, 0));                  // head
        g.add(cone(0.16, 0.4, C.gray, -0.32, 1.85, 0));          // ears
        g.add(cone(0.16, 0.4, C.gray, 0.32, 1.85, 0));
        g.add(cone(0.1, 0.3, C.pink, -0.32, 1.72, 0));           // inner ears
        g.add(cone(0.1, 0.3, C.pink, 0.32, 1.72, 0));
        g.add(sphere(0.09, C.black, -0.2, 1.42, 0.5));           // eyes
        g.add(sphere(0.09, C.black, 0.2, 1.42, 0.5));
        g.add(sphere(0.06, C.pink, 0, 1.28, 0.55));              // nose
        g.add(sphere(0.3, C.gray, -0.8, 0.3, 0));                // arms
        g.add(sphere(0.3, C.gray, 0.8, 0.3, 0));
        g.add(sphere(0.38, C.gray, -0.45, -0.9, 0));             // legs
        g.add(sphere(0.38, C.gray, 0.45, -0.9, 0));
        g.add(cone(0.14, 0.9, C.gray, 0.98, 0.45, 0.3, Math.PI / 2.6, 0)); // tail
        return g;
    }

    function buildRabbit() {
        var g = new THREE.Group();
        g.add(sphere(0.95, C.white, 0, 0, 0, 1, 1.1, 1));        // body
        g.add(sphere(0.62, C.white, 0, 1.35, 0));                // head
        var earGeo = new THREE.BoxGeometry(0.22, 1.0, 0.16);
        var earL = new THREE.Mesh(earGeo, C.white);               // ears
        earL.position.set(-0.24, 2.15, 0);
        earL.rotation.z = -0.12;
        g.add(earL);
        var earR = new THREE.Mesh(earGeo, C.white);
        earR.position.set(0.24, 2.15, 0);
        earR.rotation.z = 0.12;
        g.add(earR);
        var innerGeo = new THREE.BoxGeometry(0.1, 0.7, 0.1);
        var innerL = new THREE.Mesh(innerGeo, C.pink);            // inner ears
        innerL.position.set(-0.24, 2.15, 0);
        innerL.rotation.z = -0.12;
        g.add(innerL);
        var innerR = new THREE.Mesh(innerGeo, C.pink);
        innerR.position.set(0.24, 2.15, 0);
        innerR.rotation.z = 0.12;
        g.add(innerR);
        g.add(sphere(0.08, C.pink, -0.18, 1.4, 0.55));           // eyes
        g.add(sphere(0.08, C.pink, 0.18, 1.4, 0.55));
        g.add(sphere(0.06, C.pink, 0, 1.28, 0.58));              // nose
        g.add(sphere(0.3, C.white, -0.82, 0.3, 0));              // arms
        g.add(sphere(0.3, C.white, 0.82, 0.3, 0));
        g.add(sphere(0.4, C.white, -0.45, -0.92, 0));            // legs
        g.add(sphere(0.4, C.white, 0.45, -0.92, 0));
        g.add(sphere(0.28, C.white, 0, -0.95, 0.55));            // tail puff
        return g;
    }

    function buildFox() {
        var g = new THREE.Group();
        g.add(sphere(0.95, C.orange, 0, 0, 0, 1, 1.1, 1));       // body
        g.add(sphere(0.62, C.orange, 0, 1.4, 0));                // head
        g.add(cone(0.18, 0.5, C.orange, -0.3, 1.9, 0));          // ears
        g.add(cone(0.18, 0.5, C.orange, 0.3, 1.9, 0));
        g.add(cone(0.1, 0.3, C.black, -0.3, 1.75, 0));           // ear tips
        g.add(cone(0.1, 0.3, C.black, 0.3, 1.75, 0));
        g.add(sphere(0.24, C.cream, 0, 1.35, 0.55));             // snout
        g.add(sphere(0.06, C.black, 0, 1.38, 0.72));             // nose
        g.add(sphere(0.07, C.black, -0.2, 1.5, 0.5));            // eyes
        g.add(sphere(0.07, C.black, 0.2, 1.5, 0.5));
        g.add(sphere(0.3, C.orange, -0.82, 0.3, 0));             // arms
        g.add(sphere(0.3, C.orange, 0.82, 0.3, 0));
        g.add(sphere(0.4, C.orange, -0.45, -0.92, 0));           // legs
        g.add(sphere(0.4, C.orange, 0.45, -0.92, 0));
        g.add(cone(0.22, 1.1, C.orange, 1.05, 0.5, 0.2, Math.PI / 2.4, 0)); // tail
        g.add(cone(0.22, 0.4, C.white, 1.3, 0.78, 0.2, Math.PI / 2.4, 0));  // tail tip
        return g;
    }

    function buildPenguin() {
        var g = new THREE.Group();
        g.add(sphere(0.95, C.penguin, 0, 0, 0, 1, 1.25, 1));     // body
        g.add(sphere(0.7, C.white, 0, -0.05, 0.62, 0.75, 1.1, 0.6)); // belly
        g.add(sphere(0.6, C.penguin, 0, 1.35, 0));               // head
        g.add(sphere(0.4, C.white, 0, 1.35, 0.52, 0.7, 0.9, 0.5)); // face
        g.add(cone(0.12, 0.4, C.beak, 0, 1.25, 0.62, Math.PI / 2.2, 0)); // beak
        g.add(sphere(0.09, C.white, -0.2, 1.5, 0.5));            // eyes
        g.add(sphere(0.09, C.white, 0.2, 1.5, 0.5));
        g.add(sphere(0.05, C.black, -0.2, 1.5, 0.57));           // pupils
        g.add(sphere(0.05, C.black, 0.2, 1.5, 0.57));
        g.add(sphere(0.3, C.penguin, -0.85, 0.35, 0, 0.6, 1.4, 0.6)); // wings
        g.add(sphere(0.3, C.penguin, 0.85, 0.35, 0, 0.6, 1.4, 0.6));
        g.add(cone(0.16, 0.3, C.beak, -0.32, -1.15, 0.1));       // feet
        g.add(cone(0.16, 0.3, C.beak, 0.32, -1.15, 0.1));
        return g;
    }

    /* ---- Populate the scene ---- */
    var animalBuilders = [buildPanda, buildBear, buildCat, buildRabbit, buildFox, buildPenguin];

    var animals = [];
    var positions = [
        { x: -13, y: 2.5, z: -6,  s: 1.15 },
        { x: 12,  y: 1.5, z: -4,  s: 1.0 },
        { x: -8,  y: -3.5, z: -12, s: 0.8 },
        { x: 9,   y: -2.5, z: -14, s: 0.9 },
        { x: -16, y: -1.5, z: -18, s: 1.1 },
        { x: 15,  y: 3.5, z: -16, s: 0.75 },
        { x: 0,   y: -5,  z: -20, s: 1.3 }
    ];

    for (var i = 0; i < positions.length; i++) {
        var builder = animalBuilders[i % animalBuilders.length];
        var animal = builder();
        var p = positions[i];
        animal.position.set(p.x, p.y, p.z);
        animal.scale.set(p.s, p.s, p.s);
        animal.rotation.y = (i % 2 === 0 ? 1 : -1) * (0.5 + Math.random() * 0.4);
        scene.add(animal);
        animals.push({
            mesh: animal,
            baseY: p.y,
            phase: Math.random() * Math.PI * 2,
            speed: 0.4 + Math.random() * 0.35,
            amp: 0.35 + Math.random() * 0.4,
            spin: (Math.random() > 0.5 ? 1 : -1) * (0.12 + Math.random() * 0.18)
        });
    }

    /* ---- Floating particles (cyber dust) ---- */
    var particleCount = 90;
    var particleGeo = new THREE.BufferGeometry();
    var particlePos = new Float32Array(particleCount * 3);
    var particleData = [];
    for (var i = 0; i < particleCount; i++) {
        particlePos[i * 3] = (Math.random() - 0.5) * 60;
        particlePos[i * 3 + 1] = (Math.random() - 0.5) * 40;
        particlePos[i * 3 + 2] = (Math.random() - 0.5) * 40 - 5;
        particleData.push({
            phase: Math.random() * Math.PI * 2,
            speed: 0.2 + Math.random() * 0.4,
            amp: 0.3 + Math.random() * 0.8
        });
    }
    particleGeo.setAttribute('position', new THREE.BufferAttribute(particlePos, 3));
    var particleMat = new THREE.PointsMaterial({
        color: 0x67e8f9,
        size: 0.18,
        transparent: true,
        opacity: 0.55,
        blending: THREE.AdditiveBlending,
        depthWrite: false
    });
    var particles = new THREE.Points(particleGeo, particleMat);
    scene.add(particles);

    /* ---- Mouse parallax ---- */
    var mouseX = 0, mouseY = 0, targetX = 0, targetY = 0;
    document.addEventListener('mousemove', function (e) {
        mouseX = (e.clientX / window.innerWidth) * 2 - 1;
        mouseY = -(e.clientY / window.innerHeight) * 2 + 1;
    }, { passive: true });

    /* ---- Animation loop ---- */
    var clock = new THREE.Clock();
    var animating = false;

    function loop() {
        if (!animating) return;
        requestAnimationFrame(loop);

        var t = clock.getElapsedTime();

        // gentle bobbing + slow spin
        for (var i = 0; i < animals.length; i++) {
            var a = animals[i];
            a.mesh.position.y = a.baseY + Math.sin(t * a.speed + a.phase) * a.amp;
            a.mesh.rotation.y += a.spin * 0.016;
            a.mesh.rotation.z = Math.sin(t * 0.5 + a.phase) * 0.04;
        }

        // particles drift
        var pos = particles.geometry.attributes.position;
        for (var i = 0; i < particleCount; i++) {
            var d = particleData[i];
            pos.array[i * 3 + 1] += Math.sin(t * d.speed + d.phase) * 0.0015;
        }
        pos.needsUpdate = true;

        // mouse parallax (lerp for smoothness)
        targetX += (mouseX - targetX) * 0.04;
        targetY += (mouseY - targetY) * 0.04;
        camera.position.x = targetX * 2.6;
        camera.position.y = 1.5 + targetY * 1.8;
        camera.lookAt(0, 0.5, 0);

        renderer.render(scene, camera);
    }

    function start() {
        if (animating) return;
        animating = true;
        clock.getDelta(); // reset delta so the first frame is not a jump
        loop();
    }

    function stop() {
        animating = false;
    }

    if (reduceMotion) {
        renderer.render(scene, camera); // static single frame
    } else {
        start();
    }

    /* ---- Pause when the tab is hidden ---- */
    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            stop();
        } else if (!reduceMotion) {
            start();
        }
    });

    /* ---- Resize ---- */
    window.addEventListener('resize', function () {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    }, { passive: true });
})();