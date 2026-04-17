// JavaScript Document
 function confirm_del()
 {
	if(confirm('Are you sure you want to delete photo'))
	{
	   return true;
	}
	else
	{
		return false;
	}
 
 }

var error = "";
function showdiv(mid)
 {
    fireMyPopup();
 }
 function showdiv_Banner()
 {
    fireMyPopup();
 }
 
 
 // Browser safe opacity handling function

function setOpacity( value ) {
 document.getElementById("styled_popup").style.opacity = value / 10;
 document.getElementById("styled_popup").style.filter = 'alpha(opacity=' + value * 10 + ')';
}

function fadeInMyPopup() {
 for( var i = 0 ; i <= 100 ; i++ )
   setTimeout( 'setOpacity(' + (i / 10) + ')' , 8 * i );
}

function fadeOutMyPopup() {
 for( var i = 0 ; i <= 100 ; i++ ) {
   setTimeout( 'setOpacity(' + (10 - i / 10) + ')' , 8 * i );
 }

 setTimeout('closeMyPopup()', 800 );
}

function closeMyPopup() {
 document.getElementById("styled_popup").style.display = "none";
}

function fireMyPopup() {
 setOpacity( 0 );
 document.getElementById("styled_popup").style.display = "block";
 fadeInMyPopup();
}






function showimage(imagearray, id, imageplace)
{
	for(i=0; i<imagearray.length; i++)
	{
		if (imagearray[i]["imageid"] == id)
		{
			largeimageurl = imagearray[i]["mainimage"];
			imageurl = imagearray[i]["image"];
			width = imagearray[i]["width"];
			height = imagearray[i]["height"];
			
			if (imageurl)
			{
				document.getElementById("maininageofproduct").href = largeimageurl;
				document.getElementById(imageplace).src = imageurl;
				document.getElementById(imageplace).width = width;
				document.getElementById(imageplace).height = height;
			}
			return true;
		}
	}
}

function setnewcartproductimage(imagearray, id, frm)
{
	for(i=0; i<imagearray.length; i++)
	{
		if (imagearray[i]["imageid"] == id)
		{
			imageurl = imagearray[i]["cartimage"];

			if (imageurl)
			{
				for(i = 0; i < document.forms[frm].length; i++)
				{
					if(document.forms[frm].elements[i].name.substr(0, 6) == 'image_')
					{
						document.forms[frm].elements[i].value = imageurl;
					}
				}
			}
			return true;
		}
	}
}

function menutoggle(div1, div2)
{
	document.getElementById(div1).style.display = '';
	document.getElementById(div2).style.display = 'none';
}

function menu(childbox, flipimg, img1, img2)
{
	if (document.getElementById(childbox).style.display == 'none') 
	{
		document.getElementById(childbox).style.display = '';
		document.getElementById(flipimg).src = img1;
	}
	else 
	{	
		document.getElementById(childbox).style.display = 'none';
		document.getElementById(flipimg).src = img2;
	}
}

function chkvalidity(frm, validity,errdiv)
{
        
	chk = true;
	for(j=0; j<validity.length; j++)
	{
		chk = fieldcheck(frm, validity[j]["field"], validity[j]["datatype"], validity[j]["fieldtype"], validity[j]["msg"], validity[j]["needle"], validity[j]["depend_cmd"], validity[j]["depend_check"] ,errdiv)
		if (chk == false) return false;
	}
	return true;
}

