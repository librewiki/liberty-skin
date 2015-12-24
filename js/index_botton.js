/* 목차리스트를 고정해서 볼 수 있는 버튼을 만들어 줍니다.
   author: Damezuma
*/
if(mw.config.get("skin")=="liberty"){
    var a = "<button type=\"button\" class=\"btn btn-default\" aria-label=\"Left Align\">  <span class=\"fa fa-list\" aria-hidden=\"true\"></span></button>";
    var indexButton = document.createElement("button");
    indexButton.type = "button";
    indexButton.className = "btn btn-default";
    indexButton.innerHTML = "<span class=\"fa fa-list\" aria-hidden=\"true\"></span>";
    indexButton.style.position = "fixed";
    indexButton.style.top = "48px";
    indexButton.style.left = "0px";
    window.damezuma = {doc:null};
    $(indexButton).click(function(){
        if(window.damezuma.doc == null){
            window.damezuma.doc = $("#toc").clone();
            $(document.body).append(window.damezuma.doc);
            $(window.damezuma.doc).css({
                "position":"fixed",
                "top":44,
                "left":0,
                "background-color":"#333",
                "color":"#FFF",
                "padding":"16px",
                "bottom":0,
                "overflow-y":"scroll",
                "z-index":3000
            });
            window.damezuma.doc[0].id = "fixed-toc";
            $("#fixed-toc #togglelink").click(function(){
                $(window.damezuma.doc).remove();
                window.damezuma.doc = null;
                return false;
            });
        }


    });

    $(document.body).append(indexButton);
}