import { fabric } from "fabric/dist/fabric";

// Wavy line arrow for dribbling
fabric.WavyLineArrow = fabric.util.createClass(fabric.Line, {
    type: 'wavyLineArrow',

    initialize: function(element, options) {
        options || (options = {});
        this.callSuper('initialize', element, options);
    },

    toObject: function() {
        return fabric.util.object.extend(this.callSuper('toObject'));
    },

    _render: function(ctx) {
        // do not render if width/height are zeros or object is not visible
        if (this.width === 0 || this.height === 0 || !this.visible) return;

        ctx.save();
        
        // Calculate line properties
        var xDiff = this.x2 - this.x1;
        var yDiff = this.y2 - this.y1;
        var length = Math.sqrt(xDiff * xDiff + yDiff * yDiff);
        var angle = Math.atan2(yDiff, xDiff);

        if (length === 0) {
            ctx.restore();
            return;
        }

        // Transform to line coordinate system (same as PassLineArrow)
        ctx.translate((this.x2 - this.x1) / 2, (this.y2 - this.y1) / 2);
        ctx.rotate(angle);
        
        // Draw wavy line instead of straight line
        ctx.strokeStyle = this.stroke;
        ctx.lineWidth = this.strokeWidth;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.beginPath();
        
        const amplitude = 5; // Wave height
        const frequency = 15; // Number of waves along the line
        const segments = Math.max(Math.floor(length / 2), 20); // More segments for smoother waves
        
        // Start at beginning of line
        ctx.moveTo(-length / 2, 0);
        
        // Create wavy path
        for (let i = 1; i <= segments; i++) {
            const progress = i / segments;
            const x = (-length / 2) + progress * length;
            const y = Math.sin(progress * frequency) * amplitude;
            ctx.lineTo(x, y);
        }
        
        ctx.stroke();

        // Draw arrowhead at the end (same as PassLineArrow)
        const arrowWidth = this.strokeWidth * 4;
        const arrowLength = this.strokeWidth * 4;

        ctx.beginPath();
        ctx.moveTo(10, 0); // Start at the end of the line (same as PassLineArrow)
        ctx.lineTo(-arrowLength, arrowWidth / 2);
        ctx.lineTo(-arrowLength, -arrowWidth / 2);
        ctx.closePath();

        ctx.fillStyle = this.stroke;
        ctx.fill();

        ctx.restore();
    }
});

fabric.WavyLineArrow.fromObject = function(object, callback) {
    callback && callback(new fabric.WavyLineArrow([object.x1, object.y1, object.x2, object.y2], object));
};

fabric.WavyLineArrow.async = true;