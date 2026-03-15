document.addEventListener("DOMContentLoaded", function () {
    noteContent = document.getElementById('order-note');
    noteContentMoveTo = document.getElementById('note-side');

    noteContentMoveTo.appendChild(noteContent);




    const noteBox = document.getElementById('order-note-input');
    
    function autoResize(element) {
        element.style.height = 'auto';
        element.style.height = element.scrollHeight + 20 + 'px';
    }

    if (noteBox) {
        autoResize(noteBox);
        noteBox.addEventListener('input', function () {
            autoResize(noteBox);
        });
    }
});