  jQuery(function() {
    jQuery( "#datepicker" ).datepicker();
  });
jQuery(document).ready(function() {
    jQuery('input.toggle-vis').change(function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = jQuery('#example').DataTable().column( jQuery(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
        date_filter_column();
    } );
} );
jQuery(document).ready(function($) {
          //console.log(wdm_all_products_name);

               // jQuery('#example').DataTable();
				$.datepicker.regional[""].dateFormat = 'dd/mm/yy';
                $.datepicker.setDefaults($.datepicker.regional['']);
				jQuery("#export").click(function(){
					jQuery("#example").tableToCSV();
                    //var search_field_wrapper=jQuery('.filter_column.filter_date_range').parent();
					//jQuery('.filter_column.filter_date_range').unwrap();
					//
					//jQuery('.filter_column.filter_date_range').wrap(search_field_wrapper);
				});
				
				jQuery('#example').dataTable()
				.columnFilter({ 	sPlaceHolder: "head:before",
				aoColumns: [null,
				            { type: "date-range" }]
				});
				
				
					function getWords(str) {
    return str.split(/\s+/).slice(0,3).join(" ");
}
jQuery( "th[data-pos]" ).each(function() {
  jQuery( this ).attr('title',jQuery( this ).text());
  //jQuery( this ).text(getWords(jQuery( this ).text()));
});
    
				date_filter_column();
				// <input type="radio" name="search-type" value="category"> Category Search
				jQuery('[type=search]').parent().append('<form><input type="radio" name="search-type" value="normal" checked> Normal Search <input type="radio" name="search-type" value="product"> Product Search</form>');
				jQuery('[type=search].form-control').attr('id','wdm-search');
				  jQuery('#wdm-search').after('<select id="search-dropdown"></select>');
                                        jQuery("#search-dropdown").find('option').remove();
                                        jQuery("#search-dropdown").append('<option value="">All Products</option>');
                                        for(i=0; i < wdm_all_products_name.length; i++){
                                            jQuery("#search-dropdown").append('<option value="'+wdm_all_products_name[i]+'">'+wdm_all_products_name[i]+'</option>');
                                        }
                                        jQuery("#search-dropdown").hide();
                                        
    jQuery('#search-dropdown').change(function () {
        
        
    var table = jQuery('#example').DataTable();
 table
        .columns( jQuery('th[title=Product]').attr('data-pos') )
        .search(this.value ?  '(^'+this.value+'$)|( , '+this.value+'$)|(^'+this.value+' , )|( , '+this.value+' , )': '', true, false)
        .draw();
        
    } );
    jQuery('[name=search-type]').click(function (){
						switch(jQuery(this).val()){
								case 'normal':
										jQuery('#wdm-search').attr('type','search');
										console.log('normal');
                                        clear_filter_redisplay();
                                        jQuery('#wdm-search').show();
                                        jQuery('#search-dropdown').hide();
                                        
										break;
								
								case 'product':
										console.log('product');
                                        clear_filter_redisplay();
                                        jQuery("#search-dropdown option:first").attr("selected", true);
                                        jQuery('#wdm-search').hide();
                                        jQuery('#search-dropdown').show();
										break;
								default:
										jQuery('#wdm-search').attr('type','search');
						}
						
				});
				
				jQuery('.ui-autocomplete .ui-menu-item').click(function(){
						alert(jQuery(this).val());
					});
				
				//jQuery('.filter-row').hide();
				//jQuery('.col-sm-6').removeClass('col-sm-6').addClass('col-sm-4');
				//var datefilter = jQuery('.filter_column.filter_date_range').html();
				//jQuery('<div class="col-sm-4 wdm-filter-date"> '+ datefilter  +' </div>').insertAfter(jQuery('.dataTables_length').parent());
                
                jQuery('input[name=search-type][value=product]').click();
        } );

function date_filter_column(){
    var TRs=jQuery('.filter_column.filter_date_range').parent().siblings().length;
	jQuery('.filter_column.filter_date_range').parent().siblings().remove();
	jQuery('.filter_column.filter_date_range').parent().attr('colspan',TRs+1);
}
function clear_filter_redisplay(){
    var table = jQuery('#example').DataTable();
table
 .search( '' )
 .columns().search( '' )
 .draw();
}
