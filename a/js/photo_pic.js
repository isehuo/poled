function comment_add(id) {
    var obj = $('comment_ul');
    var newdl = document.createElement("dl");
    newdl.id = 'comment_'+id+'_li';
    newdl.className = 'bbda cl';
    var x = new Ajax();
    x.get('home.php?mod=misc&ac=ajax&op=comment&inajax=1&cid='+id, function(s){
        newdl.innerHTML = s;
    });
    if($('comment_prepend')){
        obj = obj.firstChild;
        while (obj && obj.nodeType != 1){
            obj = obj.nextSibling;
        }
        obj.parentNode.insertBefore(newdl, obj);
    } else {
        obj.appendChild(newdl);
    }
    if($('comment_message')) {
        $('comment_message').value= '';
    }
    if($('comment_replynum')) {
        var a = parseInt($('comment_replynum').innerHTML);
        var b = a + 1;
        $('comment_replynum').innerHTML = b + '';
    }
    showCreditPrompt();
}


function createElem(e){
    var obj = document.createElement(e);
    obj.style.position = 'absolute';
    obj.style.zIndex = '1';
    obj.style.cursor = 'pointer';
    obj.onmouseout = function(){ this.style.background = 'none';}
    return obj;
}



function viewPhoto(config){
    var pager = createElem('div');
    var pre = createElem('div');
    var next = createElem('div');
    var cont = $('photo_pic');
    var tar = $('pic');
    var w = tar.width/2;
    var objpos = fetchOffset(tar);

    pager.style.position = 'absolute';
    pager.style.top = '0';
    pager.style.left = objpos['left'] + 'px';
    pager.style.top = objpos['top'] + 'px';
    pager.style.width = tar.width + 'px';
    pager.style.height = tar.height + 'px';
    pre.style.left = 0;
    next.style.right = 0;
    pre.style.width = next.style.width = w + 'px';
    pre.style.height = next.style.height = tar.height + 'px';
    pre.innerHTML = next.innerHTML = '<img src="'+IMGDIR+'/emp.gif" width="' + w + '" height="' + tar.height + '" />';
    pre.onmouseover = function(){ this.style.background = 'url('+IMGDIR+'/pic-prev.png) no-repeat 0 100px'; }
    pre.onclick = function(){ window.location = config.prevlink; }
    next.onmouseover = function(){ this.style.background = 'url('+IMGDIR+'/pic-next.png) no-repeat 100% 100px'; }
    next.onclick = function(){ window.location = config.nextlink; }
    //cont.style.position = 'relative';
    cont.appendChild(pager);
    pager.appendChild(pre);
    pager.appendChild(next);
}
