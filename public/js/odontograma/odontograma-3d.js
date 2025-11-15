/**
 * INNOVADENT - Odontograma 3D Interactivo
 * Usando Three.js para renderizado 3D
 * Versión: 1.0
 */

class Odontograma3D {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        this.options = {
            width: options.width || this.container.clientWidth,
            height: options.height || this.container.clientHeight || 600,
            editable: options.editable !== undefined ? options.editable : true
        };

        this.scene = null;
        this.camera = null;
        this.renderer = null;
        this.controls = null;
        this.teeth = [];
        this.selectedTooth = null;

        this.init();
        this.createTeeth();
        this.animate();
    }

    init() {
        // Crear escena
        this.scene = new THREE.Scene();
        this.scene.background = new THREE.Color(0xf5f5f5);

        // Crear cámara
        this.camera = new THREE.PerspectiveCamera(
            75,
            this.options.width / this.options.height,
            0.1,
            1000
        );
        this.camera.position.set(0, 5, 15);
        this.camera.lookAt(0, 0, 0);

        // Crear renderer
        this.renderer = new THREE.WebGLRenderer({ antialias: true });
        this.renderer.setSize(this.options.width, this.options.height);
        this.renderer.shadowMap.enabled = true;
        this.container.appendChild(this.renderer.domElement);

        // Controles de órbita
        if (typeof THREE.OrbitControls !== 'undefined') {
            this.controls = new THREE.OrbitControls(this.camera, this.renderer.domElement);
            this.controls.enableDamping = true;
            this.controls.dampingFactor = 0.05;
        }

        // Iluminación
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
        this.scene.add(ambientLight);

        const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
        directionalLight.position.set(10, 10, 10);
        directionalLight.castShadow = true;
        this.scene.add(directionalLight);

        // Grid helper
        const gridHelper = new THREE.GridHelper(20, 20);
        this.scene.add(gridHelper);

        // Raycaster para selección
        if (this.options.editable) {
            this.raycaster = new THREE.Raycaster();
            this.mouse = new THREE.Vector2();

            this.renderer.domElement.addEventListener('click', this.onMouseClick.bind(this));
            this.renderer.domElement.addEventListener('mousemove', this.onMouseMove.bind(this));
        }

        // Responsive
        window.addEventListener('resize', this.onWindowResize.bind(this));
    }

    createTeeth() {
        // Crear estructura de dentadura completa
        this.createUpperArch();
        this.createLowerArch();
    }

    createUpperArch() {
        const archRadius = 6;
        const teethCount = 16;

        for (let i = 0; i < teethCount; i++) {
            const angle = (Math.PI * i) / (teethCount - 1);
            const x = Math.cos(angle) * archRadius;
            const z = Math.sin(angle) * archRadius - archRadius;
            const y = 2;

            const tooth = this.createTooth(i + 1, x, y, z);
            this.teeth.push(tooth);
            this.scene.add(tooth);
        }
    }

    createLowerArch() {
        const archRadius = 5.5;
        const teethCount = 16;

        for (let i = 0; i < teethCount; i++) {
            const angle = (Math.PI * i) / (teethCount - 1);
            const x = Math.cos(angle) * archRadius;
            const z = Math.sin(angle) * archRadius - archRadius;
            const y = -2;

            const tooth = this.createTooth(i + 17, x, y, z);
            this.teeth.push(tooth);
            this.scene.add(tooth);
        }
    }

    createTooth(number, x, y, z) {
        // Crear geometría del diente (aproximación simple)
        const geometry = new THREE.BoxGeometry(0.8, 1.5, 0.8);

        // Material base
        const material = new THREE.MeshPhongMaterial({
            color: 0xffffff,
            shininess: 100
        });

        const tooth = new THREE.Mesh(geometry, material);
        tooth.position.set(x, y, z);
        tooth.castShadow = true;
        tooth.receiveShadow = true;

        // Guardar información del diente
        tooth.userData = {
            number: number,
            condition: 'healthy',
            originalColor: 0xffffff
        };

        // Crear etiqueta con número
        this.createToothLabel(tooth, number);

        return tooth;
    }

    createToothLabel(tooth, number) {
        // Crear sprite con número
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        canvas.width = 64;
        canvas.height = 64;

        context.fillStyle = 'rgba(0, 0, 0, 0.7)';
        context.fillRect(0, 0, canvas.width, canvas.height);

        context.font = 'Bold 40px Arial';
        context.fillStyle = 'white';
        context.textAlign = 'center';
        context.textBaseline = 'middle';
        context.fillText(number, canvas.width / 2, canvas.height / 2);

        const texture = new THREE.CanvasTexture(canvas);
        const spriteMaterial = new THREE.SpriteMaterial({ map: texture });
        const sprite = new THREE.Sprite(spriteMaterial);

        sprite.scale.set(0.5, 0.5, 1);
        sprite.position.set(0, 1, 0);

        tooth.add(sprite);
    }

    setToothCondition(toothNumber, condition) {
        const tooth = this.teeth.find(t => t.userData.number === toothNumber);

        if (tooth) {
            const colors = {
                healthy: 0xffffff,
                caries: 0xcc0000,
                restoration: 0x0066cc,
                crown: 0xffd700,
                missing: 0xcccccc,
                endodontics: 0xff6600
            };

            const color = colors[condition] || colors.healthy;
            tooth.material.color.setHex(color);
            tooth.userData.condition = condition;
        }
    }

    onMouseClick(event) {
        event.preventDefault();

        const rect = this.renderer.domElement.getBoundingClientRect();
        this.mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        this.mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        this.raycaster.setFromCamera(this.mouse, this.camera);
        const intersects = this.raycaster.intersectObjects(this.teeth);

        if (intersects.length > 0) {
            const selectedTooth = intersects[0].object;

            // Deseleccionar anterior
            if (this.selectedTooth) {
                this.selectedTooth.material.emissive.setHex(0x000000);
            }

            // Seleccionar nuevo
            this.selectedTooth = selectedTooth;
            this.selectedTooth.material.emissive.setHex(0x00ff00);

            // Disparar evento
            this.onToothSelected(selectedTooth.userData);
        }
    }

    onMouseMove(event) {
        const rect = this.renderer.domElement.getBoundingClientRect();
        this.mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        this.mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        this.raycaster.setFromCamera(this.mouse, this.camera);
        const intersects = this.raycaster.intersectObjects(this.teeth);

        if (intersects.length > 0) {
            this.renderer.domElement.style.cursor = 'pointer';
        } else {
            this.renderer.domElement.style.cursor = 'default';
        }
    }

    onToothSelected(toothData) {
        console.log('Diente 3D seleccionado:', toothData);

        const event = new CustomEvent('tooth3DSelected', {
            detail: toothData
        });
        this.container.dispatchEvent(event);
    }

    onWindowResize() {
        this.camera.aspect = this.options.width / this.options.height;
        this.camera.updateProjectionMatrix();
        this.renderer.setSize(this.options.width, this.options.height);
    }

    animate() {
        requestAnimationFrame(this.animate.bind(this));

        if (this.controls) {
            this.controls.update();
        }

        this.renderer.render(this.scene, this.camera);
    }

    exportData() {
        const data = this.teeth.map(tooth => ({
            number: tooth.userData.number,
            condition: tooth.userData.condition
        }));

        return {
            teeth: data,
            timestamp: new Date().toISOString()
        };
    }

    importData(data) {
        if (data && data.teeth) {
            data.teeth.forEach(toothData => {
                this.setToothCondition(toothData.number, toothData.condition);
            });
        }
    }

    reset() {
        this.teeth.forEach(tooth => {
            tooth.material.color.setHex(tooth.userData.originalColor);
            tooth.userData.condition = 'healthy';
        });

        if (this.selectedTooth) {
            this.selectedTooth.material.emissive.setHex(0x000000);
            this.selectedTooth = null;
        }
    }

    dispose() {
        if (this.controls) {
            this.controls.dispose();
        }

        this.teeth.forEach(tooth => {
            tooth.geometry.dispose();
            tooth.material.dispose();
        });

        this.renderer.dispose();
        this.container.removeChild(this.renderer.domElement);
    }
}

// Exportar
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Odontograma3D;
}
