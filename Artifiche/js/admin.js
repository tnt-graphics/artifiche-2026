/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Loadmore for Collection page 

jQuery(document).ready(function() {
    if (jQuery('.col-list').length) {
        var loadmore = jQuery('.artifiche-readmore');
        var itemcount = jQuery(".collection-item").length;
        if (itemcount < 5) {
            loadmore.hide();
        }
    }
    jQuery(document).on('click', '.artifiche-readmore', function() {
        var itemcount = jQuery(".collection-item").length;
        // var reachedkoll = 5;
        var tempScrollTop = jQuery(window).scrollTop();
        if (jQuery('.col-list').length) {

            var data = {
                action: 'kollektion_load_more',
                count: itemcount,
            };
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'post',
                data: data,
                beforeSend: function() {
                    loadmore.addClass('active');
                },
                complete: function() {
                    loadmore.removeClass('active');
                    // jQuery('html,body').animate({
                    //     scrollTop: jQuery('.col-list').prop("scrollHeight")
                    // }, 2000);
                    jQuery(window).scrollTop(tempScrollTop);
                },
                success: function(response) {

                    var posts = JSON.parse(response);
                    var countp = jQuery(posts[0]).filter('.collection-item').length;
                    console.log(countp);
                    if (posts == '' || (countp < 5)) {
                        console.log("empty");
                        loadmore.hide();
                    }
                    jQuery('.col-list').append(posts);
                },
                error: function() {}
            });
        }
    });
});



// Loadmore for shop page 
jQuery(document).ready(function() {

    if (jQuery('#poster').length) {
        var loadmore = jQuery('.artifiche-readmore');
        var itemcount = jQuery(".poster-single").length;
        if (itemcount < 20) {
            loadmore.hide();
        }
    }
    if (jQuery('.woocommerce-info').length) {
        // console.log(sss);
        var loadmore = jQuery('.artifiche-readmore');
        loadmore.hide();
    }
    jQuery(document).on('click', '#shop-loadmore', function() {

        // var reachedshop = 20;
        
        var tempScrollTop = jQuery(window).scrollTop();
        if (jQuery(".woo_grid").hasClass("selected")) {
            var show_type = "grid";
        } else {
            var show_type = "list";
        }
        if (jQuery('#poster').length) {
            var itemcount = jQuery(".poster-single").length;
            var shop_filter_query = jQuery("#shop_filter_query").val();

            
            var data = {
                action: 'shop_load_more',
                count: itemcount,
                show_type: show_type,
                shop_filter_query: shop_filter_query
            };
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'post',
                data: data,
                beforeSend: function() {
                    jQuery('#shop-loadmore').parent('.artifiche-readmore').addClass('active');
                },
                complete: function() {
                    // jQuery('html,body').animate({
                    //     scrollTop: jQuery('#poster').prop("scrollHeight")
                    // }, 2000);

                },
                success: function(response) {

                    var posts = JSON.parse(response);
                    var countp = jQuery(posts[0]).filter('.poster-single').length;
                  console.log(response)
                    if (posts == '' || (countp < 20)) {
                        loadmore.hide();
                    }
                    jQuery('#poster').append(posts);



                    jQuery(".poster-single .poster img").imagesLoaded(function() {
                        jQuery('.poster_grid').each(function() {
                            jQuery(this).find('.poster-single .poster').matchHeight({
                                byRow: true
                            });
                        });
                        jQuery('#shop-loadmore').parent('.artifiche-readmore').removeClass('active');

                        jQuery(window).scrollTop(tempScrollTop);
                    });

                    var itemcount1 = jQuery(".poster-single").length;
                    // console.log(itemcount1);
                    // console.log(reachedshop);
                    // if (itemcount1 != reachedshop) {
                    //     loadmore.hide();
                    // }
                    jQuery('.cnt_poster').html(itemcount1);



                },
                error: function() { }
            });
        }
    });
});

// jQuery(document).ready(function() {

//     let thisItem = jQuery('.artifiche-readmore');
//     var reachedshop = 20;

//     jQuery(window).scroll(function() {
//         var loadmore = jQuery('.artifiche-readmore');


