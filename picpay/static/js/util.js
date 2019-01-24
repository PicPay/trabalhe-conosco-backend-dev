 /**
 * Util to support basic features. 
 * 
 * @author: Roberto Morati <robertomorati@gmail.com>
 */

// TODO: improve here to use env
IP = 'http://127.0.0.1:8080'
INFO_SERVER_REST = IP + '/api/v1/info/'
USER_SERVER_REST =  IP + '/api/v1/users/' 

/**
 * Update the content of a div.
 * 
 */
function refreshDiv(urlView,idDiv) {
	
	$.ajax({
		  url: urlView,
		  cache: false,
		  success: function(data) {
			 $('#'+idDiv).load(urlView);
		  },
		  error: function() { 
			  showNotification('top','center', 'Erro wheling update content', 1000,'danger');
			  
		  }
		});
}

/**
 * Basic info for the search
 * 
 * @param event
 * @returns
 */
var info_search =  null;
var data_search = null;
var first_load = true; // prevent bug with pagination lib

$(document).on('keyup','#target', function(event) {
	var key = event.which || event.keyCode || 0;
    if (key === 13) {
    	if ($('li.active').attr('id')=='search'){
    		var input = document.getElementById('target').value;

            if (!(!input || /^\s*$/.test(input))){
            	data_search = input;
                
            	// validation search text
                if(input.match(/[A-zÀ-ÿ]/g).length >= 2){
                	var url = INFO_SERVER_REST +input +'/';
                	get_info_search(url);
                }else
                	showNotification('top','center', 'The search text must be longer than (or equal) 2 characters', 1000,'warning');
                }else{
                	// OLD removed to preserve the server (robertomorati.com)
                    var url = INFO_SERVER_REST;
                    get_info_search(url);
                    data_search = null;
                    showNotification('top','center','Attention, please. The search returned all users.', 500,'info');
                }
            }else 
            	showNotification('top','center', 'To start the search, please select: Search API then Search User', 1000,'info');
    	}

});


/**
 * GET 
 * @param url
 * @returns
 */
function get_info_search(url){
	 $.ajax({ 
         type: "GET",
         url: url,
         success: function(data){        
            info_search = data;
		if (info_search['error'])
			showNotification('top','center', info_search['error'], 1000,'warning');
		else{
			if (info_search['success'])
				showNotification('top','center', info_search['success'], 1000,'success');
				first_load = true;
				pagination();
		}
         }
     });

}

/**
 * Removed: contains bug
 * @param url
 * @returns
 */
function old_get_info_search(url){
	$.get(url, function(response) {
		info_search = response;
		if (info_search['error'])
			showNotification('top','center', info_search['error'], 1000,'warning');
		else{
			if (info_search['success'])
				showNotification('top','center', info_search['success'], 1000,'success');
				first_load = true;
				pagination();
		}
	 });
}

/**
 * Pagination
 * @returns
 */
function pagination(){
	max = Math.ceil((info_search['pages']*5)/100);
	if (max > 10)
		max = 10
	$('#pagination-container').bootpag({
	    total: info_search['pages'],
	    page: 1,
	    maxVisible:max,
	    leaps: true,
	    firstLastUse: true,
	    first: 'first',
	    last: 'last',
	    wrapClass: 'pagination',
	    activeClass: 'active',
	    disabledClass: 'disabled',
	    nextClass: 'next',
	    prevClass: 'prev',
	    lastClass: 'last',
	    firstClass: 'first'
	}).on("page", function(event, num){
		get_content_page('#pagination-content',num);
	}); 
	
	//prevent 'bug' with pagination
	if (first_load){
		first_load = false;
		get_content_page('#pagination-content',1);
	}
}

/**
 * Get Content Page
 * 
 * TODO: improves here
 * @param iddiv
 * @param page
 * @returns
 */
function get_content_page(iddiv, page){
	if (info_search == null)
		showNotification('top','center', 'The page was reloaded, please start the search again.', 1000,'warning');
	else{
		  var url = null; 
		  if (!(!data_search || /^\s*$/.test(data_search))) 
			  url = USER_SERVER_REST+data_search+'/'+info_search['token']+'/'+ page + '/'; 
		  else 
			  url = USER_SERVER_REST+info_search['token']+'/'+ page + '/';

		$.get(url, function(response) { 
			if (response['error'])
			  showNotification('top','center', info_search['error'], 1000,'warning'); 
			else{ 
			  //showNotification('top','center', info_search['success'], 1000,'success');
			  $(iddiv).html(generate_html(response)); 
			} 
		  });
	}
}

/**
 * Build html
 * 
 * @param response
 * @returns
 */
function generate_html(response){
	
	var html = []
	
	for(u in response){
		html.push('<tr> <td>' + response[u]['id'] + '</td>' +
				  '<td>' + response[u]['username'] + '</td>' +
				  '<td>' + response[u]['full_name'] + '</td> </tr>');

	}

	return html
}