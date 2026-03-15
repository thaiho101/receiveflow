var orderContentTable = document.getElementById('order-content-table');
var submitButton = document.getElementById('note-submit-button');
var submitButtonDemo = document.getElementById('note-submit-button-demo');

var height = orderContentTable.offsetHeight;

if (submitButton) {
    submitButton.style.top = height + 430 + 'px';
}

if (submitButtonDemo) {
    submitButtonDemo.style.top = height + 430 + 'px';
}

