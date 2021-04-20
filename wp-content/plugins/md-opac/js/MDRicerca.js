/**
 * 
 */
function tecaRecPagKeyPress(event, campo){
	var chCode = event.keyCode;
	if (chCode==13 ||
			chCode==10){
		cerca(0, campo.value);
//        var tecaSearchForm = document.getElementById("tecaSearchForm");
//        tecaSearchForm.elements["recPag"].value = campo.value;
//        tecaSearchForm.elements["qStart"].value = 0;
//        document.forms.tecaSearchForm.submit();
	}
}

//function changePage(qStart){
//    var tecaSearchForm = document.getElementById("tecaSearchForm");
//    tecaSearchForm.elements["qStart"].value = qStart;
//    document.forms.tecaSearchForm.submit();
//}

function cerca(qStart, recPag){
    var x = document.getElementById("tecaSearchFacet");
    var tecaSearchForm = document.getElementById("tecaSearchForm");
    var text = "";
    var i;
    if (x != undefined){
        for (i = 0; i < x.length ;i++) {
            if (x.elements[i].type=='checkbox'){
              if (x.elements[i].checked){
                if (text != ''){
                  text += " ";
                }
                if (x.elements[i].name=='soggettoConservatore'){
                	if (x.elements[i].value=='non_identificabile'){
                        text += "+"+x.elements[i].name+":\"non identificabile\"";
                	} else {
                        text += "+"+x.elements[i].name+":\""+x.elements[i].value + "\"";
                	}
                }else if (x.elements[i].name=='subFondo'){
                	if (x.elements[i].value=='I_Serie_Carte_Patrimoniali'){
                        text += "+"+x.elements[i].name+":\"Serie_Carte_Patrimoniali\"";
                	} else {
                        text += "+"+x.elements[i].name+":\""+x.elements[i].value + "\"";
                	}
                } else {
                    text += "+"+x.elements[i].name+":\""+x.elements[i].value + "\"";
                }
              }
            }
        }
	text = text.replace(new RegExp('%22','g'),'"');
        tecaSearchForm.elements["facetQuery"].value = text;
    }

    x = document.getElementById("ricercaAvanzata");
    if ((x.style.display === 'block' &&
        $('.chosen-select').val() != null) ||
        (document.getElementById("agentSoftware") != null &&
          document.getElementById("agentSoftware").checked) ||
        (document.getElementById("oggettoDiritti") != null &&
          document.getElementById("oggettoDiritti").checked) ||
        (document.getElementById("contenitoreAdmtape") != null &&
          document.getElementById("contenitoreAdmtape").checked) ||
        (document.getElementById("eventSend") != null &&
          document.getElementById("eventSend").checked) ||
        (document.getElementById("eventDecompress") != null &&
          document.getElementById("eventDecompress").checked) ||
        (document.getElementById("eventValidation") != null &&
          document.getElementById("eventValidation").checked) ||
        (document.getElementById("eventCopyPremis") != null &&
          document.getElementById("eventCopyPremis").checked) ||
        (document.getElementById("eventMoveFile") != null &&
          document.getElementById("eventMoveFile").checked) ||
        (document.getElementById("eventGeoReplica") != null &&
          document.getElementById("eventGeoReplica").checked) ||
        (document.getElementById("eventIndex") != null &&
          document.getElementById("eventIndex").checked) ||
        (document.getElementById("fileMd5") != null &&
          document.getElementById("fileMd5").checked) ||
        (document.getElementById("fileHtml") != null &&
          document.getElementById("fileHtml").checked) ||
        (document.getElementById("fileJp2") != null &&
          document.getElementById("fileJp2").checked) ||
        (document.getElementById("fileJpeg") != null &&
          document.getElementById("fileJpeg").checked) ||
        (document.getElementById("fileTif") != null &&
          document.getElementById("fileTif").checked) ||
        (document.getElementById("filePremis") != null &&
          document.getElementById("filePremis").checked) ||
        (document.getElementById("fileJson") != null &&
          document.getElementById("fileJson").checked) ||
        (document.getElementById("fileManifest") != null &&
          document.getElementById("fileManifest").checked) ||
        (document.getElementById("oggettoRegistro") != null &&
          document.getElementById("oggettoRegistro").checked)
        ) {
      var raFiltri = document.getElementById('RA_filtri');
      var result = "<mdRicercaAvanzata>";
      var search = "";

      for (x=0; x<raFiltri.options.length; x++){
        result += "<RA_filtri>";
        result += "<text>"+encodeXml(raFiltri.options[x].text)+"</text>";
        result += "<value>"+encodeXml(raFiltri.options[x].value)+"</value>";
        result += "<selected>"+raFiltri.options[x].selected+"</selected>";
        if (raFiltri.options[x].selected){
          search += encodeXml(raFiltri.options[x].value)+" ";
        }
        result += "</RA_filtri>";
      }
      result += "<RA_esclusioni>";
      if (document.getElementById("agentSoftware") != null &&
          document.getElementById("agentSoftware").checked){
        result += "<agentSoftware>true</agentSoftware>";
      }
      if (document.getElementById("oggettoDiritti") != null &&
          document.getElementById("oggettoDiritti").checked){
        result += "<oggettoDiritti>true</oggettoDiritti>";
      }
      if (document.getElementById("contenitoreAdmtape") != null &&
          document.getElementById("contenitoreAdmtape").checked){
        result += "<contenitoreAdmtape>true</contenitoreAdmtape>";
      }
      if (document.getElementById("eventSend") != null &&
          document.getElementById("eventSend").checked){
        result += "<eventSend>true</eventSend>";
      }
      if (document.getElementById("eventDecompress") != null &&
          document.getElementById("eventDecompress").checked){
        result += "<eventDecompress>true</eventDecompress>";
      }
      if (document.getElementById("eventValidation") != null &&
          document.getElementById("eventValidation").checked){
        result += "<eventValidation>true</eventValidation>";
      }
      if (document.getElementById("eventCopyPremis") != null &&
          document.getElementById("eventCopyPremis").checked){
        result += "<eventCopyPremis>true</eventCopyPremis>";
      }
      if (document.getElementById("eventMoveFile") != null &&
          document.getElementById("eventMoveFile").checked){
        result += "<eventMoveFile>true</eventMoveFile>";
      }
      if (document.getElementById("eventGeoReplica") != null &&
          document.getElementById("eventGeoReplica").checked){
        result += "<eventGeoReplica>true</eventGeoReplica>";
      }
      if (document.getElementById("eventIndex") != null &&
          document.getElementById("eventIndex").checked){
        result += "<eventIndex>true</eventIndex>";
      }
      if (document.getElementById("fileMd5") != null &&
          document.getElementById("fileMd5").checked){
        result += "<fileMd5>true</fileMd5>";
      }
      if (document.getElementById("fileHtml") != null &&
          document.getElementById("fileHtml").checked){
        result += "<fileHtml>true</fileHtml>";
      }
      if (document.getElementById("fileJp2") != null &&
          document.getElementById("fileJp2").checked){
        result += "<fileJp2>true</fileJp2>";
      }
      if (document.getElementById("fileJpeg") != null &&
          document.getElementById("fileJpeg").checked){
        result += "<fileJpeg>true</fileJpeg>";
      }
      if (document.getElementById("fileTif") != null &&
          document.getElementById("fileTif").checked){
        result += "<fileTif>true</fileTif>";
      }
      if (document.getElementById("filePremis") != null &&
          document.getElementById("filePremis").checked){
        result += "<filePremis>true</filePremis>";
      }
      if (document.getElementById("fileJson") != null &&
          document.getElementById("fileJson").checked){
        result += "<fileJson>true</fileJson>";
      }
      if (document.getElementById("fileManifest") != null &&
          document.getElementById("fileManifest").checked){
        result += "<fileManifest>true</fileManifest>";
      }
      if (document.getElementById("oggettoRegistro") != null &&
          document.getElementById("oggettoRegistro").checked){
        result += "<oggettoRegistro>true</oggettoRegistro>";
      }

      result += "</RA_esclusioni>";
      result += "<search>"+search.trim()+"</search>";
      result += "</mdRicercaAvanzata>";
      tecaSearchForm.elements["RA_Fields"].value = toHex(result);
    }
    tecaSearchForm.elements["qStart"].value = qStart;
    if (recPag != undefined){
    	tecaSearchForm.elements["recPag"].value = recPag;
    }
    document.forms.tecaSearchForm.submit();
}

