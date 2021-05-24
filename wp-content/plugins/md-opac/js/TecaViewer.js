/**
 * 
 */

this.aPageImg =[];

function addPage(risIdr)
{
  this.aPageImg[this.aPageImg.length] = risIdr;
}

function changePage(num)
{
  dPagine.openTo('IMG.'+num, true, false);
  changeImg(num);
}

function changeImg(risIdr)
{
  pageAtt=risIdr;
  var app = document.getElementById('myApplet');
  if (app != null)
  {
    if (isApplet)
      app.viewImage(this.aPageImg[risIdr]);
    else
      app.src=this.aPageImg[risIdr];
  }
}


function changeViewCol(nomeCol, testoMsg)
{
  if (document.getElementById(nomeCol) != null)
  {
    if (document.getElementById(nomeCol).style.display=="none")
    {
      document.getElementById(nomeCol).style.display="";
      document.getElementById(nomeCol+"Img").src="../plugins/content/tecadigitale/images/xlimage/images/left.gif";
      document.getElementById(nomeCol+"Img").alt="Nascondi "+testoMsg;
      document.getElementById(nomeCol+"Img").title="Nascondi "+testoMsg;
      document.getElementById("viewer").style="";
      document.getElementById("viewer").style.width="";
    }
    else
    {
      document.getElementById(nomeCol).style.display="none";
      document.getElementById(nomeCol+"Img").src="../plugins/content/tecadigitale/images/xlimage/images/right.gif";
      document.getElementById(nomeCol+"Img").alt="Visualizza "+testoMsg;
      document.getElementById(nomeCol+"Img").title="Visualizza "+testoMsg;
      document.getElementById("viewer").style="width: 95%;";
      document.getElementById("viewer").style.width="95%";
    }
  }
//  myResize();
  return false;
}
