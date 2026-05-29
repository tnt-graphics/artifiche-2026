<?php
$posters      = '';
	$labels       = '';
	$poster_title = '';
	$poster_list_label = '';
	$poster_title_list = '';
	$poster_title = '';
	$sub_cat_list_label = '';
	$size_list_label = '';
	$künstler_name = '';
	$main_cat_list_label = '';
	$kunstler_list_label = '';
	$price_list_label = '';
	$künstler_woy = '';
                $image_id    = get_post_meta( $post->ID, 'plakatnummer', true );
                $new_flag    = get_post_meta( $post->ID, 'neu_flag', true );
                $jahr        = get_post_meta( $post->ID, 'jahr', true );
                $breite_cm   = get_post_meta( $post->ID, 'breite_cm', true );
                $breite_inch = get_post_meta( $post->ID, 'breite_inch', true );
                $hohe_cm     = get_post_meta( $post->ID, 'hohe_cm', true );
				$hohe_inch   = get_post_meta( $post->ID, 'hohe_inch', true );
				$sale_flag   = get_post_meta( $post->ID, 'sale_flag', true );
				$sale_option = get_field( 'sale_option', 'option' );
				
               // $price       = get_post_meta( $post->ID, 'unit_price', true );
				$product     = wc_get_product( $post->ID );				
				$regular_price      = $product->get_regular_price();
				$regular_price      = get_post_meta( $post->ID, 'preiskategorie_chf', true );
				$sale_price         = $product->get_sale_price();
				$internetpreis_flag = get_post_meta( $post->ID, 'internetpreis_flag', true );
				$stock_status       = $product->get_stock_status();
				// $price       = $product->get_price_html();
				$price       = get_dynamic_price_html( 'normal' );
                $collectors_choice_flag = get_post_meta( $post->ID, 'collectors_choice_flag', true);
				$purchase_limit     = get_field( 'purchase_limit', 'option' );
				$purchase_upper     = $purchase_limit + 1;
                $product_cat = get_the_terms( $post->ID, 'product_cat');

              //  $labels .= '<div class="poster-label">';
                if( $new_flag != '' && $new_flag == 1 ){
                    $labels .='<span class="poster-l-yellow">'.__( 'NEU','artifiche' ).'</span>';
                }
                if ( $collectors_choice_flag != '' && $collectors_choice_flag == 1 ) {

			// if ( $new_flag != '' && $new_flag == 1 ) {
			// 	$labels .= '<span class="separator">/</span>';
			// }

			$labels .= '<span class="poster-l-red">' . __( 'Collector’s Choice', 'artifiche' ) . '</span>';
		}
		if ( $stock_status == 'outofstock' ) {
			$labels .= '<span class="poster-l-grey">' . __( 'SOLD', 'artifiche' ) . '</span>';
		}
		if (! empty( $sale_option ) && $sale_option[0] == 'true' && get_dynamic_price_html( 'normal', true ) == true 
			&& $sale_flag == 1 ) {
			$labels .= '<span class="poster-l-cyan">' . __( 'SALE', 'artifiche' ) . '</span>';
		}
		
                if( get_the_title( $post->ID ) ){
                 	$poster_title = '<b class="poster_title bold-txt">'.get_the_title( $post->ID ).'</b>';

                }
                 $category_detail = get_the_terms( $post->ID, 'kunstler');
                 $k_flag = false;
                if( ! empty( $category_detail ) ){
                    
                    foreach( $category_detail as $cd ){
                       

                      $künstler_vorname = get_field( 'gestalter_vorname', $cd );
                      $künstle_name = get_field( 'gestalter_name', $cd );
                      $coma = ',';
					  if ($künstler_vorname != '' || $künstle_name != '') { 
					  
                      		$gestler = $künstler_vorname.' '. $künstle_name;                		
                      	
                      	  }
                      	  else{
                      		$gestler = explode("(", $cd->name)[0];         
                      	}
                      	
                        $künstler_name = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'.$gestler. $coma.$jahr.'</span></a>';    
                        $künstler_woy = '<a href="'. get_term_link( $cd ).'"><span class="kunstler_name">'. $gestler .'</span></a>';               				
                      	
                    }                    
                }else{
                	$k_flag = true;
                }
                
                if( $k_flag ) $künstler_name = '<span class="kunstler_name">'.$jahr.'</span>';

			    if( $jahr != '' )
			    	$jahr_list_label = '<span class="list_jahr">'.__( 'Jahr','artifiche' ).': </span><span class="jahr">'.$jahr.'</span><span> / </span>';
			    if( get_the_title( $post->ID ) ){
			    	$poster_title_list = '<h2>'.get_the_title( $post->ID ).'</h2>';

			    }

			    if( $künstler_name != '' )
			    	$kunstler_list_label = '<span class="list_kunstler">'.__( 'Künstler','artifiche' ).': </span>'.$künstler_vorname.' '.$künstle_name.'<span> / </span>';
			    
			    if( $breite_cm != '' || $breite_inch != '' || $hohe_cm != '' || $hohe_inch != '' ){

						$grosse = get_post_meta( $post->ID, 'grosse', true );
						$size_list_label = '';
						$size_list_label .= '<strong>' . __( 'Grösse:', 'artifiche' ) . ' </strong>'.$grosse;
						// $size_list_label .= $breite_cm . ' x ' . $hohe_cm . ' cm';
						// if ( ! empty( $breite_inch ) && ! empty( $hohe_inch ) ) {
						// 	$size_list_label .= ' / ' . $breite_inch . ' x ' . $hohe_inch.'″<br>';
						// }
			    }
			    if( $price != '')
			    	$price_list_label = '<span class="list_price">'.__( 'Preisklasse','artifiche' ).': </span>'.$price;
			    
			    if( ! empty( $product_cat ) ){

			    	foreach( $product_cat as $cat ){
			    			
			    		 if( $cat->parent == 0) $main_cat_list_label .= '<a href="'. get_term_link( $cat ).'"><span class="main_cat">'. $cat->name .'</span></a>';
			    			
			    		else $sub_cat_list_label .= '<a href="'. get_term_link( $cat ).'"><span class="sub_cat">'. $cat->name .'</span></a>';
			    	}
			    }
			   
			    $alt_text = artf_get_alt_text( $post->ID );

			       echo '<div class="poster-single">
			       		<a href="'. get_permalink( $post->ID ) .'">
			            <div class="poster">
			                <img src="' . site_url() . '/artifiche-images/posters_large/'. $image_id .'.jpg" alt="' . $alt_text . '" />
			            </div>
			            </a>
			            <div class="caption">
			                '. $labels .'
			               <a href="'. get_permalink( $post->ID ) .'">'. $poster_title .'</a>
			                '. $künstler_name .'
			                
			            </div>
			            <div class="poster_list_caption" style="display: none;">
			            	'. $labels .'
			               <a href="'. get_permalink( $post->ID ) .'">'. $poster_title_list .'</a>
			               '. $jahr_list_label .'
			               '. $kunstler_list_label .'
			               '. $size_list_label .'
			               <br/>
			               '. $price_list_label .'
			               <br/>
			               	<span class="catLabel">
			                '. $künstler_woy .'
			                '.$main_cat_list_label.'
			                '.$sub_cat_list_label.'
			                </span>
			            </div>
			        </div>';
			   