function toHex(str) {
    var hex = '';
    var i = 0;
    while(str.length > i) {
        hex += ''+str.charCodeAt(i).toString(16);
        i++;
    }
    return hex;
} 

var xml_special_to_escaped_one_map = {
    '&': '&amp;',
    '"': '&quot;',
    '<': '&lt;',
    '>': '&gt;'
};

var escaped_one_to_xml_special_map = {
    '&amp;': '&',
    '&quot;': '"',
    '&lt;': '<',
    '&gt;': '>'
};

function encodeXml(string) {
    return string.replace(/([\&"<>])/g, function(str, item) {
        return xml_special_to_escaped_one_map[item];
    });
};

function decodeXml(string) {
    return string.replace(/(&quot;|&lt;|&gt;|&amp;)/g,
        function(str, item) {
            return escaped_one_to_xml_special_map[item];
    });
}


function showSchedaByBid(id){
        var currentLocation = window.location;
        var url = currentLocation.protocol+
                        '//'+
                        currentLocation.hostname+
                        ':'+
                        currentLocation.port+
                        currentLocation.pathname+
                        '?view=show&bid='+
                        id;
        window.location = url;
}

function showScheda(id){
        var currentLocation = window.location;
/*
        var pos = currentLocation.pathname.indexOf('index.php');
        var url = currentLocation.protocol+
                        '//'+
                        currentLocation.hostname+
                        ':'+
                        currentLocation.port+
                        '/'+
                        currentLocation.pathname.substring(0,pos)+
                        'index.php?option=com_tecaricerca&view=show&myId='+
                        id;
*/
        var url = currentLocation.protocol+
                        '//'+
                        currentLocation.hostname+
                        ':'+
                        currentLocation.port+
                        currentLocation.pathname+
                        '?view=show&myId='+
                        id;
        window.location = url;
}

function findTeca(key, value){
        var currentLocation = window.location;
        var url = currentLocation.protocol+
                        '//'+
                        currentLocation.hostname+
                        ':'+
                        currentLocation.port+
                        currentLocation.pathname+
                        '?view=search&keySolr='+key+'&valueSolr='+
                        value;
        window.location = url;

}

function showImg(id){
  var currentLocation = window.location;

  var url = currentLocation.protocol+
                '//'+
                currentLocation.hostname+
                ':'+
                currentLocation.port+
                currentLocation.pathname+
                '?option=com_tecaviewer&view=showimg&myId='+id;
  window.location = url;
}

function showImgPopup(id){
  var currentLocation = window.location;

  var url = currentLocation.protocol+
                '//'+
                currentLocation.hostname+
                ':'+
                currentLocation.port+
                currentLocation.pathname+
                '?option=com_tecaviewer&view=showimg&myId='+id;
//  window.location = url;
  var popup_window=window.open(url, '_blank');
  try 
  {
    popup_window.focus();   
  } catch (e) {
    alert("!!! Attenzione !!! il vostro browser non permette l'apertura di Pop-up");
  }
}

function showOgettiDigitaliId(soggettoConservatoreKey, fondoKey, subFondoKey, subFondo2Key){
  var currentLocation = window.location;
  var url = "";

  url = currentLocation.protocol+'//'+currentLocation.hostname+':'+currentLocation.port+currentLocation.pathname;
  url += '?valueSolr=';
  url += '&keySolr=';
  url += '&qStart=0';
  url += '&facetQuery=%2BsoggettoConservatoreKey_fc%3A%22'+soggettoConservatoreKey+'%22';
  if (fondoKey != undefined){
    url += '+%2BfondoKey_fc%3A%22'+fondoKey.replace(new RegExp(soggettoConservatoreKey+'.','g'),'')+'%22';
  }
  if (subFondoKey!=undefined){
    url += '+%2BsubFondoKey_fc%3A%22'+subFondoKey.replace(new RegExp(soggettoConservatoreKey+'.'+fondoKey+'.','g'),'')+'%22';
  }
  if (subFondo2Key!=undefined){
    url += '+%2BsubFondo2Key_fc%3A%22'+subFondo2Key+'%22';
  }
  url += '&recPag=10';
  url += '&keyword=';
  window.location = url;
}

function showOgettiDigitali(soggettoConservatore, fondo){
  var currentLocation = window.location;

  var url = currentLocation.protocol+
                '//'+
                currentLocation.hostname+
                ':'+
                currentLocation.port+
                currentLocation.pathname+
                '?valueSolr=&keySolr=&qStart=0&facetQuery=%2BsoggettoConservatore_fc%3A%22'+soggettoConservatore.replace(new RegExp(' ','g'),'_')+
		'%22+%2Bfondo_fc%3A%22'+fondo.replace(new RegExp(' ','g'),'_')+
		'%22&recPag=10&keyword=Ricerca+per+parola%3A';
  window.location = url;
}
