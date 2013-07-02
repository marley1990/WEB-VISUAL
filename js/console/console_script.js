// Console SCRIPT version 2.5
//
// 

   
    
    //Hint code
    CodeMirror.commands.autocomplete = function(cm) {
        CodeMirror.showHint(cm, CodeMirror.javascriptHint);
    };
    

    /*Testing button*/
    function test() {
        if (editor.getOption("mode") === "coffeescript")
            alert("coffeescript");
        if (editor.getOption("mode") === "javascript")
            alert("javascript");
    }

    function coffeeMode() {
        jsb.style.display = "inline";
        csb.style.display = "none";
        editor.setOption("mode", "coffeescript");
        CodeMirror.autoLoadMode(editor, "coffeescript");
    }

    function javascriptMode() {
        csb.style.display = "inline";
        jsb.style.display = "none";
        editor.setOption("mode", "javascript");
        CodeMirror.autoLoadMode(editor, "javascript");
    }
    
    /*Execute the code*/
    function exec() {

        var code = editor.getValue();
                
              if(editor.getOption("mode") === "coffeescript") {
              var js = CoffeeScript.compile(code)
               var f = new Function(js);
               f();
               
               
            } else if(editor.getOption("mode") === "javascript") {
               var f = new Function(code);
               f();
            }
        }


function displayResult()
{
document.getElementById("consl").style.top="100px";
}
 function toggleConsole() {
        var el = document.getElementById("consl");
        var body = document.getElementById("webindex")

        if(body !== null && document.body.style.overflow == 'hidden'){
        document.body.style.overflow = 'auto';}

        if (el.style.display !== 'none') {
            if(body !==null){
            document.getElementById("webindex").style.overflow = 'hidden';
        }
            el.style.display = 'none';
            editor.refresh();
        }
        else {
            el.style.display = 'inline';
            el.style.float = 'left'
            editor.refresh();
        }

    }

    function toggleConsolehome() {

        var el = document.getElementById("consl")
        var body = document.getElementById("webindex")
        var btn = document.getElementById("showConsole")
        var  tab=document.getElementById("tab")
       



        // btn.value='OpenConsole';
        if(tab.style.display=='none'){
        tab.style.display='inline'}
       
        if(body !== null && document.body.style.overflow == 'hidden'){
        document.body.style.overflow = 'auto';}

        if (el.style.display !== 'none') {
            if(body !==null){
            document.getElementById("webindex").style.overflow = 'hidden';
        }
            el.style.display = 'none';
            editor.refresh();
        }
        else {
            el.style.display = 'inline';
            tab.style.display = 'none';
            el.style.float = 'left'


             el.style.position = "absolute";
            // btn.style.position="absolute";
            // btn.value='OpenConsole2212';
            editor.refresh();
        }

    }


    
    /*keys for opening the console
     * for combo or other key:
     * ctrl -> ctrlKey
     * alt -> altrKey
     * c -> 67
     * shift -> 16*/
    document.onkeyup = function(e) {
        if (e.keyCode === 220) {
            toggleConsolehome();
        }
    };
   
    
    /*Access projects page*/
    
    function webdicom() {
        window.location.href = "Web-dicom.html";
    };
    
    function webindex() {
         window.location.href = "Web-index.html";
    };
    
    function weblar() {
        window.location.href = "Web-lar.html";
    };
