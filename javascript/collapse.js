/**
* Function to emulate document.getElementById
*
* @param    string    Object ID
*
* @return    mixed    null if not found, object if found
*/
function fetch_object(idname)
{
    if (document.getElementById)
    {
        return document.getElementById(idname);
    }
    else if (document.all)
    {
        return document.all[idname];
    }
    else if (document.layers)
    {
        return document.layers[idname];
    }
    else
    {
        return null;
    }
}

/**
* Toggles the collapse state of an object
*
* @param    string    Unique ID for the collapse group
*
* @return    boolean    false
*/
function toggle_collapse(objid,img_src)              {

    obj = fetch_object('collapseobj_' + objid);
    img = fetch_object('collapseimg_' + objid);

if(img!=null)
{

    if (obj.style.display == 'none')
    {
        img.src = img_src+'_down.gif';
        obj.style.display = '';
    }
    
    
    else
    {
        img.src = img_src+'.gif';
        obj.style.display = 'none';
    }
    return false;

}

}

function toggle_uncollapse(objid,img_src)           {

        obj = fetch_object('collapseobj_' + objid);
        img = fetch_object('collapseobj_' + objid);
        obj.style.display = 'none';
        img.src = img_src;     

    return false;
}




