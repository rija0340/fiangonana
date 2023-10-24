// document.getElementById("btnPrint").addEventListener('click', function () {

//     /* find the table element in the page */
// var tbl = document.getElementById('structure');
// /* create a workbook */
// var wb = XLSX.utils.table_to_book(tbl);
// /* export to file */
// XLSX.writeFile(wb, "SheetJSTable.xlsx");

// });



// document.getElementById("btnPrint").addEventListener('click', function () {
//     /* Find the table element in the page */
//     var tbl = document.querySelector('#structure');
    
//     // Create a new worksheet
//     var ws = XLSX.utils.aoa_to_sheet([]);

//     // Loop through the rows of the table
//     var rows = tbl.querySelectorAll('tr');

//     console.log("rows");
//     console.log(rows);

//     rows.forEach(function(row, rowIndex) {
//         var cols = row.querySelectorAll('td');
//         var rowData = [];
        
//         // Loop through the cells in each row
//         cols.forEach(function(col, colIndex) {
//             var inputElement = col.querySelector('input');
//             if (inputElement) {
//                 // Get the value of the input element
//                 rowData.push(inputElement.value);
//             } else {
//                 // If there's no input element, push an empty string
//                 rowData.push('');
//             }
//         });
        
//         // Add the row data to the worksheet
//         XLSX.utils.sheet_add_aoa(ws, [rowData], {origin: -1}); // -1 means append to the end
//     });

//     // Create a workbook and add the worksheet
//     var wb = XLSX.utils.book_new();
//     XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

//     // Export to file
//     XLSX.writeFile(wb, "SheetJSTable.xlsx");
// });

// document.getElementById("btnPrint").addEventListener('click', function () {
//     /* Find the table element in the page */
//     var tbl = document.getElementById('structure');
    
//     // Create a new worksheet
//     var ws = XLSX.utils.aoa_to_sheet([]);

//     // Add the header row (if present in your table)
//     var headerRow = tbl.querySelector('tr');
//     if (headerRow) {
//         var headerCols = headerRow.querySelectorAll('td, th');
//         var headerData = [];
//         headerCols.forEach(function(col) {
//             headerData.push(col.textContent.trim()); // Get the text content of the cell
//         });
//         XLSX.utils.sheet_add_aoa(ws, [headerData], {origin: -1}); // -1 means append to the end
//     }

//     // Loop through the rows of the table
//     var rows = tbl.querySelectorAll('tr');
//     rows.forEach(function(row) {
//         var cols = row.querySelectorAll('td');
//         var rowData = [];
        
//         // Loop through the cells in each row
//         cols.forEach(function(col) {
//             var inputElement = col.querySelector('input');
//             if (inputElement) {
//                 // Get the value of the input element
//                 rowData.push(inputElement.value);
//             } else {
//                 // If there's no input element, push an empty string
//                 rowData.push('');
//             }
//         });
        
//         // Add the row data to the worksheet
//         XLSX.utils.sheet_add_aoa(ws, [rowData], {origin: -1}); // -1 means append to the end
//     });

//     // Create a workbook and add the worksheet
//     var wb = XLSX.utils.book_new();
//     XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

//     // Export to file
//     XLSX.writeFile(wb, "SheetJSTable.xlsx");
// });


document.getElementById("btnPrint").addEventListener('click', function () {
    /* Find the table element in the page */
    var tbl = document.getElementById('structure');
    
    // Create a new worksheet
    var ws = XLSX.utils.aoa_to_sheet([]);

    // Add the header row (if present in your table)
    var headerRow = tbl.querySelector('tr');
    if (headerRow) {
        var headerCols = headerRow.querySelectorAll('td, th');
        var headerData = [];
        headerCols.forEach(function(col) {
            headerData.push(col.textContent.trim()); // Get the text content of the cell
        });
        XLSX.utils.sheet_add_aoa(ws, [headerData], {origin: -1}); // -1 means append to the end
    }

    // Loop through the rows of the table
    var rows = tbl.querySelectorAll('tr');
    rows.forEach(function(row) {
        var cols = row.querySelectorAll('td');
        var rowData = [];
        
        // Loop through the cells in each row
        cols.forEach(function(col) {
            var inputElement = col.querySelector('input');
            if (inputElement) {
                // Get the value of the input element
                rowData.push(inputElement.value);
            } else {
                // Check if the cell contains plain text
                rowData.push(col.textContent.trim()); // Get the text content of the cell
            }
        });
        
        // Add the row data to the worksheet
        XLSX.utils.sheet_add_aoa(ws, [rowData], {origin: -1}); // -1 means append to the end
    });

    // Create a workbook and add the worksheet
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

    // Export to file
    XLSX.writeFile(wb, "SheetJSTable.xlsx");
});
