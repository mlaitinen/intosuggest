// ^.^ overwrite function isSuccess in mootools
//XHR.implement({
//	isSuccess: function(status){
//		return (((status >= 200) && (status < 300))||(status==404));
//	}
//});


//var jQuery = jQuery.noConflict();
var status_disp = false;
var vote_disp = false;
var status_disp1 = false;
var vote_disp1 = false;
var curr_tab = 0;
var url = "";
var urlCount = "";
var outVote_s = 0;
var clickVote_s = 0;
var curPos = null;

window.addEvent('domready',
	function () {		
		//$(document.body)
		document.addEvent("click",
			function () {			
				if (status_disp == true) {
					status_disp = false;
					status_disp1 = false;
					//closeForm('statusform');
					return;
				}
				if (vote_disp == true) {
					vote_disp = false;
					vote_disp1 = false;
					//closeForm('voteform');
					return;
				}
				if (status_disp1 == true) {
					status_disp = true;
				}
				if (vote_disp1 == true) {
					vote_disp = true;
				}
				if(document.getElementById("change_vote_"+idea_id))
					document.getElementById("change_vote_"+idea_id).style.display = "none";
			}
		)
	}
)

var idea_id = 0;
function onmove(id) {
	document.getElementById(id).style.background='#BBB';
}

function closeSBox(){
	SqueezeBox.bound.close();
//	$('sbox-window').close();
}

function onout(id) {
	document.getElementById(id).style.background='#FFF';
}

///
function sendData(tgUrl,id_form, data) {
	new Request({
		url: tgUrl,
        data: data,
		method: 'post',
		onComplete: function(txt){							
			//closeForm(id_form);							
		}
	}).send();
}


function getMousePosition(e)
{
	if (!e){
		e = e || window.event;
	}
	var res
	if( !e.pageX ) {
		res = {'x':e.clientX + document.documentElement.scrollLeft + document.body.scrollLeft, 'y':e.clientY + document.documentElement.scrollTop + document.body.scrollTop};
	} else {
		res = {'x':e.pageX, 'y':e.pageY}
		
	}
	return res;
}

function showMousePos(e)
{
	if (!e) e = event; // make sure we have a reference to the event
	
	var mp = getMousePosition(e);
	x=mp.x;
	y=mp.y;
	curPos = [mp.x, mp.y]
}
function init()
{
	document.onmousemove = showMousePos;
} 
init();
function closeForm(id_form){
	if (id_form != "") {
		document.getElementById(id_form).style.top = "-500px";
		document.getElementById(id_form).style.left = "-200px";
	}
}
function openForm(id_form){
	//alert(id_form)

	document.onmousemove = showMousePos;
	
	document.getElementById(id_form).style.top = (curPos[1]+10)+"px";
	document.getElementById(id_form).style.left = (curPos[0]-50)+"px";
	//alert(id_form)
}

function refreshIdea(id) {	
	var url = 'index.php?option=com_intosuggest&controller=idea&task=getIdea&id='+id+'&format=raw';
	var title_id = 'title'+id;
	var idea_id = 'idea'+id;
	var status_id = 'status'+id;
	var response_id = 'rps'+id;
	var vote_id = 'vote'+id; 
	var request = new Json.Remote(
		url,{			
		onComplete: function(jsonObj) {
			document.getElementById(title_id).innerHTML = jsonObj.idea[0].title;
			document.getElementById(idea_id).innerHTML = jsonObj.idea[0].fulltext;
			document.getElementById(status_id).innerHTML = jsonObj.idea[0].status;	
			//document.getElementById(vote_id).innerHTML =  "<p>"+jsonObj.idea[0].votes +"</p>";				
			document.getElementById(vote_id).innerHTML =  jsonObj.idea[0].votes ;
	}}).send();
}

function btnBackTopIdeas_click(forumId) {	
	var urlB = "index.php?option=com_intosuggest&forumId="+forumId
	changepage()
	//window.location = urlB;
	return
	//alert(urlB)
	var req = new Request({
		'url':urlB,
		method: 'post',
		onComplete: function(txt){
			document.getElementById('tab').innerHTML = txt;			
			var url = "index.php?option=com_intosuggest&controller=idea&task=topIdea&forum="+forumId+"&format=raw";			
			//getTab(url);
			//clickTab("TOP");
		}
	}).send();
	
	//location.href = 'index.php?option=com_intosuggest';
}

function lstVote_change(vote,idea_id) {			
	var url = "index.php";
    var data = {
        option: 'com_intosuggest',
        controller: 'idea',
        task: 'updateVote',
        id: idea_id,
        vote: vote,
        format: 'raw'
    };
	sendData(url, "", data);
}

