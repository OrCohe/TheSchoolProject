
function delAlert(id, kind) {
    if (confirm("Are you sure to Delete??")) {
        window.location.href = "http://localhost/orcohen/theschool/index.php?delete=" + id + "&kind=" + kind;
    }
}


