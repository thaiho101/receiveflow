<?php 
if ($sessionStatus == 'OPEN') {
    $submit_addnote_button = "Submit";
    $hiddenClass = "";
} else if ($sessionStatus == 'CLOSE') {
    $submit_addnote_button = "Update Note";
    $hiddenClass = "";
} else {
    $submit_addnote_button = "";
    $hiddenClass = "hidden";
}
?>