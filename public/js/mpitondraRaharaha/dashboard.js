// Get the table and ul elements by their IDs
const nameTable = document.getElementById('structure');
const nameList = document.getElementById('nameList');

// Function to extract and count unique names
function displayUniqueNames() {
    const names = {};

    // Loop through each row in the table body
    const rows = nameTable.tBodies[0].rows;
    for (let i = 0; i < rows.length; i++) {
        // Find all td elements in the current row
        const tds = rows[i].querySelectorAll('td');

        // Loop through each td element to find input elements
        for (let j = 0; j < tds.length; j++) {
            const nameInput = tds[j].querySelector('input');

            var idInput = $(nameInput).attr('id');
            var idMambra = $('input[name="' + idInput + '"]').val();


            console.log("idMambra");
            console.log(idMambra);
            console.log("idInput");
            console.log(idInput);

            // If we found a valid input element
            if (nameInput) {
                const name = nameInput.value;

                // Check if the name is already in the names object
                if (name !== "") {

                    if (names[name]) {
                        names[name]++;
                    } else {
                        names[name] = 1;
                    }
                }
            }
        }
    }

    // Clear the existing list
    nameList.innerHTML = '';

    // Loop through the names and add them to the ul as list items
    for (let name in names) {
        const listItem = document.createElement('li');
        listItem.textContent = `${name} (Count: ${names[name]})`;
        nameList.appendChild(listItem);
    }
}

// Call the function to initially populate the list
displayUniqueNames();


$('.sheet-input').change(function () {

    $("#nameList").empty();

    displayUniqueNames();

});

$.ajax({
    type: 'GET',
    url: '/famille-mambra/data',
    success: function (data) {
        console.log("data.kilasy");
        console.log(data.kilasy);
    },
    error: function (erreur) {
        // alert('La requête n\'a pas abouti' + erreur);
        console.log(erreur.responseText);
    }

});
