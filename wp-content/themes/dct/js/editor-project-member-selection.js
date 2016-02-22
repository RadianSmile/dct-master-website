// JavaScript Document

var listDiv;

// user for keyboard and mouseover selection
var listItems = new Array();
var selectedIndex = 0;


var selectedMembers = new Array();

jQuery(document).ready(function(e) {
		
		// if no this input
		if( jQuery('#project_member_input').length == 0 ) return;
		
		// put meta box right after title
		jQuery('#edit-slug-box').after( jQuery('#project_member') );
		
			// prevent submitting when hit enter
			jQuery(window).keydown(function(e) {
				
				if( jQuery('#project_member_input').is(':focus') )
				{
					if( e.keyCode == 13 ) {
						
						e.preventDefault();
						return false;
					}
				}
            });
			
		show_member_list(); // activate interval function
		
		// hide the listDiv from init
		jQuery('#project_member_input').focusout(function(e) {
            jQuery(listDiv).css('display','none');
        });
		
		// keyboard selection
		jQuery('#project_member_input').keydown( input_keyboard_selection );
		
		// init the member list div
		listDiv = document.createElement('div');
		jQuery(listDiv).addClass('editor-member-list');
		jQuery('#project_member_input').after(listDiv);
		
		// if already have member set, show it
		get_project_members_init();
	});

function get_project_members_init()
{
	var post_id = jQuery('#post_ID').val();
	jQuery.post( ajaxurl,{
		'action' : 'get_project_members',
		'post_id' : post_id
	}, function (response) {
		jQuery('#project_member_selected_show').html( response );
		
		var return_items = jQuery('#project_member_selected_show').children('div');
		for( var i=0; i< return_items.length; i++ )
		{
			var item_user_id = jQuery(return_items[i]).attr('id').replace('selected_','');
			selectedMembers[ item_user_id ] = true;
			jQuery(return_items[i]).mousedown(deselect_member);
		}
		
		// refresh the input 
		set_hidden_member_value();
	});
}

var last_search = '';
function show_member_list() {
	
	var inputItem = jQuery('#project_member_input');
	
	if( inputItem.is(':focus') )
	{
		if( last_search != inputItem.val() )
		{
			jQuery.post( ajaxurl,{
				'action' : 'find_project_member',
				'search_string' : inputItem.val(),
				'selected_users' : jQuery('#project_member_selected').val()
			}, function (response){
				
				console.log( response );
				
				if( response == '' )
					jQuery(listDiv).css('display','none');
				else
				{
					jQuery(listDiv).css('display','block');
					jQuery(listDiv).html( response );
					
					listItems = jQuery(listDiv).children('div');
					
					for( var i=0; i< listItems.length; i++ )
					{
						// setting st_id
						jQuery(listItems[i]).data('indexInList', i);
						jQuery(listItems[i]).mouseover(mouse_over_selection);
						jQuery(listItems[i]).mousedown(mouse_click_selection);
					}
					selectedIndex = 'f'; // means first
					//console.log( jQuery(listDiv).children('div') );
				}
			});
			last_search = inputItem.val();
		}
	}
	
	setTimeout( show_member_list, 500 );
		
}

function input_keyboard_selection(e)
{
	// enter : 13
	// up : 38
	// down : 40
	if( !jQuery('#project_member_input').is(':focus') ) return;
	if( listItems.length <= 0 ) return;
	
	if( e.keyCode == 40 )
		change_select_item( '+1' );
	else if( e.keyCode == 38 )
		change_select_item( '-1' );
	else if( e.keyCode == 13 )
	{
		item_selected( selectedIndex );
	}
}

function change_select_item( changeValue )
{
	var lastIndex = selectedIndex;
	var nextIndex = 0;
	
	if( changeValue === '-1' )
	{
		// if first press button
		if( selectedIndex == 'f' )
			nextIndex = listItems.length-1;
		else
			nextIndex = lastIndex -1;
	}
	else if( changeValue === '+1' )
	{
		if( selectedIndex == 'f' )
			nextIndex = 0;
		else
			nextIndex = (lastIndex +1) % listItems.length;
	}
	else // directly select an index
	{
		nextIndex = changeValue;
	}
	
	// if less than 0
	if( nextIndex < 0 ) nextIndex = listItems.length-1;
	
	jQuery(listItems[lastIndex]).css('background-color', 'transparent');	
	jQuery(listItems[nextIndex]).css('background-color', '#8ADFC9');
	
	selectedIndex = nextIndex;
}

function item_selected( s_index )
{
	var target_user_id = jQuery(listItems[ s_index ]).attr('id').replace('member_','');
	selectedMembers[ target_user_id ] = true;
	
	// setting value
	set_hidden_member_value();
	
	
	// display thumbnail in div
	var container = jQuery('#project_member_selected_show');
	var div = document.createElement('div');
	jQuery(div).addClass('selected-member-thumbnail');
	jQuery(div).attr('id', 'selected_' + target_user_id ); //store user_id
	jQuery(div).mousedown( deselect_member );
	
	var closeMark = document.createElement('span');
	jQuery(closeMark).text('X');
	jQuery(closeMark).addClass('close-mark');
		
	// add imgs and names in
	jQuery(div).append( jQuery(listItems[s_index]).children('img') );
	jQuery(div).append( jQuery(listItems[s_index]).children('span') );
	jQuery(div).append( closeMark );
	container.append( div );
	
	// clear everything
	jQuery('#project_member_input').val('');
	jQuery(listDiv).css('display','none');
	jQuery(listDiv).html('');
	selectedIndex = 'f';
	
}

function deselect_member( e )
{
	var user_id = jQuery(e.delegateTarget).attr('id').replace('selected_', '');
	jQuery(e.delegateTarget).remove();
	selectedMembers[ user_id ] = false;
	
	set_hidden_member_value();
}

function mouse_over_selection(e)
{
	var tagName = jQuery(e.target).prop('tagName');
	
	// if not over the div, it's its child, than target the parent
	if( tagName != 'DIV' )
	{
		var realTarget = jQuery( e.target ).parent('div');
		change_select_item( jQuery(realTarget).data('indexInList') );
	}
	else
		change_select_item( jQuery(e.target).data('indexInList') );

}

function mouse_click_selection(e)
{
	var tagName = jQuery(e.target).prop('tagName');
	
	// if not over the div, it's its child, than target the parent
	if( tagName != 'DIV' )
	{
		var realTarget = jQuery( e.target ).parent('div');
		item_selected( jQuery(realTarget).data('indexInList') );
	}
	else
		item_selected( jQuery(e.target).data('indexInList') );
}

function set_hidden_member_value()
{
	var hiddenInput = jQuery('#project_member_selected');
	var valueArray = new Array();
	
	for( var i in selectedMembers )
	{
		if( selectedMembers[i] == true )
			valueArray.push( parseInt(i) );
	}
	hiddenInput.val( JSON.stringify( valueArray ) );
}