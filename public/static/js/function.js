function checkEmpty(obj){
	var value = obj.val();
	value = trim(value); 
	var len = value.length;
	if(len>0){
		return false;
	}
	else {
		return obj;
	}
}

function checkRule(obj,Rull){
	var value = obj.val();
	if(checkEmpty(obj)){
		return false;
	}
	var res = value.match(Rull);
	if( !res){
		return false;
	}
	return obj;
}

function checkLength(obj,min,max = null){
	var value = obj.val();
	var len = value.length;
	if(min>len){
		return false;
	}else if(!max===null){
		if(len>max){
			return false;
		}
	}
	return obj;
}

function trim(str){
    return str.replace(/(^\s*)|(\s*$)/g, ""); 
}
function popMSG(title,str){
	$('body').append('<div id="popmsg" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="title"></h4></div><div class="modal-body"><p id="body"></p></div><div class="modal-footer"></div></div><!-- /.modal-content --></div></div>');

	$('#popmsg #title').text(title);
	$('#popmsg #body').text(str);
	$('#popmsg').modal();
	clearTimeout(window.popMsgTime);
	window.popMsgTime = setTimeout(function(){
		$('#popmsg').modal('hide');
	},3000);
}

function togglePopover(obj,rule,msg = ''){
	obj.change(function(){
		var res = checkRule(obj,rule);
		if(!res){
			obj.attr('data-content',msg);
			obj.popover('show');
		}else{
			obj.popover('hide');
		}
	});
}