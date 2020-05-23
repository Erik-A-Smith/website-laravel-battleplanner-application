/**************************
	Extention class type
**************************/
const Tool = require('./Tool.js').default;

class ToolIcon extends Tool {

    /**************************
            Constructor
    **************************/

    constructor(app) {
        // Super Class constructor call
        super(app);
        this.Icon = require('./Icon.js').default;
        this.size = 100;
    }

    actionDrop(coordinates,src) {
        if(src){

            var icon = new this.Icon(
                null,
                this.AddOffsetCoordinates(coordinates),
                this.size,
                src
            );

            this.app.battleplan.floor.AddDraw(icon);

            this.app.canvas.Update();
        }
    }
    
    AddOffsetCoordinates(coor){
        return {
            "x" : (coor.x) / this.app.canvas.scale - this.app.canvas.offset.x,
            "y" : (coor.y) / this.app.canvas.scale - this.app.canvas.offset.y
        }
    }
    
}
export {
    ToolIcon as
    default
}