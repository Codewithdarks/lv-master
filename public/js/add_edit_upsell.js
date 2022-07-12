$(document).ready(function () { 
    var isupsells = $("[class*='updownsellgroup_']").length;
    if(isupsells>=1){
        $('.updownsellgroup_1 > .upsell1 > .list-item-button > ul > li').addClass('aaaaaaa');
        $('.updownsellgroup_1 > .upsell1 > .list-item-button > ul > li > a.edit-btn').click();
         alert();
    }
    var app = app || {};
    app.Currency = (function() {
     var moneyFormat = '${{amount}}'; // eslint-disable-line camelcase
   
     function formatMoney(cents, format) {
       if (typeof cents === 'string') {
         cents = cents.replace('.', '');
       }
       var value = '';
       var placeholderRegex = /\{\{\s*(\w+)\s*\}\}/;
       var formatString = format || moneyFormat;
   
       function formatWithDelimiters(number, precision, thousands, decimal) {
         thousands = thousands || ',';
         decimal = decimal || '.';
   
         if (isNaN(number) || number === null) {
           return 0;
         }
   
         number = (number / 100.0).toFixed(precision);
   
         var parts = number.split('.');
         var dollarsAmount = parts[0].replace(
           /(\d)(?=(\d\d\d)+(?!\d))/g,
           '$1' + thousands
         );
         var centsAmount = parts[1] ? decimal + parts[1] : '';
   
         return dollarsAmount + centsAmount;
       }
   
       switch (formatString.match(placeholderRegex)[1]) {
         case 'amount':
           value = formatWithDelimiters(cents, 2);
           break;
         case 'amount_no_decimals':
           value = formatWithDelimiters(cents, 0);
           break;
         case 'amount_with_comma_separator':
           value = formatWithDelimiters(cents, 2, '.', ',');
           break;
         case 'amount_no_decimals_with_comma_separator':
           value = formatWithDelimiters(cents, 0, '.', ',');
   
           break;
         case 'amount_no_decimals_with_space_separator':
           value = formatWithDelimiters(cents, 0, ' ');
           break;
         case 'amount_with_apostrophe_separator':
           value = formatWithDelimiters(cents, 2, "'");
           break;
       }
   
       return formatString.replace(placeholderRegex, value);
     }
   
     return {
       formatMoney: formatMoney
     };
   })();


      $(document).on('click', '.edit-btn', function () {
         var currentid = $(this).attr('data-id'); //alert(currentid);
         var type = $(this).data('type');
         var parentupsellid = $(this).data('parentupsellid'); 
         console.log(type);console.log(parentupsellid);
         if(type=='downsell' && parentupsellid==''){
            alert('Make sure you have Upsell for this.');
            return false;
         }
         if(parentupsellid!=''){
            $('input[name="parentupsellid"]').val(parentupsellid);
         }
         
         $('input[name="upselldownid"]').val(currentid);
         $('.product-detail').html('');
         $('.discount-offer').css('visibility','hidden');
         $('.actiongroupupdnll').css('visibility','hidden');
         $('#discountamount').val('');
         $('input[name="productname"]').val('');
         $('input[name="discounttype"]:checked').prop('checked', false);
         $('input[name="upselltype"]').val(type);
        current = $(this);
         if(currentid!=''){
            csrftoken = $('input[name="_token"]').val();
             $.ajax({
                url: GETUPSELLURL,
                type: 'POST',
                data: {id:currentid,_token:csrftoken,type:type},
                async: true,
                success: function (response) {
                   // console.log(response);    
                    var obj= jQuery.parseJSON(response.response_body);
                    var extobj = jQuery.parseJSON(response.response_extra);
                    console.log(extobj);
                    console.log(obj);
                    var productdetail ='<div class="product-image"><img src="'+obj.featured_image+'" alt="'+obj.title+'"></div><div class="product-content"><div class="product-desc"><h3>'+obj.title+'</h3><p>'+obj.description+'</p></div><div class="mainprice product-price" data-price="'+(obj.price/100).toFixed(2)+'">Price: <strong>'+app.Currency.formatMoney(obj.price, app.moneyFormat)+'</strong></div><div class="discountprice product-price"></div></div>';
                    $('input[name="shopify_productid"]').val(obj.id);
                    $('input[name="shopify_productname"]').val(obj.title);
                    $('input[name="productname"]').val(obj.title);
                    $('input[name="shopify_producthandle"]').val(obj.handle);
                    $('.product-detail').html(productdetail);
                    $('input[name="discountamount"]').val(extobj.discountamount);
                    $("input[name=discounttype][value=" + extobj.discounttype + "]").prop('checked', true);
                    $('.discount-offer,.actiongroupupdnll').css('visibility','visible');
                    $('.preview-btn').attr('data-id',currentid).attr('data-type',type);

                    if(extobj.discounttype=='Percentage'){
                        var discountget = ((obj.price/100) * extobj.discountamount) / 100;
                        var discountedprice = (obj.price/100) - discountget;
                        $('.discountprice').html('Discount:<strong>'+app.Currency.formatMoney(parseFloat(discountedprice*100), app.moneyFormat)+'</strong>');
                    }else if(extobj.discounttype=='Fixed'){
                        var discountget = (obj.price/100) - parseFloat(extobj.discountamount);
                        var discountedprice = discountget;
                        $('.discountprice').html('Discount:<strong>'+app.Currency.formatMoney(discountedprice*100, app.moneyFormat)+'</strong>');
                    }
                  //  const obj = JSON.parse(response);
                    //alert(obj.message);
                },
                error: function (jqXHR, exception) {
                    //alert(jqXHR.responseJSON.message);
                },
                timeout: 5000000,
            });
         }
         $(this).parents(".listing-main").find(".list-item").removeClass('active');
         $(this).parents(".listing-main").siblings().find(".list-item").removeClass('active');
         if ($(this).parents().hasClass("downsell")) {
             $(this).parents(".downsell .list-item").addClass('active');
         } else {
             $(this).parents(".listing-main > .list-item").addClass('active');
         }
         $('.product-column').addClass('active');
        
    });

    $(document).on('click', '.view-btn, .preview-btn', function () {
        var updnsellid = $(this).data('id');
        var type = $(this).data('type');
        if(updnsellid!=''){
        //window.location.href = ;
        window.open(""+CHECKOUTDOMAIN+"singlefunnel?id="+updnsellid+"&type="+type+"", '_blank');
        }
    });

    $(document).on('keyup','#productname', function() { 
        var term = $(this).val();
        console.log(term);
        if (term.length >= 3){
            $.ajax({
                async:true,
                dataType : 'jsonp',   //you may use jsonp for cross origin request
                crossDomain:true,
                url: 'https://eordeals.co/search/suggest.json?q='+term+'&resources[type]=product&limit=10&resources[options][unavailable_products]=hide&resources[options][fields]=title,product_type,variants.title,tag',
                success: function(data) {
                    //console.log(data.resources.results);
                    var ajax_items = '<ul>';
                    if(data.resources.results.products.length>0){
                        $(data.resources.results.products).each(function(index,productdetail ) {
                            ajax_items +='<li data-proid="'+productdetail.id+'" data-proimg="'+productdetail.image+'" data-proprice="'+productdetail.price+'" data-protitle="'+productdetail.title.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;")+'" data-proinfo="'+productdetail.body.replace(/&/g, "&amp;").replace(/>/g, "&gt;").replace(/</g, "&lt;").replace(/"/g, "&quot;")+'" data-prohandle="'+productdetail.handle+'"><img src="'+productdetail.image+'"/>'+productdetail.title+'</li>';
                            //console.log(productdetail.handle); 
                        });                   
                    }else{
                        ajax_items +='<li style="pointer-events: none;">No Product Found</li>';
                    }
                    ajax_items += '</ul>';
                   $('.search-dropdown').html(ajax_items).css('display','block'); 
                }
              });
        }
    });
    $(document).on('click','.search-dropdown ul li', function() {
        var productimage = $(this).data('proimg');
        var producttitle = $(this).data('protitle');
        var productprice = $(this).data('proprice');
        var productdesc = $(this).data('proinfo');
        var prodcutid = $(this).data('proid');
        var producthandle = $(this).data('prohandle');
        var productdetail ='<div class="product-image"><img src="'+productimage+'" alt="'+producttitle+'"></div><div class="product-content"><div class="product-desc"><h3>'+producttitle+'</h3><p>'+productdesc+'</p></div><div class="mainprice product-price" data-price="'+productprice+'">Price: <strong>'+app.Currency.formatMoney(productprice, app.moneyFormat)+'</strong></div><div class="discountprice product-price"></div></div>';
        $('input[name="shopify_productid"]').val(prodcutid);
        $('input[name="shopify_productname"]').val(producttitle);
        $('input[name="shopify_producthandle"]').val(producthandle);
        $('.product-detail').html(productdetail);
        $('.search-dropdown').html('').css('display','none');
        $('#discountamount').val('');
        $('input[name="productname"]').val(producttitle);
        $('input[name="discounttype"]:checked').prop('checked', false);
        $('.discount-offer,.actiongroupupdnll').css('visibility','visible');
    });
    $(document).on('blur','#discountamount', function() {
        var discount = $(this).val();
        if(discount==''){var discount =0;}
        var discounttype = $('input[name="discounttype"]:checked').val(); 
        var productprice = $('.mainprice').data('price');
        
        if(typeof discounttype !== "undefined"){
            if(discounttype=='Percentage'){
                if(discount>100){maxdiscount=100}else{maxdiscount=discount;}
                var discountget = (productprice * maxdiscount) / 100;
                var discountedprice = productprice - discountget;
                $('.discountprice').html('Discount:<strong>'+app.Currency.formatMoney(parseFloat(discountedprice*100), app.moneyFormat)+'</strong>');
            }else if(discounttype=='Fixed'){
                var discountget = productprice - parseFloat(discount);
                if (discountget > 0) {
                var discountedprice = discountget;
                }else{
                    var discountedprice = 0.00  
                }
                $('.discountprice').html('Discount:<strong>'+app.Currency.formatMoney(discountedprice*100, app.moneyFormat)+'</strong>');
            }

        }
       // if(discounttype)
    });
    $(document).on('change','input[name="discounttype"]', function() {
        var discount = $('#discountamount').val();
        var discounttype = $('input[name="discounttype"]:checked').val(); 
        var productprice = $('.mainprice').data('price');
            if(discounttype=='Percentage' && discount!=''){
                if(discount>100){maxdiscount=100}else{maxdiscount=discount;}
                var discountget = (productprice * maxdiscount) / 100;
                var discountedprice = productprice - discountget;
                $('.discountprice').html('Discount:<strong>'+app.Currency.formatMoney(parseFloat(discountedprice*100), app.moneyFormat)+'</strong>');
            }else if(discounttype=='Fixed' && discount!=''){
                var discountget = productprice -  parseFloat(discount);
                if (discountget > 0) {
                    var discountedprice = discountget;
                    }else{
                        var discountedprice = 0.00  
                    }
                $('.discountprice').html('Discount:<strong>'+app.Currency.formatMoney(discountedprice*100, app.moneyFormat)+'</strong>');
            }

    });
    $("#saveupdnsellform").on('submit', function(e){
        var type = $('input[name="upselltype"]').val();
        e.preventDefault();
        $.ajax({
            url: SAVEUPSELLURL,
            type: 'POST',
            data:new FormData(this),
            processData:false,
            dataType:'json',
            contentType:false,
            success:function(data){
               console.log(data);

               jQuery('.list-item').each(function(){
                var parent = jQuery(this);
                if(parent.hasClass('active')) {
                    jQuery(parent).find('a.edit-btn').attr('data-id',data.upselldownid);
                    jQuery(parent).find('a.view-btn').attr('data-id',data.upselldownid);
                    jQuery('.preview-btn').attr('data-id',data.upselldownid).attr('data-type',type);
                    jQuery(parent).find('.list-item-content > p').html($('input[name="shopify_productname"]').val());
                    jQuery(parent).find('a.deleteupsell').attr('data-id',data.upselldownid);
                    jQuery(parent).parent().find('.downsell a.edit-btn').attr('data-parentupsellid',data.upselldownid);
                } 
            });
            if(data.type=='upsell'){
                $('input[name="upselldownid"]').val(data.upselldownid);
                $('input[name="parentupsellid"]').val(data.upselldownid);
            }else if(data.type=='downsell'){
                $('input[name="upselldownid"]').val(data.upselldownid);
            }
            
                
                alert(data.message);
            }
        });
    });
    var count = $("[class*='updownsellgroup_']").length;
    $(".add-upsell").click(function () {
        count = count + 1;
        var addupsell = '<div class="listing-main updownsellgroup_'+count+' mb-4"><div class="list-item d-flex align-items-center px-3 py-3 mb-4 upsell'+count+'"><div class="list-item-icon"><img src="/images/upsell.svg" alt=""></div><div class="list-item-content"><h5>Upsell</h5><p>Product name here</p></div><div class="list-item-button"><ul><li><a href="javascript:void(0)" class="view-btn" data-id="" data-type="upsell"><i class="fas fa-eye"></i></a></li><li><a href="javascript:void(0)" class="edit-btn" data-id="" data-type="upsell"><i class="fas fa-edit"></i></a></li><li><a href="javascript:void(0)" class="deleteupsell" data-id="" data-type="upsell"><i class="fas fa-trash-alt"></i></a></li></ul></div></div><div class="downsell ml-70 downsell'+count+'"><div class="list-item d-flex align-items-center px-3 py-3"><div class="list-item-icon"><img src="/images/downsell.svg" alt=""></div><div class="list-item-content"><h5>Downsell</h5><p>Product name here</p></div><div class="list-item-button"><ul><li><a href="javascript:void(0)" class="view-btn" data-id="" data-type="downsell"><i class="fas fa-eye"></i></a></li><li><a href="javascript:void(0)" class="edit-btn" data-parentupsellid="" data-id="" data-type="downsell"><i class="fas fa-edit"></i></a></li><li><a href="javascript:void(0)" class="deletedownsell" data-id="" data-type="downsell"><i class="fas fa-trash-alt"></i></a></li></ul></div></div></div></div>';
        $(addupsell).insertBefore(".funnel-listing .listing-main:nth-last-child(2)");
        
        $('.product-column').removeClass('active');
        $(".listing-main").find(".list-item").removeClass('active');
        console.log("count; ", count)
        if (count == 5) {
            $(".add-upsell").hide()
        } else {
            $(".add-upsell").show()
        }
    });
    
    $(document).on('click',".add-dnsell",function () {
        var parentupsellid = $(this).parent().parent().find('.edit-btn').data('id');
        //alert(parentupsellid);
         var adddnsell = '<div class="list-item d-flex align-items-center px-3 py-3"><div class="list-item-icon"><img src="/images/downsell.svg" alt=""></div><div class="list-item-content"><h5>Downsell</h5><p>Product name here</p></div><div class="list-item-button"><ul><li><a href="javascript:void(0)" class="view-btn" data-id="" data-type="downsell"><i class="fas fa-eye"></i></a></li><li><a href="javascript:void(0)" class="edit-btn" data-parentupsellid="'+parentupsellid+'" data-id="" data-type="downsell"><i class="fas fa-edit"></i></a></li><li><a href="javascript:void(0)" class="deletedownsell" data-id="" data-type="downsell"><i class="fas fa-trash-alt"></i></a></li></ul></div></div>';
         $(this).parent().html(adddnsell);
    });

$(".click-to-edit").click(function () {
    var title_html = $.trim($(this).siblings(".funnel-title").text()); 
    var actionfor = $(this).siblings(".fw-bold").text()
    if(actionfor=='Tag:'){
        var title_input = '<input type="text" name="updatefunneltag" id="updatefunneltag" class="form-control" value="'+title_html+'" maxlength="100" minlength="10">';
    }else{
        var title_input = '<input type="text" name="updatefunnelname" id="updatefunnelname" class="form-control" value="'+title_html+'" maxlength="100" minlength="10">';
    }
    $(this).siblings(".funnel-title").html("")
    $(this).siblings(".funnel-title").append(title_input)
    $(this).parent().find(".click-to-cancel").show()
    $(this).parent().find(".click-to-update").show()
    $(this).hide();
});

$(".click-to-cancel").click(function () {    
    var actionfor = $(this).siblings(".fw-bold").text()
    if(actionfor=='Tag:'){
        var title_html = $("#updatefunneltag").val();
    }else{
        var title_html = $("#updatefunnelname").val();
    }
    $(this).siblings(".funnel-title").html(title_html)
    $(this).parent().find(".click-to-edit").show()
    $(this).parent().find(".click-to-update").hide()
    $(this).hide();
});
$("#discountamount").bind("keypress", function (e) {
    var keyCode = e.which ? e.which : e.keyCode

    if ((keyCode == 43)) {
      return true;
    }else if (!(keyCode >= 48 && keyCode <= 57 )){
    return false;
    }
});
$(document).on("click",".updatefunnelinfo",function () {   
    if($('#updatefunnelname').val()){
        var funnelname = $("#updatefunnelname").val();  
    }else{
        var funnelname = '';
    }   
    if($('#updatefunneltag').val()){
        var funneltag = $("#updatefunneltag").val(); 
    }else{
        var funneltag = ''; 
    }
   var funnelid = $('input[name="funnelid"]').val();
   var csrftoken = $('input[name="_token"]').val();
   var current = $(this);
    $.ajax({
        url: UPDATEURL,
        type: 'POST',
        data: {name:funnelname ,id:funnelid,_token:csrftoken,tag:funneltag},
        async: true,
        success: function (response) {    
            const obj = JSON.parse(response);
            $(current).parent().find('.click-to-cancel').trigger('click');
            alert(obj.message);

        },
        error: function (jqXHR, exception) {
            alert(jqXHR.responseJSON.message);
        },
        timeout: 5000000,
    });
})

$(document).on("click","#savefunnelmain",function(){
    var totalupsell = $("[class*='updownsellgroup_']").length;
    var checkemptyupsell = false;
    var funnelID = $('input[name="funnelid"]').val();
    var _token = $('input[name="_token"]').val();
    var success = $(this).data('success');
    $("[class*='updownsellgroup_']").map(function() {

    if(this.textContent.includes('Product name here')){
        checkemptyupsell=true;
    }
  });
    if(totalupsell==0 || checkemptyupsell){
        alert('Not able to Save funnel with empty Upsell.');
    }else{
      //alert('Allgood');  
      $.ajax({
        url: ENABLEFUNNELURL,
        type: 'POST',
        data: {funnelID:funnelID ,_token:_token},
        async: true,
        success: function (response) {    
            const obj = JSON.parse(response);
            alert(obj.message);
            window.location.href = success;
        },
        error: function (jqXHR, exception) {
            alert(jqXHR.responseJSON.message);
        },
        timeout: 5000000,
    });
    }
});
$(document).on("click",".deleteupsell,.deletedownsell",function(){

var updnid = $(this).data('id');
var type = $(this).data('type');
var token = $('input[name="_token"]').val();
var funnelid = $('input[name="funnelid"]').val();
var current = $(this);
if(updnid=='' && type=='downsell'){
$(this).parent().parent().parent().parent().parent().html('<div class="add-updnsell add-dnsell ml-70"><div class="list-item d-flex align-items-center px-3"><div class="list-item-icon">+</div><div class="list-item-content"><p>Add an downsell</p></div></div></div>');
}else if(updnid!='' && type=='downsell'){
    $.ajax({
        url: DELETEFUNNELURL,
        type: 'POST',
        data: {updnid:updnid ,_token:token,type:type},
        async: true,
        success: function (response) {  
            $(current).parent().parent().parent().parent().parent().html('<div class="add-updnsell add-dnsell ml-70"><div class="list-item d-flex align-items-center px-3"><div class="list-item-icon">+</div><div class="list-item-content"><p>Add an downsell</p></div></div></div>');
            //const obj = JSON.parse(response);
           // alert(obj.message);
        },
        error: function (jqXHR, exception) {
            alert(jqXHR.responseJSON.message);
        },
        timeout: 5000000,
    });
}else if(updnid=='' && type=='upsell'){
    $(this).parent().parent().parent().parent().parent().remove();
    var totalupsell = $("[class*='updownsellgroup_']").length;
    if (totalupsell == 5) {
        $(".add-upsell").hide()
    } else {
        $(".add-upsell").show()
    }
}else if(updnid!='' && type=='upsell'){
    $.ajax({
        url: DELETEFUNNELURL,
        type: 'POST',
        data: {updnid:updnid,_token:token,type:type,funnelid:funnelid},
        async: true,
        success: function (response) {  
            $(current).parent().parent().parent().parent().parent().remove();
            //const obj = JSON.parse(response);
           // alert(obj.message);
           var totalupsell = $("[class*='updownsellgroup_']").length;
            if (totalupsell == 5) {
                $(".add-upsell").hide()
            } else {
                $(".add-upsell").show()
            }
        },
        error: function (jqXHR, exception) {
            alert(jqXHR.responseJSON.message);
        },
        timeout: 5000000,
    });
    
}

});
		
});
