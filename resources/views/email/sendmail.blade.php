<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>email send</title>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body >

            <h1>Daily Stock Report</h1>
            <br/><br/><br/>

            
            <table>
                <thead>
                    <tr>
                        <th>Ticker</th>
                        <th>Market</th>
                        <th>Yesterday Price</th>
                        <th>Todays Price</th>
                        <th>Change (%)</th>
                        <th>Date</th>
                    </tr>
                <thead>

                <tbody>
                    @foreach( $details as $stock )


                    <tr>
                       <td>{{ $stock->ticker }}</td>
                       <td>{{ $stock->market }}</td>
                       <td>{{ $stock->open }}</td>
                       <td>{{ $stock->close }}</td>
                       <td>{{ $stock->change}}</td>
                       <td>{{ $stock->created_at }}</td>
                     <tr>

                     @endforeach
                </tbody>

            </table>


        
    </body>
</html>
