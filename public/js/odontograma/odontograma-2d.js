/**
 * INNOVADENT - Odontograma 2D Interactivo
 * Autor: INNOVADENT Team
 * Versión: 1.0
 */

class Odontograma {
    constructor(canvasId, options = {}) {
        this.canvas = document.getElementById(canvasId);
        this.ctx = this.canvas.getContext('2d');

        this.options = {
            width: options.width || 1200,
            height: options.height || 600,
            toothSize: options.toothSize || 40,
            gap: options.gap || 10,
            editable: options.editable !== undefined ? options.editable : true,
            nomenclature: options.nomenclature || 'universal' // universal, palmer, fdi
        };

        this.canvas.width = this.options.width;
        this.canvas.height = this.options.height;

        // Configuración de dientes
        this.teeth = {
            upper: {
                right: [1, 2, 3, 4, 5, 6, 7, 8],
                left: [9, 10, 11, 12, 13, 14, 15, 16]
            },
            lower: {
                left: [17, 18, 19, 20, 21, 22, 23, 24],
                right: [25, 26, 27, 28, 29, 30, 31, 32]
            }
        };

        // Estado de cada diente
        this.teethState = {};
        this.initializeTeethState();

        // Colores para condiciones
        this.colors = {
            healthy: '#FFFFFF',
            caries: '#CC0000',
            restoration: '#0066CC',
            crown: '#FFD700',
            missing: '#CCCCCC',
            endodontics: '#FF6600',
            selected: '#00FF00'
        };

        this.selectedTooth = null;
        this.selectedCondition = 'healthy';

        // Event listeners
        if (this.options.editable) {
            this.canvas.addEventListener('click', this.handleClick.bind(this));
            this.canvas.addEventListener('mousemove', this.handleMouseMove.bind(this));
        }

        this.draw();
    }

    initializeTeethState() {
        const allTeeth = [
            ...this.teeth.upper.right,
            ...this.teeth.upper.left,
            ...this.teeth.lower.left,
            ...this.teeth.lower.right
        ];

        allTeeth.forEach(tooth => {
            this.teethState[tooth] = {
                condition: 'healthy',
                surfaces: {
                    mesial: 'healthy',
                    distal: 'healthy',
                    occlusal: 'healthy',
                    vestibular: 'healthy',
                    lingual: 'healthy'
                },
                notes: ''
            };
        });
    }

    draw() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

        // Dibujar dientes superiores
        this.drawArch('upper', 50);

        // Dibujar dientes inferiores
        this.drawArch('lower', this.canvas.height / 2 + 50);

