<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Market Data</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: "Inter", sans-serif;
            font-size: 16px;
            overflow-x: hidden;
        }

        .menu-bar {
            display: flex;
            justify-content: space-around;
            margin: 0;
            padding: 0;
        }

        .menu {
            color: black;
        }

        .head-bar {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            border-bottom: 0.5px solid rgb(224, 235, 235);
            padding: 10px;
            width: 100%;
        }

        .main-logo {
            margin-left: 30px;
        }

        .nav-links {
            display: flex;
            justify-content: space-around;
            margin-right: 30px;
        }



        .table-link {
            margin-left: 5rem;
            color: black;
            text-decoration: none;
            padding: 2px;
        }

        .order_data {
            font-weight: bold;
            border: 3px solid rgb(102, 153, 0);
            border-radius: 5px;
        }

        .table-link:hover {
            color: rgb(102, 153, 0)
        }

        .content {
            padding-top: 2%;
            padding-left: 20px;
            padding-right: 20px;
        }

        .features {
            display: flex;
            justify-content: space-between;
            align-items: end;
        }

        .features-form {
            display: flex;
            justify-content: space-around;
            align-items: end;
            width: 55%;
        }

        @media (min-width: 580px) {
            .menu {
                display: none;
            }

        }

        @media (max-width: 500px) {

            .head-bar {
                flex-direction: column;
            }

            .nav-links {
                display: none;
                margin-top: 10px;
            }

            .nav-links {
                /* align-items: start; */
                flex-direction: column;
            }

            /* body{
                background-color: aqua;
            } */
            .features {
                background-color: #f5f5f5;
                flex-direction: column;
                justify-content: start;
                align-items: center;
                height: auto;
                width: 100%;
                /* flex-direction: column; */
            }

            .features-form {
                flex-direction: column;
                justify-content: start;
                align-items: start;
                width: 100%;
            }

            .home-link {
                margin: 10px;
            }

            #search_term {
                margin: 10px;
            }

            .date {
                margin: 10px;
            }

            .sortBy {
                margin: 10px;
            }

            .pagination {
                font-size: 10px;
            }
        }

        .home-link {
            background-color: rgb(222, 243, 252);
            color: black;
            padding: 4px;
            text-decoration: none;
            border-radius: 5px;
        }

        .home-link:hover {
            background-color: rgb(102, 153, 0)
        }

        #search_term {
            border-radius: 5px;
            width: 150px;
            padding: 4px;
        }

        #search_term:focus {
            border: 1px;
        }

        #start_date {
            padding: 4px;
        }

        #end_date {
            padding: 4px;
        }


        .date {
            display: flex;
        }

        .end {
            margin-left: 10px;
        }

        .sortBy {
            color: black;
        }

        #selectedName {
            padding: 7px;
        }

        .initiate_form {
            display: flex;
            justify-content: end;
        }

        #columnForm {
            display: flex;
            flex-wrap: wrap;
        }

        .parent-div {
            margin-top: 5px;
            max-height: 600px;
            overflow-y: auto;
            border: 1px solid black;
            width: 100%;
            border-radius: 5px;
        }

        table {
            width: 100%;
            /* Make the table full width */
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        thead th {
            background-color: #f5f5f5;
            position: sticky;
            /* Fix the table header */
            top: 0;
            /* Place it at the top of the parent div */
            background-color: #f5f5f5;
            z-index: 1;
            /* Make it appear on top of the table cells */

        }


        .form2 {
            display: flex;

            flex-wrap: wrap;
        }

        .check {

            margin-left: 10px;
            margin-right: 10px;
            margin-top: 10px;
            padding: 5px;
            border-radius: 10px;

        }


        .custom-checkbox,
        .check {
            color: white;
            background-color: rgb(4, 44, 91);
        }

        .selected {
            background-color: rgb(174, 205, 234);
        }

        #initiate {
            font-size: 11px;
            margin-left: 10px;
            background-color: rgb(222, 243, 252);
            border-radius: 8px;
        }

        #initiate:hover {
            background-color: rgb(89, 179, 0);

        }

        .pagination-block {
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            flex-wrap: wrap;
            list-style: none;
        }

        .pagination a {
            text-decoration: none;
            color: black;
        }

        .pagination>li {
            padding: 10px;

        }

        .page-item {
            border: 0.7px solid rgb(166, 166, 166);
            border-radius: 5px;
        }

        .page-item+.active {
            background-color: rgb(6, 5, 64);
            border: 0.7px solid rgb(166, 166, 166);
        }

        .page-item+.disabled {
            background-color: rgb(166, 166, 166);
        }

        input[type='number'],
        input[type='text'],
        input[type='numeric'] {
            padding-left: 10px;
            width: 70px;
        }

        .inputs {
            display: flex;
            flex-direction: column;
            margin-left: 15px;
        }

        button {
            margin-left: 30px;
            width: 70px;
        }

        .check {
            font-size: 12px;
        }

        .price,
        .volume,
        .shadow,
        .delivery {
            display: flex;
            margin-left: 30px;
        }

        label,
        option {
            font-size: 10px;
        }

        .filters {
            display: flex;
            justify-content: space-around;
            width: 100%;
            align-items: end
        }

        button:hover {
            background-color: rgb(4, 4, 58);
            color: #f5f5f5
        }

        input {
            border: none;
            border-bottom: 2px solid black
        }



        #search_term {
            width: 80px;
            border: 1px solid black
        }
    </style>
