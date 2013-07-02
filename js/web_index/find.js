function retriveJsonDocument() {
    var clusterstree2javascript = [1, 2, 3,[4,5,6,7,8,9,10,11,12,13,14,15,16,17]]
    createTree(clusterstree2javascript,"modello","prototipo","modello1","modello text");

    //preview("1");

    //$(function () {
    //    var value = document.getElementById('inputModelId').value;
        //alert("VALUE=== "+ value);
    //    $.ajax({
    //        url: 'http://localhost:28017/ilariodb/documents/?filter_type=' + value,
    //        type: 'get',
    //        dataType: 'jsonp',
    //        jsonp: 'jsonp', // mongod is expecting the parameter name to be called "jsonp"
    //        success: function (data) {

    //            //if the document doesn't exist launch an alert
    //            if (typeof (data["rows"][0]) === "undefined") {
    //                alert("Attenzione non esiste un modello con id " + value)
    //            } else {
                   
    //                //Retrive clusters_tree 
    //                var clustersTree = data["rows"][0]["clusters_tree"];
    //                var type = data["rows"][0]["type"];
    //                var description = data["rows"][0]["description"];
    //                var id = data["rows"][0]["id"];
    //                var name = data["rows"][0]["name"];
                    

    //                //Transform the object in a javascript object
    //                var clusterstree2javascript = $.parseJSON(clustersTree);
    //               // //var description2javascript = $.parseJSON(description);
    //               //// alert("description2javascript " + description2javascript);
    //               // var type2javascript = $.parseJSON(type);
    //               // alert("type2javascript" + type2javascript);
    //               // var id2javascript = $.parseJSON(id);
    //               // alert("id2javascript " + id2javascript);
    //               // var name2javascript = $.parseJSON(name);

    //                //Print tree
    //                createTree(clusterstree2javascript, type, description, id, name);
    //            }
    //        },
    //        error: function (XMLHttpRequest, textStatus, errorThrown) {
    //            console.log('error', errorThrown);
    //        }
    //    });
    //});
    
}


function search() {
    $(function () {
        var value = document.getElementById('inputModelId').value;
    alert("VALUE=== "+ value);
        $.ajax({
            url: 'http://localhost:28017/ilariodb/documents/?filter_type=' + value,
            type: 'get',
            dataType: 'jsonp',
            jsonp: 'jsonp', // mongod is expecting the parameter name to be called "jsonp"
            success: function (data) {

                //if the document doesn't exist launch an alert
                if (typeof (data["rows"][0]) === "undefined") {
                    alert("Attenzione non esiste un modello con id " + value)
                } else {

                    //Retrive clusters_tree 
                    var clustersTree = data["rows"][0]["clusters_tree"];
                    var type = data["rows"][0]["type"];
                    var description = data["rows"][0]["description"];
                    var id = data["rows"][0]["id"];
                    var name = data["rows"][0]["name"];


                    //Transform the object in a javascript object
                    var clusterstree2javascript = $.parseJSON(clustersTree);
                   // //var description2javascript = $.parseJSON(description);
                   //// alert("description2javascript " + description2javascript);
                   // var type2javascript = $.parseJSON(type);
                   // alert("type2javascript" + type2javascript);
                   // var id2javascript = $.parseJSON(id);
                   // alert("id2javascript " + id2javascript);
                   // var name2javascript = $.parseJSON(name);

                    //Print tree
                    createTree(clusterstree2javascript, type, description, id, name);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('error', errorThrown);
            }
        });
    });


}