        // Dibujar leyenda
        this.drawLegend();
    }

    drawArch(arch, startY) {
        const centerX = this.canvas.width / 2;
        const toothSize = this.options.toothSize;
        const gap = this.options.gap;

        if (arch === 'upper') {
            // Lado derecho (1-8)
            let x = centerX;
            this.teeth.upper.right.forEach(toothNum => {
                this.drawTooth(x, startY, toothNum, 'upper');
                x += toothSize + gap;
            });

            // Lado izquierdo (9-16)
            x = centerX - toothSize - gap;
            this.teeth.upper.left.forEach(toothNum => {
                this.drawTooth(x, startY, toothNum, 'upper');
                x -= toothSize + gap;
            });
        } else {
            // Lado izquierdo (17-24)
            let x = centerX - toothSize - gap;
            this.teeth.lower.left.forEach(toothNum => {
                this.drawTooth(x, startY, toothNum, 'lower');
                x -= toothSize + gap;
            });

            // Lado derecho (25-32)
            x = centerX;
            this.teeth.lower.right.forEach(toothNum => {
                this.drawTooth(x, startY, toothNum, 'lower');
                x += toothSize + gap;
            });
        }
    }

    drawTooth(x, y, toothNum, arch) {
        const size = this.options.toothSize;
        const state = this.teethState[toothNum];

        // Color base según condición
        const fillColor = this.colors[state.condition] || this.colors.healthy;

        // Dibujar diente (rectángulo redondeado)
        this.ctx.save();
        this.ctx.fillStyle = fillColor;
        this.ctx.strokeStyle = this.selectedTooth === toothNum ? this.colors.selected : '#000000';
        this.ctx.lineWidth = this.selectedTooth === toothNum ? 3 : 1;

        this.roundRect(x, y, size, size, 5);
        this.ctx.fill();
        this.ctx.stroke();

        // Dibujar superficies si tienen condiciones
        this.drawSurfaces(x, y, size, state.surfaces);

        // Dibujar número del diente
        this.ctx.fillStyle = '#000000';
        this.ctx.font = 'bold 12px Arial';
        this.ctx.textAlign = 'center';
        this.ctx.textBaseline = 'middle';
        this.ctx.fillText(toothNum, x + size/2, y + size/2);

        this.ctx.restore();
    }

    drawSurfaces(x, y, size, surfaces) {
        const surfaceSize = size / 3;

        // Mesial (izquierda)
        if (surfaces.mesial !== 'healthy') {
            this.ctx.fillStyle = this.colors[surfaces.mesial];
            this.ctx.fillRect(x, y + surfaceSize, surfaceSize, surfaceSize);
        }

        // Distal (derecha)
        if (surfaces.distal !== 'healthy') {
            this.ctx.fillStyle = this.colors[surfaces.distal];
            this.ctx.fillRect(x + size - surfaceSize, y + surfaceSize, surfaceSize, surfaceSize);
        }

        // Occlusal (centro)
        if (surfaces.occlusal !== 'healthy') {
            this.ctx.fillStyle = this.colors[surfaces.occlusal];
            this.ctx.fillRect(x + surfaceSize, y + surfaceSize, surfaceSize, surfaceSize);
        }

        // Vestibular (arriba)
        if (surfaces.vestibular !== 'healthy') {
            this.ctx.fillStyle = this.colors[surfaces.vestibular];
            this.ctx.fillRect(x + surfaceSize, y, surfaceSize, surfaceSize);
        }

        // Lingual (abajo)
        if (surfaces.lingual !== 'healthy') {
            this.ctx.fillStyle = this.colors[surfaces.lingual];
            this.ctx.fillRect(x + surfaceSize, y + size - surfaceSize, surfaceSize, surfaceSize);
        }
    }

    drawLegend() {
        const legendX = 20;
        const legendY = this.canvas.height - 100;
        const boxSize = 20;
        const gap = 10;

        this.ctx.font = 'bold 14px Arial';
        this.ctx.fillStyle = '#000000';
        this.ctx.fillText('Leyenda:', legendX, legendY - 10);

        let x = legendX;
        let y = legendY;

        const conditions = [
            { key: 'healthy', label: 'Sano' },
            { key: 'caries', label: 'Caries' },
            { key: 'restoration', label: 'Restauración' },
            { key: 'crown', label: 'Corona' },
            { key: 'endodontics', label: 'Endodoncia' },
            { key: 'missing', label: 'Ausente' }
        ];

        conditions.forEach((condition, index) => {
            if (index > 0 && index % 3 === 0) {
                x = legendX;
                y += boxSize + gap;
            }

            // Caja de color
            this.ctx.fillStyle = this.colors[condition.key];
            this.ctx.fillRect(x, y, boxSize, boxSize);
            this.ctx.strokeStyle = '#000000';
            this.ctx.strokeRect(x, y, boxSize, boxSize);

            // Etiqueta
            this.ctx.fillStyle = '#000000';
            this.ctx.font = '12px Arial';
            this.ctx.textAlign = 'left';
            this.ctx.fillText(condition.label, x + boxSize + 5, y + boxSize/2 + 4);

            x += 180;
        });
    }

    roundRect(x, y, width, height, radius) {
        this.ctx.beginPath();
        this.ctx.moveTo(x + radius, y);
        this.ctx.lineTo(x + width - radius, y);
        this.ctx.quadraticCurveTo(x + width, y, x + width, y + radius);
        this.ctx.lineTo(x + width, y + height - radius);
        this.ctx.quadraticCurveTo(x + width, y + height, x + width - radius, y + height);
        this.ctx.lineTo(x + radius, y + height);
        this.ctx.quadraticCurveTo(x, y + height, x, y + height - radius);
        this.ctx.lineTo(x, y + radius);
        this.ctx.quadraticCurveTo(x, y, x + radius, y);
        this.ctx.closePath();
    }

    handleClick(event) {
        const rect = this.canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        const tooth = this.getToothAtPosition(x, y);

        if (tooth) {
            this.selectedTooth = tooth;
            this.onToothSelected(tooth);
            this.draw();
        }
    }

    handleMouseMove(event) {
        const rect = this.canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        const tooth = this.getToothAtPosition(x, y);

        if (tooth) {
            this.canvas.style.cursor = 'pointer';
        } else {
            this.canvas.style.cursor = 'default';
        }
    }

    getToothAtPosition(x, y) {
        // Implementar detección de diente según posición
        // Por ahora, retornar null (a implementar completamente)
        return null;
    }

    setToothCondition(toothNum, condition) {
        if (this.teethState[toothNum]) {
            this.teethState[toothNum].condition = condition;
            this.draw();
        }
    }

    setSurfaceCondition(toothNum, surface, condition) {
        if (this.teethState[toothNum]) {
            this.teethState[toothNum].surfaces[surface] = condition;
            this.draw();
        }
    }

    onToothSelected(toothNum) {
        // Callback cuando se selecciona un diente
        console.log('Diente seleccionado:', toothNum);

        // Disparar evento personalizado
        const event = new CustomEvent('toothSelected', {
            detail: {
                toothNum: toothNum,
                state: this.teethState[toothNum]
            }
        });
        this.canvas.dispatchEvent(event);
    }

    exportData() {
        return {
            teeth: this.teethState,
            timestamp: new Date().toISOString()
        };
    }

    importData(data) {
        if (data && data.teeth) {
            this.teethState = data.teeth;
            this.draw();
        }
    }

    reset() {
        this.initializeTeethState();
        this.selectedTooth = null;
        this.draw();
    }
}

// Exportar para uso en módulos
if (typeof module !== 'undefined' && module.exports) {
    module.exports = Odontograma;
}
