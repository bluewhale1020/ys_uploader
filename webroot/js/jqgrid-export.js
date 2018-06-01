/*!
 * createGridPostData
 * (c) 2018 yasuno
 */


function createGridPostData(gridID, ShowLabel){
    var grid = $('#' + gridID);
    var rowIDList = grid.getDataIDs();
    var row = grid.getRowData(rowIDList[0]); 

    var colNames = [];
    var rowData = [];
    var i = 0;
    var stpt = 0;

    for(var cName in row) {
        colNames[i++] = cName; // Capture Column Names
    }

    if (ShowLabel) {
    	var headerLabels = grid.jqGrid("getGridParam", "colNames");  
    	
		if(headerLabels[0].indexOf("checkbox") > -1){//チェックボックス列は削除
		  // 部分一致のときの処理
		  headerLabels.shift();
		}
    	  	
    	rowData[0] = headerLabels;
    	stpt = 1;
    }
    for(var j=stpt;j-stpt<rowIDList.length;j++) {
        row = grid.getRowData(rowIDList[j-stpt]); // Get Each Row
        oneRow = [];
        for(var i = 0 ; i<colNames.length ; i++ ) {
            oneRow[i] ="\"" +  row[colNames[i]] + "\""; // Create a CSV delimited with ;
        }
        rowData[j] = oneRow; // Create a row of rowData

    }	
	return rowData;

}

function jqueryPost(action, method, input) {
    "use strict";
    var form;
    form = $('<form />', {
        action: action,
        method: method,
        style: 'display: none;'
    });
    if (typeof input !== 'undefined') {

        $.each(input, function (name, value) {

            if( typeof value === 'object' ) {

                $.each(value, function(objName, objValue) { 

                    $('<input />', {
                        type: 'hidden',
                        name: name + '[]',
                        value: objValue
                    }).appendTo(form);
                } );      
            }
            else {

                $('<input />', {
                    type: 'hidden',
                    name: name,
                    value: value
                }).appendTo(form);
            }
        });
    }
    form.appendTo('body').submit();
}
