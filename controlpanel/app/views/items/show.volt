{{ content() }}
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Showing all Items</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-striped">
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Category</th>
                        <th>Item</th>
                        <th align="center" style="width: 15%">Actions</th>
                    </tr>
                    {% for Item in page.items %}
                        <tr>
                            <td>{{ Item.id }}</td>
                            <td>
                                {% for category in Item.getItemsCategories() %}=> {{ category.getCategories().name }}<br />{% endfor %}
                            </td>
                            <td>{{ Item.name }}</td>
                            <td>{{ Item.code }}</td>
                            <td>{{ link_to("Items/edit/" ~ Item.id, '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Edit', "class": "btn btn-default") }}&nbsp;&nbsp;<a class="btn btn-default" href="javascript:confirmDelete('{{ Item.name }}','/controlpanel/Items/delete/{{ Item.id }}')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Delete</a></td>
                        </tr>
                    {% endfor %}
                </table>
            </div><!-- /.box-body -->
            {% if page.total_items > page.limit %}
            <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                    <li>{{ link_to("Items/show", '&laquo;') }}</li>
                    <li>{{ link_to("Items/show?page=" ~ page.before, 'Previous') }}</li>
                    <li><a>{{ page.current }}</a></li>
                    <li>{{ link_to("Items/show?page=" ~ page.next, 'Next') }}</li>
                    <li>{{ link_to("Items/show?page=" ~ page.last, '&raquo;') }}</li>
                </ul>
            </div>
            {% endif %}
          </div><!-- /.box -->
    </div>
</div>
