import './bootstrap.js';
import 'flowbite';
import { createApp } from 'vue';
import Canvas from "./components/Canvas.vue";
import Toolbar from "./components/Toolbar.vue";
import ToolbarItem from "./components/ToolbarItem.vue";

// Only mount Vue app if the canvas container exists (on soccerdraw page)
const canvasContainer = document.getElementById('vue-canvas-app');
if (canvasContainer) {
    // Create Vue app with a root component that can render the Canvas
    const app = createApp({
        template: '<Canvas></Canvas>',
        components: {
            Canvas,
            Toolbar,
            ToolbarItem
        }
    });

    app.mount('#vue-canvas-app');
}
