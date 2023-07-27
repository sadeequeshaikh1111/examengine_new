$( document ).ready(function() {
    id=get_recent();
    console.log( "page ready !"+id );

    console.log(id);
    GetQuestion(id);
});
function get_recent()
{
    id='1';
    $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "getQuestion/"+'1',       
        success: function (data) {
        id=data.id;
       
}
    });
return id;
}
function GetQuestion(str)
{
  var lang =$('#LANG').val()
  console.log(lang);
  $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "getQuestion/"+str+"/"+lang,       
        success: function (data) {
        console.log("option is: "+data.option1);
        console.log(data.option2);



if(data.Qtype==1)//text question 4 radio options
{
  $('#qn_lbl').html(data.SQn);
          $('#Question_container').html(data.Question);
          clear_option_divs();
          generate_options(data.option1,data.option2,data.option3,data.option4);

    
} 
else if(data.Qtype==2)//text question 2 radio options  
        { 
          clear_option_divs();
          $('#qn_lbl').html(data.SQn);
          $('#Question_container').html(data.Question);
        //  generate_checkboxes(data.option1,data.option2,data.option3,data.option4);
        Generate_TrueFalse_options(data.option1,data.option2);
}
else if(data.Qtype==3)//image question 4 radio options
{   
  clear_option_divs();
  $('#qn_lbl').html(data.SQn);
  $('#Question_container').html("data Question Image");
          generate_options(data.option1,data.option2,data.option3,data.option4);
}
else if(data.Qtype==4)//image question 2 radio options
{ 
          clear_option_divs();
          $('#qn_lbl').html(data.SQn);

          $('#Question_container').html("data Question_Image");
        //  generate_checkboxes(data.option1,data.option2,data.option3,data.option4);
        Generate_TrueFalse_options(data.option1,data.option2);
}
else if(data.Qtype==5)//text question 4 checkboxes 
        { 
          clear_option_divs();
          $('#qn_lbl').html(data.SQn);

          $('#Question_container').html(data.Question);
          generate_checkboxes(data.option1,data.option2,data.option3,data.option4);
       // Generate_TrueFalse_options(data.option1,data.option2);
}
else if(data.Qtype==6)//Image question 4 checkboxes 
        { 
          clear_option_divs();
         $('#qn_lbl').html(data.SQn);

          $('#Question_container').html("data.Question_Image");
          generate_checkboxes(data.option1,data.option2,data.option3,data.option4);
       // Generate_TrueFalse_options(data.option1,data.option2);
}
console.log("SQN "+data.SQn);



}
      });
    
}
function change_css(flag)
{
  var greencss="visited_answered_button";
  var redcss="visited_answered_button";

if(flag<5)//unanswered
{
  $("#"+Question_number).addClass(greencss);
}
else
{  $("#"+Question_number).addClass(redcss);
}

}
function getstatus(reg_no)
{alert("we r in getstatus")
        console.log(" status test");
        var greencss="visited_answered_button";
        var redcss="visited_unanswered_button";
        $.ajax({  //create an ajax request to display.php
            type: "GET",
            url: "get_qn_status/"+reg_no,       
            success: function (data) {
                for(var i = 0; i < data.length; i++)
                {
                        comment = data[i].status;
                        if(data[i].status=="unanswered")
                        {console.log(data[i].status)     
                                $("#"+data[i].SQN).addClass(redcss);

                        }
                        else if(data[i].status=="saved")
                        {console.log(data[i].status)
                                $("#"+data[i].SQN).addClass(greencss);

                        }
        
                }
                 
    }
        });
        


}
function get_selected(question_no,reg_no)
{
$qn=question_no;
 $.ajax({  //create an ajax request to display.php
        type: "GET",
        url: "get_qn_ans/"+reg_no+'/'+$qn,       
        success:function (data) {

                console.log(data.selected_ans)
        
       select_prev_ans_options(data.selected_ans)
}
    });
return id;
}
function select_prev_ans_options(str)
{
        if(str.length==1)
     {   $("#"+"option"+str).checked = true;
        $("#option"+str).prop("checked", true);
}
else
{console.log(str)
        var answer= str.split("");
        
        if(answer[0]=="1")
        { $("#option1").prop("checked", true);}
        if(answer[1]=="2")
        {$("#option2").prop("checked", true);}
        if(answer[2]=="3")
        {$("#option3").prop("checked", true);}
        if(answer[3]=="4")
        {$("#option4").prop("checked", true);}

}



}



