$(document).ready(function () {
    $("#entities-grid").ajaxgrid({
        dataUrl: "http://127.0.0.1:8000/ajax/user",
        editUrl: "http://127.0.0.1:8000/user/edit/",
        sortableColumns: ["id", "email", "name", "enabled", "dispatch",
            "roles"],
        filterableColumns: ["id", "email", "name", "enabled", "dispatch",
            "roles"],
        rowsPerPage: 5,
        key: 'user'
    });
});