var groesse = 30;

$(document).ready(function (){

    var counter = 0;


    startConfig();

    // Bilder einfügen
    $(".image-thumbnail").on("click", function (){
        counter++;
        let imgid = "img" + counter;
        $("#malbereich").append("<div id='img" + counter + "'>" +
            "<img id='print" + imgid + "' src='" + $(this).attr("src") + "'" +
            "<br><br><button class=\"imgbtn\" id=\"plus\" onclick=\"plus('" + imgid + "')\">+</button>" +
            "  <button class=\"imgbtn\" id=\"minus\" onclick=\"minus('" + imgid + "')\">-</button>" +
            "  <button class=\"imgbtn delbtn\" id=\"del\" onclick=\"del('" + imgid + "')\">X</button>" +
            "</div>");
        //$("#img" + counter).resizable();

        $("#" + imgid).draggable();
        $("#" + imgid).css("position", "absolute");
        $("#" + imgid).css("top", "400");
        $("#" + imgid).css("left", "0");
        $("#" + imgid).css("z-index", "2");

        if($(this).attr("src").includes("backgrounds") == true){
            $("#print" + imgid).width($("#malbereich").width());
            $("#print" + imgid).height($("#malbereich").height());
        }
        else{
            $("#print" + imgid).height(200);
        }
    })

    // Symbole unter den Bildern verstecken
    $("#removeimgbtn").on("click", function (){
        if($(".imgbtn").css("visibility") == "hidden") {
            $(".imgbtn").css("visibility", "visible")
        }
        else{
            $(".imgbtn").css("visibility", "hidden")
        }

    });

    // Auswahl der Größe
    $("select").on("change", function(){
        const auswahl = $("OPTION").filter(':selected').val();

        let size = [];
        size = getAspectRatio(auswahl);

        $("#malbereich").width(size[0]);
        $("#malbereich").height(size[1]);
    });

    // Button "Neues Bild"
    $("#newImage").on("click", function (){
        window.location.href = 'index.php';
    });

    //TODO
    // Button "Bild speichern"
    $("#saveImage").on("click", function (){

        $("#malbereich").css("border", "none")
        $(".imgbtn").css("visibility", "hidden")

        html2canvas(document.querySelector("#malbereich"), {
            scale: 4
        }).then(canvas => {
            //window.location.href = 'download.php?ext=png&img=' + canvas;
            //document.body.appendChild(canvas)
            $("#malbereich").empty();
            $("#malbereich").append(canvas);
        });

        $("#malbereich-text").empty();
        $("#malbereich-text").css("color", "red");
        $("#malbereich-text").css("font-size", "larger");
        $("#malbereich-text").html("Rechtsklick und Bild speichern...");


    });

    // Bildfläche vergrößern
    $("#imageAreaPlus").on("click", function (){
        if($("#malbereich").width() < 1600){
            $("#malbereich").width( $("#malbereich").width() + 30);
            $("#malbereich").height( $("#malbereich").height() + 30 );
        }
    });

    // Bildfläche verkleinern
    $("#imageAreaMinus").on("click", function (){
        if($("#malbereich").width() > 200){
            $("#malbereich").width( $("#malbereich").width() - 30);
            $("#malbereich").height( $("#malbereich").height() - 30 );
        }
    });
});


// Funktion für das richtige Seitenverhältnis des Malbereichs
function getAspectRatio(option){
    let width = 0;
    let height = 0;
    let screenwidth = (window.innerWidth * 0.6);
    let screenheight = (window.innerHeight * 0.6);

    switch (parseInt(option)) {
        case 1:
            // 16:9
            width = screenwidth;
            height = ((screenwidth / 16) * 9);
            break;
        case 2:
            // 9:16
            width = ((screenheight / 16) * 9);
            height = screenheight;
            break;
        case 3:
            // 4:3
            width = screenwidth;
            height = ((screenwidth / 4) * 3);
            break;
        case 4:
            // 3:4
            width = ((screenheight / 4) * 3);
            height = screenheight;
            break;
        case 5:
            // A4 quer (297x210)
            width = screenwidth;
            height = ((screenwidth / 10) * 7);
            break;
        case 6:
            // A4 hoch (210x297)
            width = ((screenheight / 10) * 7);
            height = screenheight;
            break;
        default:
            width = screenwidth;
            height = ((screenwidth / 16) * 9);
    }

    return [parseInt(width), parseInt(height)];
}

// Funktion für Dinge die beim Start eingestellt werden sollen
/*
    - Seitenverhältnis des Malbereichs
 */
function startConfig(){
    let size = [];
    size = getAspectRatio(1);
    $("#malbereich").width(size[0]);
    $("#malbereich").height(size[1]);
    $("#malbereich").html("");
}

function del(myID){
    $("#" + myID).remove();
}

function plus(myID){
    let meinBild = $("#print" + myID);
    if (meinBild.height() < 1000){
        meinBild.height( meinBild.height() + groesse );
    }
}

function minus(myID){
    let meinBild = $("#print" + myID);
    if (meinBild.height() > 60){
        meinBild.height( meinBild.height() - groesse );
    }

}
