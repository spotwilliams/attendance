function datatableColumnHeaderValue(myParent, dataTable, dataIndex) {
    if (!myParent.is('td')) {
        var tdActual = myParent.parents('td')[0];
    } else {
        var tdActual = myParent;//.parents('td')[0];
    }
    var idx = dataTable.cell(tdActual).index().column;
    var header = dataTable.column(idx).header();
    if (dataIndex === undefined) {
        dataIndex = 'cat';
    }
    return $(header).data(dataIndex);

}
function datatableCellValue(myParent, dataTable) {

    var trActual = myParent.parents('tr')[0];
    var dataRow = dataTable.row(trActual);
    // console.log(dataRow.data());
    return dataRow.data();
}