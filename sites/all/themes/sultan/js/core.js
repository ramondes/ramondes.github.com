// variables
var myCLogEnabled = false; // true, false
var myCLogType = 'console'; // console, alert

var mySliderAutoEnabled = true; // true, false
var mySliderLeft = 0; // start slider margin-left

// function core
function myCLog(text,log_type){
    if(myCLogEnabled){
        if(log_type) myCLogType = log_type;
        switch(myCLogType){
            case 'alert':
                alert(text);
            break;
            case 'console':
            default:
                console.log(text);
            break;            
        }        
    }
}

// function slider
function mySliderClick(id){myCLog('mySliderClick('+id+');');
    var count_slider = $(id+' li.product').length;    
    var width_slider2 = 290;
    var width_slider = 310;
    var width_view_slider = $('.mySliderWidth').width();
    $('.next').click(function(){myCLog('mySliderClick('+id+'); next : click');
        if(mySliderLeft > -(count_slider*width_slider2-width_view_slider)){
            mySliderLeft = mySliderLeft-width_slider;
            mySliderAutoEnabled = false;
        }
        mySliderSetAnimate(id,mySliderLeft,800);
    });
    
    $('.prew').click(function(){myCLog('mySliderClick('+id+'); prew : click');
        if(mySliderLeft < 0){
            mySliderLeft = mySliderLeft+width_slider; 
            mySliderAutoEnabled = false;
        }
        mySliderSetAnimate(id,mySliderLeft,800);
    });
}
function mySliderAuto(id){myCLog('mySliderAuto('+id+')');
    var count_slider = $(id+' li.product').length;
    var width_slider2 = 290;
    var width_slider = 310;
    var width_view_slider = $('.mySliderWidth').width();
    if(mySliderLeft > -(count_slider*width_slider2-width_view_slider)){
        mySliderLeft = mySliderLeft-width_slider;
    }else{
        mySliderLeft = 0;
    } 
    mySliderSetAnimate(id,mySliderLeft,800);
}
function mySliderSetAnimate(id,m_left,duration){
    if(!duration) duration = 1000;
    if(!m_left) m_left = 0;
    myCLog('mySliderSetAnimate('+id+','+m_left+','+duration+')');
    //$(id).css('margin-left',m_left);
    $(id).animate({
        marginLeft: m_left
    }, duration );
}

// document ready
$(document).ready(function(){myCLog('document.ready(core);');
    if($('#field_data_field__new').length){
        mySliderClick('#field_data_field__new');
        var mySliderInterval = setInterval(function(){
            if(!mySliderAutoEnabled){
                window.clearInterval(mySliderInterval);
            }else{
                mySliderAuto('#field_data_field__new');
            }
        },4000);
    }
    if($('#field_data_field__new2').length){
        mySliderClick('#field_data_field__new2');
        /*var mySliderInterval2 = setInterval(function(){
            if(!mySliderAutoEnabled){
                window.clearInterval(mySliderInterval2);
            }else{                
                mySliderAuto('#field_data_field__new2');
            }
        },4000);*/      
    }
});
