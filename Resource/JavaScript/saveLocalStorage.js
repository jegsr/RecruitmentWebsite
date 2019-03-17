function objOfertas() {
    this.titulo;
    this.descritivo;
    this.requisitos;
    this.categoria;
    this.categoriaespecifica;
    this.remuneracao;
    this.tipoHorario;
    this.dataInicio;
    this.dataFim;
}



function storeOferta() {
    var array1 = new objOfertas();
    var arrayOfertas = [];


    array1.titulo = document.getElementById('titulo').value;
    array1.descritivo = document.getElementById('descritivo').value;
    array1.requisitos = document.getElementById('requisitos').value;
    array1.categoria = document.getElementById('categoria').value;
    array1.categoriaespecifica = document.getElementById('categoriaespecifica').value;
    array1.remuneracao = document.getElementById('remuneracao').value;
    array1.tipoHorario = document.getElementById('tipoHorario').value;
    array1.dataInicio = document.getElementById('dataInicio').value;
    array1.dataFim = document.getElementById('dataFim').value;

    if (localStorage['ofertasTemporarias'] != undefined && localStorage['ofertasTemporarias'] != null) {
        arrayOfertas = JSON.parse(localStorage['ofertasTemporarias']);
    }

    
    arrayOfertas[arrayOfertas.length] = array1;


    localStorage.setItem('ofertasTemporarias', JSON.stringify(arrayOfertas));
    
     this.parentNode.parentNode.remove();
    
    var section =  document.createElement('section');
    section.setAttribute('id','criarOferta')
    var h1 =document.createElement('h1');
    h1.innerHTML='Guardado com sucesso';
    section.appendChild(h1);
    
    var parent=document.getElementById('rodape');
    parent.parentNode.insertBefore(section,parent);
}

function initEvent() {
    document.getElementById('storeOferta').addEventListener('click', storeOferta);
}

document.addEventListener('DOMContentLoaded', initEvent);






