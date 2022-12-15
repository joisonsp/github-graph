
const ul = document.querySelector('#list-repo')

function getRepo() {
    fetch('https://api.github.com/users/'+username+'/repos')
      .then(async res => {

        if(!res.ok) {
          throw new Error(res.status)
        }

        var data = await res.json()

        data.map(item => {

            var li=document.createElement("option");
            li.value=item.name;

            li.innerHTML = `
            ${item.name}

        `

        ul.appendChild(li)

        })

      }).catch(e => console.log(e))
  }
getRepo()

$(document).ready(function() {

    async function getCommits(url) {

        const headers = {
            "Accept" : "application/vnd.github.cloak-preview"
        }
        const response = await fetch(url, {
            "method" : "GET",
            "headers" : headers
        })

        const result = await response.json()
        var results = result.items
        console.log(results)
        let cont = 0;
        let quantidades = []
        let datas = []
        for (let index = 0; index < results.length; index++) {
            datas.push(results[index].commit.author.date);
            cont++;
            quantidades.push(cont)
            let data = {
                login: results[index].author.login,
                comments_url: results[index].comments_url,
                date: results[index].commit.author.date
            }
            fetch('http://127.0.0.1:8000/api/commit/cadastro', {
                method: "POST",
                body: JSON.stringify(data),
                headers: {"Content-type": "application/json; charset=UTF-8"}
                })
            .then(response => response.json())
            .catch(err => console.log(err));
        }

        geraGraficos(datas, quantidades);



    }

    $('#list-repo').change(function() {
        var dateObj = new Date();
        var month = dateObj.getUTCMonth() + 1; //months from 1-12
        var day = dateObj.getUTCDate();
        var year = dateObj.getUTCFullYear();

        newdate = year + "-" + month + "-" + day;


        var ultimoDia = new Date();
        ultimoDia.setDate(ultimoDia.getDate() - 90);
        var month = ultimoDia.getUTCMonth() + 1; //months from 1-12
        var day = ultimoDia.getUTCDate();
        var year = ultimoDia.getUTCFullYear();

        olddate = year + "-" + month + "-" + day;

        valor = $("#list-repo").val();
        let url = `https://api.github.com/search/commits?q=repo:${username}/${valor} author-date:${olddate}..${newdate}`//'https://api.github.com/search/commits?q=repo:freecodecamp/freecodecamp author-date:2019-03-01..2019-03-31'
        getCommits(url)



    });

    function geraGraficos(datas, quantidades){
        var ctx = document.getElementById('myChart').getContext('2d');

        var chart = new Chart(ctx, {

            type: 'bar',
            data: {
                labels: datas,


                datasets: [{
                    label: 'Cotações',
                    borderColor: 'rgb(195, 98, 65)',
                    data: quantidades
                }]
            },

            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

  });