//         if (jQuery(".woo_grid").hasClass("selected")) {
//             var show_type = "grid";
//         } else {
//             var show_type = "list";
//         }
//         if (jQuery('#poster').length) {
//             var itemcount = jQuery(".poster-single").length;
//             var shop_filter_query = jQuery("#shop_filter_query").length;


//             if (itemcount < 20) {
//                 loadmore.hide();
//             }
//             if (jQuery(window).scrollTop() >= jQuery('#poster').offset().top + jQuery('#poster').outerHeight() - window.innerHeight) {

//                 if (reachedshop == itemcount) {
//                     var data = {
//                         action: 'shop_load_more',
//                         count: itemcount,
//                         show_type: show_type,
//                         shop_filter_query: shop_filter_query
//                     };
//                     jQuery.ajax({
//                         url: ajax_object.ajax_url,
//                         type: 'post',
//                         data: data,
//                         beforeSend: function() {
//                             loadmore.addClass('active');
//                         },
//                         complete: function() {
//                             loadmore.removeClass('active');
//                         },
//                         success: function(response) {
//                             // alert(response)
//                             // setTimeout(function() {

//                             var posts = JSON.parse(response);
//                             if (posts == '') {
//                                 loadmore.hide();
//                             }
//                             jQuery('#poster').append(posts);
//                             jQuery('#poster .poster-single .poster').matchHeight({
//                                 byRow: true
//                             });

//                             console.log('posts appended');
//                             var itemcount1 = jQuery(".poster-single").length;
//                             if (itemcount1 != reachedshop) {
//                                 loadmore.hide();
//                             }
//                             jQuery('.cnt_poster').html(itemcount1);



//                         },
//                         error: function() {}
//                     });
//                     reachedshop = reachedshop + 20;
//                 }
//                 //code to load content
//             }
//         }

//     });

// });



// Loadmore for News List page 

jQuery(document).ready(function() {
    if (jQuery('.artifiche-newslist').length) {
        var loadmore = jQuery('.artifiche-readmore');
        var itemcount = jQuery(".news-list-single").length;
        if (itemcount < 5) {
            loadmore.hide();
        }
    }
    jQuery(document).on('click', '#news-loadmore', function() {
        var itemcount = jQuery(".news-list-single").length;
        var news_view_type = jQuery("#news_view_type").val();
        var news_cat_val = jQuery("#news_cat_val").val();
        var tempScrollTop = jQuery(window).scrollTop();
        if (jQuery('.artifiche-newslist').length) {

            var data = {
                action: 'news_load_more',
                count: itemcount,
                news_view_type: news_view_type,
                news_cat_val: news_cat_val
            };
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'post',
                data: data,
                beforeSend: function() {
                    loadmore.addClass('active');
                },
                complete: function() {
                    loadmore.removeClass('active');
                    jQuery(window).scrollTop(tempScrollTop);
                },
                success: function(response) {

                    var posts = JSON.parse(response);
                    var countp = jQuery(posts[0]).filter('.news-list-single').length;
                    if (posts == '' || (countp < 5)) {
                        loadmore.hide();
                    }
                    jQuery('.artifiche-newslist').append(posts);
                },
                error: function() {}
            });
        }

    });

});



// Loadmore for Taxonomy List page 

