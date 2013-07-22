@extends('layouts/master')

@section('content')

<h2>Ping IP Address</h2>
<p>Send an ICMP request to the specified server.</p>

<br>

<div class="row">
    <div class="span4">

        <form id="pingHost" class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="host">Host</label>

                <div class="controls">
                    <input type="text" id="host" name="host" placeholder="google.com" autofocus>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="interval">Interval</label>

                <div class="controls">
                    <div class="input-append">
                        <input type="text" id="interval" name="interval" value="1">
                        <span class="add-on">sec</span>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="count">Count</label>

                <div class="controls">
                    <input type="text" id="count" name="count" value="5">
                    <p class="help-block">Number of requests</p>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Check</button>
                </div>
            </div>
        </form>        

    </div>
    <div class="span4 offset1">
        <table id="results" class="table">
            <thead>
                <tr>
                    <th>Host</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>


@stop

@section('scripts')

<script type="text/javascript">


    function ping(serializedData) {
        // Fork it
        var request;

        // fire off the request to /form.php
        request = $.ajax({
            url: "/api/v0/network/ip/ping",
            type: "post",
            data: serializedData
        });

        // callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR, i){
            var status = response.results.status;
            var statusClass;
            if(status === 'success') {
                statusClass = 'success';
            } else if(status === 'failure') {
                statusClass = 'error';
            } else {

            }

            // Append the table
            $("#results").find('tbody')
                .append($('<tr>').addClass(statusClass)
                    .append($('<td>').text(response.host))
                    .append($('<td>').text(response.results.time + 'ms'))
                );
        });

        // callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.error(
                "The following error occured: "+
                    textStatus, errorThrown
            );
        });
    }

    $(document).ready(function() {

        $('#pingHost').submit(function(form) {
            form.preventDefault();

            // setup some local variables
            var $form = $(this);
            // let's select and cache all the fields
            var $inputs = $form.find("input, select, button, textarea");
            // serialize the data in the form
            var serializedData = $form.serialize();

            var count = $('#count').val();
            var interval = $('#interval').val();

            ping(serializedData);
            (function pingLoop(i, interval) {
                setTimeout(function () {
                    console.log('ping '+i );
                    ping(serializedData);
                    if (--i) pingLoop(i);      //  decrement i and call myLoop again if i > 0
                }, interval * 1000)
            })(count - 1, interval);                        //  pass the number of iterations as an argument

            // prevent default posting of form
            event.preventDefault();

        });

    });
</script>

@stop
