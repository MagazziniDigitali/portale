/**
 * 
 */

function showHidden(myDiv) {
    var x = document.getElementById(myDiv);
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}

function addRicercaAvanzata() {
  var raFiltri = document.getElementById('RA_filtri');
  var operatore = "";
  var ricerca ="";
  var opt;


  if (!(document.getElementById('RA_campoName').value != "" &&
      document.getElementById('RA_campoValue').value != "") &&
      !document.getElementById('RA_dataDa').value != "" &&
      !document.getElementById('RA_depositatoDa').value != "") {
    alert("Selezonare almeno una combinazione valida");
    return false;
  }

  if (document.getElementById('RA_operatore').value==='and'){
    operatore="+";
  } else if (document.getElementById('RA_operatore').value==='not'){
    operatore="-";
  }
  document.getElementById('RA_operatore').value = "and";

  if (document.getElementById('RA_campoName').value != "" &&
      document.getElementById('RA_campoValue').value != ""){
    campo = document.getElementById('RA_campoName').value;
    valore = document.getElementById('RA_campoValue').value.trim();
    ricerca = "";

    ricerca = analizzaTesto(operatore, campo, valore);

    if (ricerca !=""){
        opt = document.createElement("option");
        opt.value= ricerca;
        opt.text= ricerca;
        opt.selected="selected";
        raFiltri.add(opt);
    }
    document.getElementById('RA_campoName').value = "";
    document.getElementById('RA_campoValue').value = "";
  } 
  if (document.getElementById('RA_dataDa').value != ""){
    ricerca = "";

    if (document.getElementById('RA_dataA').value != ""){
      ricerca = "data:["+document.getElementById('RA_dataDa').value+" TO "+document.getElementById('RA_dataA').value+"]";
    } else {
      ricerca = "data:\""+document.getElementById('RA_dataDa').value+"\"";
    }
    if (ricerca !=""){
        opt = document.createElement("option");
        opt.value= operatore+ricerca;
        opt.text= operatore+ricerca;
        opt.selected="selected";
        raFiltri.add(opt);
    }
    document.getElementById('RA_dataDa').value = "";
    document.getElementById('RA_dataA').value  = "";
  }

  if (document.getElementById('RA_depositatoDa').value != ""){
    //indexed:[2017-02-16T00:00:00.000Z TO 2017-02-18T23:59:59.000Z]
    ricerca = "";
    if (checkDate(document.getElementById('RA_depositatoDa'))){
      ricerca = "indexed:["+convertDate(document.getElementById('RA_depositatoDa').value, true)+" TO ";
      if (document.getElementById('RA_depositatoA').value != "" &&
          checkDate(document.getElementById('RA_depositatoA'))){
        ricerca +=convertDate(document.getElementById('RA_depositatoA').value, false);
      } else {
        ricerca += "*";
      }
      ricerca += "]";
    }
    if (ricerca !=""){
        opt = document.createElement("option");
        opt.value= operatore+ricerca;
        opt.text= operatore+ricerca;
        opt.selected="selected";
        raFiltri.add(opt);
    }
    document.getElementById('RA_depositatoDa').value = "";
    document.getElementById('RA_depositatoA').value  = "";
  } 

  $('.chosen-select').trigger('chosen:updated');
}

function analizzaTesto(operatore, campo, valore){
  var result = "";
  var pos=-1;

  valore = valore.trim();
  if (valore.substring(0,1) =="\""){
    valore = valore.substring(1);
    pos = valore.indexOf("\"");
    if (pos>-1){
      result = operatore+campo+":\""+valore.substring(0,pos)+"\"";
      valore = valore.substring(pos+1);
      if (valore.trim() != ""){
        result += " "+analizzaTesto(operatore, campo, valore);
      }
    } else {
      result = operatore+campo+":\""+valore+"\"";
    }
  } else {
    pos = valore.indexOf(" ");
    if (pos>-1){
      result = operatore+campo+":"+valore.substring(0,pos)+" ";
      result += analizzaTesto(operatore, campo, valore.substring(pos));
    } else {
      result = operatore+campo+":"+valore;
    }
  }
  return result;
}

function convertDate(myDate, inizio){
  var parts = "";
  var dt;

  parts = myDate.split('/');
  dt = parts[2]+"-"+parts[1]+"-"+parts[0];
  if (inizio) {
    dt+="T00:00:00.000Z";
  } else {
    dt+="T23:59:59.999Z";
  }
  return dt;
}

// Original JavaScript code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.

function checkDate(field)
{
  var allowBlank = true;
  var minYear = 1902;
  var maxYear = (new Date()).getFullYear();

  var errorMsg = "";

  // regular expression to match required date format
  re = /^(\d{1,2})\/(\d{1,2})\/(\d{4})$/;

  if(field.value != '') {
    if(regs = field.value.match(re)) {
      if(regs[1] < 1 || regs[1] > 31) {
        errorMsg = "Invalid value for day: " + regs[1];
      } else if(regs[2] < 1 || regs[2] > 12) {
        errorMsg = "Invalid value for month: " + regs[2];
      } else if(regs[3] < minYear || regs[3] > maxYear) {
        errorMsg = "Invalid value for year: " + regs[3] + " - must be between " + minYear + " and " + maxYear;
      }
    } else {
      errorMsg = "Invalid date format: " + field.value;
    }
  } else if(!allowBlank) {
    errorMsg = "Empty date not allowed!";
  }

  if(errorMsg != "") {
    alert(errorMsg);
    field.focus();
    return false;
  }

  return true;
}