jQuery(document).ready(function() {

    if (jQuery('.tax-all-list').length) {
        var loadmore = jQuery('.tax-loadmore');
        var itemcount = jQuery('.tax-all-list .poster-single').length;
        var posterTotal = parseInt(jQuery('#kollektionen-poster-total').val(), 10) || 0;
        if (posterTotal > 0 && itemcount >= posterTotal) {
            loadmore.hide();
        } else if (itemcount < 20) {
            loadmore.hide();
        }
    }
    jQuery(document).on('click', '.tax-loadmore', function() {
        var tax_page_type = jQuery("#tax-readmore-name").val();
        var current_tax = jQuery("#current-tax").val();
        var plakatzuweisungen = jQuery("#kollektionen-plakatzuweisungen").val() || '';
        var itemcount = jQuery('.tax-all-list .poster-single').length;
        var posterTotal = parseInt(jQuery('#kollektionen-poster-total').val(), 10) || 0;
        var tempScrollTop = jQuery(window).scrollTop()
        if (jQuery('.tax-all-list').length) {
            var data = {
                action: 'tax_load_more',
                count: itemcount,
                tax_page_type: tax_page_type,
                current_tax: current_tax,
                plakatzuweisungen: plakatzuweisungen
            };
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'post',
                data: data,
                beforeSend: function() {
                    loadmore.addClass('active');
                },
                complete: function() {

                    // jQuery('html,body').animate({
                    //     scrollTop: jQuery('.tax-all-list').prop("scrollHeight")
                    // }, 2000);
                    // jQuery(window).scrollTop(tempScrollTop);
                },
                success: function(response) {

                    var posts = JSON.parse(response);
                    var countp = jQuery(posts[0]).filter('.poster-single').length;
                    if (posts == '' || countp === 0 || (posterTotal > 0 && jQuery('.tax-all-list .poster-single').length + countp >= posterTotal)) {
                        loadmore.hide();
                    }
                    jQuery('.tax-all-list').append(posts);
                    jQuery(".tax-all-list .poster img").imagesLoaded(function() {
                        jQuery('.tax-all-list').each(function() {
                            jQuery(this).find('.poster-single .poster').matchHeight({
                                byRow: true
                            });
                        });
                        loadmore.removeClass('active');
                        jQuery(window).scrollTop(tempScrollTop);

                    });

                },
                error: function() {}
            });
        }

    });

});


// Loadmore for Similar/Tag Posts List page 

jQuery(document).ready(function() {

    if (jQuery('.similartag-list').length) {
        var loadmore = jQuery('.artifiche-readmore');
        var itemcount = jQuery(".poster-single").length;
        if (itemcount < 20) {
            loadmore.hide();
        }
    }
    jQuery(document).on('click', '#similar-loadmore', function() {
        var itemcount = jQuery(".poster-single").length;
        var similarload_type = jQuery("#similarload_type").val();
        var tempScrollTop = jQuery(window).scrollTop();
        if (similarload_type == 'similar_product') {
            var p_query = jQuery("#similar_query").val();
        } else {
            var p_query = jQuery("#tag_query").val();
        }

        if (jQuery('.home-collection-list').length) {

            var data = {
                action: 'similar_load_more',
                count: itemcount,
                similar_query: p_query,
            };
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'post',
                data: data,
                beforeSend: function() {
                    loadmore.addClass('active');
                },
                complete: function() {},
                success: function(response) {

                    var posts = JSON.parse(response);
                    var countp = jQuery(posts[0]).filter('.poster-single').length;
                    if (posts == '' || (countp < 20)) {
                        loadmore.hide();
                    }
                    jQuery('.posters').append(posts);
                    jQuery(".poster_grid .poster img").imagesLoaded(function() {
                        jQuery('.poster_grid').each(function() {
                            jQuery(this).find('.poster-single .poster').matchHeight({
                                byRow: true
                            });
                        });
                        loadmore.removeClass('active');

                        jQuery(window).scrollTop(tempScrollTop);
                    });
                },
                error: function() {}
            });
        }

    });

});


jQuery(".woo_list").on("click", function() {

    jQuery("ul.products").addClass("poster_list");
    jQuery("ul.products").removeClass("poster_grid");
    jQuery(".poster_list_caption").show();
    jQuery(".caption").hide();
    jQuery(this).addClass("selected");
    jQuery(".woo_grid").removeClass("selected");

});
jQuery(document).on('click', '.woo_grid', function() {

    jQuery('.poster_grid').each(function() {
        jQuery(this).find('.poster-single .poster').matchHeight({
            byRow: true
        });
    });
    jQuery(this).addClass("selected");
    jQuery(".woo_list").removeClass("selected");
    jQuery("ul.products").removeClass("poster_list");
    jQuery("ul.products").addClass("poster_grid");
    jQuery(".poster_list_caption").hide();
    jQuery(".caption").show();
});

