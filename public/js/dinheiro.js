String.prototype.extenso = function(c){
    var ex = [
        ["zero", "um", "dois", "tres", "quatro", "cinco", "seis", "sete", "oito", "nove", "dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezessete", "dezoito", "dezenove"],
        ["dez", "vinte", "trinta", "quarenta", "cinqüenta", "sessenta", "setenta", "oitenta", "noventa"],
        ["cem", "cento", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"],
        ["mil", "milhao", "bilhao", "trilhao", "quadrilhao", "quintilhao", "sextilhao", "setilhao", "octilhao", "nonilhao", "decilhao", "undecilhao", "dodecilhao", "tredecilhao", "quatrodecilhao", "quindecilhao", "sedecilhao", "septendecilhao", "octencilhao", "nonencilhao"]
    ];
    var a, n, v, i, n = this.replace(c ? /[^,\d]/g : /\D/g, "").split(","), e = " e ", $ = "Meticais", d = "centavo", sl;
    for(var f = n.length - 1, l, j = -1, r = [], s = [], t = ""; ++j <= f; s = []){
        j && (n[j] = (("." + n[j]) * 1).toFixed(2).slice(2));
        if(!(a = (v = n[j]).slice((l = v.length) % 3).match(/\d{3}/g), v = l % 3 ? [v.slice(0, l % 3)] : [], v = a ? v.concat(a) : v).length) continue;
        for(a = -1, l = v.length; ++a < l; t = ""){
            if(!(i = v[a] * 1)) continue;
            i % 100 < 20 && (t += ex[0][i % 100]) ||
            i % 100 + 1 && (t += ex[1][(i % 100 / 10 >> 0) - 1] + (i % 10 ? e + ex[0][i % 10] : ""));
            s.push((i < 100 ? t : !(i % 100) ? ex[2][i == 100 ? 0 : i / 100 >> 0] : (ex[2][i / 100 >> 0] + e + t)) +
            ((t = l - a - 2) > -1 ? " " + (i > 1 && t > 0 ? ex[3][t].replace("ao", "ões") : ex[3][t]) : ""));
        }
        a = ((sl = s.length) > 1 ? (a = s.pop(), s.join(" ") + e + a) : s.join("") || ((!j && (n[j + 1] * 1 > 0) || r.length) ? "" : ex[0][0]));
        a && r.push(a + (c ? (" " + (v.join("") * 1 > 1 ? j ? d + "s" : (/0{6,}$/.test(n[0]) ? "de " : "") + $.replace("l", "is") : j ? d : $)) : ""));
    }
    return r.join(e);
};

function extenso(valor,local = 'extenso'){
  let v = ""+valor;
  if(v===""){
    document.getElementById(local).value = "";
    return;
  }
  // console.log(typeof(v));
  v = v.replaceAll("MT","");
  v = v.replaceAll(",","")
  var x = v.split(".");
  if(x.length === 2){
    var valor = x[0].extenso()+" meticais";
    if(parseInt(x[1]) > 0){
      valor += " e "+x[1].extenso()+" centavos."; 
    }else{
      valor += ".";
    }
  }else{
    var valor = x[0].extenso()+" meticais ";
  }
  //alert("x[1] = "+x[0]);
    if(x[0].length===4)
      valor = valor.replace("um mil","mil");
  valor = valor.charAt(0).toUpperCase() + valor.slice(1);
  document.getElementById(local).value = valor;
}
function replaceAllMoeda(valor){
    for(i=0;i<6;i++){
        valor = valor.replaceAll("MT", "");
        valor = valor.replaceAll(",", "");
        valor = valor.replaceAll(" ", "");
    }
    return valor;
}


function replaceMoeda(valor){
    for(i=0;i<6;i++){
        valor = valor.replace("MT", "");
        valor = valor.replace(",", "");
        valor = valor.replace(" ", "");
    }
    return valor;
}
/** Number format **/
function number_format (number, decimals, decPoint, thousandsSep) { // eslint-disable-line camelcase

  number = (number + '').replaceAll(/[^0-9+\-Ee.]/g, '')
  var n = !isFinite(+number) ? 0 : +number
  var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
  var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
  var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
  var s = ''

  var toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec)
    return '' + (Math.round(n * k) / k)
      .toFixed(prec)
  }

  // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
  if (s[0].length > 3) {
    s[0] = s[0].replaceAll(/\B(?=(?:\d{3})+(?!\d))/g, sep)
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || ''
    s[1] += new Array(prec - s[1].length + 1).join('0')
  }

  return s.join(dec);
}
/** Number format **/