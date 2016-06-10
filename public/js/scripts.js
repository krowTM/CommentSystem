function saveComment()
{
	var name = document.getElementById('name-input').value;
	var email = document.getElementById('email-input').value;
	var message = document.getElementById('message-input').value;
	var spam_answer = document.getElementById('spam-answer-input').value;
	
	if (name != '' && email != '' && message != '' && spam_answer != '') {
		var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				reloadComments();
				reloadCommentForm();
			}
		}
		
		xmlhttp.open('POST','index.php',true);
		xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlhttp.send('model=Comment&controller=Comments&action=add&name=' + name + 
				'&email=' + email + '&message=' + message + '&spam_answer=' + spam_answer);
	}
	
	return false;
}

function saveReply(id)
{
	var name = document.getElementById('name-input-' + id).value;
	var email = document.getElementById('email-input-' + id).value;
	var message = document.getElementById('message-input-' + id).value;
	var spam_answer = document.getElementById('spam-answer-input-' + id).value;
	
	if (name != '' && email != '' && message != '' && id != 0 && spam_answer != '') {
		var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				reloadComments();
				closeReplyForm(id);
			}
		}
		
		xmlhttp.open('POST','index.php',true);
		xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
		xmlhttp.send('model=Reply&controller=Replies&action=add&name=' + name + 
				'&email=' + email + '&message=' + message + '&comment_id=' + id + '&spam_answer=' + spam_answer);
	}
	
	return false;
}

function reloadComments() 
{
	var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('comments-div').innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open('POST','index.php',true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send('model=Comment&controller=Comments&action=load_ajax_comments');
}

function reloadCommentForm() 
{
	var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('new-comment').innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open('POST','index.php',true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send('model=Comment&controller=Comments&action=load_comment_form');
}

function showReplyLink(id) 
{
	document.getElementById('reply-span-' + id).style.visibility = 'visible';
}

function hideReplyLink(id) 
{
	document.getElementById('reply-span-' + id).style.visibility = 'hidden';
}

var openedReplyForm = 0;

function showReplyForm(id) 
{	
	if (openedReplyForm != 0) {
		closeReplyForm(openedReplyForm);
	}
	
	openedReplyForm = id;
	
	var xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById('new-reply-' + id).innerHTML = xmlhttp.responseText;
			document.getElementById('new-reply-' + id).style.display = 'block';
			document.getElementById('reply-span-' + id).style.display = 'none';
			document.getElementById('close-reply-span-' + id).style.visibility = 'visible';
		}
	}
	
	xmlhttp.open('POST','index.php',true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send('model=Reply&controller=Replies&action=load_reply_form&comment_id=' + id);
}

function closeReplyForm(id) 
{
	document.getElementById('new-reply-' + id).innerHTML = '';
	document.getElementById('new-reply-' + id).style.display = 'none';
	document.getElementById('reply-span-' + id).style.display = 'inline';
}

reloadComments();
reloadCommentForm();