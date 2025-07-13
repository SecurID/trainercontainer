import { fabric } from "fabric/dist/fabric";

// Bold line arrow for shooting
fabric.BoldLineArrow = fabric.util.createClass(fabric.Line, {
    type: 'boldLineArrow',

    initialize: function(element, options) {
        options || (options = {});
        // Make the stroke width 3x thicker for bold effect
        options.strokeWidth = (options.strokeWidth || 2) * 3;
        this.callSuper('initialize', element, options);
    },

    toObject: function() {
        return fabric.util.object.extend(this.callSuper('toObject'));
    },

    _render: function(ctx) {
        this.callSuper('_render', ctx);

        // do not render if width/height are zeros or object is not visible
        if (this.width === 0 || this.height === 0 || !this.visible) return;

        ctx.save();

        var xDiff = this.x2 - this.x1;
        var yDiff = this.y2 - this.y1;
        var angle = Math.atan2(yDiff, xDiff);

        ctx.translate((this.x2 - this.x1) / 2, (this.y2 - this.y1) / 2);
        ctx.rotate(angle);

        // Arrow size relative to stroke width (larger for bold arrow)
        const arrowWidth = this.strokeWidth * 2;
        const arrowLength = this.strokeWidth * 2;

        // Draw arrowhead
        ctx.beginPath();
        ctx.moveTo(10, 0);
        ctx.lineTo(-arrowLength, arrowWidth / 2);
        ctx.lineTo(-arrowLength, -arrowWidth / 2);
        ctx.closePath();

        ctx.fillStyle = this.stroke;
        ctx.fill();

        ctx.restore();
    }
});

fabric.BoldLineArrow.fromObject = function(object, callback) {
    callback && callback(new fabric.BoldLineArrow([object.x1, object.y1, object.x2, object.y2], object));
};

fabric.BoldLineArrow.async = true;