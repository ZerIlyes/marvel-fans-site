<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carrousel 3D de Bandes Dessinées</title>
    <style>
        body { margin: 0; }
        canvas { display: block; }
        .comic-image {
            transition: opacity 0.3s ease-in-out;
            cursor: pointer;
        }
        .comic-image:hover {
            opacity: 0.7;
        }
    </style>
</head>
<body>

<!-- Three.js -->
<script src="https://cdn.jsdelivr.net/npm/three/build/three.min.js"></script>
<!-- OrbitControls.js -->
<script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>

<script>
    // Créer la scène
    var scene = new THREE.Scene();

    // Ajouter une caméra
    var camera = new THREE.PerspectiveCamera(55, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.z = 300; // Ajuster en fonction de la vue initiale désirée

    // Créer le rendu
    var renderer = new THREE.WebGLRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    // Charger les images de bandes dessinées
    var textureLoader = new THREE.TextureLoader();
    var textures = [
        { texture: textureLoader.load('./public/images/Quizzz.png'), link: 'page1.html' },
        { texture: textureLoader.load('./public/images/Forums.png'), link: 'page1.html' },
        { texture: textureLoader.load('./public/images/Review.png'), link: 'page1.html' },
        { texture: textureLoader.load('./public/images/Jarviss.png'), link: 'page1.html' },


        // Ajoutez vos autres images ici avec les liens correspondants
    ];

    // Variables globales pour le rayon et les meshs
    var radius = 100; // Réduisez cette valeur pour rapprocher les images
    var meshes = [];


    // Créer des meshs avec ces textures et les positionner
    textures.forEach(function(item, index) {
        var geometry = new THREE.PlaneGeometry(75, 50);
        var material = new THREE.MeshBasicMaterial({
            map: item.texture,
            side: THREE.DoubleSide // Ajouter cette ligne pour rendre le matériau visible des deux côtés
        });
        var mesh = new THREE.Mesh(geometry, material);
        var angle = (index / textures.length) * Math.PI * 2;
        mesh.position.x = radius * Math.cos(angle);
        mesh.position.y = radius * Math.sin(angle);
        mesh.lookAt(new THREE.Vector3(0, 0, 0));
        scene.add(mesh);
        meshes.push({ mesh: mesh, link: item.link }); // Stocker les meshs et les liens pour une utilisation ultérieure
    });

    // Ajouter un contrôle pour la rotation à l'aide de la souris
    var controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableZoom = false; // Désactiver le zoom par défaut

    // Gestionnaire d'événement pour le zoom personnalisé avec la molette de la souris
    function onDocumentMouseWheel(event) {
        var zoomSpeed = 0.1;
        var zoomDirection = event.deltaY > 0 ? 1 : -1;
        radius += zoomDirection * zoomSpeed * (radius * 0.1);
        radius = Math.max(50, Math.min(500, radius)); // Limiter le rayon
        meshes.forEach(function(item, index) {
            var angle = (index / textures.length) * Math.PI * 2;
            item.mesh.position.x = radius * Math.cos(angle);
            item.mesh.position.y = radius * Math.sin(angle);
        });
    }

    // Ajouter l'écouteur d'événements pour la molette de la souris au document
    document.addEventListener('wheel', onDocumentMouseWheel, false);

    // Gestionnaire d'événement pour le clic sur une image
    document.addEventListener('click', function(event) {
        var mouse = new THREE.Vector2();
        var raycaster = new THREE.Raycaster();

        // Coordonnées de la souris dans l'espace 2D normalisé
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        // Mettre à jour le rayon et tester l'intersection avec les meshs
        raycaster.setFromCamera(mouse, camera);
        var intersects = raycaster.intersectObjects(meshes.map(function(item) { return item.mesh; }));

        if (intersects.length > 0) {
            // L'utilisateur a cliqué sur une image
            var link = meshes.find(function(item) { return item.mesh === intersects[0].object; }).link;
            window.location.href = link; // Rediriger vers la page correspondante
        }
    });
    document.addEventListener('mousemove', onMouseMove, false);
    var INTERSECTED;

    function onMouseMove(event) {
        var mouse = new THREE.Vector2();
        var raycaster = new THREE.Raycaster();

        // Coordonnées de la souris dans l'espace 2D normalisé
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

        // Mettre à jour le rayon et tester l'intersection avec les meshs
        raycaster.setFromCamera(mouse, camera);
        var intersects = raycaster.intersectObjects(meshes.map(function(item) { return item.mesh; }));

        if (intersects.length > 0) {
            if (INTERSECTED != intersects[0].object) {
                if (INTERSECTED) {
                    // Réinitialiser l'effet de survol précédent
                    INTERSECTED.scale.set(1, 1, 1);
                }
                INTERSECTED = intersects[0].object;
                // Appliquer l'effet de survol
                INTERSECTED.scale.set(1.2, 1.2, 1.2); // Exemple d'effet de zoom
            }
        } else {
            if (INTERSECTED) {
                // Réinitialiser l'effet de survol
                INTERSECTED.scale.set(1, 1, 1);
            }
            INTERSECTED = null;
        }
    }

    // La boucle de rendu
    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

    animate();
</script>
</body>
</html>