function fieldcheck(frm, field, datatype, fieldtype, msg, needle, depend_field, depend_check,errdiv)
{
	//document.getElementById(responseid).style.display='none';
	state = true;
        
	if ((fieldtype == "radio" || fieldtype == "checkbox") && datatype != "depend")
	{
		if(datatype == "chkcount")
		{
					return checkcheckboxcnt(frm, field, msg,needle,errdiv);
		}
		else
			return chkradiocheckbox(frm, field, msg,errdiv);
	}
	else
	{
		for(i = 0; i < document.forms[frm].length; i++)
		{
			if(document.forms[frm].elements[i].name == field)
			{
				
				if (datatype == "char")
				{
					if(trim(document.forms[frm].elements[i].value) == "") state = false;
				}
				else if (datatype == "curr")
				{
					if (parseFloat(document.forms[frm].elements[i].value) < 0) state = false;
					if (checkcurr(document.forms[frm].elements[i].value) == false) state = false;
				}
				else if (datatype == "number")
				{
					
					if (checknumber(document.forms[frm].elements[i].value) == false) state = false;
				}				
				else if(datatype == "float")
                                {
                                    if (parseFloat(document.forms[frm].elements[i].value) < 0) state = false;
                                }
				else if (datatype == "numberMinComp")
				{
					if (parseFloat(document.forms[frm].elements[i].value) == 0) state = false;
					if (checknumber(document.forms[frm].elements[i].value) == false) state = false;
				}
				
				else if (datatype == "mobilenumber")
				{
				 if (check_mobile(document.forms[frm].elements[i].value) == false) state = false;
				}	
				
				 else if (datatype == "phonenumber")
				{
				 if (check_phonenumber(document.forms[frm].elements[i].value) == false) state = false;
				}		
				
				
				else if (datatype == "email")
				{
					
					if (emailCheck(document.forms[frm].elements[i].value) == false) state = false;
				}
				else if (datatype == "email_domain")
				{
					
					if (emailCheck_with_domain(document.forms[frm].elements[i].value) == false) state = false;
				}
				else if (datatype == "memail")
				{
					
					if (validmultipleemail(document.forms[frm].elements[i].value) == false) state = false;
				}
				
				else if (datatype == "nospecial")
				{
					if (nonspecialchar(document.forms[frm].elements[i].value) == false) state = false;
				}
				else if (datatype == "compare")
				{
					if (strcompare(document.forms[frm].elements[i].value, needle) == false) state = false;
				}
				else if (datatype == "comparedates")
				{
					if (CompareDates(document.forms[frm].elements[i].value, needle) == false) state = false;
				}
				
				else if (datatype == "notsame")
				{
					if (strnotsame(document.forms[frm].elements[i].value, needle) == false) state = false;
				}
				else if (datatype == "either")
				{
					if (streither(document.forms[frm].elements[i].value, needle) == false) state = false;
				}
				else if (datatype == "length")
				{
					if (chkstringlength(document.forms[frm].elements[i].value, needle) == false) state = false;
				}
				else if (datatype == "lengthgr")
				{
					if (chkstringlengthgr(document.forms[frm].elements[i].value, needle) == false) state = false;
				}
				
				else if (datatype == "depend")
				{
					if (radiocheckvalue(frm, document.forms[frm].elements[i].name) != needle) return true;
					if (chkdependency(frm, document.forms[frm].elements[i], needle, depend_field, depend_check) == false) state = false;
				}
				else if(datatype == "image")
				{ 
				   //alert(document.forms[frm].elements[i].value);
					 
					if(checkimage(document.forms[frm].elements[i].value) == false) state = false;
				}
				else if(datatype == "video")
				{
					//alert(datatype) ;
					if(validatevideo(document.forms[frm].elements[i].value) == false) state = false;
				}
			    else if(datatype == "pdf")
				{
					//alert(datatype) ;
					if(validatepdf(document.forms[frm].elements[i].value) == false) state = false;
				}	
				else if(datatype == "flash")
				{
					//alert(datatype) ;
					if(validateflash(document.forms[frm].elements[i].value) == false) state = false;
				}		
				
				else if(datatype == "audio")
				{
					//alert(datatype) ;
					if(validateaudio(document.forms[frm].elements[i].value) == false) state = false;
				}	
				
				else if(datatype == "selected_files")
				{
					//alert(datatype) ;
					if(validateselected_files(document.forms[frm].elements[i].value) == false) state = false;
				}
				
				else if(datatype == "docfile")
				{
					//alert(datatype) ;
					if(validatedoc_file(document.forms[frm].elements[i].value) == false) state = false;
				}
				
				else if(datatype == "pressfile")
				{
					//alert(datatype) ;
					if(pressfile_files(document.forms[frm].elements[i].value) == false) state = false;
				}

				else if(datatype == "validpassword")
			    {
						if(validate_password(document.forms[frm].elements[i].value) == false) state = false;					
				}
				
			   else if(datatype == "url")
				{
					if(check_url(document.forms[frm].elements[i].value) == false) state = false;
				}	
				else if(datatype == "lessnum")
				{
					if(check_lessnum(document.forms[frm].elements[i].value,needle) == false) state = false;
				}	
				else if(datatype == "grnum")
				{
					if(check_grnum(document.forms[frm].elements[i].value,needle) == false) state = false;
				}	
				else if(datatype == "decimal")
				{
					if(CheckDecimal(document.forms[frm].elements[i].value,needle) == false) state = false;
						
				}
				else if(datatype == "checkincr")
				{
					if(checkincreament(document.forms[frm].elements[i].value,needle) == false) state = false;	
				}
				else if(datatype == "flag")
				{
					if(needle == 'invalid')
					state = false		
					else
					state = true;			
				}
			}
			if (!state)
			{
				//alert(msg);
				//alert(responseid);
				//document.getElementById(responseid).style.display='';
				//if(error != "")
                               
                if(errdiv)
                {
				document.getElementById(errdiv).style.display='';
					error = "<span class=\"notification n-error\">"+msg+"</span>";
				
				
				document.getElementById(errdiv).innerHTML= error;
                                    }
                                    else
                                     {
                                         document.getElementById("error").style.display='';
					error = "<span class=\"notification n-error\">"+msg+"</span>";
				
				
				document.getElementById("error").innerHTML= error;
                                     }
				
				if (datatype != "depend") 
				{
					if (document.forms[frm].elements[i].disabled == false) document.forms[frm].elements[i].focus();
				}
				return state;
			}
		}
	}
}
function check_lessnum(num1,num2)
{
	
	if(parseFloat(num1) < parseFloat(num2)) return false;	
}
function check_grnum(num1,num2)
{
	if(parseFloat(num1) > parseFloat(num2)) return false;	
}
function chkstringlength(string, strlength)
{	
	//alert(strlength);
	if (string.length < strlength) return false;
}
function chkstringlengthgr(string, strlength)
{	
	//alert(strlength);
	if (string.length > strlength) return false;
}
function streither(str1, str2)
{
	if (trim(str1) == "" && trim(str2) == "") return false;
}

