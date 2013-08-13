@extends('layouts/master')

@section('content')

<h2>Port Status</h2>
<p>Get the status of a port on a server.</p>

<br>

<table class="table">
    <thead>
        <tr>
            <th>Host</th>
            <th>Port</th>
            <th>Description</th>
            <th>Since</th>
        </tr>
    </thead>
    <tbody>
        <tr class="success">
            <td>Google Web Search</td>
            <td>Hosted by The Cloud</td>
            <td>Web Search</td>
            <td><?php echo time(); ?></td>
        </tr>
    </tbody>
</table>

@stop

@section('scripts')

<script type="text/javascript">

    $(document).ready(function () {

        if (!Modernizr.localstorage) {
            window.localStorage = {
                getItem: function (sKey) {
                    if (!sKey || !this.hasOwnProperty(sKey)) {
                        return null;
                    }
                    return unescape(document.cookie.replace(new RegExp("(?:^|.*;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*((?:[^;](?!;))*[^;]?).*"), "$1"));
                },
                key: function (nKeyId) {
                    return unescape(document.cookie.replace(/\s*\=(?:.(?!;))*$/, "").split(/\s*\=(?:[^;](?!;))*[^;]?;\s*/)[nKeyId]);
                },
                setItem: function (sKey, sValue) {
                    if (!sKey) {
                        return;
                    }
                    document.cookie = escape(sKey) + "=" + escape(sValue) + "; expires=Tue, 19 Jan 2038 03:14:07 GMT; path=/";
                    this.length = document.cookie.match(/\=/g).length;
                },
                length: 0,
                removeItem: function (sKey) {
                    if (!sKey || !this.hasOwnProperty(sKey)) {
                        return;
                    }
                    document.cookie = escape(sKey) + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
                    this.length--;
                },
                hasOwnProperty: function (sKey) {
                    return (new RegExp("(?:^|;\\s*)" + escape(sKey).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=")).test(document.cookie);
                }
            };
            window.localStorage.length = (document.cookie.match(/\=/g) || window.localStorage).length;
        }

        var sites = localstorage.getItem('sites');
        sites = JSON.parse(sites);
        if(sites.length > 0) {
            // Load our existing websites
        }

        // Watch for new entires


        // Check existing ones


    });
</script>

@stop
