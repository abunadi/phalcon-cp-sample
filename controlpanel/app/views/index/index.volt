{{ content() }}
{% if auth is 1 %}
	<!-- Info boxes -->
	<div class="row">
	    <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
		        <span class="info-box-icon bg-aqua"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></span>
                <div class="info-box-content">
                    <span class="info-box-text">Malls</span>
                    <span class="info-box-number">{{ malls_count }}</span>
                </div><!-- /.info-box-content -->
	        </div><!-- /.info-box -->
	    </div><!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span></span>
                <div class="info-box-content">
                    <span class="info-box-text">Stores</span>
                    <span class="info-box-number">{{ stores_count }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div><!-- /.col -->
	</div><!-- /.row -->
{% endif %}