</head>

<body>

    <div class="content">
        <div class="features">


            <form class="filters" method="GET" action="{{ route('market-data') }}" class="features-form">

                <div class="inputs">
                    <input type="text" id="search_term" name="search_term" value="{{ $searchTerm ?? '' }}"
                        placeholder="search">
                </div>

                <div class="inputs">
                    <label for="market_date">Market Date:</label>
                    <input type="date" id="market_date" name="market_date" value="{{ $marketDate ?? '' }}">
                </div>

                <div class="inputs">
                    <label for="series">Series</label>
                    <select name="series" id="series" class="form-control">
                        <option value="">All</option>
                        <option value="EQ" {{ $series == 'EQ' ? 'selected' : '' }}>Eq</option>
                        <option value="ST" {{ $series == 'ST' ? 'selected' : '' }}>ST</option>
                        <option value="SM" {{ $series == 'SM' ? 'selected' : '' }}>SM</option>
                        <option value="E1" {{ $series == 'E1' ? 'selected' : '' }}>E!</option>
                    </select>
                </div>

                <div class="price">
                    <div class="inputs">
                        <label for="start_date">Change% From</label>
                        <input type="number" id="start_date" name="from" value="{{ $from ?? '' }}"
                            placeholder="from">
                    </div>
                    <div class="inputs">
                        <label for="end_date">Change% To</label>
                        <input type="number" id="end_date" name="to" value="{{ $to ?? '' }}"
                            placeholder="to">
                    </div>
                </div>

                <div class="price">
                    <div class="inputs">
                        <label for="priceFrom">Price From</label>
                        <input type="number" id="priceFrom" name="priceFrom" value="{{ $priceFrom ?? '' }}"
                            placeholder="price from">
                    </div>
                    <div class="inputs">
                        <label for="priceTo">Price To</label>
                        <input type="number" id="priceTo" name="priceTo" value="{{ $priceTo ?? '' }}"
                            placeholder="price to">
                    </div>
                </div>

                {{-- <div class="volume">
                    <div class="inputs">
                        <label for="start_date">Volume1:</label>
                        <input type="numeric" id="start_date" name="volume1" value="{{ $volume1 ?? '' }}">
                    </div>
                    <div class="inputs">
                        <label for="end_date">Volume2:</label>
                        <input type="numeric" id="end_date" name="volume2" value="{{ $volume2 ?? '' }}">
                    </div>
                </div>

                <div class="shadow">
                    <div class="inputs">
                        <label for="end_date">Upper</label>
                        <input type="numeric" id="end_date" name="upper" value="{{ $upper ?? '' }}">
                    </div>
                    <div class="inputs">
                        <label for="end_date">Lower:</label>
                        <input type="numeric" id="end_date" name="lower" value="{{ $lower ?? '' }}">
                    </div>
                </div> --}}

                <div class="delivery">
                    <div class="inputs">
                        <label for="end_date">Delivery1%</label>
                        <input type="numeric" id="end_date" name="delivery1" value="{{ $delivery1 ?? '' }}">
                    </div>
                    <div class="inputs">
                        <label for="end_date">Deliver2%</label>
                        <input type="numeric" id="end_date" name="delivery2" value="{{ $delivery2 ?? '' }}">
                    </div>
                </div>

                <div class="inputs">
                    <label for="orderBy">Order By</label>
                    <select name="orderBy" id="orderBy" class="form-control">
                        <option value="trade_qnty">All</option>
                        <option value="trade_qnty" {{ $orderBy == 'trade_qnty' ? 'selected' : '' }}>Volumes</option>
                        <option value="no_of_trades" {{ $orderBy == 'no_of_trades' ? 'selected' : '' }}>Trades
                        </option>
                        <option value="change_in_cent" {{ $orderBy == 'change_in_cent' ? 'selected' : '' }}>Change%
                        </option>
                        <option value="closed_price" {{ $orderBy == 'closed_price' ? 'selected' : '' }}>Closed
                        </option>
                        <option value="del_percent" {{ $orderBy == 'del_percent' ? 'selected' : '' }}>Delivey%
                        </option>
                    </select>
                </div>
                <button id="filter_btn" type="submit" style="display;">Filter</button>

            </form>



        </div>

        <form class="form2 "action="{{ route('market-data') }}" method="GET" id="columnForm">
            @foreach ($columns as $column)
                @if ($column == 'id')
                    <label class="check">
                        <input type="checkbox" class="checkbox" name="columns[]" value="{{ $column }}"
                            checked>
                        <span class="custom-checkbox">{{ $columnLabels[$column] }}</span>

                    </label>
                @else
                    <label class="check">
                        <input type="checkbox" class="checkbox" name="columns[]" value="{{ $column }}"
                            onchange="document.getElementById('columnForm').submit()"
                            {{ in_array($column, $selectedColumns) ? 'checked' : '' }}>
                        <span class="custom-checkbox">{{ $columnLabels[$column] }}</span>
                    </label>
                @endif
            @endforeach

        </form>

        <div class="parent-div table-container">

            <table id="userTable">
                <thead>
                    <tr>
                        @foreach ($selectedColumns as $column)
                            <th>{{ $columnLabels[$column] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($market_data as $row)
                        <tr class="row1">
                            @foreach ($selectedColumns as $column)
                                <td class>{{ $row->$column }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="pagination-block">
            {{ $market_data->appends(request()->input())->links() }}
        </div>
    </div>
    <script>
        (function() {
            if (window.history && window.history.pushState) {
                // Prevent navigation using the back button
                window.history.pushState(null, null, document.URL);

                // Disable back button
                window.addEventListener('popstate', function() {
                    window.history.pushState(null, null, document.URL);
                });
            }
        })();

        function myFunction() {
            var x = document.getElementById("myLinks");
            if (x.style.display === "flex") {
                x.style.display = "none";
            } else {
                x.style.display = "flex";
            }
        }
        var table = document.getElementById('userTable');
        var rows = table.getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            row.addEventListener('click', function() {
                var name = this.getElementsByTagName('td')[0].textContent + ". " + this.getElementsByTagName('td')[
                    2].textContent;
                document.getElementById('selectedName').value = name;

                // Highlight the selected row
                var selectedRow = table.getElementsByClassName('selected')[0];
                if (selectedRow) {
                    selectedRow.classList.remove('selected');
                }
                this.classList.add('selected');
            });
        }
        document.getElementById("start_date").addEventListener("keydown", filterOnEnter);
        document.getElementById("end_date").addEventListener("keydown", filterOnEnter);

        function filterOnEnter(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                document.getElementById("filter_btn").click();
            }
        }
    </script>
</body>

</html>
