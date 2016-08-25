<?php

global $woocommerce;
$wc_fields_additional=get_option('wc_fields_additional',array());

$all_products_name_array=get_all_products_name();
$all_categories_name_array=get_all_categories_name();

wp_enqueue_style( 'wdm_jquery_ui_css', plugins_url('/css/jquery-ui.css', __FILE__) );
wp_enqueue_style( 'wdm_bootstrap_css', plugins_url('/css/bootstrap.min.css', __FILE__) );
wp_enqueue_style( 'wdm_jquery_css', plugins_url('/css/jquery.dataTables.min.css', __FILE__) );
wp_enqueue_style( 'wdm_dataTables_css', plugins_url('/css/dataTables.bootstrap.min.css', __FILE__) );
wp_enqueue_style( 'wdm_jquerysctipttop_css', plugins_url('/css/jquerysctipttop.css', __FILE__) );
wp_enqueue_style( 'wdm_custom_css', plugins_url('/css/wdm-custom.css', __FILE__) );

wp_enqueue_script( 'wdm_jquery_js', plugins_url( '/js/jquery-1.11.3.min.js', __FILE__ ), 'jquery', false, true );
wp_enqueue_script( 'wdm_jquery_ui_js', plugins_url( '/js/jquery-ui.js', __FILE__ ), 'jquery', false, true );
wp_enqueue_script( 'wdm_columnFilter_js', plugins_url( '/js/jquery.dataTables.columnFilter.js', __FILE__ ), 'jquery', false, true );
wp_enqueue_script( 'wdm_dataTables_js', plugins_url( '/js/jquery.dataTables.js', __FILE__ ), 'jquery', false, true );
wp_enqueue_script( 'wdm_bootstrap_js', plugins_url( '/js/dataTables.bootstrap.js', __FILE__ ), 'jquery', false, true );
wp_enqueue_script( 'wdm_tabletoCSV_js', plugins_url( '/js/jquery.tabletoCSV.js', __FILE__ ), 'jquery', false, true );

wp_enqueue_script( 'wdm_custom_js', plugins_url( '/js/wdm-custom.js', __FILE__ ), 'jquery', false, true );

wp_localize_script( 'wdm_custom_js', 'wdm_all_products_name', $all_products_name_array );



?>
	<div id='wdm-user-listing-div'>
		<h1>Product Buyers</h1>

		<div>
			Hide column: <br>
			<input type="checkbox" class="toggle-vis" data-column="0"> Order Id <br>
			<input type="checkbox" class="toggle-vis" data-column="1"> Date <br>
			<input type="checkbox" class="toggle-vis" data-column="2"> Time <br>
			<input type="checkbox" class="toggle-vis" data-column="3"> Purchaser <br>
			<?php
			$column_id=4;
			foreach($wc_fields_additional as $key=>$values)
			{
				echo '<input type="checkbox" class="toggle-vis" data-column="'.$column_id.'"> '.$values['label'].' <br>';
				$column_id++;
			}
			?>
			<input type="checkbox" class="toggle-vis" data-column="<?php echo $column_id; ?>"> Products <br>
		</div>
		<br>
		<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
			<tr class='filter-row'>
				<th style="border: 0px"></th>
				<th style="border: 0px"></th>
				<th style="border: 0px"></th>
				<th style="border: 0px"></th>
				<?php
				foreach($wc_fields_additional as $key=>$values)
				{
					echo '<th style="border: 0px"></th>';
				}
				?>
				<th style="border: 0px"></th>
			</tr>
			<tr>
				<th data-pos='1'>Order Id</th>
				<th data-pos='2'>Date</th>
				<th data-pos='3'>Time</th>
				<th data-pos='3'>Purchaser</th>
				<?php
				$column_id=4;
				foreach($wc_fields_additional as $key=>$values)
				{
					echo '<th data-pos='.$column_id.'>'.$values['label'].'</th>';
					$column_id++;
				}
				?>
				<th data-pos='<?php echo $column_id; ?>'>Products</th>
				<th data-pos='<?php echo $column_id; ?>'>Quantities</th>
			</tr>
			</thead>
			<tbody>

			<?php
			global $wp_query;
			$args = array(
				'post_type' => 'shop_order',
				'post_status' => array('wc-processing','wc-completed'),
				'posts_per_page' => -1,
			);

			// The Query
			$wp_query=new WP_Query( $args );

			// The Loop
			while ( have_posts() ) : the_post();
				echo '<tr>';
				echo '<td>'.get_the_ID().'</td>';
				echo '<td>'.get_the_date('d/m/Y').'</td>';
				echo '<td>'.get_the_time().'</td>';
				echo '<td>'.get_post_meta( get_the_ID(),'_billing_first_name', true ).' '.
					get_post_meta( get_the_ID(),'_billing_last_name', true ).' &#60;'.
					get_post_meta( get_the_ID(),'_billing_email', true ).'&#62;</td>';
				foreach($wc_fields_additional as $key=>$values)
				{
					echo '<td>'.get_post_meta( get_the_ID(),$key, true ).'</td>';
				}

				$order_id=get_the_ID();
				$order = new WC_Order( $order_id );
				$items = $order->get_items();

				$order_items=array();
				$order_quantities=array();
				foreach ( $items as $item ) {
					$product_name = $item['name'];
					$product_id = $item['product_id'];
					$product_variation_id = $item['variation_id'];
					array_push($order_items,$product_name);
					array_push($order_quantities,$item['qty']);
				}
				echo '<td>'.implode(' , ',$order_items).'</td>';
				echo '<td>'.implode(' , ',$order_quantities).'</td>';
				echo '</tr>';
			endwhile;

			// Reset Query
			wp_reset_query();
			?>
			</tbody>
		</table>
		<div>
			<button id="export" data-export="export">Export</button>
		</div>
	</div>
<?php

function get_all_products_name(){

	$all_products=array();
	$args = array( 'post_type' => 'product', 'posts_per_page' => -1,);
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post(); global $product;
		//array_push($all_products,get_the_title());
		array_push($all_products, html_entity_decode(str_replace("&#8217;","'",get_the_title())) );
		//echo get_the_title();
	endwhile;
	wp_reset_query();
	sort($all_products);
	return $all_products;
}

function get_all_categories_name(){

	$all_categories=array();

	$args = array(
		'number'     => $number,
		'orderby'    => 'title',
		'order'      => 'ASC',
		'hide_empty' => $hide_empty,
		'include'    => $ids
	);
	$product_categories = get_terms( 'product_cat',$args);
	$count = count($product_categories);
	//echo $count;
	if ( $count > 0 ){
		foreach ( $product_categories as $product_category ) {
			array_push($all_categories,$product_category->name);
		}
	}
	return $all_categories;
}

?>
