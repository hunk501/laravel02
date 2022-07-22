<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>Profile Page</title>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
      <style>
        html,
        body,
        .container {
          height: 100%;
          overflow: hidden;
        }

        .container {
          display: flex;
          justify-content: center;
        }

        #object {
          height: 300px;
          width: 800px;
          align-self: center;
        }
        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
          padding: 15px;
        }
        thead {
          font-weight: bold;
        }
      </style>
    </head>
    <body class="antialiased">
        <div class="container">
          <div id="object">
            <p><h2>Fetch Github Usernames</h2></p>
            <form id="myform">
              <p>
                <input type="text" id="search" name='search' placeholder="Username"/> &nbsp; 
                <button>Search</button> &nbsp; 
                <a href="{{ url('/') }}">Home</a>
              </p>
            </form>
            <div>
              <table id="mytable" padding="60">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Login</th>
                    <th>Company</th>
                    <th>Followers</th>
                    <th>Public Repo</th>
                    <th>Average of Followers</th>
                  </tr>
                </thead>
                <tbody id="results">
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <input type="hidden" id="api" value="{{ url('/api/github') }}"/>
        <script>
          $(document).ready(function(){
            /**
             * Seach Button
             */
            $('button').on('click', function(event){
              event.preventDefault();
              
              var str = $('#search').val();
              var keepGoing = true;
              $("#results tr").length;
              if($("#results tr").length >= 10) {
                alert('Maximum limit only 10');
                keepGoing = false;
              }
              if(!str) {
                alert('Please fill out string to be search!');
                keepGoing = false;
              }
              if(keepGoing) {
                ajaxQuery(str);
              }
            });

          });

          function ajaxQuery(e) {
            $.ajax({
              type: 'POST',
              data: $('#myform').serialize(),
              url: $('#api').val(),
              beforeSend: function() {
                console.log('beforesend');
                //$('#results').html('');
              },
              success: function(res) {
                console.log(res);
                if(res.success) {
                  $("#"+ res.data.login).remove();
                  buildData(res.data);
                } else {
                  //$('#results').html('<tr><td colspan="6" style="color:red;">'+ res.message +'</td></tr>');
                  alert(res.message);
                }
              },
              error: function(er) {
                console.log(er);
                alert(er);
              } 
            });
          }

          function buildData(user) {
            let tr = '<tr id="'+ user.login +'">';

            tr += '<td>' + user.name + '</td>';
            tr += '<td>' + user.login + '</td>';
            tr += '<td>' + user.company + '</td>';
            tr += '<td>' + user.followers + '</td>';
            tr += '<td>' + user.repositories + '</td>';
            tr += '<td>' + user.avarage_follower + '</td>';
            tr += '</tr>';

            $('#results').prepend(tr);
            // Sort table
            sortTable($('#mytable'));
          }

          function sortTable(table) {
            var asc = 'asc';
            var tbody = table.find('tbody');

            tbody.find('tr').sort(function(a, b) {
              return $('td:first', a).text().localeCompare($('td:first', b).text());
            }).appendTo(tbody);
          }

        </script>
    </body>
</html>
