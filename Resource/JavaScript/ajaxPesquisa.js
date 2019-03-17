

function semPesquisa(session) {
    var article = document.createElement('article');
    var h1 = document.createElement('h1');
    h1.setAttribute('class', 'Erro');
    h1.innerHTML = "Não existe pesquisas para os parametros selecionados";
    article.appendChild(h1);
    session.appendChild(article);
    return session;
}

function pesquisar() {
    
    var tipoHorario = document.getElementsByName('tipoHorario');
    var i = 0;
    while (i < tipoHorario.length && !tipoHorario[i].checked) {
        i++;
    }


    if (isNaN(tipoHorario[i].value) && !isFinite(tipoHorario[i].value)) {
        alert('erro1');
    }


    var categoria = document.getElementById('categoria');
    var subCategoria = document.getElementById('subCategoria');
    if ((subCategoria.value).length > 150) {
        alert('erro4');
    }

    var distrito = document.getElementById('distrito');
    var concelho = document.getElementById('concelho');
    if ((concelho.value).length > 150) {
        alert('erro7');
    }

    var texto = document.getElementById('textoPesquisa');
    if ((texto.value).length > 150) {
        alert('erro9');
    }

    $.post('./Application/Utils/pesquisarValidate.php', {'tipoHorario': tipoHorario[i].value,
        'categoria': categoria[categoria.selectedIndex].value,
        'subCategoria': subCategoria.value,
        'distrito': distrito[distrito.selectedIndex].value,
        'concelho': concelho.value,
        'texto': texto.value}, function (data) {


        var section;
        if ((session = document.getElementById('ofertasEmprego')) !== null) {
            session.parentNode.removeChild(session);
        }


        section = document.createElement('section');
        section.setAttribute('id', 'ofertasEmprego');
        var json = JSON.parse(data);

        if (json.length > 0) {
            
            var i;
            for (i = 0; i < json.length; i++) {

                var article = document.createElement('article');
                var fieldSet = document.createElement('fieldset');
                article.setAttribute('class', 'oferta');
                article.setAttribute('id', json[i].id);
                var key = Object.keys(json[i]);
                for (var j = 0; j < key.length; j++) {

                    var h1 = document.createElement('h1');
                    switch (key[j]) {
                        case 'categoriaespecifica':
                            h1.innerHTML = 'categoria especifica: ';
                            break;
                        case 'dataInicio':
                            h1.innerHTML = 'data inicio: ';
                            break;
                        case 'dataFim':
                            h1.innerHTML = 'data fim: ';
                            break;
                        case 'tipoHorario':
                            h1.innerHTML = 'tipo horario: ';
                            break;
                        default:
                            h1.innerHTML = key[j] + ': ';
                    }
                    var h3 = document.createElement('h3');
                    h3.innerHTML = json[i][key[j]];
                    fieldSet.appendChild(h1);
                    fieldSet.appendChild(h3);
                }
                article.appendChild(fieldSet);
                var button = document.createElement('button');
                button.setAttribute('class', 'Favorito');
                button.innerHTML = "Favorito";
                button.addEventListener('click', favorito);
                article.appendChild(button);

                var button1 = document.createElement('button');
                button1.setAttribute('class', 'Candidatar');
                button1.innerHTML = "Candidatar";
                button1.addEventListener('click', candidatar);
                article.appendChild(button1);

                var button2 = document.createElement('button');
                button2.setAttribute('class', 'Visualizar');
                button2.innerHTML = "Visualizar";
                button2.addEventListener('click', visualizar);
                article.appendChild(button2);
                section.appendChild(article);
            }
        } else {
            section = semPesquisa(section);
        }

        var pesquisar=document.getElementById('rodape');
        pesquisar.parentNode.insertBefore(section,pesquisar);
    });
}

function favorito() {
    var id_oferta = this.parentNode.getAttribute('id');


    if ($.isNumeric(id_oferta)) {
        $.post('./Application/Utils/pesquisarValidate.php', {'favorito': 'true', 'id_oferta': id_oferta}, function (data) {




            console.log(data);

            var json = JSON.parse(data);
            console.log(json);

            if (json.length > 0) {

                if (localStorage['ofertasFavoritas'] != undefined && localStorage['ofertasFavoritas'] != null) {
                    var arrayFavoritas = JSON.parse(localStorage['ofertasFavoritas']);
                }


                arrayFavoritas[arrayFavoritas.length] = json;


                localStorage.setItem('ofertasFavoritas', JSON.stringify(arrayFavoritas));

            }
        });
    } else {
        alert('erro ao enviar favorito');
    }
}

function visualizar() {
   window.location.href = './visualizarOferta.php?id='+this.parentNode.getAttribute('id');
}

function candidatar() {
    var id_oferta = this.parentNode.getAttribute('id');


    if ($.isNumeric(id_oferta)) {
        $.post('./Application/Utils/pesquisarValidate.php', {'candidatar': 'true', 'id_oferta': id_oferta}, function (data) {
            
        });
    } else {
        alert('erro ao enviar favorito');
    }
}

function initEvent() {
    document.getElementById('Pesquisar').addEventListener('click', pesquisar);

}

document.addEventListener('DOMContentLoaded', initEvent);