function refesh(id,response){
	response = response.trim();
	if(response == "") {
		rps_content = '<a class="rs_add" href="javascript:addRepose(\'rps'+id+'\')">' + getAddResponseText() + '</a>'
		document.getElementById('rps'+id).innerHTML=rps_content;
	}
	else {
		rps_content = '<div id="rps-title'+id+'" class="rs_title">' + getAdminResponseText() + '</div>'
		rps_content += '<div id="rps-content'+id+'" class="rs_content">'+response+'</div>'
		rps_content += '<a class="rs_edit" onclick="addRepose(\'rps'+id+'\')" href="javascript:void(0);">' + getEditText() + '</a>'
		document.getElementById('rps'+id).innerHTML=rps_content;
	}	
}


function addRepose(id) {
	var num_id = id.substring(3);
	var cache = "cache_rps_content";
	cache += num_id;
	var oldValue = document.getElementById(cache).value;
	txt = "<textarea name='Response' style='width: 99%; border:1px dotted #6291D1;'></textarea>";
	txt +="<br />";
	txt += "<input type='button' onclick=\"addResponse('"+id+"')\" value='Save'/>";
	txt += "<input type='button' style=\"margin:0px 2px;\" onclick=\"refesh('"+num_id+"','"+oldValue+"')\" value='Cancel'/>";
	document.getElementById(id).innerHTML=txt;

	document.adminForm.Response.value = oldValue
	document.adminForm.Response.select();
}

function addResponse(sid) {
	var id = sid.substring(3);
	var response = document.adminForm.Response.value;
	var url = "index.php";
    var data = {
        option: 'com_intosuggest',
        controller: 'idea',
        task: 'addResponse',
        id: id,
        response: response
    };
	sendData(url, '', data);
	//refreshIdea(id);
	refesh(id,response);
	var cache = "cache_rps_content";
	cache += id;
	document.getElementById(cache).value = response;
}
function ondel(id) {
	var agress = confirm(getConfirmDeleteIdeaText());
	if (agress) {
		
		var url = "index.php?option=com_intosuggest&controller=idea&format=raw&task=delIdea&id="+id;
		if(typeof(getUserId) != 'undefined')
			url += "&user_id="+getUserId();
		new Request({
			'url': url,
			method:'post',
			onComplete:function(txt){
				document.location.reload(true);
			}
		}).send();
	}		
}
function newForm(id) {
//	SqueezeBox.fromElement('frm_New');
	SqueezeBox.fromElement( $(id), {parse: 'rel'} );
}

function onedit(id) {
	var edit_id = "frm_Edit_" + id;
	SqueezeBox.fromElement( $(edit_id), {parse: 'rel'} );
}

function closeAll(){
	//closeForm('voteform');
	//closeForm('statusform');
}

function rating (idea_id,parentid,num,total,width) {
	var str='';
	for (i=1;i<=num;i++) {
		str +="<li><a href=\"javascript:void(0);\" onclick=\"rating("+idea_id+",\'"+parentid+"\',"+i+","+total+","+width+");\" id=\"rate_"+i+"\" title=\""+i+" out of "+total+"\" class=\"selected-rate\" style=\"width:"+(num*width)+"px\" rel=\"nofollow\">"+i+"</a></li>";
	}
	for (j=num+1;j<=total;j++) {
		str +="<li><a href=\"javascript:void(0);\" onclick=\"rating("+idea_id+",\'"+parentid+"\',"+j+","+total+","+width+");\" id=\"rate_"+j+"\" title=\""+j+" out of "+total+"\" class=\"r"+j+"-unit rater\" rel=\"nofollow\">"+j+"</a></li>";	
	}
	document.getElementById(parentid).innerHTML=str;
}

function changepage() {	
	document.adminForm.task.value = 'changePage';
	document.adminForm.submit();
}

function autoclose() {
	//closeForm('voteform');
	//closeForm('statusform');
	clickVote_s = 0;
	outVote_s =0;
}
function outVote() { 
	if (clickVote_s == '1')
		outVote_s = 1;
	else outVote_s = 0;
}
function clickVote(){
	clickVote_s = 1;
}
function msgbox(txt) {
	alert( txt );
}

//default_search

function btnSearch_click() {
	var forum_id = getForumId()
	var key = document.getElementById('key_search').value;
	var auto_comp_url ="index.php?option=com_intosuggest&controller=idea&task=autoComplete&forum="+forum_id+"&key="+key+"&format=raw";
	var filter = key.trim();
	filter = filter.length;
	if (filter > 0)
		key = key.trim();
	if (key == "") return;
	url = "index.php?option=com_intosuggest&controller=idea&task=search&forum="+forum_id+"&key="+key+"&format=raw";	 		
	var tab = document.getElementById('tab'); tab.innerHTNL = '';
	var req = new Request({
		'url': url,
		method: 'post',
		onComplete: function(txt){
			tab.innerHTML = txt;
		}
	}).send();
}

