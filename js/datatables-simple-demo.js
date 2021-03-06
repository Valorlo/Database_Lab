window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple,{
            columns: [
                {select:0, sortable: false}
            ]
        });
    }

    const bookRecord = document.getElementById('borrowRecord');
    if (bookRecord) {
        new simpleDatatables.DataTable(bookRecord,{
            sortable: false
        });
    }
});
