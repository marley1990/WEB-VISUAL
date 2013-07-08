function allModel() {
    clearDivPreview()
    $(function () {
          var query = {
           type:"model"
        }
        $.ajax({ //'http://localhost:28017/ilariomaiolodb/documents/?filter_type=model'
             url:'https://api.mongohq.com/databases/testMarco/collections/documents/documents',
            type: 'get',
            data:{
                  _apikey:"bb65hmp1vtvu49shsqjf",
                  q:JSON.stringify(query)
            },
            dataType: 'json',
            success: function (data) {
                
                //if the document doesn't exist launch an alert
                if (typeof (data) === "undefined") {
                    alert("doesn't exist any model ")
                } else {
                    var length = data.length;
                   
                    //Retrive clusters_tree 
                    for(var j=0; j<length; j++){
                    var type = data[j]["type"];
                    var description = data[j]["description"];
                    var id = data[j]["id"];
                    var name = data[j]["name"];

                    
                    createDiv(""+j,type, description, id, name);
                }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('error', errorThrown);
            }
        });
    }); 

}

function retriveJsonDocumentById(value) {
    clearDivResult();
    $(function () {
    var query = {
           id:"modello".concat(value)
        }
        $.ajax({ // 'http://localhost:28017/ilariomaiolodb/documents/?filter_id=modello'.concat(id)
             url:'https://api.mongohq.com/databases/testMarco/collections/documents/documents',
            type: 'get',
            data:{
                  _apikey:"bb65hmp1vtvu49shsqjf",
                  q:JSON.stringify(query)
            },
            dataType: 'json',
            success: function (data) {
                data = data[0]
                console.log(data)
                //if the document doesn't exist launch an alert
                if (typeof (data) === "undefined") {
                    alert("doesn't exist a model with id : " + id)
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

function over(numberButton){
        var divId =  document.getElementById(""+numberButton);
        divId.style.opacity = ".50";
        divId.style.cursor = "pointer";
        
}

function out(numberButton){
        var divId =  document.getElementById(""+numberButton);
        divId.style.removeProperty("background");
        divId.style.removeProperty("opacity");
               
}



function createDiv(number, type, description, modelloid, name){
    var container = document.getElementById("preview");
    var divId = document.createElement("button");
    divId.setAttribute("id", number);
    divId.setAttribute("width" , "10%");
    divId.setAttribute("height" , "10%");
    divId.setAttribute("float" , "left");
    divId.innerHTML = '<font size='+1+'>description:'+description+'</font>'+
                      '<font size='+1+'>id:'+modelloid+'</font>'+
                      '<font size='+1+'>name:'+name+'</font></br>';
    var id = modelloid.substring(7);
    divId.setAttribute("onclick", "retriveJsonDocumentById("+""+id+")");
    divId.setAttribute("onmouseover","over("+""+number+")");
    divId.setAttribute("onmouseout", "out("+""+number+")")
    container.appendChild(divId);
    
}

function clearDivPreview() {
    var divPreview = document.getElementById('preview');
    divPreview.innerHTML = "";

}
