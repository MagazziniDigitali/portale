function blurKeyword(){
  if (document.getElementById("keyword").value == "")
  {
    document.getElementById("keyword").classList.add("defaultTextActive");
    document.getElementById("keyword").value = document.getElementById("keyword").title;
  }
}

function focusKeyword(){
  if (document.getElementById("keyword").value == document.getElementById("keyword").title)
  {
    document.getElementById("keyword").classList.remove("defaultTextActive");
    document.getElementById("keyword").value="";
  }
}

function initKeyword(){
  if (document.getElementById("keyword") != null){
    document.getElementById("keyword").addEventListener("focus", focusKeyword);
    document.getElementById("keyword").addEventListener("blur", blurKeyword);
    blurKeyword();
  } else {
    setTimeout(initKeyword,1000);
  }
}
setTimeout(initKeyword,1000);

function onChangeTecaHome(url){
  var form=document.getElementById("tecaSearchForm");
  form.action=url;
  form.submit();
}
