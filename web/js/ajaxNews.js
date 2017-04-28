$(document).ready(function () {
    $("#entities-grid").ajaxgrid({
        dataUrl: "http://127.0.0.1:8000/ajax/news",
        editUrl: "http://127.0.0.1:8000/news/edit/",
        sortableColumns: ["id", "name", "description", "createdAt", "user",
            "numberOfViews"],
        filterableColumns: ["id", "name", "description", "createdAt", "user",
            "numberOfViews"],
        rowsPerPage: 5,
        key: 'news'
    });
});