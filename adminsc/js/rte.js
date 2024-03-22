function setVals(fieldName) {
    document.getElementById(fieldName).value = document.frames[fieldName + 'iView'].document.body.innerHTML;
//alert(document.getElementById(fieldName).value);
}

function Init(formName, fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    fld = document.getElementById(fieldName);
    ifr.document.designMode = 'On';
    ifr.document.open();
    var now = new Date();
    ifr.document.write('<html><head><meta http-equiv="content-type" content="text/html; charset=Windows-1251"><style>@import url(../css/styles.css?k=' + now.getYear() + now.getMonth() + now.getDate() + now.getHours() + now.getMinutes() + now.getSeconds() + '); td { border: 1px solid #CCCCCC; } a { color: #0000ff; } body { text-align: left; margin: 7px; background-color: #FFFFFF; }</style></head><body class="main_white"></body></html>');
    ifr.document.body.innerHTML = fld.value;
    ifr.document.close();
    ifr.mod = 1;
    ifr.removedtags = 0;
}




function doBold(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('bold', false, null);
}

function doItalic(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('italic', false, null);
}

function doUnderline(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('underline', false, null);
}

function doSup(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    var r = ifr.document.selection.createRange();
    r.select();
    var s = r.htmlText;
    if (s == " " || s == "&nbsp;") {
        return;
    }
    r.pasteHTML("<sup>" + r.htmlText + "</sup>")
}

function doImageAlign(fieldName, align) {
    ifr = document.frames[fieldName + 'iView'];
    var r = ifr.document.selection.createRange();
    r.select();
    var s = r.htmlText;
    if (s == " " || s == "&nbsp;") {
        return;
    }
    s = s.replace('<IMG', '<IMG align="' + align + '"');
    r.pasteHTML(s);
}

function doLeft(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('justifyleft', false, null);
}

function doCenter(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('justifycenter', false, null);
}

function doRight(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('justifyright', false, null);
}

function doJustify(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('JustifyFull', false, null);
}

function doOrdList(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('insertorderedlist', false, null);
}

function doBulList(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('insertunorderedlist', false, null);
}

function doForeCol(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    var fCol = prompt('Enter foreground color', '');
    if (fCol != null)
        ifr.document.execCommand('forecolor', false, fCol);
}

function doBackCol(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    var bCol = prompt('Enter background color', '');
    if (bCol != null)
        ifr.document.execCommand('backcolor', false, bCol);
}

function doLink(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('createlink');
}

function doRule(fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifr.document.execCommand('InsertHorizontalRule', true, null);
}

function doFont(fieldName, fName) {
    ifr = document.frames[fieldName + 'iView'];
    if (fName != '')
        ifr.document.execCommand('fontname', false, fName);
}

function doSize(fieldName, fSize) {
    ifr = document.frames[fieldName + 'iView'];
    if (fSize != '')
        ifr.document.execCommand('fontsize', false, fSize);
}

function doHead(fieldName, hType) {
    ifr = document.frames[fieldName + 'iView'];
    if (hType != '') {
        ifr.document.execCommand('formatblock', false, hType);
    }

}

function doToggleView(formName, fieldName) {
    ifr = document.frames[fieldName + 'iView'];
    ifrcont = document.getElementById(fieldName + 'framecontainer');
    tblCtrls = document.getElementById(fieldName + 'tblCtrls');
    fld = document.getElementById(fieldName);
    if (ifr.mod == 1)
    {
        iHTML = ifr.document.body.innerHTML;
        ifrcont.style.display = 'none';
        //setting up the form content
        fld.value = ifr.document.body.innerHTML;
        fld.style.display = 'block';
        // Hide all controls
        tblCtrls.style.filter = 'Alpha(Opacity=10)';
        fld.focus();
        ifr.mod = 2;
    } else
    {
        iText = fld.value;
        ifr.document.body.innerHTML = iText;

        ifrcont.style.display = 'block';
        fld.style.display = 'none';
        // Show all controls
        tblCtrls.style.filter = 'none';
        ifr.focus();
        ifr.mod = 1;
    }
}



function clear_tags(fieldName) {
    iView = document.frames[fieldName + 'iView'];
    iView.focus();
    var m = iView.document.body.innerHTML;
    re_br = /<br>/gi;
    re_p = /<p>/gi;
    re_pend = /<\/p>/gi;
    re_1br = /__br__/gi;
    re_1p = /__p__/gi;
    re_1pend = /__pend__/gi;
    re = /<[\/\!]*?[^<>]*?>/gi;
    re_pp = /<p><\/p>/gi;
    newm = m.replace(re_br, '__br__');
    newm = newm.replace(re_p, '__p__');
    newm = newm.replace(re_pend, '__pend__');
    newm = newm.replace(re, '');
    newm = newm.replace(re_1br, '<br>');
    newm = newm.replace(re_1p, '<p>');
    newm = newm.replace(re_1pend, '</p>');
    newm = newm.replace(re_pp, '<br />');
    iView.document.body.innerHTML = newm;
    ifr.removedtags = 1;
    clear_nbsp(fieldName);
}

function clear_nbsp(fieldName) {
    iView = document.frames[fieldName + 'iView'];
    iView.focus();
    var m = iView.document.body.innerHTML;
    re = /(\&nbsp;)*/gi;
    newm = m.replace(re, '');
    iView.document.body.innerHTML = newm;
}

function clear_tags_first_time(fieldName) {
    if (!ifr.removedtags) {
        clear_tags(fieldName);
    }
}


// Получить текущий тег
function getTag() {
    var sel = editArea.document.selection;
    var aTR = sel.createRange();
    if (sel.type == 'Control')
        return aTR(0);
    else
        return aTR.parentElement();
}

// Получить тег с нужным именем
function getObject(name) {
    var parentEl = getTag();
// для ускорения проверяется — редактируется ли элемент (IE 5.5+)
    while (parentEl.isContentEditable) {
        if (parentEl.tagName == name.toUpperCase())
            return parentEl;
        else
            parentEl = parentEl.parentNode;
    }
    return false;
}

