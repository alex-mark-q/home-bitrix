console.log("include begin date work");

BX.ready(function() {

    BX.addCustomEvent('Kanban.Grid:onRender', function(grid) {

        const column = grid.getColumn('CONVERTED');
        if (column && column.layout.items) {
            BX.style(column.layout.items, 'border', '2px solid red');
        }
        
    });

})