function strcompare(str1, str2)
{
	if (str1 != str2) return false;
}
function strnotsame(str1, str2)
{
	if (str1 == str2) return false;
}

function mannav(frm, objname, msg, mode)
{
	if (chkradiocheckbox(frm, objname, msg))
	{
		document.forms[frm].cmd_mode.value = mode;
		document.forms[frm].submit();
		return true;
	}
	else
	{
		return false;
	}
}

function radiocheckvalue(frm, objname)
{
	for(i = 0; i < document.forms[frm].length; i++)
	{
		if(document.forms[frm].elements[i].name == objname)
		{
			if(document.forms[frm].elements[i].checked == true)
			{
				return document.forms[frm].elements[i].value;
			}
		}
	}
	return false;
}

function togglecheckbox(frm, master)
{
	for(i = 0; i < document.forms[frm].length; i++)
	{
		if(document.forms[frm].elements[i].name == master)
		{
			if (document.forms[frm].elements[i].checked == true) ckeckit = true;
			else if (document.forms[frm].elements[i].checked == false) ckeckit = false;
		}
	}
	for(i = 0; i < document.forms[frm].length; i++)
	{
		if(document.forms[frm].elements[i].type == 'checkbox')
		{
			if (ckeckit == true) document.forms[frm].elements[i].checked = true;
			else if (ckeckit == false) document.forms[frm].elements[i].checked = false;
		}
	}
}

