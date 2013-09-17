function loadFlash(file,width,height,id,name,bgColor)
{
	var embedHtml = "";
	embedHtml += "<embed type=\"application/x-shockwave-flash\" ";
	embedHtml += "src=\""+file+"\" ";
	embedHtml += "width=\""+width+"\" ";
	embedHtml += "height=\""+height+"\" ";
	embedHtml += "id=\""+id+"\"";
	embedHtml += "name=\""+name+"\" ";
	embedHtml += "bgcolor=\""+bgColor+"\" ";
	embedHtml += "/>";
	document.write(embedHtml);	
}