$(document).ready(function () {
    $("#entities-grid").ajaxgrid({
        dataUrl: "http://127.0.0.1:8000/ajax/category",
        editUrl: "http://127.0.0.1:8000/category/edit/",
        sortableColumns: ["id", "name", "parentCategory"],
        filterableColumns: ["id", "name", "parentCategory"],
        rowsPerPage: 5,
        key: 'category'
    });
});