function selectvalue(frm, objname)
{
	for(i = 0; i < document.forms[frm].length; i++)
	{
		if(document.forms[frm].elements[i].name == objname)
		{
			if(document.forms[frm].elements[i].selected == true)
			{
				return document.forms[frm].elements[i].value;
			}
		}
	}
	return false;
}

function chkradiocheckbox(frm, objname, msg,errdiv)
{
	for(i = 0; i < document.forms[frm].length; i++)
	{
		if(document.forms[frm].elements[i].name == objname)
		{
			if(document.forms[frm].elements[i].checked == true) return true;
		}
	}
	//alert(msg);
	
		error += "<span class=\"notification n-error\">"+msg+"</span>";
	
	document.getElementById(errdiv).style.display='';			
	document.getElementById(errdiv).innerHTML= error;
					
	return false;
}

function submitform(frm, action)
{
	if (action)
	{
		document.forms[frm].action = action;
	}
	document.forms[frm].submit();
	return true;
}
function submitformforseprate(frm, action,cmd)
{
	if (action)
	{
		document.forms[frm].action = action;
		document.forms[frm].task.value=cmd;
	}
	document.forms[frm].submit();
	return true;
}
function redirect(url)
{
	document.location.href = url;
	return true;
}

function nonspecialchar(varStr)
{
	var iChars = "`~!@#$%^&*()-=+\|,./?'\"[] {}";
	for (var i = 0; i < varStr.length; i++) 
	{
		if (iChars.indexOf(varStr.charAt(i)) != -1)
		{
            return false;
        }
	}
}

function emailCheck(emailStr, errormessage)
{
	var checkTLD=1;
	var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
	var emailPat=/^(.+)@(.+)$/;
	var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	var validChars="\[^\\s" + specialChars + "\]";
	var quotedUser="(\"[^\"]*\")";
	var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
	var atom=validChars + '+';
	var word="(" + atom + "|" + quotedUser + ")";
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
	var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
	var matchArray=emailStr.match(emailPat);

	if (matchArray==null) 
	{
		return false;
	}
	
	var user=matchArray[1];
	var domain=matchArray[2];

	for (i=0; i<user.length; i++) 
	{
		if (user.charCodeAt(i)>127) 
		{
			return false;
		}
	}
	for (i=0; i<domain.length; i++) 
	{
		if (domain.charCodeAt(i)>127) 
		{
			return false;
   		}
	}

	if (user.match(userPat)==null) 
	{
		return false;
	}

	var IPArray=domain.match(ipDomainPat);
	if (IPArray!=null) 
	{
		for (var i=1;i<=4;i++) 
		{
			if (IPArray[i]>255) 
			{
				return false;
   			}
		}
		return true;
	}

	var atomPat=new RegExp("^" + atom + "$");
	var domArr=domain.split(".");
	var len=domArr.length;
	for (i=0;i<len;i++) 
	{
		if (domArr[i].search(atomPat)==-1) 
		{
			return false;
	   	}
	}

	if (checkTLD && domArr[domArr.length-1].length!=2 && domArr[domArr.length-1].search(knownDomsPat)==-1) 
	{
		return false;
	}

	if (len<2) 
	{
		return false;
	}

	return true;
}



