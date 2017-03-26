<section class="content">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Login to Control Panel</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                {{ form('session/start', 'role': 'form', 'class': "form-horizontal") }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                {{ text_field('username', 'class': "form-control", 'placeholder': "Username") }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                {{ password_field('password', 'class': "form-control", 'placeholder': "Password") }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">{{ content() }}</div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        {{ submit_button('Login', 'class': 'btn btn-info pull-right') }}
                    </div><!-- /.box-footer -->
                </form>
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
