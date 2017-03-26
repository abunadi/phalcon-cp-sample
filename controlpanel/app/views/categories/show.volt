{{ content() }}
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Showing all categories</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Parent Category</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th align="center" style="width: 15%">Actions</th>
                    </tr>
                    {% for category in page.items %}
                        <tr>
                            <td>{{ category.id }}</td>
                            <td>{{ category.getCategories().name }}</td>
                            <td>{{ category.name }}</td>
                            <td>{{ category.description }}</td>
                            <td>{{ link_to("categories/edit/" ~ category.id, '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', "class": "btn btn-default") }}&nbsp;&nbsp;<a class="btn btn-default" href="javascript:confirmDelete('{{ category.name }}','/controlpanel/categories/delete/{{ category.id }}')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a></td>
                        </tr>
                    {% endfor %}
                </table>
            </div><!-- /.box-body -->
            {% if page.total_items > page.limit %}
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        <li>{{ link_to("categories/show", '&laquo;') }}</li>
                        <li>{{ link_to("categories/show?page=" ~ page.before, 'Previous') }}</li>
                        <li><a>{{ page.current }}</a></li>
                        <li>{{ link_to("categories/show?page=" ~ page.next, 'Next') }}</li>
                        <li>{{ link_to("categories/show?page=" ~ page.last, '&raquo;') }}</li>
                    </ul>
                </div>
            {% endif %}
      </div><!-- /.box -->
    </div>
</div>
