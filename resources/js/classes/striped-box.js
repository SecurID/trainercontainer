import { fabric } from "fabric/dist/fabric";

// Striped box for marking areas
fabric.StripedBox = fabric.util.createClass(fabric.Rect, {
    type: 'stripedBox',

    initialize: function(options) {
        options || (options = {});
        // Set default properties for striped box
        options.fill = 'transparent';
        options.stroke = '#666';
        options.strokeWidth = 2;
        options.strokeDashArray = [5, 5];
        this.callSuper('initialize', options);
    },

    toObject: function() {
        return fabric.util.object.extend(this.callSuper('toObject'));
    },

    _render: function(ctx) {
        // Render only the base rectangle with dashed border
        this.callSuper('_render', ctx);
    },

    containsPoint: function(point, lines, absolute, calculate) {
        // Only respond to clicks on the border, not the interior
        var coords = this._getCoords(absolute, calculate);
        var halfWidth = this.width / 2;
        var halfHeight = this.height / 2;
        var borderThickness = Math.max(this.strokeWidth || 2, 10); // Minimum 10px for easier clicking
        
        // Transform point to object coordinate system
        var localPoint = fabric.util.transformPoint(point, fabric.util.invertTransform(this.calcTransformMatrix()));
        
        var x = localPoint.x;
        var y = localPoint.y;
        
        // Check if point is within the outer bounds
        var withinOuter = (x >= -halfWidth && x <= halfWidth && y >= -halfHeight && y <= halfHeight);
        
        if (!withinOuter) {
            return false;
        }
        
        // Check if point is within the inner bounds (excluding border)
        var innerLeft = -halfWidth + borderThickness;
        var innerRight = halfWidth - borderThickness;
        var innerTop = -halfHeight + borderThickness;
        var innerBottom = halfHeight - borderThickness;
        
        var withinInner = (x >= innerLeft && x <= innerRight && y >= innerTop && y <= innerBottom);
        
        // Only return true if within outer bounds but NOT within inner bounds (i.e., on the border)
        return withinOuter && !withinInner;
    }
});

fabric.StripedBox.fromObject = function(object, callback) {
    callback && callback(new fabric.StripedBox(object));
};

fabric.StripedBox.async = true;