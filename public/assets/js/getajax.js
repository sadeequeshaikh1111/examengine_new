/*$(document).ready(function(){
    $('#btn1').click(function()
    {alert("script  on");
$.get("{{URL::to(getdemo)}}",function(data){
console.log(data);

});

    }
    );
    });*/
    var id = document.getElementById("txtid").value;

    $(document).ready(function() {
        $("#btn1").click(function() { 
         $.ajax({  //create an ajax request to display.php
          type: "GET",
          url: "get-blog-list/",       
          success: function (data) {
            $('#div2').html(data.name);
            console.log(data.name);
          }
        });
      });//btn1 ends here

$("#btn2").click(function(){
    var id = $("#txtid").val();
    var x=parseInt(id)+1;
    alert(id);

    $.ajax({  //create an ajax request to display.php

        type: "GET",
        url: "getuserbyid/"+x+"/sad",       
        success: function (data) {
          $('#div2').html(data.name);
          console.log(data.name);
        }
      });


});



      });