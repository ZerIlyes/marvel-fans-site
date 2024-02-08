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

        if (!isModalOpen) {
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
    }

    document.addEventListener('mousemove', onMouseMove, false);

    function onDocumentMouseDown(event) {
        if (isModalOpen) {
            return; // Ne pas gérer les interactions 3D si la modal est ouverte
        }

        var mouse = new THREE.Vector2();
        var raycaster = new THREE.Raycaster();
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        var intersects = raycaster.intersectObjects(scene.children);

        if (!isModalOpen) {
            if (intersects.length > 0) {
                var clickedMesh = intersects[0].object;

                if (clickedMesh === mesh1 && !isSignupModalOpen) {
                    $('#loginModal').modal('show');
                } else if (clickedMesh === mesh2 && !isLoginModalOpen) {
                    $('#signupModal').modal('show');
                }
            }
        }
    }

    document.addEventListener('mousedown', onDocumentMouseDown, false);

    var isModalOpen = false; // Variable pour suivre si une modal est ouverte
    var isLoginModalOpen = false; // Variable pour suivre si la modal de connexion est ouverte
    var isSignupModalOpen = false; // Variable pour suivre si la modal d'inscription est ouverte

    // Fonction pour désactiver les contrôles de la caméra lorsque la modal de connexion est ouverte
    $('#loginModal').on('shown.bs.modal', function () {
        isModalOpen = true;
        isLoginModalOpen = true;
    });

    // Fonction pour réactiver les contrôles de la caméra lorsque la modal de connexion est fermée
    $('#loginModal').on('hidden.bs.modal', function () {
        isModalOpen = false;
        isLoginModalOpen = false;
    });

    // Fonction pour désactiver les contrôles de la caméra lorsque la modal d'inscription est ouverte
    $('#signupModal').on('shown.bs.modal', function () {
        isModalOpen = true;
        isSignupModalOpen = true;
    });

    // Fonction pour réactiver les contrôles de la caméra lorsque la modal d'inscription est fermée
    $('#signupModal').on('hidden.bs.modal', function () {
        isModalOpen = false;
        isSignupModalOpen = false;
    });

    function animate() {
        requestAnimationFrame(animate);

        if (!isModalOpen) {
            controls.update();
        }

        renderer.render(scene, camera);
    }

    animate();
});