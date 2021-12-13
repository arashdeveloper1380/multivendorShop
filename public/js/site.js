/*
|--------------------------------------------------------------------------
| Start Show Category                                                     │
|--------------------------------------------------------------------------
*/
$(document).ready(function(){
    $('.cat_item').mouseover(function () { 
        const li_width = $(this).css('width');
        const ul_width = $(".index-cat-list ul").width();
        const a = li_width.replace('px','');
        const right = ul_width-$(this).offset().left-a+15;
        $('.cat_hover').css('width',li_width);
        $('.cat_hover').css('right',right);
        $('.cat_hover').css('transform','scaleX(1)');
        $('.li_div').hide()
        $('.li_div',this).show();
    });
    $('.index-cat-list').mouseleave(function(){
        $('.li_div').hide()
        $('.cat_hover').css('transform','scaleX(0)');
    });
});


/*
|--------------------------------------------------------------------------
| Start Slider                                                            │
|--------------------------------------------------------------------------
*/
let imgCount = 0;
let img = 0;
function loadSlider(count){
    imgCount = count;
    setInterval(next,3500);
}

function next() { 
    $('.slider_bullet_div span').removeClass('active')
    if(img == (imgCount-1)){
        img = -1;
    }
    img = img+1;
    $('.slide_div').hide();
    document.getElementById('slider_img_'+img).style.display='block';
    $('#slider_bullet_'+img).addClass('active');
}

function previous() { 
    $('.slider_bullet_div span').removeClass('active');
    img = img-1;
    if(img == -1){
        img = (imgCount)-1;
    }
    $('.slide_div').hide();

    document.getElementById('slider_img_'+img).style.display='block';
    $('#slider_bullet_'+img).addClass('active');
}