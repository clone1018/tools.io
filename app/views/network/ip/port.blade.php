@extends('layouts/master')

@section('content')

<h2>Port Status</h2>
<p>Get the status of a port on a server.</p>

<br>

<div class="row">
    <div class="span4">

        <form id="portStatus" class="form-horizontal">
            <div class="control-group">
                <label class="control-label" for="host">Host</label>

                <div class="controls">
                    <input type="text" id="host" name="host" placeholder="google.com" autofocus>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="port">Port</label>

                <div class="controls">
                    <input type="text" id="port" name="port" placeholder="80">
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
                    <th>Port</th>
                    <th><abbr title="Estimation of what the service is">Service</abbr></th>
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
    $(document).ready(function() {

        var request;

        $('#portStatus').submit(function(form) {
            form.preventDefault();

            // abort any pending request
            if (request) {
                request.abort();
            }

            // setup some local variables
            var $form = $(this);
            // let's select and cache all the fields
            var $inputs = $form.find("input, select, button, textarea");
            // serialize the data in the form
            var serializedData = $form.serialize();

            // let's disable the inputs for the duration of the ajax request
            $inputs.prop("disabled", true);

            // fire off the request to /form.php
            request = $.ajax({
                url: "/api/v0/network/ip/port",
                type: "post",
                data: serializedData
            });

            // callback handler that will be called on success
            request.done(function (response, textStatus, jqXHR){
                var status = response.results.status;
                var statusClass;
                if(status === 'open') {
                    statusClass = 'success';
                } else if(status === 'closed') {
                    statusClass = 'error';
                } else {

                }

                // Append the table
                $("#results").find('tbody')
                    .append($('<tr>').addClass(statusClass)
                        .append($('<td>').text(response.host))
                        .append($('<td>').text(response.port))
                        .append($('<td>').text(response.results.guess))
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

            // callback handler that will be called regardless
            // if the request failed or succeeded
            request.always(function () {
                // reenable the inputs
                $inputs.prop("disabled", false);
            });

            // prevent default posting of form
            event.preventDefault();

        });

    });
</script>

@stop