// jQuery(".jahr-sort").on("click",function(){

//  jQuery(".cc-choice-sort").removeClass("selected");
//  jQuery(this).addClass("selected");

// });

// jQuery(".cc-choice-sort").on("click",function(){

//  jQuery(".cc-choice-sort").addClass("selected");
//  jQuery(".jahr-sort").removeClass("selected");

// });
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);

    if(sPageURL.indexOf('&') != -1){
        sURLVariables = sPageURL.split('&');
    }else{
        sURLVariables = sPageURL.split('?');
    }      
      var sParameterName;
      var i;

    for (i = sURLVariables.length - 1; i >= 0; i--) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};
    

jQuery(document).ready(function() {
    var sort = getUrlParameter('sort');
 
    if (sort == "jahr-asc" || sort == "jahr-desc" ) {

        jQuery("a.jahr-sort").addClass("selected");
        jQuery("a.cc-choice-sort").removeClass("selected");
           }
    else if (sort == "price-asc" || sort == "price-desc" ) {
        jQuery("a.price-sort").addClass("selected");
    }else{

    }
    // if (window.location.href.indexOf("sort=jahr") > -1) {

    //     jQuery("a.jahr-sort").addClass("selected");
        
    // } else if (window.location.href.indexOf("sort=price") > -1){
    //      jQuery("a.price-sort").addClass("selected");
    // }else{

    // }

 var cc_flag = Cookies.get('artf_cc_flag');
        if( cc_flag == 'true' ){
            jQuery("a.cc-choice-sort").addClass("selected");
        }else{
            jQuery("a.cc-choice-sort").removeClass("selected");

        }

    // if (window.location.href.indexOf("sortby=cchoice") > -1) {

    //     jQuery("a.cc-choice-sort").addClass("selected");
    //   //   jQuery("a.jahr-sort").removeClass("selected");
        
    // } else {
    //     jQuery("a.cc-choice-sort").removeClass("selected");
    // }

    // if (window.location.href.indexOf("sortby=sale") > -1) {

    //     jQuery("a.sale-sort").addClass("selected");
    //   //   jQuery("a.jahr-sort").removeClass("selected");
        
    // } else {
    //     jQuery("a.sale-sort").removeClass("selected");
    // }

    var sale_flag = Cookies.get('artf_sale_flag');
        if( sale_flag == 'true' ){
            jQuery("a.sale-sort").addClass("selected");
        }else{
            jQuery("a.sale-sort").removeClass("selected");

        }

  if (window.location.href.indexOf("?") > -1) {
    jQuery('html, body').animate({
            scrollTop: jQuery(".searchform").offset().top
        }, 2000);
  }

jQuery(".jahr-sort").on('click', function() {
        var url = document.location.href;
        if (window.location.href.indexOf("?sort=jahr-desc") > -1) {//alert()
          
            if (window.location.href.indexOf("&") > -1) {
                    var r_string = 'sort=jahr-desc&';
                    var new_url = url.replace(r_string, "sort=jahr-asc&");
                }
            else { 
                    var r_string = '?sort=jahr-desc'; 
                    var new_url = url.replace(r_string, "?sort=jahr-asc");
                }
                var url = new_url.replace( "&sort=price-desc", '' );
                var url = new_url.replace( "&sort=price-asc", '' );
            

        }else if (window.location.href.indexOf("?sort=jahr-asc") > -1) {
            if (window.location.href.indexOf("&") > -1) {
                    var r_string = 'sort=jahr-asc&';
                    var new_url = url.replace(r_string, "sort=jahr-desc&");
                }
            else {
                    var r_string = '?sort=jahr-asc'; 
                    var new_url = url.replace(r_string, "?sort=jahr-desc");
                }
            var url = new_url.replace( "&sort=price-desc", '' );
            var url = new_url.replace( "&sort=price-asc", '' );
            
        }else if (window.location.href.indexOf("&sort=jahr-asc") > -1) {
             var r_string = '&sort=jahr-asc'; 
             var new_url = url.replace(r_string, "&sort=jahr-desc");
             var url = new_url.replace( "&sort=price-desc", '' );
             var url = new_url.replace( "&sort=price-asc", '' );
        }else if (window.location.href.indexOf("&sort=jahr-desc") > -1) {
             var r_string = '&sort=jahr-desc'; 
             var new_url = url.replace(r_string, "&sort=jahr-asc");
             var url = new_url.replace( "sort=price-desc", '' );
             var url = new_url.replace( "sort=price-asc", '' );
        }
        else {
             if (window.location.href.indexOf("?") > -1) {
                    var r_string = '&sort=jahr-asc';
                }
            else { 
                var r_string = '?sort=jahr-asc'; 
                } 
            var new_url = url + r_string;
            var url = new_url.replace( "sort=price-desc", '' );
            var url = new_url.replace( "sort=price-asc", '' );
           
        }
         
         document.location = url;
    });
    jQuery(".cc-choice-sort").on('click', function() {

         var cc_flag = Cookies.get('artf_cc_flag');
        console.log('flag'+cc_flag)
        if( cc_flag == 'true' ){

            Cookies.remove('artf_cc_flag');

        }else{
            Cookies.set('artf_cc_flag', true);

        }
        console.log(cc_flag)
       var url = document.location.href;
       document.location = url;

       /* var url = document.location.href;
        if (window.location.href.indexOf("?sortby=cchoice") > -1) {         
            if (window.location.href.indexOf("&") > -1) {
                    var r_string = 'sortby=cchoice&';
                }
            else { 
                var r_string = '?sortby=cchoice'; 
                }   
            var new_url = url.replace(r_string, "");

        } else if (window.location.href.indexOf("&sortby=cchoice") > -1) { 
            var new_url = url.replace("&sortby=cchoice", "");
        }else {
              if (window.location.href.indexOf("?") > -1) {
                    var r_string = '&sortby=cchoice';
                }
            else { 
                var r_string = '?sortby=cchoice'; 
                } 
            var new_url = url + r_string;
            
        }
        document.location = new_url;*/
    });

jQuery(".menu li a").on('click', function(){
    var sale_flag = Cookies.get('artf_sale_flag');
    var cc_flag = Cookies.get('artf_cc_flag');
    if( sale_flag == 'true' ){
            Cookies.remove('artf_sale_flag');
        }
        if( cc_flag == 'true' ){

            Cookies.remove('artf_cc_flag');

        }
});
    jQuery(".sale-sort").on('click', function() {

        var sale_flag = Cookies.get('artf_sale_flag');
        console.log('flag'+sale_flag)
        if( sale_flag == 'true' ){

            Cookies.remove('artf_sale_flag');

        }else{
            Cookies.set('artf_sale_flag', true);

        }
        console.log(sale_flag)
       var url = document.location.href;
       document.location = url;
/*if (window.location.href.indexOf("?sortby=sale") > -1) {         
            if (window.location.href.indexOf("&") > -1) {
                    var r_string = 'sortby=sale&';
                }
            else { 
                var r_string = '?sortby=sale'; 
                }   
            var new_url = url.replace(r_string, "");

        } else if (window.location.href.indexOf("&sortby=sale") > -1) { 
            var new_url = url.replace("&sortby=sale", "");
        }else {
              if (window.location.href.indexOf("?") > -1) {
                    var r_string = '&sortby=sale';
                }
            else {
                var r_string = '?sortby=sale'; 
                }
            var new_url = url + r_string;
            
        }
        document.location = new_url;*/
         
    });
    
    jQuery(".price-sort").on('click', function() {
        var url = document.location.href;
        if (window.location.href.indexOf("?sort=price-desc") > -1) {
            if (window.location.href.indexOf("&") > -1) {
                    var r_string = 'sort=price-desc&';
                    var new_url = url.replace(r_string, "sort=price-asc&");
                }
            else { 
                var r_string = '?sort=price-desc'; 
                var new_url = url.replace(r_string, "?sort=price-asc");
                }   

        }else if (window.location.href.indexOf("?sort=price-asc") > -1) {
            if (window.location.href.indexOf("&") > -1) {
                    var r_string = 'sort=price-asc&';
                    var new_url = url.replace(r_string, "sort=price-desc&");
                }
            else { 
                var r_string = '?sort=price-asc'; 
                var new_url = url.replace(r_string, "?sort=price-desc");
                }   
        }else if (window.location.href.indexOf("&sort=price-asc") > -1) {
             var r_string = '&sort=price-asc'; 
             var new_url = url.replace(r_string, "&sort=price-desc");
        }else if (window.location.href.indexOf("&sort=price-desc") > -1) {
             var r_string = '&sort=price-desc'; 
             var new_url = url.replace(r_string, "&sort=price-asc");
        } else {
            if (window.location.href.indexOf("?") > -1) {
                    var r_string = '&sort=price-asc';
                }
            else { 
                var r_string = '?sort=price-asc'; 
                } 
            var new_url = url + r_string;
        }
         var url = new_url.replace( "sort=jahr-desc", '' );
         var url = new_url.replace( "sort=jahr-asc", '' );
         document.location = url;
    });

});