///default tab

function getTab(tgUrl, id) {
	url = tgUrl;
	
	var old_container = document.getElementById('content_' + document.current_tab);
	if(old_container)
		old_container.innerHTML = "";
	
	document.current_tab = id;
	
	
	var container = document.getElementById('content_' + id);
	if(!container)
		return;
	var loading = new Element("div");
	loading.addClass('ajax-loading');
	container.innerHTML = "";
	loading.inject(container);
	
	var req = new Request({
		'url':url,
		'method': 'post',
		onComplete: function(numrow){
			container.innerHTML = numrow;	
			/*var sb = new Sortables('listidea', {
				
				clone:true,
				revert: true,
				
				initialize: function() { 
					
				},
				
				onStart: function(el) { 
					
				},
			
				onComplete: function(el) {
					//el.setStyle('background','#ddd');
					
				}
			})*/		
		}
			///Pagination(parseInt(numrow), 'Pagination')
	}).send();
}

function loadPage(url, container_id)
{
	var container = null;
	if(url.indexOf("idea")>=0 && url.indexOf("search")>=0)
	{
		container = document.getElementById("tab")	
	}
	else if(document.current_tab)	
	{
		container = document.getElementById('content_' + document.current_tab);
	}
	else if(url.indexOf("displayIdeas")>=0)
	{
		container = document.getElementById('content');	
	}
	else
		container = document.getElementById('contentComment');	
	var req = new Request({
		'url':url,
		method: 'post',
		onComplete: function(numrow){
			container.innerHTML = numrow;	
			///Pagination(parseInt(numrow), 'Pagination')
		}
	}).send();
}

function clickTab(id) {	
	
	
	var forumId = document.getElementById('forumId_selected').value;
	//id = id.substr(1);
	if (id == 'TOP') {		
		url = "index.php?option=com_intosuggest&controller=idea&task=topIdea&forum="+forumId+"&format=raw";
		urlCount = "index.php?option=com_intosuggest&controller=idea&task=topIdeaCount&forum="+forumId+"&format=raw";			
	}else if (id == 'HOT') {
		url = "index.php?option=com_intosuggest&controller=idea&task=hotIdea&forum="+forumId+"&format=raw";
		urlCount = "index.php?option=com_intosuggest&controller=idea&task=hotIdeaCount&forum="+forumId+"&format=raw";
	}else if (id == 'NEW') {
		url = "index.php?option=com_intosuggest&controller=idea&forum="+forumId+"&task=newIdea&format=raw";
		urlCount = "index.php?option=com_intosuggest&controller=idea&forum="+forumId+"&task=newIdeaCount&format=raw";
	}else {
		url = "index.php?option=com_intosuggest&controller=idea&task=IdeaWithStatus&status_id="+id+"&forum="+forumId+"&format=raw";
		urlCount = "index.php?option=com_intosuggest&controller=idea&task=IdeaWithStatusCount&status_id="+id+"&forum="+forumId+"&format=raw";
	}
	
	getTab(url, id);
	curr_tab = id;
	
}

///default status
var stt_idea_id = 0;
function clickStatus(id) {
	stt_idea_id = id;		
	status_disp1 = true;
}
function updateIdeaStatus(idea_id,stt_id) {		
	var url = "index.php?option=com_intosuggest&controller=idea&task=updateIdeaStatus&format=raw&id="+idea_id+"&status_id="+stt_id;
	
	var req = new Request({
		'url':url,
		method: 'post',
		onComplete: function(txt){	
			txt = txt.trim()					
			var cls = "" + txt.replace(" ", "_").toLowerCase();	
			if(txt == null || txt == ''){
				txt = 'No status'
				cls = "none"
			}
            document.location.reload(true);
		}
	}).send();
	
	return;
			
}

//default vote
function getY( oElement )
	{		
		var iTop = 0;
		var iLeft = 0;
		while( oElement != null ) {
			iTop += oElement.offsetTop;
			iLeft = oElement.offsetLeft;
			oElement = oElement.offsetParent;
		}
		return [iLeft, iTop];
	}
