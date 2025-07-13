import { fabric } from "fabric/dist/fabric";

fabric.Cross = fabric.util.createClass(fabric.Object, {
    type: 'cross',

    // Default properties
    initialize: function(options) {
        options || (options = {});
        this.callSuper('initialize', options);

        // Set the origin of rotation and scaling to the center of the cross
        this.originX = 'center';
        this.originY = 'center';

        this.width = options.width;
        this.height = options.height;
        this.fill = 'black'; // Default fill color
    },

    toObject: function() {
        return fabric.util.object.extend(this.callSuper('toObject'), {
            width: this.width,
            height: this.height,
            fill: this.fill,
        });
    },

    _render: function(ctx) {
        // Ensure transformations (scale, rotate, etc.) are applied
        this.callSuper('_render', ctx);

        // Cross dimensions relative to strokeWidth
        const crossThickness = this.strokeWidth || 1;
        const halfWidth = this.width / 2;
        const halfHeight = this.height / 2;

        ctx.fillStyle = this.fill;
        ctx.strokeStyle = this.stroke;
        ctx.lineWidth = crossThickness;

        // Draw the vertical part of the cross
        ctx.beginPath();
        ctx.moveTo(-halfWidth, 0);
        ctx.lineTo(halfWidth, 0);

        // Draw the horizontal part of the cross
        ctx.moveTo(0, -halfHeight);
        ctx.lineTo(0, halfHeight);
        ctx.stroke();
    },
});