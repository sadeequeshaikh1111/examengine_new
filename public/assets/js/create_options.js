//option generater starterd Type 1 question:Text Question with 4 radio
function generate_options(op1,op2,op3,op4)
{
  $('#optiondiv_1').append(
$('<input>').prop({
  type: 'radio',
  id: 'option1',
  name: 'options',
  value: '1'
})).append($('<label>').prop({
for:'option1',

        }).html(op1));
        $('#optiondiv_2').append(
$('<input>').prop({
  type: 'radio',
  id: 'option2',
  name: 'options',
  value: '2'
})

        ).append($('<label>').prop({
for:'option2',

        }).html(op2));    
        $('#optiondiv_3').append(
$('<input>').prop({
  type: 'radio',
  id: 'option3',
  name: 'options',
  value: '3'
})

        ).append($('<label>').prop({
for:'option3',

        }).html(op3));
        $('#optiondiv_4').append(
$('<input>').prop({
  type: 'radio',
  id: 'option4',
  name: 'options',
  value: '4'
})

        ).append($('<label>').prop({
for:'option4',

        }).html(op4));           
            
}

//option generator ended
//option generater starterd Type 2 question:Text Question with True  False radio

function Generate_TrueFalse_options(op1,op2)
{
    $('#optiondiv_1').append(
        $('<input>').prop({
          type: 'radio',
          id: 'option1',
          name: 'options',
          value: '1'
        })
        
                ).append($('<label>').prop({
        for:'option1',
        
                }).html(op1));
                $('#optiondiv_2').append(
        $('<input>').prop({
          type: 'radio',
          id: 'option2',
          name: 'options',
          value: '2'
        })
        
                ).append($('<label>').prop({
        for:'options',
        
                }).html(op2));    

}
//checkboxes funtion Type 3 question:Image Question with 4 Options
function generate_Image_options(op1,op2,op3,op4)
{

}
//End of generate_Image_options(op1,op2,op3,op4) type 3

//checkboxes funtion Type 5 question:Text Question with 4 Checkboxes
function generate_checkboxes(op1,op2,op3,op4)
{
  $('#optiondiv_1').append(
$('<input>').prop({
  type: 'checkbox',
  id: 'option1',
  name: 'options',
  value: '1'
})

        ).append($('<label>').prop({
for:'option1',

        }).html(op1));

//checkb2
$('#optiondiv_2').append(
$('<input>').prop({
  type: 'checkbox',
  id: 'option2',
  name: 'options',
  value: '2'
})

        ).append($('<label>').prop({
for:'option2',

        }).html(op2));

//checkb3
$('#optiondiv_3').append(
$('<input>').prop({
  type: 'checkbox',
  id: 'option3',
  name: 'options',
  value: '3'
})

        ).append($('<label>').prop({
for:'option3',

        }).html(op3));
//checkb4
$('#optiondiv_4').append(
$('<input>').prop({
  type: 'checkbox',
  id: 'option4',
  name: 'options',
  value: '4'
})

        ).append($('<label>').prop({
for:'option4',

        }).html(op4));
}
//check box function ended

//clear  optionsdiv function
function clear_option_divs()
{
          $('#optiondiv_1').empty();
          $('#optiondiv_2').empty();
          $('#optiondiv_3').empty();
          $('#optiondiv_4').empty();

}
//clear optiondiv() ended
//clear response() started
function clear_resp()
{

console.log("Response cleared");
$("#option2").prop("checked", false);
$("#option1").prop("checked", false);
$("#option3").prop("checked", false);
$("#option4").prop("checked", false);
change_css(0);
}
//clear_resp() ended