console.log("include begin date work");

BX.ready(function() {

    BX.addCustomEvent('Kanban.Column:onAddedToGrid', function(column) {
        // const layout = column.getLayout();
        
        if (column.id === "CONVERTED") {
            
            let methods = [];
            let obj = column;
            
            // Проходим по всей цепочке прототипов, чтобы собрать методы
            while (obj) {
                methods = methods.concat(Object.getOwnPropertyNames(obj).filter(item => typeof obj[item] === 'function'));
                obj = Object.getPrototypeOf(obj);
            }
            
            console.log("Доступные методы объекта onAddedToGrid:", [...new Set(methods)].sort());

            const columnNode = column.layout?.container;
            
            const columnContainer = column.getContainer();
            console.log("is method", columnContainer);

            if (columnContainer) {
                // 1. Добавляем рамку самой колонке
                BX.style(columnNode, 'border', '2px solid #f0008c');
                BX.style(columnNode, 'borderRadius', '12px');
                BX.style(columnNode, 'transition', 'all 0.3s ease'); // Плавное появление

            
            }

            // setTimeout(() => {
            //     console.log("Layout snapshot:", column.layout?.container );
            //     const columnNode = column.layout?.container;
            //     if (columnNode) {
            //         BX.addClass(columnNode, 'my-highlight-class');
            //     }
            // }, 10);


        }

        
    });

    // BX.addCustomEvent('Kanban.Column:onAddedToGrid', function(column) {
    //     // Вызываем метод-геттер
    //     const layout = column.getLayout(); 
        
    //     if (layout && layout.container) {
    //         // Теперь работаем с container без setTimeout
    //         BX.style(layout.container, 'border', '2px solid #f0008c');
            
    //         // Также можно сразу подкрасить заголовок
    //         if (layout.title) {
    //             BX.style(layout.title, 'color', '#f0008c');
    //         }
    //     }
    // });


    BX.addCustomEvent('Kanban.Grid:onRender', function(grid) {

        let methods = [];
        let obj = grid;
        
        // Проходим по всей цепочке прототипов, чтобы собрать методы
        while (obj) {
            methods = methods.concat(Object.getOwnPropertyNames(obj).filter(item => typeof obj[item] === 'function'));
            obj = Object.getPrototypeOf(obj);
        }
        
        console.log("Доступные методы объекта onRender:", [...new Set(methods)].sort());

        // В этот момент ВСЕ колонки уже точно в DOM
        console.log('Kanban.Grid:onRender', grid, grid.getColumnTitle);
        const column = grid.getColumn('CONVERTED'); // Получаем нужную колонку по ID
        const columnContainer = grid.getGridContainer();
        console.log("onRender columnContainer", columnContainer, column.layout.items);
        if (column && column.layout.items) {
            BX.style(column.layout.items, 'border', '2px solid red');
        }
    });
})