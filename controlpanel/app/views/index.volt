<!DOCTYPE html>
<html>
    <head>
	    <meta charset="utf-8">
	    <meta http-equiv="Content-Type" content="text/html" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        {{ get_title() }}
        {{ stylesheet_link('css/bootstrap/bootstrap.min.css') }}
        {{ stylesheet_link('css/bootstrap/bootstrap-tags.css') }}
        {{ stylesheet_link('css/AdminLTE.min.css') }}
        {% if auth is 1 %}
		    {{ stylesheet_link('css/skins/skin-blue.min.css') }}
		    <!-- jQuery 2.1.4 -->
            {{ javascript_include('js/jQuery/jQuery-2.1.4.min.js') }}
            <!-- Bootstrap 3.3.5 -->
            {{ javascript_include('js/bootstrap/bootstrap.min.js') }}
            {{ javascript_include('js/bootstrap/bootstrap-tags.min.js') }}
            <!-- AdminLTE App -->
            {{ javascript_include('js/app.min.js') }}
            {{ javascript_include('js/cp.js') }}
	    {% endif %}
    </head>
    <body class="hold-transition skin-blue">
	    {% if auth is 1 %}
            {% include "layouts/header.volt" %}
		    {% include "layouts/sidebar.volt" %}
        	{% include "layouts/main.volt" %}
        	{% include "layouts/footer.volt" %}
	    {% else%}
		    {% include "layouts/login_form.volt" %}
	    {% endif %}
    </body>
</html>