var idea_id = 0;
function clickVotes(id) {
	
	vote_disp1 = true;

	idea_id = id;
}
function getVote(id) {
	var url = 'index.php?option=com_intosuggest&controller=idea&task=getIdea&id='+id+'&format=raw';		
	var vote_id = 'vote'+id; 
	alert(url)
	var request = new Json.Remote(
		url,{			
		onComplete: function(jsonObj) {				
			alert(jsonObj)							
			document.getElementById(vote_id).innerHTML = jsonObj.idea[0].votes;				
	}}).send();
}
function sendVote(idea, votes){
	var id_form = 'VoteForm';
	var url = "index.php?option=com_intosuggest&controller=idea&format=raw&task=updateVote&id="+idea+"&vote="+votes;
	var id = idea_id;
	var req = new Request({
		'url': url,
		method: 'post',
		onComplete: function(txt){						
			//document.getElementById("vote"+id).innerHTML = txt;
			Vote.refresh(txt)
		}
	}).send();	
}

function updateVote(votes) {
	var url = "index.php";
    var data = {
        option: 'com_intosuggest',
        controller: 'idea',
        task: 'updateVote',
        id: idea_id,
        vote: votes
    };
	sendData(url, 'VoteForm', data);
	refreshIdea(idea_id);		
	var v_id = "voteB" + idea_id;
	document.getElementById(v_id).innerHTML = votes;
	idea_id = 0;		
}

function delComment(id){
	var agree = confirm(getConfirmDeleteText());
	var controller = document.getElementById('controller').value;
	
	if (agree){
		 if (controller == 'comment'){
		 	var idea_id = document.getElementById('idea_id').value;
			var url="index.php?option=com_intosuggest&controller=comment&format=raw&task=delComment&id="+id+"&idea_id="+idea_id;
			var req = new Request({
				'url': url,
				method: 'get',
				onComplete:function(result){
					document.getElementById('contentComment').innerHTML = result;
					
				}
			}).send();
		 }else if (controller == 'activity'){
			 //get list comment of userid
			 var url="index.php?option=com_intosuggest&controller=comment&format=raw&task=UdelComment&id="+id; 
			 var req = new Request({
				 	'url': url,
					method:'get',
					onComplete:function(result){
						loadPage('index.php?option=com_intosuggest&controller=activity&format=raw&task=displayComments&user_id='+getUserId()+'&page=1')
						//document.getElementById('list_comment').removeChild(document.getElementById('comment_'+id))
						
						var e = document.getElementById('count_comment');
						if(e)
						{
							e.innerHTML = result;
						}
						//document.getElementById('contentComment').innerHTML = result;
					}
			}).send();
		 }
	}
} 
function reset() {
	alert("asdsad")
	if ((outVote_s == '1') && (clickVote_s == '1')) {
		outVote_s = 0;
		clickVote_s = 0;
	}
} 
function resetComment() {
	document.getElementById('comment').value = "";
	document.getElementById('comment').focus();
}
function addComment() {
	var comment  = document.getElementById('comment').value;
	if (comment == ""){
		alert(getRequireCommentText());
	}else{
		var idea_id  = document.getElementById('idea_id').value;
		var forum_id = document.getElementById('forum_id').value;
		
		var url="index.php?option=com_intosuggest&controller=comment&format=raw&task=addComment&idea_id="+idea_id+"&comment="+comment+"&forum_id="+forum_id;
		var req = new Request({
			'url':url,
			medthod:'get',
			onComplete:function(result){
				document.getElementById('contentComment').innerHTML = result;					
				document.getElementById('comment').value = "";
				
				document.getElementById('comment_count').innerHTML++;
			}
		}).send();
	}
}
function load(){
	var url = "index.php?option=com_intosuggest&controller=idea&task=ideaWithUserid&format=raw";
	var req = new Request({
		'url':url,
		method: 'post',
		onComplete: function(txt){
		document.getElementById('content').innerHTML = txt;
		}
	}).send();
}

