function matchCustom(params, data) {
    // If there are no search terms, return all of the data
    if ($.trim(params.term) === '') {
        return data;
    }

    // Do not display the item if there is no 'text' property
    if (typeof data.text === 'undefined') {
        return null;
    }

    // `params.term` should be the term that is used for searching
    // `data.text` is the text that is displayed for the data object
    if (data.text.indexOf(params.term) > -1) {
        var modifiedData = $.extend({}, data, true);
        modifiedData.text += ' (matched)';

        // You can return modified objects from here
        // This includes matching the `children` how you want in nested data sets
        return modifiedData;
    }

    // Return `null` if the term should not be displayed
    return null;
}

// selects = document.querySelectorAll('.js-source-states');

// console.log($(".presides"));
// for (let index = 0; index < selects.length; index++) {
//     classes = selects[index].getAttribute('class').split(" ")

// }
// var datas = [
//     "ato", "anarako", "no ilaina"
// ]


var currentYear = new Date();
currentYear = currentYear.getFullYear();
var sabbatsAnnuel = [];


for (let month = 0; month < 12; month++) {
    for (let day = 0; day < 31; day++) {
        date = new Date(currentYear, month, day);
        if (date.getDay() == 6) {
            sabbatsAnnuel.push(date);
        }
    }
}

for (let i = 0; i < sabbatsAnnuel.length; i++) {
    // ajouter un zero si date format est un seul caractere
    day = sabbatsAnnuel[i].getDate();
    if (day < 10) {
        day = "0" + day;
    }
    month = sabbatsAnnuel[i].getMonth();
    month = month + 1;
    if (month < 10) {
        month = "0" + month;
    }

    sabbatDate = day + "-" + month + "-" + sabbatsAnnuel[i].getFullYear();
    console.log(sabbatDate);
    $("#" + sabbatDate + "_presides").select2({
        dropdownAutoWidth: true,
        width: "200px"
    });

    $("#" + sabbatDate + "_dimyMinitra").select2({
        dropdownAutoWidth: true,
        width: "200px"
    });

    $("#" + sabbatDate + "_tmt").select2({
        dropdownAutoWidth: true,
        width: "200px"
    });

    $("#" + sabbatDate + "_lesona").select2({
        dropdownAutoWidth: true,
        width: "200px"
    });

    $("#" + sabbatDate + "_mpitoryTeny").select2({
        dropdownAutoWidth: true,
        width: "200px"
    });

    $("#" + sabbatDate + "_presidesHariva").select2({
        dropdownAutoWidth: true,
        width: "200px"
    });

}



