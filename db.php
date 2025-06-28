<?php
function createCon() {
    return mysqli_connect("localhost", "root", "", "testdb");
}

function closeCon($conn) {
    mysqli_close($conn);
}
?>