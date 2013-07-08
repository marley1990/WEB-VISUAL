function retriveJsonDocument() {
    clearDivResult();
    $(function () {
        var value = document.getElementById('inputModelId').value;
        var query = {
                id:"modello".concat(value)
        }
        $.ajax({ 
            url:'https://api.mongohq.com/databases/testMarco/collections/documents/documents',
            type: 'get',
            data:{
                  _apikey:"bb65hmp1vtvu49shsqjf",
                  q:JSON.stringify(query)
            },
            dataType: 'json',
            success: function (data) {
                data = data[0]
                //if the document doesn't exist launch an alert
                if (typeof (data) === "undefined") {
                    alert("doesn't exist a model with id : " + value)
                } else {

                    //Retrive clusters_tree 
                    var clustersTree = data["clusters_tree"];
                    var type = data["type"];
                    var description = data["description"];
                    var id = data["id"];
                    var name = data["name"];

                    //Print tree
                    createTree(clustersTree, type, description, id, name);
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('error', errorThrown);
            }
        });
    }); 
}

function clearDivResult() {
    var divResult = document.getElementById("printResult");
    var svg = document.getElementsByTagName("svg")[0];
    if(svg==null)
        return false;
    else{
    divResult.removeChild(svg);
    }
}
