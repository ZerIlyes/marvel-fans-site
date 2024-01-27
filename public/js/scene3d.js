document.addEventListener('DOMContentLoaded', function () {
    var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    var renderer = new THREE.WebGLRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    var controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableZoom = false;

    camera.position.z = 5;

    var textureLoader = new THREE.TextureLoader();
    var materials = [
        new THREE.MeshBasicMaterial({ map: textureLoader.load('public/images/Connectez.png'), side: THREE.DoubleSide }),
        new THREE.MeshBasicMaterial({ map: textureLoader.load('public/images/Inscription.png'), side: THREE.DoubleSide })
    ];

    var geometry = new THREE.PlaneGeometry(2, 2);
    var mesh1 = new THREE.Mesh(geometry, materials[0]);
    var mesh2 = new THREE.Mesh(geometry, materials[1]);

    mesh1.position.x = -2.5;
    mesh2.position.x = 2.5;

    scene.add(mesh1);
    scene.add(mesh2);

    var INTERSECTED;
    function onMouseMove(event) {
        var mouse = new THREE.Vector2();
        var raycaster = new THREE.Raycaster();

        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        var intersects = raycaster.intersectObjects(scene.children);

        if (intersects.length > 0) {
            if (INTERSECTED != intersects[0].object) {
                if (INTERSECTED) INTERSECTED.scale.set(1, 1, 1);
                INTERSECTED = intersects[0].object;
                INTERSECTED.scale.set(1.2, 1.2, 1.2);
            }
        } else {
            if (INTERSECTED) INTERSECTED.scale.set(1, 1, 1);
            INTERSECTED = null;
        }
    }
    document.addEventListener('mousemove', onMouseMove, false);

    function onDocumentMouseDown(event) {
        var mouse = new THREE.Vector2();
        var raycaster = new THREE.Raycaster();
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        var intersects = raycaster.intersectObjects(scene.children);

        if (intersects.length > 0) {
            var clickedMesh = intersects[0].object;

            if (clickedMesh === mesh1) {
                $('#loginModal').modal('show');
            } else if (clickedMesh === mesh2) {
                $('#signupModal').modal('show');
            }
        }
    }
    document.getElementById('avatar').addEventListener('change', function() {
        document.getElementById('selectedAvatar').src = this.value;
    });

    document.addEventListener('mousedown', onDocumentMouseDown, false);

    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

    animate();
});