var Vote = {
	vote		: null,
	value		: 0,
	idea		: null,
	scroller	: null,
	index		: 0,
	count		: 0,
	delay		: null,
	scrolling	: false,
	to: function(value)
	{
		this.vote = document.getElementById(idea);
		
	},
	refresh: function(newValue)
	{
		var sum_vote = document.getElementById('sum_vote_'+this.idea);
		var obj = null;
		var totalVote = '';
		try {
			eval('obj = '+newValue);
			var totalVote = obj.totalpoint_html;
		} catch (e) {
			return;
		}
		if(totalVote) {
			sum_vote.innerHTML = totalVote;
		}
	},
	up: function(idea)
	{
		if(this.scrolling == true)
			return;
		this.vote = document.getElementById("user_vote_"+idea);
		
		this.idea = idea;
		this.count = this.vote.getElementsByTagName("SPAN").length;
		this.scroller = this.vote.getElementsByTagName("DIV").item(0)
		var scrollY = parseInt(this.scroller.style.marginTop);//this.vote.getSize()['scroll']['y'];
		if(scrollY==0)
			return;
		this.scrolling = true;
		Vote.scroll("up", scrollY, 20)
		
		//this.index = Math.abs(scrollY/20);
		//vote.scrollTo(0, scrollY)	
	},
	down: function(idea)
	{
		if(this.scrolling == true)
			return;
		this.vote = document.getElementById("user_vote_"+idea);
		this.idea = idea;
		this.count = this.vote.getElementsByTagName("SPAN").length;
		
		this.scroller = this.vote.getElementsByTagName("DIV").item(0)
		//alert(this.scroller.style.marginTop)
		var scrollY = parseInt(this.scroller.style.marginTop);///*this.scroller.getStyle("margin-top")*/);//this.vote.getSize()['scroll']['y'];
		
		if(scrollY<= -(this.count-1)*20)
			return;
		this.scrolling = true;
		Vote.scroll("down", scrollY, 20)
		//this.index=Math.abs(scroll/20);
		//vote.scrollTo(0, scrollY)	
	},
	updateVote: function(value)
	{
		//alert(value)
		sendVote(this.idea, value);
	},
	scroll: function(type, from, amount)
	{
		var timer;
		switch(type)
		{
			case 'up':
				amount -= 2;

				//this.scroller.setStyle("margin-top", (from+20-amount)+"px")
				this.scroller.style.marginTop = (from+20-amount)+"px";
				if(amount==0)
					break;
				timer = setTimeout('Vote.scroll("up", '+from+','+amount+')', 15)
				break;
			case 'down':
				amount -= 2;
				
				//this.scroller.setStyle("margin-top", (from-(20-amount))+"px")
				this.scroller.style.marginTop = (from-(20-amount))+"px";
				if(amount==0)
					break;
				timer = setTimeout('Vote.scroll("down", '+from+','+amount+')', 15)
				break;	
		}
		if(amount==0)
		{
			
			clearTimeout(timer);	
			this.index = Math.abs(from/20)
			var p=this;
			type=='up' ? this.index-- : this.index++;
			//alert(from)
			if(this.index==0)
				$$('#left_number_'+this.idea).addClass("is-min")
			else
				$$('#left_number_'+this.idea).removeClass("is-min")

			if(this.index==this.count-1)	
				$$('#next_number_'+this.idea).addClass("is-max")
			else
				$$('#next_number_'+this.idea).removeClass("is-max")
			var span = this.vote.getElementsByTagName("SPAN").item(this.index)
			
			// wait 3s to update
			this.delay = setTimeout(function(){p.updateVote(span.getElementsByTagName("input").item(0).value)}, 1000);
			this.scrolling = false;
			return;
		}
		
		// this is important to cancel update when user click to change vote value
		// from stop click to update are 3s => not bad ^.^
		clearTimeout(this.delay) 
	}
}

var IdeaInfo = {
	item		: null,
	item_tmp	: null,
	height		: 0,
	hiehgt_tmp 	: 0,
	isClose		: true,
	idea_id		: null,
	
	expand: function(v)
	{
		var timer = null;
		var newHeight = typeof(v)!='undefined' ? v : 200;
		newHeight+=25;
		//this.item.style.height = newHeight+"px";	
		alert(this.item.getSize()['scroll']['y']+","+this.item.getSize()['size']['y'])	
		if(newHeight>=this.height)
		{
			clearTimeout(timer);
			return;
		}
		timer = setTimeout('IdeaInfo.expand('+newHeight+')', 50);
	},
	toggle: function(item)
	{
		
		if(typeof(item) == 'string')
		{
			item = document.getElementById(item)
		}
		if(this.item!=null && this.item.id!=item.id)
		{
			this.item_tmp = this.item
			this.height_tmp = this.height;
			if(!this.isClose)
				this.collapse();
			this.isClose = true;	
		}
		this.item_tmp = this.item
		this.height_tmp = this.height;
		this.item = item
		this.height = this.item.getSize()['scroll']['y']
		if(this.isClose)
			this.expand()
		else
			this.collapse()
			
		this.isClose = !this.isClose		
	},
	collapse: function(v)
	{
		var timer = null;
		var newHeight = typeof(v)!='undefined' ? v : this.height_tmp;
		newHeight-=25;
		this.item_tmp.style.height = newHeight+"px";
				
		if(newHeight<=200)
		{
			clearTimeout(timer);
			return;
		}
		timer = setTimeout('IdeaInfo.collapse('+newHeight+')', 50);
	}		
}