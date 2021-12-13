/*
|--------------------------------------------------------------------------
| Start Sidebar Menu                                                      │
|--------------------------------------------------------------------------
*/
let Toggle = false;
$('#sidebar_menu li').click(function () {
    if(!$(this).hasClass('active')){
        $('#sidebar_menu li').removeClass('active');
        $(this).addClass('active');
        $('.child_menu').slideUp(300);

        $('#sidebar_menu .fa-angle-left').removeClass('fa-angle-down');
        $('.fa-angle-left',this).addClass('fa-angle-down');

        if(!Toggle){
            $('.child_menu',this).slideDown(300);
        }else{
            $('.child_menu',this).show();
        }
    }
    else if(Toggle){
        $('.child_menu').slideUp(300);
        $('.child_menu',this).show();
    }
});

$('#sidebarToggle').click(function () {
    if($('.page_sidebar').hasClass('toggled')){
        Toggle = false;
        $('.page_sidebar').removeClass('toggled').css('transition','all 0.1s ease-in-out');
        $('#sidebar_menu').find('.active .child_menu').css('display','block');
        $('.page_content').css('margin-right','240px');
    }else{
        Toggle = true;
        $('.page_sidebar').addClass('toggled');
        $('.child_menu').hide();
        $('#sidebar_menu li').removeClass('active');
        $('.page_content').css('margin-right','50px');
    }
});

set_sidebar_width = function () {
    const width = document.body.offsetWidth;
    if(width<850){
        $('.page_sidebar').addClass('toggled');
        $('.page_content').css('margin-right','50px');
        $('.child_menu').hide();
    }else{
        if(Toggle==false){
            $('.page_sidebar').removeClass('toggled');
            $('.page_content').css('margin-right','240px');
    }
}
}

$(window).resize(function () {
    set_sidebar_width();
});
$(document).ready(function () {
    set_sidebar_width();
    const url = window.location.href.split('?')[0];

    $('#sidebar_menu a[href="'+url+'"]').parent().parent().addClass('active');
    $('#sidebar_menu a[href="'+url+'"]').parent().parent().find('a .fa-angle-left').addClass('fa-angle-down');

    $('#sidebar_menu a[href="'+url+'"]').parent().parent().find('.child_menu').show();
});



/*
|--------------------------------------------------------------------------
| Start Select Image On Category                                          │
|--------------------------------------------------------------------------
*/
select_file = function(){
    $('#img').click();
}
loadFile = function (event) {
    var render=new FileReader;
    render.onload=function (){
        var output=document.getElementById('output');
        output.src=render.result;
    };
    render.readAsDataURL(event.target.files[0]);
}



