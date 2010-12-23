
function checkDisabledStatus()
{
    for (y=0; y < document.forms.length; y++)
    {
        for (x=0; x < document.forms[y].elements.length; x++)
        {
           if(document.forms[y].elements[x].disabled && document.forms[y].elements[x].type!="radio" )
           {
            document.forms[y].elements[x].className+=' disabled';
           }
           else
           {
            document.forms[y].elements[x].className+=' enabled';
           }
        }
    }
}


function fOver(src) {
	src.style.backgroundColor='#F1F4F8';
	src.style.cursor = 'default';
}


function fOut(src) {
	src.style.backgroundColor='#fff';
		src.style.cursor = 'default';
}

function fOverAlt(src) {
	src.style.backgroundColor='#BFFFCD';
	src.style.cursor = 'default';
}


function fOutAlt(src) {
	src.style.backgroundColor='#D9FFE1';
	src.style.cursor = 'default';
}
	
function fOverAltCancelled(src) {
	src.style.backgroundColor='#f6d6d6';
	src.style.cursor = 'default';
}


function fOutAltCancelled(src) {
	src.style.backgroundColor='#f7e8e8';
	src.style.cursor = 'default';
}
	

