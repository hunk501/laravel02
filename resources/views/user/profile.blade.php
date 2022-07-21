<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>Profile Page</title>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    </head>
    <body class="antialiased">
        <div>
          <div>
            <p><h2>Profile</h2></p>
            <form id="myform">
              <p><input type="text" id="search" name='search' placeholder="Github Username"/> &nbsp; <button>Search</button></p>
            </form>
            <div>
              <table>
                <thead>
                  <tr>
                    <td>Name</td>
                    <td>Login</td>
                    <td>Company</td>
                    <td>Followers</td>
                    <td>Repos</td>
                    <td>Average</td>
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
              if(str) {
                ajaxQuery(str);
              } else {
                alert('Please fill out string to be search!');
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
                $('#results').html('');
              },
              success: function(res) {
                console.log(res);
                buildData(res);
              },
              error: function(er) {
                console.log(er);
                alert(er);
              } 
            });
          }

          function buildData(user) {
            let tr = '<tr>';

            tr += '<td>' + user.name + '</td>';
            tr += '<td>' + user.login + '</td>';
            tr += '<td>' + user.company + '</td>';
            tr += '<td>' + user.followers + '</td>';
            tr += '<td>' + user.repositories + '</td>';
            tr += '<td>' + user.avarage_follower + '</td>';
            tr += '</tr>';

            $('#results').html(tr);
          }
        </script>
    </body>
</html>
