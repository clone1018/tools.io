@extends('layouts/master')

@section('content')

<h2>Matt's Traceroute</h2>
<p>An advanced extended version of traceroute.</p>

<br>

<div class="row">
    <div class="span4">

        <form id="mtrRequest" class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="hostname">Hostname / IP</label>

                <div class="controls">
                    <input type="text" id="hostname" name="hostname" placeholder="google.com" autofocus>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" id="dns"> Look up DNS hostnames
                    </label>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Traceroute</button>
                </div>
            </div>
        </form>

    </div>
    <div class="span4 offset1">
        <table id="#results" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>IP</th>
                    <th>Packet Loss</th>
                    <th>Best</th>
                    <th>Average</th>
                    <th>Worst</th>
                </tr>
            </thead>
            <tbody id="output"></tbody>
        </table>
    </div>
</div>


@stop

@section('scripts')

<script src="http://tools.io/socket.io/socket.io.js"></script>
<script type="text/javascript">

    $(document).ready(function() {
        var socket = io.connect('http://tools.io/');
        console.log(socket);
        socket.on('hop', function (data) {
            console.log(data);
            var hop = data.split(" "),
                element = "#e" + hop[0];

            if ($(element).length > 0) {
                $(element + ' .hop-ip').html(hop[1]);
                $(element + ' .hop-packet-loss').html(hop[2] + '%');
                $(element + ' .hop-best').html(hop[5] + 'ms');
                $(element + ' .hop-average').html(hop[6] + 'ms');
                $(element + ' .hop-worst').html(hop[7] + 'ms');
            } else {
                $('#output').append('<tr id="e' + hop[0] + '">' +
                    '<td class="hop-id">' + hop[0] + '</td>' +
                    '<td class="hop-ip">' + hop[1] + '</td>' +
                    '<td class="hop-packet-loss">' + hop[2] + '%</td>' +
                    '<td class="hop-best">' + hop[5] + 'ms</td>' +
                    '<td class="hop-average">' + hop[6] + 'ms</td>' +
                    '<td class="hop-worst">' + hop[7] + 'ms</td>' +
                    '</tr>');
            }
        });
        socket.on('error', function (err) {
            console.log(err);
            alert(err);
        });
        socket.on('end', function () {
            $('button').removeAttr('disabled');
        });
        socket.on('connect', function () {
            $('button').removeAttr('disabled');
        });

        $('#mtrRequest').submit(function (event) {
            event.preventDefault();

            $('button[type="submit"]').attr('disabled', 'disabled');
            $('#output').fadeOut(function () {
                $(this).html('').fadeIn(function () {
                    socket.emit('mtr', {hostname: $('#hostname').val(), dns: $('#dns').prop('checked')});
                });
            });
        });
    });

</script>

@stop
