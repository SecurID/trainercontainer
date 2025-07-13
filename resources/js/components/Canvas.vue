<template>
    <div class="flex flex-col items-center">
        <div class="flex justify-center">
            <canvas
                class="border-2 border-gray-500"
                ref="can"
                width="1024"
                height="765"
                @mouse:down="handleMouseDown"
                @mouse:move="handleMouseMove"
                @mouse:up="handleMouseUp"
                @object:modified="handleObjectModified"
                tabindex="0"
            ></canvas>
        </div>
        <div class="space-y-2">
            <!-- First Line: Players, Ball & Movement -->
            <div class="flex justify-center">
                <toolbar>
                    <!-- Players & Ball -->
                    <toolbar-item @tool-selected="selectTool('player-offense')">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-sm">Offense</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('player-defense')">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-3 relative">
                                <div class="absolute inset-0 border border-black transform rotate-45"></div>
                            </div>
                            <span class="text-sm">Defense</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('player-third')">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-3 bg-green-500"></div>
                            <span class="text-sm">Third</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('ball')">
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-black rounded-full"></div>
                            <span class="text-sm">Ball</span>
                        </div>
                    </toolbar-item>

                    <div class="border-l border-gray-300 mx-2 h-6"></div>

                    <!-- Movement & Actions -->
                    <toolbar-item @tool-selected="selectTool('pass')">
                        <div class="flex items-center space-x-1">
                            <div class="w-4 h-0 border-t border-black relative">
                                <div class="absolute -right-0.5 -top-0.5 w-0 h-0 border-l border-l-black border-t-[2px] border-t-transparent border-b-[2px] border-b-transparent"></div>
                            </div>
                            <span class="text-sm">Pass</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('run')">
                        <div class="flex items-center space-x-1">
                            <div class="w-4 h-0 border-t border-dashed border-black relative">
                                <div class="absolute -right-0.5 -top-0.5 w-0 h-0 border-l border-l-black border-t-[2px] border-t-transparent border-b-[2px] border-b-transparent"></div>
                            </div>
                            <span class="text-sm">Run</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('shoot')">
                        <div class="flex items-center space-x-1">
                            <div class="w-4 h-0 border-t-2 border-black relative">
                                <div class="absolute -right-0.5 -top-1 w-0 h-0 border-l border-l-black border-t-[3px] border-t-transparent border-b-[3px] border-b-transparent"></div>
                            </div>
                            <span class="text-sm">Shoot</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('dribble')">
                        <div class="flex items-center space-x-1">
                            <div class="w-4 h-0 relative">
                                <svg width="16" height="6" viewBox="0 0 16 6" class="absolute -top-1.5">
                                    <path d="M1,3 Q3,1 5,3 T9,3 L13,3" stroke="black" stroke-width="1" fill="none"/>
                                    <polygon points="12,2 15,3 12,4" fill="black"/>
                                </svg>
                            </div>
                            <span class="text-sm">Dribble</span>
                        </div>
                    </toolbar-item>
                </toolbar>
            </div>

            <!-- Second Line: Equipment, Goals & Background -->
            <div class="flex justify-center">
                <toolbar>
                    <!-- Equipment -->
                    <toolbar-item @tool-selected="selectTool('cone')">
                        <div class="flex items-center space-x-1">
                            <div class="w-0 h-0 border-l border-l-transparent border-r border-r-transparent border-b-2 border-b-orange-500"></div>
                            <span class="text-sm">Cone</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('area')">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-2 border border-dashed border-gray-600"></div>
                            <span class="text-sm">Area</span>
                        </div>
                    </toolbar-item>

                    <div class="border-l border-gray-300 mx-2 h-6"></div>

                    <!-- Goals -->
                    <toolbar-item @tool-selected="selectTool('goal-l')">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-2 border border-l-0 border-green-600"></div>
                            <span class="text-sm">Goal L</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('goal-r')">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-2 border border-r-0 border-green-600"></div>
                            <span class="text-sm">Goal R</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('minigoal-l')">
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-1.5 border border-l-0 border-orange-500"></div>
                            <span class="text-sm">Mini L</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="selectTool('minigoal-r')">
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-1.5 border border-r-0 border-orange-500"></div>
                            <span class="text-sm">Mini R</span>
                        </div>
                    </toolbar-item>

                    <div class="border-l border-gray-300 mx-2 h-6"></div>

                    <!-- Background -->
                    <toolbar-item @tool-selected="setBackground('full-field')">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-2 border border-black relative">
                                <div class="absolute top-1/2 left-1/2 w-1 h-1 border border-black rounded-full transform -translate-x-1/2 -translate-y-1/2"></div>
                                <div class="absolute top-1/2 left-0 w-0 h-1 border-l border-black transform -translate-y-1/2"></div>
                            </div>
                            <span class="text-sm">Full</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="setBackground('half-field')">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-1.5 border border-black relative">
                                <div class="absolute bottom-0 left-1/2 w-1 h-1 border border-black rounded-full transform -translate-x-1/2 translate-y-1/2"></div>
                            </div>
                            <span class="text-sm">Half</span>
                        </div>
                    </toolbar-item>
                    <toolbar-item @tool-selected="setBackground('white')">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-2 bg-white border border-gray-400"></div>
                            <span class="text-sm">White</span>
                        </div>
                    </toolbar-item>

                    <div class="border-l border-gray-300 mx-2 h-6"></div>

                    <!-- Download -->
                    <toolbar-item @tool-selected="downloadCanvas()" class="bg-green-500 hover:bg-black">
                        <div class="flex items-center space-x-1">
                            <div class="w-3 h-3 relative">
                                <div class="w-3 h-2 border border-white"></div>
                                <div class="absolute bottom-0 left-1/2 w-0 h-0 border-l-[3px] border-l-transparent border-r-[3px] border-r-transparent border-t-[3px] border-t-white transform -translate-x-1/2"></div>
                            </div>
                            <span class="text-sm text-white">Download</span>
                        </div>
                    </toolbar-item>
                </toolbar>
            </div>
        </div>
    </div>