function emailCheck_with_domain(emailStr, errormessage)
{
	var checkTLD=1;
	var knownDomsPat=/^(org|edu)$/;
	var emailPat=/^(.+)@(.+)$/;
	var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
	var validChars="\[^\\s" + specialChars + "\]";
	var quotedUser="(\"[^\"]*\")";
	var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
	var atom=validChars + '+';
	var word="(" + atom + "|" + quotedUser + ")";
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
	var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
	var matchArray=emailStr.match(emailPat);

	if (matchArray==null) 
	{
		return false;
	}
	
	var user=matchArray[1];
	var domain=matchArray[2];

	for (i=0; i<user.length; i++) 
	{
		if (user.charCodeAt(i)>127) 
		{
			return false;
		}
	}
	for (i=0; i<domain.length; i++) 
	{
		if (domain.charCodeAt(i)>127) 
		{
			return false;
   		}
	}

	if (user.match(userPat)==null) 
	{
		return false;
	}

	var IPArray=domain.match(ipDomainPat);
	if (IPArray!=null) 
	{
		for (var i=1;i<=4;i++) 
		{
			if (IPArray[i]>255) 
			{
				return false;
   			}
		}
		return true;
	}

	var atomPat=new RegExp("^" + atom + "$");
	var domArr=domain.split(".");
	var len=domArr.length;
	for (i=0;i<len;i++) 
	{
		if (domArr[i].search(atomPat)==-1) 
		{
			return false;
	   	}
	}

	if (checkTLD && domArr[domArr.length-1].length!=2 && domArr[domArr.length-1].search(knownDomsPat)==-1) 
	{
		return false;
	}

	if (len<2) 
	{
		return false;
	}

	return true;
}


function popUp(URL, width, height) 
{
/*	window.open(URL, 'mywindow',"toolbar=0,scrollbars=1,left=50,top=50,location=0,statusbar=0,menubar=0,resizable=1,width='" + width + "',height='"+ height +"' ");*/

	window.open (URL, "mywindow","location=1,status=1,scrollbars=1, width="+width+",height="+height+"");
}

