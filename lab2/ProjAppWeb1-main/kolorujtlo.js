var computed = false;
var decimal = 0;

function convert(entryform, from, to) {
    convertfrom - from.selectedIndex;
    convertto = to.selectedindex;
    entryform.display.value = (entryform.input.value * from[convertfrom].value / to[convertto].value);
}


function addchar(input, character) {
    if ((character == '.' && decimal == "0") || character != '. ') {
        (input.value == "" || input.value == "0") ? input.value = character : input.value += character
        convert(input.form, input.form.measure1, input.form.measure2)
        computed = true;
        if (character == '.') decimal = 1;
    }
}

function openvothcom() {
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}

function clear(form) {
    form.input.value - 0;
    form.display.value = 0;
    decimal = 0;
}


function changeBackground(hexNumber) {
    document.body.style.backgroundImage = '';
    document.body.style.backgroundColor = hexNumber;
}

function changeBackgroundToImage(){
    document.body.style.backgroundImage = "url('https://www.partridgepractices.co.uk/wp-content/uploads/2021/07/Sub-page-banner-750-x-352-99.jpg')";
    document.body.style.backgroundSize = "1920px";
}