</template>

<script>
import '../classes/arrow-line.js';
import '../classes/dotted-line-arrow.js';
import '../classes/bold-line-arrow.js';
import '../classes/wavy-line-arrow.js';
import '../classes/cross.js';
import '../classes/striped-box.js';
import Toolbar from './Toolbar.vue';
import ToolbarItem from './ToolbarItem.vue';
import { fabric } from 'fabric/dist/fabric';
import goal_r from '../assets/svg/goal-right.svg?raw'
import goal_l from '../assets/svg/goal-left.svg?raw'
import minigoal_r from '../assets/svg/minigoal-right.svg?raw'
import minigoal_l from '../assets/svg/minigoal-left.svg?raw'

export default {
    components: {
        Toolbar,
        ToolbarItem
    },
    data() {
        return {
            canvas: null,
            currentTool: null,
            isDrawing: false,
            startPoint: null,
            currentObject: null,
            objectSize: 20,
            objectColor: '#000000',
            backgroundType: 'white'
        }
    },
    computed: {
        scaledObjectSize() {
            return this.backgroundType === 'white' ? this.objectSize * 1.5 : this.objectSize;
        }
    },
    mounted() {
        const ref = this.$refs.can;
        this.canvas = new fabric.Canvas(ref);
        this.drawFootballField(); // Call the method to draw the field here
        this.canvas.on('mouse:down', this.handleMouseDown);
        this.canvas.on('mouse:move', this.handleMouseMove);
        this.canvas.on('mouse:up', this.handleMouseUp);
        this.canvas.on('object:modified', this.handleObjectModified);

        document.addEventListener('keydown', this.handleKeyDown);
    },
    beforeDestroy() {
        // Remove the keydown listener when the component is destroyed
        document.removeEventListener('keydown', this.handleKeyDown);
    },
    methods: {
        selectTool(tool) {
            this.currentTool = tool;
            if (this.currentObject) {
                this.canvas.discardActiveObject();
                this.currentObject = null;
            }
        },
        setBackground(backgroundType) {
            const previousType = this.backgroundType;
            this.backgroundType = backgroundType;
            this.clearField();
            this.drawFootballField();

            // Handle object scaling when switching to/from white background
            this.scaleObjectsForBackground(previousType, backgroundType);
        },
        scaleObjectsForBackground(previousType, newType) {
            // Scale factor for white background (make objects bigger)
            const whiteBackgroundScale = 1.5;

            // Determine scale factor based on transition
            let scaleFactor = 1;
            if (previousType !== 'white' && newType === 'white') {
                // Switching to white background - make objects bigger
                scaleFactor = whiteBackgroundScale;
            } else if (previousType === 'white' && newType !== 'white') {
                // Switching from white background - make objects smaller
                scaleFactor = 1 / whiteBackgroundScale;
            }

            if (scaleFactor !== 1) {
                this.canvas.forEachObject((obj) => {
                    // Only scale user-drawn objects (selectable ones)
                    if (obj.selectable !== false) {
                        obj.scale(scaleFactor);
                        obj.setCoords();
                    }
                });
                this.canvas.renderAll();
            }
        },
        clearField() {
            // Remove all field elements (keep user-drawn objects)
            const objectsToRemove = [];
            this.canvas.forEachObject((obj) => {
                if (obj.selectable === false && obj.evented === false) {
                    objectsToRemove.push(obj);
                }
            });
            objectsToRemove.forEach(obj => this.canvas.remove(obj));
        },
        downloadCanvas() {
            // Deselect any active objects to avoid selection borders in export
            this.canvas.discardActiveObject();
            this.canvas.renderAll();

            // Generate filename with timestamp
            const now = new Date();
            const timestamp = now.toISOString().slice(0, 19).replace(/[:.]/g, '-');
            const filename = `soccer-diagram-${timestamp}.png`;

            // Export canvas as PNG
            const dataURL = this.canvas.toDataURL({
                format: 'png',
                quality: 1.0,
                multiplier: 2 // Higher resolution for better quality
            });

            // Create download link
            const link = document.createElement('a');
            link.download = filename;
            link.href = dataURL;

            // Trigger download
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },
        handleMouseDown(e) {
            if (e.target) {
                // An existing object was clicked, do not proceed with drawing a new element
                return;
            }
            if (['pass', 'run', 'shoot', 'dribble', 'area'].includes(this.currentTool)) {
                if (!this.isDrawing) {
                    this.isDrawing = true;
                    this.startPoint = new fabric.Point(e.absolutePointer.x, e.absolutePointer.y);
                } else {
                    const endPoint = new fabric.Point(e.absolutePointer.x, e.absolutePointer.y);
                    let line;
                    if (this.currentTool === 'pass') {
                        line = new fabric.PassLineArrow([this.startPoint.x, this.startPoint.y, endPoint.x, endPoint.y], {
                            strokeWidth: this.scaledObjectSize / 10,
                            fill: this.objectColor,
                            stroke: this.objectColor,
                            originX: 'center',
                            originY: 'center'
                        });
                    } else if (this.currentTool === 'run') {
                        line = new fabric.DottedLineArrow([this.startPoint.x, this.startPoint.y, endPoint.x, endPoint.y], {
                            strokeWidth: this.scaledObjectSize / 10,
                            fill: this.objectColor,
                            stroke: this.objectColor,
                            originX: 'center',
                            originY: 'center'
                        });
                    } else if (this.currentTool === 'shoot') {
                        line = new fabric.BoldLineArrow([this.startPoint.x, this.startPoint.y, endPoint.x, endPoint.y], {
                            strokeWidth: this.scaledObjectSize / 10,
                            fill: this.objectColor,
                            stroke: this.objectColor,
                            originX: 'center',
                            originY: 'center'
                        });
                    } else if (this.currentTool === 'dribble') {
                        line = new fabric.WavyLineArrow([this.startPoint.x, this.startPoint.y, endPoint.x, endPoint.y], {
                            strokeWidth: this.scaledObjectSize / 10,
                            fill: this.objectColor,
                            stroke: this.objectColor,
                            originX: 'center',
                            originY: 'center'
                        });
                    } else if (this.currentTool === 'area') {
                        // Create striped box from start point to end point
                        const left = Math.min(this.startPoint.x, endPoint.x);
                        const top = Math.min(this.startPoint.y, endPoint.y);
                        const width = Math.abs(endPoint.x - this.startPoint.x);
                        const height = Math.abs(endPoint.y - this.startPoint.y);

                        line = new fabric.StripedBox({
                            left: left,
                            top: top,
                            width: width,
                            height: height,
                            originX: 'left',
                            originY: 'top'
                        });
                    }
                    this.canvas.add(line);
                    this.isDrawing = false;
                    this.startPoint = null;
                }
            } else {
                this.isDrawing = true;
                this.startPoint = new fabric.Point(e.absolutePointer.x, e.absolutePointer.y);

                if (this.currentTool === 'cone') {
                    this.currentObject = new fabric.Triangle({
                        left: this.startPoint.x - (this.scaledObjectSize / 2),
                        top: this.startPoint.y - (this.scaledObjectSize / 2),
                        width: this.scaledObjectSize,
                        height: this.scaledObjectSize,
                        // fill with orange color
                        fill: '#FFA500'
                    });
                } else if (this.currentTool === 'player-offense') {
                    this.currentObject = new fabric.Circle({
                        left: this.startPoint.x - (this.scaledObjectSize / 2),
                        top: this.startPoint.y - (this.scaledObjectSize / 2),
                        radius: this.scaledObjectSize / 2,
                        fill: 'red'
                    });
                } else if (this.currentTool === 'ball') {
                    const ballRadius = this.scaledObjectSize / 3; // Smaller than offense player
                    this.currentObject = new fabric.Circle({
                        left: this.startPoint.x - ballRadius,
                        top: this.startPoint.y - ballRadius,
                        radius: ballRadius,
                        fill: 'black'
                    });
                } else if (this.currentTool === 'player-third') {
                    this.currentObject = new fabric.Rect({
                        left: this.startPoint.x - (this.scaledObjectSize / 2),
                        top: this.startPoint.y - (this.scaledObjectSize / 2),
                        width: this.scaledObjectSize,
                        height: this.scaledObjectSize,
                        fill: 'green'
                    });
                } else if (this.currentTool === 'player-defense') {
                    this.currentObject = new fabric.Cross({
                        left: this.startPoint.x, // X-coordinate where the click occurred
                        top: this.startPoint.y, // Y-coordinate where the click occurred
                        fill: 'black', // Color of the cross
                        strokeWidth: this.scaledObjectSize / 8, // Thickness of the cross lines
                        width: this.scaledObjectSize, // Width of the cross
                        height: this.scaledObjectSize, // Height of the cross
                        angle: 45, // Rotate the cross 45 degrees
                        originX: 'center', // Set the horizontal origin of rotation and positioning to the center
                        originY: 'center', // Set the vertical origin of rotation and positioning to the center
                    });
                } else if (this.currentTool === 'goal-r') {
                    fabric.loadSVGFromString(goal_r, (objects, options) => {
                        this.currentObject = fabric.util.groupSVGElements(objects, options);
                        this.currentObject.set({
                            left: this.startPoint.x, // X-coordinate where the click occurred
                            top: this.startPoint.y, // Y-coordinate where the click occurred
                        })
                    });
                } else if (this.currentTool === 'goal-l') {
                    fabric.loadSVGFromString(goal_l, (objects, options) => {
                        this.currentObject = fabric.util.groupSVGElements(objects, options);
                        this.currentObject.set({
                            left: this.startPoint.x, // X-coordinate where the click occurred
                            top: this.startPoint.y, // Y-coordinate where the click occurred
                        })
                    });
                } else if (this.currentTool === 'minigoal-l') {
                    fabric.loadSVGFromString(minigoal_l, (objects, options) => {
                        this.currentObject = fabric.util.groupSVGElements(objects, options);
                        this.currentObject.set({
                            left: this.startPoint.x, // X-coordinate where the click occurred
                            top: this.startPoint.y, // Y-coordinate where the click occurred
                        })
                    });
                } else if (this.currentTool === 'minigoal-r') {
                    fabric.loadSVGFromString(minigoal_r, (objects, options) => {
                        this.currentObject = fabric.util.groupSVGElements(objects, options);
                        this.currentObject.set({
                            left: this.startPoint.x, // X-coordinate where the click occurred
                            top: this.startPoint.y, // Y-coordinate where the click occurred
                        })
                    });
                }

                if (this.currentObject) {
                    this.canvas.add(this.currentObject);
                }
            }
        },
        handleMouseMove(e) {
            if (this.isDrawing && ['pass', 'run', 'shoot', 'dribble', 'area'].includes(this.currentTool)) {
                const pointer = this.canvas.getPointer(e.e);
                if (!this.currentObject) {
                    if (this.currentTool === 'pass') {
                        this.currentObject = new fabric.PassLineArrow([this.startPoint.x, this.startPoint.y, pointer.x, pointer.y], {
                            strokeWidth: this.scaledObjectSize / 10,
                            fill: this.objectColor,
                            stroke: this.objectColor,
                            originX: 'center',
                            originY: 'center'
                        });
                    } else if (this.currentTool === 'run') {
                        this.currentObject = new fabric.DottedLineArrow([this.startPoint.x, this.startPoint.y, pointer.x, pointer.y], {
                            strokeWidth: this.scaledObjectSize / 10,
                            fill: this.objectColor,
                            stroke: this.objectColor,
                            originX: 'center',
                            originY: 'center'
                        });
                    } else if (this.currentTool === 'shoot') {
                        this.currentObject = new fabric.BoldLineArrow([this.startPoint.x, this.startPoint.y, pointer.x, pointer.y], {
                            strokeWidth: this.scaledObjectSize / 10,
                            fill: this.objectColor,
                            stroke: this.objectColor,
                            originX: 'center',
                            originY: 'center'
                        });
                    } else if (this.currentTool === 'dribble') {
                        this.currentObject = new fabric.WavyLineArrow([this.startPoint.x, this.startPoint.y, pointer.x, pointer.y], {
                            strokeWidth: this.scaledObjectSize / 10,
                            fill: this.objectColor,
                            stroke: this.objectColor,
                            originX: 'center',
                            originY: 'center'
                        });
                    } else if (this.currentTool === 'area') {
                        // Create preview striped box
                        const left = Math.min(this.startPoint.x, pointer.x);
                        const top = Math.min(this.startPoint.y, pointer.y);
                        const width = Math.abs(pointer.x - this.startPoint.x);
                        const height = Math.abs(pointer.y - this.startPoint.y);

                        this.currentObject = new fabric.StripedBox({
                            left: left,
                            top: top,
                            width: width,
                            height: height,
                            originX: 'left',
                            originY: 'top'
                        });
                    }
                    this.canvas.add(this.currentObject);
                } else {
                    if (this.currentTool === 'area') {
                        // Update striped box dimensions
                        const left = Math.min(this.startPoint.x, pointer.x);
                        const top = Math.min(this.startPoint.y, pointer.y);
                        const width = Math.abs(pointer.x - this.startPoint.x);
                        const height = Math.abs(pointer.y - this.startPoint.y);

                        this.currentObject.set({
                            left: left,
                            top: top,
                            width: width,
                            height: height
                        });
                    } else {
                        // For arrows
                        this.currentObject.set({x2: pointer.x, y2: pointer.y});
                    }
                }
                this.canvas.renderAll();
            }
        },
        handleMouseUp() {
            this.isDrawing = false;
            this.startPoint = null;
            this.currentObject = null;
        },
        handleObjectModified() {
            if (this.currentObject) {
                this.canvas.discardActiveObject();
                this.currentObject = null;
            }
        },
        handleKeyDown(e) {
            // Check if the backspace or delete key was pressed
            if (e.key === 'Backspace' || e.key === 'Delete') {
                // Prevent the default action to avoid navigating back in browser or other default actions
                e.preventDefault();

                const activeObject = this.canvas.getActiveObject();
                if (activeObject) {
                    // Remove the active object from the canvas
                    this.canvas.remove(activeObject);
                    this.canvas.requestRenderAll();
                }
            }
        },
        drawFootballField() {
            const fieldColor = 'white';
            const lineColor = 'black';
            const lineWidth = 2;

            // Field dimensions
            const canvasWidth = this.canvas.width;
            const canvasHeight = this.canvas.height;

            if (this.backgroundType === 'white') {
                // Just white background, no lines
                const outerRect = new fabric.Rect({
                    left: 0,
                    top: 0,
                    fill: fieldColor,
                    stroke: '',
                    strokeWidth: 0,
                    selectable: false,
                    evented: false,
                    width: canvasWidth,
                    height: canvasHeight
                });
                this.canvas.add(outerRect);
                this.canvas.sendToBack(outerRect);
                return;
            }

            // Outer boundaries
            const outerRect = new fabric.Rect({
                left: 0,
                top: 0,
                fill: fieldColor,
                stroke: lineColor,
                strokeWidth: lineWidth,
                selectable: false,
                evented: false,
                width: canvasWidth,
                height: canvasHeight
            });

            const elements = [outerRect];

            if (this.backgroundType === 'full-field') {
                // Full field with center circle, halfway line, and both goal areas

                // Center circle
                const centerCircle = new fabric.Circle({
                    left: canvasWidth / 2,
                    top: canvasHeight / 2,
                    radius: 50,
                    stroke: lineColor,
                    strokeWidth: lineWidth,
                    fill: '',
                    selectable: false,
                    evented: false,
                    originX: 'center',
                    originY: 'center'
                });

                // Halfway line
                const halfwayLine = new fabric.Line([canvasWidth / 2, 0, canvasWidth / 2, canvasHeight], {
                    stroke: lineColor,
                    strokeWidth: lineWidth,
                    selectable: false,
                    evented: false
                });

                // Left Goal Area
                const goalAreaLeft = new fabric.Rect({
                    left: 0,
                    top: (canvasHeight / 2) - 90,
                    fill: '',
                    stroke: lineColor,
                    strokeWidth: lineWidth,
                    selectable: false,
                    evented: false,
                    width: 60,
                    height: 180
                });

                // Right Goal Area
                const goalAreaRight = new fabric.Rect({
                    left: canvasWidth - 60,
                    top: (canvasHeight / 2) - 90,
                    fill: '',
                    stroke: lineColor,
                    strokeWidth: lineWidth,
                    selectable: false,
                    evented: false,
                    width: 60,
                    height: 180
                });

                elements.push(centerCircle, halfwayLine, goalAreaLeft, goalAreaRight);

            } else if (this.backgroundType === 'half-field') {
                // Half field focused on penalty area with proper soccer proportions
                // Standard penalty area: 40.3m x 16.5m, Goal area: 18.3m x 5.5m

                const fieldMargin = 40; // Margin around the penalty area
                const fieldWidth = canvasWidth - (fieldMargin * 2);
                const fieldHeight = canvasHeight - (fieldMargin * 2);

                // Field boundaries
                outerRect.set({
                    left: fieldMargin,
                    top: fieldMargin,
                    width: fieldWidth,
                    height: fieldHeight
                });

                // Penalty area (16-meter box) - main focus
                // Takes up most of the field height, proportional width
                const penaltyAreaWidth = fieldWidth * 0.55; // 55% of field width
                const penaltyAreaHeight = fieldHeight * 0.65; // 65% of field height
                const penaltyAreaLeft = fieldMargin + (fieldWidth - penaltyAreaWidth) / 2;
                const penaltyAreaTop = fieldMargin;

                const penaltyArea = new fabric.Rect({
                    left: penaltyAreaLeft,
                    top: penaltyAreaTop,
                    fill: '',
                    stroke: lineColor,
                    strokeWidth: lineWidth,
                    selectable: false,
                    evented: false,
                    width: penaltyAreaWidth,
                    height: penaltyAreaHeight
                });

                // Goal area (6-yard box) inside penalty area
                const goalAreaWidth = penaltyAreaWidth * 0.45; // 45% of penalty area width
                const goalAreaHeight = penaltyAreaHeight * 0.35; // 35% of penalty area height
                const goalAreaLeft = penaltyAreaLeft + (penaltyAreaWidth - goalAreaWidth) / 2;
                const goalAreaTop = penaltyAreaTop;

                const goalArea = new fabric.Rect({
                    left: goalAreaLeft,
                    top: goalAreaTop,
                    fill: '',
                    stroke: lineColor,
                    strokeWidth: lineWidth,
                    selectable: false,
                    evented: false,
                    width: goalAreaWidth,
                    height: goalAreaHeight
                });

                // Goal line (top edge where goal would be)
                const goalLine = new fabric.Line([
                    goalAreaLeft + goalAreaWidth * 0.25,
                    penaltyAreaTop,
                    goalAreaLeft + goalAreaWidth * 0.75,
                    penaltyAreaTop
                ], {
                    stroke: lineColor,
                    strokeWidth: lineWidth * 2, // Thicker for goal line
                    selectable: false,
                    evented: false
                });

                // Penalty spot
                const penaltySpotX = penaltyAreaLeft + penaltyAreaWidth / 2;
                const penaltySpotY = penaltyAreaTop + penaltyAreaHeight * 0.73; // 73% down the penalty area

                const penaltySpot = new fabric.Circle({
                    left: penaltySpotX,
                    top: penaltySpotY,
                    radius: 3,
                    fill: lineColor,
                    selectable: false,
                    evented: false,
                    originX: 'center',
                    originY: 'center'
                });

                // Penalty arc (partial circle at bottom of penalty area)
                const penaltyArc = new fabric.Circle({
                    left: penaltySpotX,
                    top: penaltySpotY,
                    radius: 35, // 9.15m arc radius scaled
                    stroke: lineColor,
                    strokeWidth: lineWidth,
                    fill: '',
                    selectable: false,
                    evented: false,
                    originX: 'center',
                    originY: 'center',
                    startAngle: Math.PI * 0.75, // 135 degrees
                    endAngle: Math.PI * 0.25   // 45 degrees
                });

                // Halfway line at bottom
                const halfwayLine = new fabric.Line([
                    fieldMargin,
                    fieldMargin + fieldHeight,
                    fieldMargin + fieldWidth,
                    fieldMargin + fieldHeight
                ], {
                    stroke: lineColor,
                    strokeWidth: lineWidth,
                    selectable: false,
                    evented: false
                });

                // Center circle (partial, showing only the part that would be visible)
                const centerCircle = new fabric.Circle({
                    left: canvasWidth / 2,
                    top: fieldMargin + fieldHeight,
                    radius: 35,
                    stroke: lineColor,
                    strokeWidth: lineWidth,
                    fill: '',
                    selectable: false,
                    evented: false,
                    originX: 'center',
                    originY: 'center'
                });

                elements.push(penaltyArea, goalArea, goalLine, penaltySpot, penaltyArc, halfwayLine, centerCircle);
            }

            // Add all field elements to the canvas
            this.canvas.add(...elements);
            this.canvas.sendToBack(outerRect); // Ensure the field is in the background
        },
    }
};
</script>