function checknumber(object)
{
	var x=object;
	var anum=/(^\d+$)|(^\d+\d+$)/;
	if (anum.test(x))
	{
		return true;
	}
	else
	{
		return false;
	}
}
function checkcurr(object)
{
	var x=object;
	var anum=/(^\d+$)|(^\d+\.\d+$)/;
	if (anum.test(x))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function trim (s)
{
	return rtrim(ltrim(s));
}

function ltrim (s)
{
	return s.replace( /^\s*/, "" );
}

function rtrim (s)
{
	return s.replace( /\s*$/, "" );
}

/**kiran*/
function check_selAll(element ,msg)
{
	
  var id = document.getElementsByName(element);
  var check = 0;
  for(var i = 0 ; i< id.length ; i++)
  {
    if(id[i].checked)
    {
      check = 1;
	  break;
    }
	else
	 check = 0;
  }

  if(check == 0) {
    alert(msg);
    return false;
  }
  return true;
}

function check_sel(element)
{
  var id = document.getElementsByName(element);
  var check = 0;
  var cnt = 0;
  for(var i = 0 ; i< id.length ; i++)
  {
    if(id[i].checked)
    {
      check = 1;
	  cnt = cnt + 1 ;
    }
  }

  if(check == 0) {
    alert("Please Select Record");
    return false;
  }
  if(cnt > 1) {
    alert("Please Select Only One Record");
    return false;
  }
  return true;
}

function checkAllBox(form,name,val)
{
  for( i=0 ; i<form.length ; i++)
   {
   	  if(form.elements[i].type =='checkbox' && form.elements[i].name == name)
  		  form.elements[i].checked = val;
   }
}


function checkimage(path)
{
	var ph_url = path
	var start_pos = ph_url.lastIndexOf(".")+1;// this function gives the possition of "." in ph_ulr
	var file_ext = ph_url.substring(start_pos);// this function gives the extention of file e.g .jpg , .txt .jpeg 
	if(file_ext.toLowerCase()!="jpg"  && file_ext.toLowerCase()!="gif" && file_ext.toLowerCase()!="jpeg" && file_ext.toLowerCase()!="png")
	{
		  return false;
	} 
}

function validatevideo(value)
{
	validformFile = /(.flv)$/;
	if(!validformFile.test(value.toLowerCase()))
		return false;
}
function validatepdf(value)
{
	validformFile = /(.pdf)$/;
	if(!validformFile.test(value.toLowerCase()))
		return false;
}

function validateflash(value)
{
	validformFile = /(.swf)$/;
	if(!validformFile.test(value.toLowerCase()))
	   return false;
}

function validateaudio(value)
{
	validformFile = /(.mp3|.wmv|.wav|.wpl|.wma)$/;
	if(!validformFile.test(value.toLowerCase()))
	   return false;
}

function validateselected_files(value)
{
 	validformFile = /(.pdf|.doc|.jpg|.gif)$/;
	if(!validformFile.test(value.toLowerCase()))
	   return false;
}


function validatedoc_file(value)
{
 	validformFile = /(.pdf|.doc|.docx)$/;
	if(!validformFile.test(value.toLowerCase()))
	   return false;
}

function pressfile_files(value)
{
 	validformFile = /(.doc|.docx|.xls|.xlsx|.pdf)$/;
	if(!validformFile.test(value.toLowerCase()))
	   return false;
}


 

function check_url(str)
{ 
  if(str)
    {
      var exp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
      var urlVal = exp.test(str);
	  return urlVal
   }
   else
     return false;

}


function check_phonenumber(object) /*allowed only   0 to 9 and - */
{
	var x=object;
	var anum=/^[0-9\-]+$/;
	if(anum.test(x))
	{
	  return true;
	}
	else
	{
	  return false;
	}
}


function check_mobile(object) /*allowed only   0 to 9 with 10 digit only*/ 
{
	var x=object;
	var anum=/^[0-9]+$/;
	if(anum.test(x))
	{
		if(x.length == 10)	
			  return true;
		else
			  return false;
	}
	else
	{
	  return false;
	}
}





function getFiledvalue(fieldname)
 {
	var val="";
	if(fieldname) 
	 {
		val =trim(document.getElementsByName(fieldname)[0].value);
		if(val) return val;
	}
	return false; 
}
function setFocustoFiled(fieldname)
{
  if(fieldname)	
  document.getElementsByName(fieldname)[0].focus();
}





function check_order(msg)
 {
	 var x="";
    var orderlen = document.getElementsByName("order[]").length;
	for(var k=0 ; k<orderlen; k++)
	 {
			x = document.getElementsByName("order[]")[k].value;
			var anum=/(^\d+$)|(^\d+\d+$)/;
			if (!anum.test(x))
			{
				alert(msg + (k+1));
				return false;
			}
	 }
	return true;
}



function validate_password(value)
 {
	 	/*
			Passwords will contain at least 1  letter
			Passwords will contain at least 1 number special char
			Passwords will contain at least 7 characters in length
		*/
	 
//	 var re=/^(?=^.{7,}$)((?=.*\d)(?=.*\W+))(?!.*\s)(?=.*[a-zA-Z]).*$/;

	 	/*
			Passwords will contain at least 1  letter
			Passwords will contain at least 1 number
			Passwords will contain at least 7 characters in length
		*/
	 var re=/^(?=^.{7,}$)((?=.*\d))(?!.*\s)(?=.*[a-zA-Z]).*$/;
	 if (!re.test(value))  return false;
	 else return true;
	 
 }


function isExisting(myform,myfield){

	if(document.getElementsByName(myfield)[0] ==undefined)
		{
				return false;
		}
	else
		{
				return true;
		}
	return false;	
}

function isExisting_byid(myform,myfield){

	if(document.getElementById(myfield) ==undefined)
		{
				return false;
		}
	else
		{
				return true;
		}
	return false;	
}
function validmultipleemail(value) {
    var result = value.split(",");
    for(var i = 0;i < result.length;i++)
    if(!validateEmail(result[i])) 
            return false;               
    return true;
}

function validateEmail(field)
{
	
    var regex=/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i;
    return (regex.test(field)) ? true : false;
	
}
function CompareDates(fromdate,todate)
{
    var str1 = fromdate;
    var str2 = todate;
    var dt1  = parseInt(str1.substring(0,2),10);
    var mon1 = parseInt(str1.substring(3,5),10);
    var yr1  = parseInt(str1.substring(6,10),10);
    var dt2  = parseInt(str2.substring(0,2),10);
    var mon2 = parseInt(str2.substring(3,5),10);
    var yr2  = parseInt(str2.substring(6,10),10);
    var date1 = new Date(yr1, mon1, dt1);
    var date2 = new Date(yr2, mon2, dt2);
    if(date2 < date1)
    {
        
        return false;
    }
    else
    {
         return true;
    }
} 

function showpopup(divval) //used for lightbox
{
	if(divval !="" && divval !="undefined")
		{
			document.getElementById(divval).style.display='block';
			document.getElementById('fade').style.display='block'
		}	
}

function closepopup(divval) //used for lightbox
{
	
	if(divval !="" && divval !="undefined")
		{
			document.getElementById(divval).style.display='none';
			document.getElementById('fade').style.display='none'
		}	
}




function check_login()
	{
	
	var thisform="login";
	var validity = [
		{field:"username_login", msg:"<?=$cmsg['136']?>", datatype:"char", fieldtype:"text" ,responseid: "errusername_login"},
		{field:"password_login", msg:"<?=$cmsg['1']?>", datatype:"char", fieldtype:"text" ,responseid: "errpassword_login"}
		];
		
		return chkvalidity(thisform, validity);
	 }





function show_ingredient()
 {
    fireMyPopup_ingredient();
 }
 // Browser safe opacity handling function
 
function setOpacity_ingredient( value ) {
 document.getElementById("popup_ingredient").style.opacity = value / 10;
 document.getElementById("popup_ingredient").style.filter = 'alpha(opacity=' + value * 10 + ')';
}

function fadeInMyPopup_ingredient() {
 for( var i = 0 ; i <= 100 ; i++ )
   setTimeout( 'setOpacity_ingredient(' + (i / 10) + ')' , 8 * i );
}

function fadeOutMyPopup_ingredient() {
 for( var i = 0 ; i <= 100 ; i++ ) {
   setTimeout( 'setOpacity_ingredient(' + (10 - i / 10) + ')' , 8 * i );
 }

 setTimeout('closeMyPopup_ingredient()', 800 );
}

function closeMyPopup_ingredient() {
 document.getElementById("popup_ingredient").style.display = "none";
}

function fireMyPopup_ingredient() {
 setOpacity_ingredient( 0 );
 document.getElementById("popup_ingredient").style.display = "block";
 fadeInMyPopup_ingredient();
}



function ischecked(frm, objname)
{
	for(i = 0; i < document.forms[frm].length; i++)
	{
		if(document.forms[frm].elements[i].name == objname)
		{
			if(document.forms[frm].elements[i].checked == true) return true;
		}
	}			
	return false;
}


function showdetail_recipe(url,cond)
	{
		
		if(url =="")	url =pathUrl+"index.php" ;
		
		if(cond ==true)
			{
				location.href=url;
			}
		else
			{
				showpopup('logindiv');	
			}
	}
	
	
	
function tvsch_classes(val)	
	{
		var ary =new Array;
		ary[0] ="sunday";
		ary[1] ="monday";
		ary[2] ="tuesday";
		ary[3] ="wednesday";
		ary[4] ="thursday";		
		ary[5] ="friday";				
		ary[6] ="saturday";						
		
		for(var i=0;i<7;i++)
			{
				if(val==ary[i])	
					{
						document.getElementById("li_"+ary[i]).className = ary[i];					
						document.getElementById("a_"+ary[i]).className = "";							
					}
				else
					{
						document.getElementById("a_"+ary[i]).className = ary[i];	
						document.getElementById("li_"+ary[i]).className = "";											
					}
			}
			if(val !="")
				document.getElementsByName("days")[0].setAttribute('id',val);
			
	}



function show_hide_fbdiv(val)
{
 if(val =="s")		
 	{
		document.getElementById("c_show").style.display='';		
		document.getElementById("a_hide").style.display='';				
	   document.getElementById("a_show").style.display='none';			   		
		
	}
	
 else	
 	{
	   document.getElementById("c_show").style.display='none';	
	   document.getElementById("a_show").style.display='';	
		document.getElementById("a_hide").style.display='none';		   
	}
	
	
}


function showtweets(val)
{
	if(val =="F")	
	 {
		 document.getElementById("div_fb").style.display='';	 		
		 document.getElementById("div_tweet").style.display='none';	
	 }
	 else
	 {
		 document.getElementById("div_fb").style.display='none';	 		
		 document.getElementById("div_tweet").style.display='';	 	
	 }
	
}
function CheckDecimal(pNum, pDp){
	
    return new RegExp("^\\d*\\.\\d{0," + pDp + "}$").test(pNum);
}
function checkincreament(tvalues,incrval)
{
	if(parseInt(tvalues)%parseInt(incrval) ==  0)
	    return true;
	else
		return false;
}

function checkcheckboxcnt(frm, objname, msg ,count,errdiv)
{
	var cnt =0;
	for(i = 0; i < document.forms[frm].length; i++)
	{
		if(document.forms[frm].elements[i].name == objname)
		{
			if(document.forms[frm].elements[i].checked == true)
			{
				cnt++;
				if(count)
				{
					if(cnt > count)
					{
					  				
                                    if(errdiv)
                                    {
				document.getElementById(errdiv).style.display='';
					error = "<span class=\"notification n-error\">"+msg+"</span>";
				
				
				document.getElementById(errdiv).innerHTML= error;
                                    }
                                    else
                                     {
                                         document.getElementById("error").style.display='';
					error = "<span class=\"notification n-error\">"+msg+"</span>";
				
				
				document.getElementById("error").innerHTML= error;
                                     }
				
				if (datatype != "depend") 
				{
					if (document.forms[frm].elements[i].disabled == false) document.forms[frm].elements[i].focus();
				}
						return false;
					}
					else
						return true;
				}
				return true;
				
				
			}
		}
	}
	if(cnt <=0)
	{
		 				
                                    if(errdiv)
                                    {
				document.getElementById(errdiv).style.display='';
					error = "<span class=\"notification n-error\">"+msg+"</span>";
				
				
				document.getElementById(errdiv).innerHTML= error;
                                    }
                                    else
                                     {
                                         document.getElementById("error").style.display='';
					error = "<span class=\"notification n-error\">"+msg+"</span>";
				
				
				document.getElementById("error").innerHTML= error;
                                     }
				
				if (datatype != "depend") 
				{
					if (document.forms[frm].elements[i].disabled == false) document.forms[frm].elements[i].focus();
				}
		return false;	
	}
	return false;
}
function notSchDiv(id)
	{
		if(id)
			var schlNotInLstDiv = document.getElementById("schlNotInLstDiv"+id);
		else
			var schlNotInLstDiv = document.getElementById("schlNotInLstDiv");
		if(schlNotInLstDiv.style.display=="none")
			{
				schlNotInLstDiv.style.display="inline";
				if(id)
					document.getElementById("newhs"+id).value = 1;
				else
					document.getElementById("newhs").value = 1;
			}
		else
			{
				schlNotInLstDiv.style.display="none";
				if(id)
					document.getElementById("newhs"+id).value = 0;
				else
					document.getElementById("newhs").value = 0;
			}	
	}	
	