jQuery(document).ready(function() {
  /*  if (jQuery("input[name='shipping_method[0]']").length) {

        var shipping = jQuery("input[name='shipping_method[0]']").val();

        if (String(shipping) == String('flat_rate:4')) {
            jQuery("#customer_details").hide();
            // alert(jQuery("div#payment").attr("class"))
        }

    }
*/


    if (jQuery(".kategorie-list").length) {

    }

    jQuery(".filter_back").on('click', function() {

        var referrer = document.referrer;
        var shop_url = jQuery(".shop_url").val();
        var site_url = jQuery(".site_url").val();

        if (referrer.indexOf(shop_url) != -1) {

            window.location = shop_url;
        } else {
            window.location = site_url;
        }
    });

    jQuery(".sold_posters").on('click', function() {

        if (jQuery(this).prop("checked") == true) {
            jQuery(this).val("1");
            jQuery(".sold_posters").val("1");
            jQuery(".sold_posters_hid").remove();
        } else {

            jQuery(this).val("0");
            jQuery('<input type="hidden" class="sold_posters sold_posters_hid" name="sold_posters" value="0" />').insertBefore('.sold_posters');


            jQuery(".sold_posters").val("0");
        }

    });

    jQuery(".ajax_add_to_cart").on('click', function() {

        jQuery(".ahnliche-plakate").hide();

    });

      jQuery("#sold_posters").click(function(){
        if (jQuery(this).is(":checked")){
                // jQuery(".sold-poster").hide();
                if (window.location.href.indexOf("&sold_posters=") > -1) {

                 var url = document.location.href;
                  var new_url = url.replace("&sold_posters=0", "&sold_posters=1");
                 document.location = new_url;
                

                } 
                else {

                var url = document.location.href;
                if (window.location.href.indexOf("?") > 0) {

                    var url = url + "&sold_posters=1";
                }
                else { 

                    var url = url + "?sold_posters=1"; 
                    }      
                     setTimeout(function(){ document.location = url; }, 300);
                // 
                }
            }
           else {
                // jQuery(".sold-poster").show();
                if (window.location.href.indexOf("&sold_posters=") > -1) {

                var url = document.location.href;
                var new_url = url.replace("&sold_posters=1", "&sold_posters=0");
                document.location = new_url;

                } else {
                    var url = document.location.href;
                   if (window.location.href.indexOf("?") > -1) {
                        var url = url +"&sold_posters=0";
                    }
                    else { 
                        var url = url +"?sold_posters=0";
                        }
                        setTimeout(function(){ document.location = url; }, 300);          
                 }
            }
        });
        jQuery(".csold_posters").click(function(){
            if (jQuery(this).is(":checked")){
                Cookies.set('sold_posters', true);       
            }else{
                Cookies.remove('sold_posters');
                }

        });
        jQuery(".reload").click(function(){
            if (jQuery(this).is(":checked")){
                Cookies.set('sold_posters', true);
                document.location = document.location.href;
            }else{
                Cookies.remove('sold_posters');
                document.location = document.location.href;
            }

        });
       
});