 // Créer la scène
    var scene = new THREE.Scene();

    // Ajouter une caméra pour le carrousel
    var carouselCamera = new THREE.PerspectiveCamera(55, window.innerWidth / window.innerHeight, 0.1, 1000);
    carouselCamera.position.z = 300;

    // Créer le rendu
    var renderer = new THREE.WebGLRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    // Charger les images de bandes dessinées
    var textureLoader = new THREE.TextureLoader();
    var textures = [
    { texture: textureLoader.load('./public/images/Quizzz.png'), link: 'index.php?action=quiz_list' },
    { texture: textureLoader.load('./public/images/Forums.png'), link: 'index.php?action=forum_topics' },
    { texture: textureLoader.load('./public/images/Review.png'), link: 'index.php?action=write_review' },
    { texture: textureLoader.load('./public/images/Jarviss.png'), link: 'index.php?action=jarvis' },
    // Ajoutez vos autres images ici avec les liens correspondant
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

    // Ajouter un contrôle pour le carrousel
    var carouselControls = new THREE.OrbitControls(carouselCamera, renderer.domElement);
    carouselControls.enableZoom = false;

    // Variables pour la rotation du carrousel
    var carouselSpeed = 0.003; // Vitesse de rotation du carrousel
    var carouselRotation = 0; // Rotation actuelle du carrousel

    // La boucle de rendu
    function animate() {
    requestAnimationFrame(animate);

    // Rotation du carrousel en continu
    carouselRotation += carouselSpeed;
    meshes.forEach(function(item, index) {
    var angle = carouselRotation + (index / textures.length) * Math.PI * 2;
    item.mesh.position.x = radius * Math.cos(angle);
    item.mesh.position.y = radius * Math.sin(angle);
    item.mesh.lookAt(new THREE.Vector3(0, 0, 0)); // S'assurer que les images regardent vers le centre
});

    renderer.render(scene, carouselCamera);
}

    animate();

    // Ajouter des gestionnaires d'événements pour le survol et le clic
    var raycaster = new THREE.Raycaster();
    var mouse = new THREE.Vector2();

    function onMouseMove(event) {
    // Mettre à jour les coordonnées de la souris
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    // Mettre à jour le raycaster avec la position de la souris
    raycaster.setFromCamera(mouse, carouselCamera);

    // Vérifier les intersections
    var intersects = raycaster.intersectObjects(meshes.map(function(item) {
    return item.mesh;
}));

    // Si la souris survole un objet, appliquer l'effet de survol
    if (intersects.length > 0) {
    var intersected = intersects[0].object;
    meshes.forEach(function(item) {
    if (item.mesh === intersected) {
    item.mesh.scale.set(1.2, 1.2, 1.2); // Appliquer l'effet de survol
}
});
} else {
    // Si la souris ne survole pas d'objet, réinitialiser l'échelle de tous les objets
    meshes.forEach(function(item) {
    item.mesh.scale.set(1, 1, 1);
});
}
}

    function onMouseClick(event) {
    // Mettre à jour les coordonnées de la souris
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;

    // Mettre à jour le raycaster avec la position de la souris
    raycaster.setFromCamera(mouse, carouselCamera);

    // Vérifier les intersections
    var intersects = raycaster.intersectObjects(meshes.map(function(item) {
    return item.mesh;
}));

    // Si la souris clique sur un objet, ouvrir le lien associé
    if (intersects.length > 0) {
    var intersected = intersects[0].object;
    meshes.forEach(function(item) {
    if (item.mesh === intersected) {
    window.open(item.link, '_blank'); // Ouvre le lien dans un nouvel onglet
}
});
}
}

    // Ajouter les gestionnaires d'événements de survol et de clic au document
    document.addEventListener('mousemove', onMouseMove, false);
    document.addEventListener('click', onMouseClick, false);