/*
|--------------------------------------------------------------------------
| Start Delete Row                                                        │
|--------------------------------------------------------------------------
*/
let delete_url;
let token;
let send_array_data = false;
let _method ='DELETE';
del_row = function(url,t,message){
    _method ='DELETE';
    delete_url = url;
    token = t;
    $('#msg').text(message);
    $('.message_div').slideDown(100);
}
delete_row = function(){
    if(send_array_data){
        $("#data_form").submit();
    }else{
        let form = document.createElement('form');
        form.setAttribute('method','POST');
        form.setAttribute('action',delete_url);

        const hidden_field1 = document.createElement('input');
        hidden_field1.setAttribute('name','_method');
        hidden_field1.setAttribute('value',_method);
        form.appendChild(hidden_field1);

        const hidden_field2 = document.createElement('input');
        hidden_field2.setAttribute('name','_token');
        hidden_field2.setAttribute('value',token);
        form.appendChild(hidden_field2);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
}
hide_box = function(){
    delete_url = '';
    token = '';
    $('.message_div').slideUp(100);
}



/*
|--------------------------------------------------------------------------
| Start multiple Delete & Restore                                         │
|--------------------------------------------------------------------------
*/

$('.check_box').click(function () {
    send_array_data = false;
    const $checkbox = $('table tr td input[type="checkbox"]');
    const count = $checkbox.filter(':checked').length;
    if(count>0){
        $('.dropdown-item.off').css('display','block');
    }
    else{
        $('.dropdown-item.off').css('display','none');
    }
});
$('.item_form').click(function () {
    send_array_data = true;

    const $checkbox = $('table tr td input[type="checkbox"]');
    const count = $checkbox.filter(':checked').length;
    if(count>0){
        const href=window.location.href.split('?');
        const action=href[0]+"/"+this.id;
        if(href.length==0){
            action = action+href[1];
        }
        $('#data_form').attr('action',action);
        $('#msg').text($(this).attr('msg'));
        $('.message_div').slideDown(100);
    }
});
$('a,button').tooltip();



/*
|--------------------------------------------------------------------------
| Start Restore One Row                                                   │
|--------------------------------------------------------------------------
*/
restore_row = function(url, t, message){
    _method ='POST';
    delete_url=url;
    token = t;
    $('#msg').text(message);
    $('.message_div').slideDown(100);
}



/*
|--------------------------------------------------------------------------
| Start Tag Product                                                       │
|--------------------------------------------------------------------------
*/
add_tag = function(){
    const tag_list = document.getElementById('tag_list').value;
    const t = tag_list.split(',');
    const keywords = document.getElementById('keywords').value;
    let count = document.getElementsByClassName('tag_div').length+1;
    let string = keywords;
    for (let i = 0; i<t.length; i++){
        if(t[i].trim()!=''){
            const n = keywords.search(t[i]);
            if(n==-1){
                const r = "'"+t[i]+"'";
                string = string+","+t[i];
                var tag = '<div class="tag_div" id="tag_div_'+count+'">'+
                    '<span class="fa fa-remove" onclick="remove_tag('+count+','+r+')"></span>'+t[i]+
                    '</div>';
                    count++;
                    $("#tag_box").append(tag);
            }
        }
    }
    document.getElementById('keywords').value=string;
    document.getElementById('tag_list').value='';
}

remove_tag = function (id,text) {
    $("#tag_div_"+id).hide();
    const keywords = document.getElementById('keywords').value;
    const t1 = text + ",";
    const t2 ="," + text ;
    let a = keywords.replace(t1,'');
    let b = a.replace(t2,'');
    document.getElementById('keywords').value = b;
}



/*
|--------------------------------------------------------------------------
| Start Delete Image                                                      │
|--------------------------------------------------------------------------
*/
function del_img(id,url,token){
    var route = url+"/";
    var form = document.createElement("form");
    form.setAttribute("method","post");
    form.setAttribute("action",route+id);
    var hiddenField2 = document.createElement("input");
    hiddenField2.setAttribute("name", "_token");
    hiddenField2.setAttribute("value",token);
    form.appendChild(hiddenField2);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}


/*
|--------------------------------------------------------------------------
| Start Add Item Category                                                 │
|--------------------------------------------------------------------------
*/
add_item_input = function(){

    const id = document.getElementsByClassName('item_input').length+1;

    const html = '<div class="form-group item_groups" id="item_-'+id+'">'+
    '<input type="text" class="form-control item_input" name="item[-'+id+']" placeholder="نام گروه ویژگی">'+
    '<span class="fa fa-plus-circle" onclick="add_child_input(-'+id+')"></span>'+
    '<div class="child_item_box"></div>'+
    '</div>';
    $('#item_box').append(html);
}

add_child_input = function(id){

    const child_count = document.getElementsByClassName('child_input_item').length+1;
    const count = document.getElementsByClassName('child_'+id).length+1;

    const html ='<div class="form-group child_'+id+'">'+
    count+' - '+'<input type="checkbox" name="check_box_item['+id+'][-'+child_count+']">'+
    '<input type="text" name="child_item['+id+'][-'+child_count+']" class="form-control child_input_item" placeholder="نام ویژگی">'+
    '</div>';

    $("#item_"+id).find('.child_item_box').append(html);
}


/*
|--------------------------------------------------------------------------
| Start Add value Product                                                 │
|--------------------------------------------------------------------------
*/
add_item_value_input = function (id)
{
    const html = '<div class ="form-group">'+
    '<label></label>'+
    '<input name="item_value['+id+'][]" type="text" class="form-control">'+
    '</div>';
    $('#input_item_box_'+id).append(html);
}


/*
|--------------------------------------------------------------------------
| Start Category Filter                                                   │
|--------------------------------------------------------------------------
*/
add_filter_input = function() {
    const id = document.getElementsByClassName('filter_input').length+1;
    const html = 

    '<div class="form-group item_groups" id="filter_-'+id+'">'+
        '<input type="text" class="form-control filter_input" name="filter[-'+id+']" placeholder="نام گروه فیلتر">'+
        '<span class="fa fa-plus-circle" onclick="add_filter_child_input(-'+id+')"></span>'+
        '<div class="child_filter_box"></div>'+
    '</div>';

    $('#filter_box').append(html);
}

add_filter_child_input = function (id) { 

    const child_count = document.getElementsByClassName('child_input_filter').length+1;
    const count = document.getElementsByClassName('child_'+id).length+1;

    const html =

    '<div class="form-group child_'+id+'">'+
        count + ' - ' +'<input type="text" name="child_filter['+id+'][-'+child_count+']" class="form-control child_input_filter" placeholder="نام فیلتر">'+
    '</div>';

    $("#filter_"+id).find('.child_filter_box').append(html);

}


/*
|--------------------------------------------------------------------------
| Start Add Filter Box                                                    │
|--------------------------------------------------------------------------
*/
$('.item_filter_box ul li input[type="checkbox"]').click(function () {
    const filter = $(this).parent().parent().parent().parent().find('.filter_value');
    const input = $(this).parent().parent().parent().parent().find('.item_value');
    const text = $(this).parent().text().trim();

    let value = input.val();
    let filter_value = filter.val();

    if($(this).is(":checked")){
        if(value.trim() == ''){
            value = text;
            filter_value = $(this).val();
        }else{
            value = value+","+text;
            filter_value = filter_value+"@"+$(this).val();
        }
        input.val(value);
        filter.val(filter_value);
    }
    else{
       value = value.replace(","+text,"");
       value = value.replace(text,"");

       filter_value = filter_value.replace("@"+$(this).val(),"");
       filter_value = filter_value.replace($(this).val(),"");

       input.val(value);
       filter.val(filter_value);

    }
});

$('.show_filter_box').click(function () { 

    const el = $(this).parent().find('.item_filter_box');
    const display = el.css('display');
    if(display=='block')
    {
        el.slideUp();
    }else{
        el.slideDown(500);
    }
});